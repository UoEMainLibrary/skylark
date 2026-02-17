<div class="col-xs-6 col-md-3 box">
    @php
        $titleField = 'dctitleen';
        $thumbnailField = 'dcformatthumbnailen';
        $bitstreamField = 'dcformatoriginalen';
        
        // Get title
        $title = $doc[$titleField][0] ?? $doc[$titleField] ?? 'Untitled';
        if (is_array($title)) {
            $title = $title[0] ?? 'Untitled';
        }
        
        // Get document ID
        $docId = $doc['id'] ?? $doc['handle'] ?? '';
        if (is_array($docId)) {
            $docId = $docId[0] ?? '';
        }
        
        // Extract ID from handle if needed
        if (str_contains($docId, '/')) {
            $parts = explode('/', $docId);
            $docId = end($parts);
        }
        
        $thumbnailUrl = null;
        $hasImage = false;
        
        // Try to find thumbnail or bitstream
        if (isset($doc[$bitstreamField])) {
            $bitstreams = is_array($doc[$bitstreamField]) ? $doc[$bitstreamField] : [$doc[$bitstreamField]];
            
            foreach ($bitstreams as $bitstream) {
                $segments = explode('##', $bitstream);
                if (count($segments) >= 5) {
                    $filename = urlencode($segments[1] ?? '');
                    $handle = $segments[3] ?? '';
                    $seq = $segments[4] ?? '';
                    
                    // Check if it's an image
                    if (stripos($filename, '.jpg') !== false || stripos($filename, '.jpeg') !== false) {
                        $hasImage = true;
                        $handleId = basename($handle);
                        
                        // Try to find matching thumbnail
                        if (isset($doc[$thumbnailField])) {
                            $thumbnails = is_array($doc[$thumbnailField]) ? $doc[$thumbnailField] : [$doc[$thumbnailField]];
                            foreach ($thumbnails as $thumbnail) {
                                $tSegments = explode('##', $thumbnail);
                                if (count($tSegments) >= 5) {
                                    $tFilename = urlencode($tSegments[1] ?? '');
                                    if ($tFilename === $filename . '.jpg') {
                                        $tSeq = $tSegments[4] ?? '';
                                        $thumbnailUrl = url("/record/{$handleId}/{$tSeq}/{$tFilename}");
                                        break 2;
                                    }
                                }
                            }
                        }
                        
                        // Use bitstream itself if no thumbnail
                        if (!$thumbnailUrl) {
                            $thumbnailUrl = url("/record/{$handleId}/{$seq}/{$filename}");
                        }
                        break;
                    }
                }
            }
        }
        
        // Truncate title for display
        $displayTitle = strlen($title) > 15 ? substr($title, 0, 15) . '...' : $title;
    @endphp
    
    <a href="{{ url('/record/' . $docId) }}?highlight={{ urlencode($query) }}" title="{{ $title }}">
        <div class="imagebox">
            @if($thumbnailUrl)
                <img src="{{ $thumbnailUrl }}" class="img-responsive" title="{{ $title }}" alt="{{ $title }}" loading="lazy">
            @else
                <img src="{{ asset('images/comingsoon.gif') }}" class="img-responsive" title="{{ $title }}" alt="{{ $title }}">
            @endif
        </div>
    </a>
    
    <div class="recordtitle">
        <p>
            <a href="{{ url('/record/' . $docId) }}?highlight={{ urlencode($query) }}" title="{{ $title }}">
                {{ $displayTitle }}
            </a>
        </p>
    </div>
</div>
