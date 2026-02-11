<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RecordController extends Controller
{
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

        try {
            // Fetch image from DSpace with SSL verification disabled (for self-signed certs)
            // Matches CodeIgniter's stream_context_create with verify_peer => false
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->get($url);

            if (! $response->successful()) {
                abort(404, 'Image not found');
            }

            // Get content type from response or default to application/octet-stream
            $contentType = $response->header('Content-Type', 'application/octet-stream');
            $contentLength = $response->header('Content-Length', strlen($response->body()));

            // Return streaming response with proper headers
            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Content-Length', $contentLength)
                ->header('Cache-Control', 'public, max-age=31536000') // Cache for 1 year
                ->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
        } catch (\Exception $e) {
            abort(404, 'Image not found');
        }
    }
}
