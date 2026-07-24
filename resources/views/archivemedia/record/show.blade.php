@extends('layouts.archivemedia')

@section('title', $recordTitle . ' - Archives Media')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $filters       = array_keys(config('skylight.filters', []));
    $mediaUri      = (string) config('skylight.media_url_prefix', '');

    $fieldKey = static function (string $displayName) use ($fieldMappings): string {
        return str_replace('.', '', $fieldMappings[$displayName] ?? '');
    };

    $titleField     = $fieldKey('Title');
    $authorField    = $fieldKey('Author');
    $dateField      = $fieldKey('Date');
    $typeField      = $fieldKey('Type');
    $bitstreamField = $fieldKey('Bitstream');
    $thumbnailField = $fieldKey('Thumbnail');
    $tagsField      = $fieldKey('Tags');
    $imageUriField  = $fieldKey('ImageUri');
    $accNoField     = $fieldKey('Accession Number');

    // Bitstream loop — build thumbnail strip, audio/video/PDF links, and (if a
    // JSON manifest is present) the UV/Mirador/IIIF/LUNA logo strip.
    $thumbnailLinks = [];
    $numThumbnails  = 0;
    $audioLink = '';
    $videoLink = '';
    $pdfLink   = '';
    $jsonLink  = '';
    $audioFile = false;
    $videoFile = false;
    $pdfFile   = false;
    $imageId   = '';
    $accno     = '';

    if (! empty($record[$bitstreamField])) {
        $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];
        $bitstreamArray = [];
        foreach ($bitstreams as $bitstreamForArray) {
            $segments = explode('##', (string) $bitstreamForArray);
            $seq = $segments[4] ?? null;
            if ($seq !== null) {
                $bitstreamArray[$seq] = $bitstreamForArray;
            }
        }
        ksort($bitstreamArray);

        $thumbnailMap = [];
        if (! empty($record[$thumbnailField])) {
            $thumbnails = is_array($record[$thumbnailField]) ? $record[$thumbnailField] : [$record[$thumbnailField]];
            foreach ($thumbnails as $thumb) {
                $tSegments = explode('##', (string) $thumb);
                $tFilename = urlencode($tSegments[1] ?? '');
                if ($tFilename !== '') {
                    $thumbnailMap[$tFilename] = $thumb;
                }
            }
        }

        foreach ($bitstreamArray as $bitstream) {
            $bSegments = explode('##', (string) $bitstream);
            $bFilename = urlencode($bSegments[1] ?? '');
            if ($imageId === '') {
                $imageId = substr($bFilename, 0, 7);
            }
            $bHandle   = $bSegments[3] ?? '';
            $bSeq      = $bSegments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
            $bUri      = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;

            $lower = strtolower($bFilename);

            if (str_contains($lower, '.jpg')) {
                $thumbnailKey = $bFilename.'.jpg';
                if (isset($thumbnailMap[$thumbnailKey])) {
                    $tSegments = explode('##', (string) $thumbnailMap[$thumbnailKey]);
                    $tSeq      = $tSegments[4] ?? '';
                    $tFilename = urlencode($tSegments[1] ?? '');
                    $tUri      = './record/'.$bHandleId.'/'.$tSeq.'/'.$tFilename;

                    $tile  = '<div class="thumbnail-tile';
                    if ($numThumbnails % 4 === 0) {
                        $tile .= ' first';
                    }
                    $tile .= '"><a title="'.e($recordTitle).'" class="fancybox" rel="group" href="'.$bUri.'">';
                    $tile .= '<img src="'.$tUri.'" class="record-thumbnail" title="'.e($recordTitle).'" /></a></div>';
                    $thumbnailLinks[] = $tile;
                    $numThumbnails++;
                }
            } elseif (str_contains($lower, '.mp3')) {
                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="'.$bUri.'" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;
            } elseif (str_contains($lower, '.mp4')) {
                $mediaBUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                $ua = (string) request()->userAgent();
                $mp4ok = ! str_contains($ua, 'Chrome') || str_contains($ua, 'Edge');
                if ($mp4ok) {
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$mediaBUri.'" type="video/mp4" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            } elseif (str_contains($lower, '.webm')) {
                $ua = (string) request()->userAgent();
                if (! str_contains($ua, 'Edge') && str_contains($ua, 'Chrome')) {
                    $mediaBUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$mediaBUri.'" type="video/webm" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            } elseif (str_contains($lower, '.pdf')) {
                $pdfLink .= 'Click <a href="'.$bUri.'">'.e($bFilename).'</a> to download.<br>';
                $pdfFile = true;
            } elseif (str_contains($lower, '.json')) {
                if (! empty($record[$accNoField])) {
                    $accno = is_array($record[$accNoField]) ? ($record[$accNoField][0] ?? '') : $record[$accNoField];
                }
                $manifest = url('/archivemedia/record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename);
                $jsonLink  = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.$manifest.'" target="_blank" class="uvlogo" title="View in UV"></a></span>';
                $jsonLink .= '<span class ="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo" title="View in Mirador"></a></span>';
                $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q='.$accno.'" class="lunalogo" title="View in LUNA"></a></span>';
                $jsonLink .= '<span class ="json-link-item"><a href="'.$manifest.'" target="_blank" class="iiiflogo" title="IIIF manifest"></a></span>';
            }
        }
    }

    $dateSuffix = '';
    if ($dateField !== '' && ! empty($record[$dateField])) {
        $dateVal = is_array($record[$dateField]) ? ($record[$dateField][0] ?? '') : $record[$dateField];
        if ($dateVal !== '') {
            $dateSuffix = ' ('.$dateVal.')';
        }
    }
@endphp

<div class="content">
    <div itemscope itemtype="http://schema.org/CreativeWork">
        <div class="full-title">
            <h1 class="itemtitle">{{ $recordTitle }}{{ $dateSuffix }}</h1>
            <div class="tags">
                @if($authorField !== '' && ! empty($record[$authorField]))
                    @foreach((is_array($record[$authorField]) ? $record[$authorField] : [$record[$authorField]]) as $author)
                        @php
                            $orig  = urlencode($author);
                            $lower = urlencode(strtolower($author));
                        @endphp
                        <a class="artist" href="./search/*:*/Artist:%22{{ $lower }}+%7C%7C%7C+{{ $orig }}%22">{{ $author }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="full-metadata">
            <table>
                <tbody>
                    @php
                        $excludes = [''];
                        $rowsHtml = '';
                        foreach ($recordDisplay as $key) {
                            $element = $fieldKey($key);
                            if ($element === '' || ! isset($record[$element]) || in_array($key, $excludes, true)) {
                                continue;
                            }
                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                            $rowsHtml .= '<tr><th>'.e($key).'</th><td>';
                            $count = count($values);
                            foreach ($values as $index => $metadatavalue) {
                                $rowsHtml .= e($metadatavalue);
                                if ($index < $count - 1) {
                                    $rowsHtml .= '; ';
                                }
                            }
                            $rowsHtml .= '</td></tr>';
                        }
                    @endphp
                    {!! $rowsHtml !!}
                </tbody>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="clearfix"></div>

    @if(! empty($record[$bitstreamField]))
        <div class="record_bitstreams">
            @if($jsonLink !== '')
                <div class="json-link">
                    <p>{!! $jsonLink !!}</p>
                </div>
            @endif

            @if($numThumbnails > 0)
                @php
                    $stripsHtml = '';
                    $i = 0;
                    $stripsHtml .= '<div class="thumbnail-strip">';
                    foreach ($thumbnailLinks as $thumb) {
                        if ($i > 0 && $i % 4 === 0) {
                            $stripsHtml .= '</div><div class="clearfix"></div><div class="thumbnail-strip">';
                        }
                        $stripsHtml .= $thumb;
                        $i++;
                    }
                    $stripsHtml .= '</div><div class="clearfix"></div>';
                @endphp
                {!! $stripsHtml !!}
            @endif

            @if($audioFile)<br><br>{!! $audioLink !!}@endif
            @if($videoFile)<br><br>{!! $videoLink !!}@endif
            @if($pdfFile)<br><br>{!! $pdfLink !!}@endif
        </div>
        <div class="clearfix"></div>
    @endif

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
@endsection

@section('sidebar')
    @php
        $relatedTitleField  = str_replace('.', '', config('skylight.field_mappings.Title', ''));
        $relatedAuthorField = str_replace('.', '', config('skylight.field_mappings.Author', ''));
        $relatedDateField   = str_replace('.', '', config('skylight.field_mappings.Date', ''));
        $relatedCount       = is_array($relatedItems ?? null) ? count($relatedItems) : 0;
    @endphp

    <h4>Related Items</h4>

    <ul class="related">
        @if($relatedCount === 0)
            <li>None.</li>
        @else
            @foreach($relatedItems as $index => $doc)
                @php
                    $docId = isset($doc['id'])
                        ? (is_array($doc['id']) ? ($doc['id'][0] ?? '') : $doc['id'])
                        : '';
                    $docTitle = 'Untitled';
                    if (! empty($doc[$relatedTitleField])) {
                        $t = $doc[$relatedTitleField];
                        $docTitle = is_array($t) ? ($t[0] ?? 'Untitled') : $t;
                    }
                    $docDate = '';
                    if ($relatedDateField !== '' && ! empty($doc[$relatedDateField])) {
                        $d = $doc[$relatedDateField];
                        $docDate = is_array($d) ? ($d[0] ?? '') : $d;
                    }

                    $liClass = '';
                    if ($index === 0) {
                        $liClass = ' class="first"';
                    } elseif ($index === $relatedCount - 1) {
                        $liClass = ' class="last"';
                    }
                @endphp

                <li{!! $liClass !!}>
                    <a class="related-record" href="./record/{{ $docId }} " title="{{ $docTitle }}">{{ $docTitle }}
                        @if($docDate !== '')({{ $docDate }})@endif
                    </a>

                    <div class="tags">
                        @if($relatedAuthorField !== '' && ! empty($doc[$relatedAuthorField]))
                            @foreach((is_array($doc[$relatedAuthorField]) ? $doc[$relatedAuthorField] : [$doc[$relatedAuthorField]]) as $author)
                                @php
                                    $orig  = ucwords(urlencode($author));
                                    $lower = urlencode(strtolower($author));
                                @endphp
                                <a href="./search/*:*/Artist:%22{{ $lower }}+%7C%7C%7C+{{ $orig }}%22" title="{{ $author }}">{{ $author }}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
@endsection
