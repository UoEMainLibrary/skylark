@extends('layouts.anatomy')

@section('title', $recordTitle . ' - University of Edinburgh Anatomical Collection')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $filters       = array_keys(config('skylight.filters', []));
    $mediaUri      = (string) config('skylight.media_url_prefix', '');

    $fieldKey = static function (string $displayName) use ($fieldMappings): string {
        return str_replace('.', '', $fieldMappings[$displayName] ?? '');
    };

    $authorField    = $fieldKey('Author');
    $typeField      = $fieldKey('Type');
    $dateField      = $fieldKey('Date');
    $bitstreamField = $fieldKey('Bitstream');
    $thumbnailField = $fieldKey('Thumbnail');
    $linkField      = $fieldKey('Link');

    // Bitstream loop: legacy anatomy builds a main image + thumbnail strip +
    // audio/video links.
    $bitstreamLink   = '';
    $mainImage       = false;
    $mainImageTest   = false;
    $thumbnailLinks  = [];
    $numThumbnails   = 0;
    $audioLink = '';
    $videoLink = '';
    $audioFile = false;
    $videoFile = false;

    if (! empty($record[$bitstreamField])) {
        $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];
        $bitstreamArray = [];
        foreach ($bitstreams as $bs) {
            $segments = explode('##', (string) $bs);
            $seq = $segments[4] ?? null;
            if ($seq !== null) {
                $bitstreamArray[$seq] = $bs;
            }
        }
        ksort($bitstreamArray);

        $thumbnailMap = [];
        if (! empty($record[$thumbnailField])) {
            $thumbnails = is_array($record[$thumbnailField]) ? $record[$thumbnailField] : [$record[$thumbnailField]];
            foreach ($thumbnails as $thumb) {
                $tSegments = explode('##', (string) $thumb);
                $tFilename = $tSegments[1] ?? '';
                if ($tFilename !== '') {
                    $thumbnailMap[$tFilename] = $thumb;
                }
            }
        }

        foreach ($bitstreamArray as $bs) {
            $bSegments = explode('##', (string) $bs);
            $bFilename = $bSegments[1] ?? '';
            $bHandle   = $bSegments[3] ?? '';
            $bSeq      = $bSegments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
            $bUri      = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;
            $lower     = strtolower($bFilename);

            if (str_contains($lower, '.jpg')) {
                if (! $mainImage) {
                    $mainImageTest = true;
                    $mainImage = true;
                    $bitstreamLink = '<div class="main-image">';
                    $bitstreamLink .= '<a title="'.e($recordTitle).'" class="fancybox" rel="group" href="'.$bUri.'"> ';
                    $bitstreamLink .= '<img class="record-main-image" src="'.$bUri.'">';
                    $bitstreamLink .= '</a>';
                    $bitstreamLink .= '</div>';
                } elseif (isset($thumbnailMap[$bFilename.'.jpg'])) {
                    $tSegments = explode('##', (string) $thumbnailMap[$bFilename.'.jpg']);
                    $tSeq      = $tSegments[4] ?? '';
                    $tFilename = $tSegments[1] ?? '';
                    $tUri      = './record/'.$bHandleId.'/'.$tSeq.'/'.$tFilename;

                    $tile  = '<div class="thumbnail-tile';
                    if ($numThumbnails % 4 === 0) {
                        $tile .= ' first';
                    }
                    $tile .= '"><a title="'.e($recordTitle).'" class="fancybox" rel="group" href="'.$bUri.'"> ';
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
                if (! str_contains($ua, 'Chrome') || str_contains($ua, 'Edge')) {
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
    @if($mainImageTest)<div class="full-title">@endif
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
    @if($mainImageTest)</div>@endif

    @if($mainImage)
        <div class="full-image">
            {!! $bitstreamLink !!}
        </div>
    @endif

    @if($mainImageTest)<div class="full-metadata">@endif
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
                        $isFilter = in_array($key, $filters, true) && $key !== 'Artist';
                        foreach ($values as $index => $metadatavalue) {
                            if ($isFilter) {
                                $orig  = urlencode($metadatavalue);
                                $lower = urlencode(strtolower($metadatavalue));
                                $rowsHtml .= '<a href="./search/*:*/'.$key.':%22'.$lower.'+%7C%7C%7C+'.$orig.'%22" title="'.e($metadatavalue).'">'.e($metadatavalue).'</a>';
                            } else {
                                $rowsHtml .= e($metadatavalue);
                            }
                            if ($index < $count - 1) {
                                $rowsHtml .= '; ';
                            }
                        }
                        $rowsHtml .= '</td></tr>';
                    }

                    // Zoomable Image(s) row for LUNA/is.ed.ac.uk links.
                    if ($linkField !== '' && ! empty($record[$linkField])) {
                        $links = is_array($record[$linkField]) ? $record[$linkField] : [$record[$linkField]];
                        $lunaRow = '';
                        foreach ($links as $linkURI) {
                            $linkURI = str_replace(['"', '|'], ['%22', '%7C'], (string) $linkURI);
                            if (str_contains($linkURI, 'images.is.ed.ac.uk')) {
                                if ($lunaRow === '') {
                                    $lunaRow = '<tr><th>Zoomable Image(s)</th><td>';
                                }
                                $lunaRow .= '<a href="'.$linkURI.'" target="_blank"><i class="fa fa-file-image-o fa-lg">&nbsp;</i></a>';
                            }
                        }
                        if ($lunaRow !== '') {
                            $lunaRow .= '</td></tr>';
                            $rowsHtml .= $lunaRow;
                        }
                    }
                @endphp
                {!! $rowsHtml !!}
            </tbody>
        </table>
    @if($mainImageTest)</div>@endif

    <div class="clearfix"></div>

    @if(! empty($record[$bitstreamField]))
        <div class="record_bitstreams">
            @if($numThumbnails > 0)
                @php
                    $stripsHtml = '<div class="thumbnail-strip">';
                    $i = 0;
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

            @if($audioFile)<br>.<br>{!! $audioLink !!}@endif
            @if($videoFile)<br>.<br>{!! $videoLink !!}@endif
        </div>
        <div class="clearfix"></div>
    @endif

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
@endsection

@section('sidebar')
    @php
        $relatedTitleField  = str_replace('.', '', config('skylight.field_mappings.Title', ''));
        $relatedAuthorField = str_replace('.', '', config('skylight.field_mappings.Author', 'dc.contributor.author.en'));
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
                    <a class="related-record" href="./record/{{ $docId }}" title="{{ $docTitle }}">{{ $docTitle }}
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
