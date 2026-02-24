<?php

namespace App\Http\Controllers;

use App\Helpers\BitstreamHelper;
use App\Services\SolrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecordController extends Controller
{
    public function __construct(protected SolrService $solrService) {}

    /**
     * Display a single record detail page
     */
    public function show(Request $request, string $id)
    {
        // Fetch record from Solr
        $record = $this->solrService->getRecord($id);

        if (! $record) {
            abort(404, 'Record not found');
        }

        // Get configuration
        $recordDisplay = config('skylight.recorddisplay', []);
        $fieldMappings = config('skylight.field_mappings', []);
        $filters = array_keys(config('skylight.filters', []));
        $relatedFieldMappings = config('skylight.related_fields', []);

        // Get field names (with dots removed)
        $bitstreamField = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
        $thumbnailField = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');
        $titleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
        $parentCollectionField = str_replace('.', '', $fieldMappings['Parent Collection'] ?? '');
        $subCollectionField = str_replace('.', '', $fieldMappings['Sub Collections'] ?? '');
        $internalUriField = str_replace('.', '', $fieldMappings['Internal URI'] ?? '');
        $aspaceUriField = str_replace('.', '', $fieldMappings['ASpace URI'] ?? '');
        $lunaUriField = str_replace('.', '', $fieldMappings['LUNA URI'] ?? '');
        $lmsUriField = str_replace('.', '', $fieldMappings['LMS URI'] ?? '');
        $otherUriField = str_replace('.', '', $fieldMappings['Other URI'] ?? '');

        // Get record title
        $recordTitle = 'Untitled';
        if (isset($record[$titleField]) && ! empty($record[$titleField])) {
            $titleValue = $record[$titleField];
            $recordTitle = is_array($titleValue) ? ($titleValue[0] ?? 'Untitled') : $titleValue;
        }

        // Get highlight query parameter
        $highlightQuery = $request->query('highlight', '');

        // Fetch related items
        $relatedItems = $this->solrService->getRelatedItems($id, $record, $relatedFieldMappings);

        // Parse bitstreams
        $bitstreams = $this->parseBitstreams($record, $bitstreamField, $thumbnailField);

        return view('record.show', [
            'record' => $record,
            'recordTitle' => $recordTitle,
            'recordDisplay' => $recordDisplay,
            'fieldMappings' => $fieldMappings,
            'filters' => $filters,
            'bitstreamField' => $bitstreamField,
            'thumbnailField' => $thumbnailField,
            'parentCollectionField' => $parentCollectionField,
            'subCollectionField' => $subCollectionField,
            'internalUriField' => $internalUriField,
            'aspaceUriField' => $aspaceUriField,
            'lunaUriField' => $lunaUriField,
            'lmsUriField' => $lmsUriField,
            'otherUriField' => $otherUriField,
            'highlightQuery' => $highlightQuery,
            'relatedItems' => $relatedItems,
            'bitstreams' => $bitstreams,
        ]);
    }

    /**
     * Parse bitstreams into structured data
     */
    protected function parseBitstreams(array $record, string $bitstreamField, string $thumbnailField): array
    {
        $parsed = [
            'main_image' => null,
            'images' => [],
            'thumbnails' => [],
            'audio' => [],
            'video' => [],
            'pdf' => [],
        ];

        if (! isset($record[$bitstreamField])) {
            return $parsed;
        }

        $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];

        // Sort and process bitstreams
        $imageArray = [];
        foreach ($bitstreams as $bitstream) {
            $seq = BitstreamHelper::getSequence($bitstream);

            if (BitstreamHelper::isImage($bitstream)) {
                $imageArray[$seq] = $bitstream;
            } elseif (BitstreamHelper::isAudio($bitstream)) {
                $parsed['audio'][] = [
                    'uri' => BitstreamHelper::getUri($bitstream),
                    'filename' => BitstreamHelper::getFilename($bitstream),
                ];
            } elseif (BitstreamHelper::isVideo($bitstream)) {
                $parsed['video'][] = [
                    'uri' => BitstreamHelper::getUri($bitstream),
                    'filename' => BitstreamHelper::getFilename($bitstream),
                ];
            } elseif (BitstreamHelper::isPdf($bitstream)) {
                $parsed['pdf'][] = [
                    'uri' => BitstreamHelper::getUri($bitstream),
                    'filename' => BitstreamHelper::getFilename($bitstream),
                    'size' => BitstreamHelper::getFormattedSize($bitstream),
                ];
            }
        }

        // Sort images by sequence
        ksort($imageArray);

        // First image is the main image
        $isFirst = true;
        foreach ($imageArray as $seq => $bitstream) {
            $imageData = [
                'uri' => BitstreamHelper::getUri($bitstream),
                'filename' => BitstreamHelper::getFilename($bitstream),
                'description' => BitstreamHelper::getDescription($bitstream),
                'seq' => $seq,
            ];

            if ($isFirst) {
                $parsed['main_image'] = $imageData;
                $isFirst = false;
            } else {
                $parsed['images'][] = $imageData;
            }
        }

        return $parsed;
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
