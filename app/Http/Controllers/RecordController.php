<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecordController extends Controller
{
    /**
     * Test endpoint to verify DSpace connectivity
     * Access via /record/test-proxy to check configuration
     */
    public function testProxy()
    {
        $bitstreamUrl = config('services.dspace.bitstream_url');
        $testUrl = $bitstreamUrl.'51352/2/0025556c.jpg.jpg';

        $info = [
            'config_bitstream_url' => $bitstreamUrl,
            'test_url' => $testUrl,
            'app_debug' => config('app.debug'),
            'app_env' => config('app.env'),
        ];

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->get($testUrl);

            $info['test_result'] = 'SUCCESS';
            $info['status_code'] = $response->status();
            $info['content_type'] = $response->header('Content-Type');
            $info['content_length'] = $response->header('Content-Length');
            $info['body_size_bytes'] = strlen($response->body());
            $info['body_starts_with_jpeg'] = str_starts_with($response->body(), "\xFF\xD8\xFF");
        } catch (\Exception $e) {
            $info['test_result'] = 'FAILED';
            $info['error_message'] = $e->getMessage();
            $info['error_class'] = get_class($e);
        }

        return response()->json($info, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Proxy images from DSpace bitstream endpoint
     * Matches CodeIgniter implementation in record.php lines 72-121
     */
    public function proxyImage(string $id, string $seq, string $filename)
    {
        // URL encode special characters in filename (matching CodeIgniter logic)
        $filename = str_replace(' ', '%20', $filename);
        $filename = str_replace('(', '%28', $filename);
        $filename = str_replace(')', '%29', $filename);
        $filename = str_replace("'", '%27', $filename);
        $filename = str_replace(',', '%2C', $filename);

        // Construct DSpace bitstream URL
        $bitstreamUrl = config('services.dspace.bitstream_url');
        $url = $bitstreamUrl.$id.'/'.$seq.'/'.$filename;

        // Log the attempt in non-production environments
        if (config('app.debug')) {
            Log::info('Image proxy attempt', [
                'url' => $url,
                'bitstream_base' => $bitstreamUrl,
                'id' => $id,
                'seq' => $seq,
                'filename' => $filename,
            ]);
        }

        try {
            // Fetch image from DSpace with SSL verification disabled (for self-signed certs)
            // Matches CodeIgniter's stream_context_create with verify_peer => false
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->get($url);

            if (! $response->successful()) {
                $statusCode = $response->status();
                $errorBody = substr($response->body(), 0, 500);

                // Log failure details
                Log::warning('Image proxy failed', [
                    'url' => $url,
                    'status' => $statusCode,
                    'error' => $errorBody,
                ]);

                // In debug mode, return detailed error
                if (config('app.debug')) {
                    return response("Image proxy failed:\nURL: {$url}\nStatus: {$statusCode}\nError: {$errorBody}", 404)
                        ->header('Content-Type', 'text/plain')
                        ->header('X-Debug-Url', $url)
                        ->header('X-Debug-Status', $statusCode);
                }

                abort(404, 'Image not found');
            }

            // Get content type from response or default to application/octet-stream
            $contentType = $response->header('Content-Type', 'application/octet-stream');
            $contentLength = $response->header('Content-Length', strlen($response->body()));

            // Log success in debug mode
            if (config('app.debug')) {
                Log::info('Image proxy success', [
                    'url' => $url,
                    'content_type' => $contentType,
                    'content_length' => $contentLength,
                ]);
            }

            // Return streaming response with proper headers
            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Content-Length', $contentLength)
                ->header('Cache-Control', 'public, max-age=31536000') // Cache for 1 year
                ->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000).' GMT')
                ->header('X-Proxied-From', config('app.debug') ? $url : 'dspace'); // Debug header
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Image proxy exception', [
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // In debug mode, return detailed error
            if (config('app.debug')) {
                return response("Image proxy exception:\nURL: {$url}\nError: {$e->getMessage()}", 500)
                    ->header('Content-Type', 'text/plain')
                    ->header('X-Debug-Url', $url)
                    ->header('X-Debug-Error', substr($e->getMessage(), 0, 200));
            }

            abort(404, 'Image not found');
        }
    }
}
