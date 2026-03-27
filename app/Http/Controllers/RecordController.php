<?php

namespace App\Http\Controllers;

use App\Helpers\BitstreamHelper;
use App\Services\RepositoryFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RecordController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Get collection-aware view name, respecting skin version for EERC.
     */
    protected function collectionView(string $view): string
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.{$view}";

        if ($collection === 'eerc') {
            return PageController::eercViewName($collectionView);
        }

        return view()->exists($collectionView) ? $collectionView : $view;
    }

    /**
     * Display a single record detail page
     */
    public function show(Request $request, string $id, ?string $type = null)
    {
        // Get repository service for current collection
        $repository = $this->repositoryFactory->current();

        // Fetch record from repository (pass type if available for ArchivesSpace)
        $record = method_exists($repository, 'getRecordWithType')
            ? $repository->getRecordWithType($id, $type)
            : $repository->getRecord($id);

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
        $relatedItems = $repository->getRelatedItems($record, config('skylight.related_number', 10));

        // Parse bitstreams
        $bitstreams = $this->parseBitstreams($record, $bitstreamField, $thumbnailField);

        return view($this->collectionView('record.show'), [
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
        $pdfBitstreams = [];
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
                $pdfBitstreams[] = $bitstream;
            }
        }

        foreach (BitstreamHelper::orderPdfBitstreamsForDownload($pdfBitstreams) as $bitstream) {
            $parsed['pdf'][] = [
                'uri' => BitstreamHelper::getUri($bitstream),
                'filename' => BitstreamHelper::getFilename($bitstream),
                'size' => BitstreamHelper::getFormattedSize($bitstream),
            ];
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

        $url = $this->dSpaceBitstreamUrl($id, $seq, $filename);
        $requestLooksLikePdf = str_ends_with(strtolower(rawurldecode($filename)), '.pdf');

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

            $body = $response->body();

            if ($requestLooksLikePdf && $this->responseIsNonPdfPayload($response->header('Content-Type', ''), $body)) {
                abort(404, 'This bitstream is not a PDF (often sequence 1 is a IIIF manifest). Use another link on the record page or a different sequence number.');
            }

            // Get content type from response or default to application/octet-stream
            $contentType = $response->header('Content-Type', 'application/octet-stream');
            $contentLength = $response->header('Content-Length', strlen($body));

            // Return streaming response with proper headers
            return response($body)
                ->header('Content-Type', $contentType)
                ->header('Content-Length', $contentLength)
                ->header('Cache-Control', 'public, max-age=31536000') // Cache for 1 year
                ->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e) {
            throw $e;
        } catch (\Exception $e) {
            abort(404, 'Image not found');
        }
    }

    /**
     * Join base URL with item id, sequence, and filename without duplicating or dropping slashes.
     */
    protected function dSpaceBitstreamUrl(string $id, string $seq, string $filenameEncoded): string
    {
        $base = rtrim((string) config('services.dspace.bitstream_url'), '/');

        return $base.'/'.$id.'/'.$seq.'/'.$filenameEncoded;
    }

    /**
     * DSpace sometimes stores IIIF presentation JSON with a ".pdf" name or sends application/octet-stream for JSON.
     */
    protected function responseIsNonPdfPayload(string $contentTypeHeader, string $body): bool
    {
        $mime = strtolower(trim(Str::before($contentTypeHeader, ';')));

        if (str_contains($mime, 'json')) {
            return true;
        }

        return $this->bodyLooksLikeIiifPresentationJson($body);
    }

    protected function bodyLooksLikeIiifPresentationJson(string $body): bool
    {
        $trim = ltrim($body);
        if ($trim === '' || $trim[0] !== '{') {
            return false;
        }

        if (! str_contains($trim, '"@type"')) {
            return false;
        }

        return str_contains($trim, 'sc:Manifest')
            || str_contains($trim, '"Manifest"')
            || (str_contains($trim, 'iiif.io') && str_contains($trim, 'presentation'));
    }
}
