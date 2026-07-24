@extends('layouts.calendars')

@section('title', $recordTitle . ' - Calendars')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $filters       = array_keys(config('skylight.filters', []));
    $schema        = config('skylight.schema_links', []);
    $mediaUri      = (string) config('skylight.media_url_prefix', '');

    $fieldKey = static function (string $displayName) use ($fieldMappings): string {
        return str_replace('.', '', $fieldMappings[$displayName] ?? '');
    };

    $subjectField   = $fieldKey('Subject');
    $bitstreamField = $fieldKey('Bitstream');
    $thumbnailField = $fieldKey('Thumbnail');
    $linkField      = $fieldKey('Link');

    // Bitstream loop: build main image + thumbnail strip + audio/video links.
    $bitstreamMainImage = null;
    $thumbnailLinks     = [];
    $numThumbnails      = 0;
    $audioLink = '';
    $videoLink = '';
    $audioFile = false;
    $videoFile = false;

    if (! empty($record[$bitstreamField])) {
        $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];

        $bitstreamArray = [];
        foreach ($bitstreams as $bitstream) {
            $segments = explode('##', (string) $bitstream);
            $filename = $segments[1] ?? '';
            $seq = $segments[4] ?? null;
            if ($seq !== null && (str_contains($filename, '.jpg') || str_contains($filename, '.JPG'))) {
                $bitstreamArray[$seq] = $bitstream;
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

        $isMain = true;
        foreach ($bitstreamArray as $bitstream) {
            $bSegments = explode('##', (string) $bitstream);
            $bFilename = $bSegments[1] ?? '';
            $bHandle   = $bSegments[3] ?? '';
            $bSeq      = $bSegments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
            $bUri      = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;

            if ($isMain) {
                $mainHtml  = '<div class="main-image">';
                $mainHtml .= '<a title="'.e($recordTitle).'" class="fancybox" rel="group" href="'.$bUri.'"> ';
                $mainHtml .= '<img class="record-main-image" src="'.$bUri.'">';
                $mainHtml .= '</a>';
                $mainHtml .= '</div>';
                $bitstreamMainImage = $mainHtml;
                $isMain = false;
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
        }

        // Audio/video pass — reruns over ALL bitstreams (legacy behaviour).
        foreach ($bitstreams as $bitstream) {
            $segments = explode('##', (string) $bitstream);
            $bFilename = $segments[1] ?? '';
            $bHandle   = $segments[3] ?? '';
            $bSeq      = $segments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
            $bUri      = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;
            $lower     = strtolower($bFilename);

            if (str_contains($lower, '.mp3')) {
                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="'.$bUri.'" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;
            } elseif (str_contains($lower, '.mp4')) {
                $bUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                $ua = (string) request()->userAgent();
                if (! str_contains($ua, 'Chrome') || str_contains($ua, 'Edge')) {
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$bUri.'" type="video/mp4" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            } elseif (str_contains($lower, '.webm')) {
                $ua = (string) request()->userAgent();
                if (! str_contains($ua, 'Edge') && str_contains($ua, 'Chrome')) {
                    $bUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$bUri.'" type="video/webm" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            }
        }
    }
@endphp

<h1 class="itemtitle">{{ $recordTitle }}</h1>
<div itemscope itemtype="http://schema.org/CreativeWork">
    <div class="tags">
        @if($subjectField !== '' && ! empty($record[$subjectField]))
            @foreach((is_array($record[$subjectField]) ? $record[$subjectField] : [$record[$subjectField]]) as $subject)
                @php
                    $orig  = urlencode($subject);
                    $lower = urlencode(strtolower($subject));
                @endphp
                <a class="$month" href="./search/*:*/%22Subject{{ $lower }}+%7C%7C%7C+{{ $orig }}%22">{{ $subject }}</a>
            @endforeach
        @endif
    </div>

    <div class="content">
        @if(! empty($record[$bitstreamField]))
            <div class="record_bitstreams">
                {!! $bitstreamMainImage !!}
                @if($bitstreamMainImage)<div class="clearfix"></div>@endif

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

                @if($audioFile){!! $audioLink !!}@endif
                @if($videoFile){!! $videoLink !!}@endif
            </div>
            <div class="clearfix"></div>
        @endif

        <div class="full-metadata">
            <table>
                <tbody>
                    @php
                        $rowsHtml = '';
                        foreach ($recordDisplay as $key) {
                            $element = $fieldKey($key);
                            if ($element === '' || ! isset($record[$element])) {
                                continue;
                            }
                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                            $rowsHtml .= '<tr><th>'.e($key).'</th><td>';
                            $count = count($values);
                            $isFilter   = in_array($key, $filters, true);
                            $schemaProp = $schema[$key] ?? null;
                            foreach ($values as $index => $metadatavalue) {
                                $orig  = urlencode($metadatavalue);
                                $lower = urlencode(strtolower($metadatavalue));
                                if ($isFilter) {
                                    $link = '<a href="./search/*:*/'.$key.':%22'.$lower.'+%7C%7C%7C+'.$orig.'%22" title="'.e($metadatavalue).'">'.e($metadatavalue).'</a>';
                                    $rowsHtml .= $schemaProp
                                        ? '<span itemprop="'.e($schemaProp).'">'.$link.'</span>'
                                        : $link;
                                } else {
                                    $rowsHtml .= $schemaProp
                                        ? '<span itemprop="'.e($schemaProp).'">'.e($metadatavalue).'</span>'
                                        : e($metadatavalue);
                                }
                                if ($index < $count - 1) {
                                    $rowsHtml .= '; ';
                                }
                            }
                            $rowsHtml .= '</td></tr>';
                        }

                        // Zoomable Image row for LUNA/is.ed.ac.uk links.
                        if ($linkField !== '' && ! empty($record[$linkField])) {
                            $links = is_array($record[$linkField]) ? $record[$linkField] : [$record[$linkField]];
                            $lunaRow = '';
                            foreach ($links as $linkURI) {
                                $linkURI = str_replace(['"', '|'], ['%22', '%7C'], (string) $linkURI);
                                if (str_contains($linkURI, 'images.is.ed.ac.uk')) {
                                    if ($lunaRow === '') {
                                        $lunaRow = '<tr><th>Zoomable Image</th><td>';
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
        </div>
    </div>
</div>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
@endsection

@section('sidebar')
    @php
        $relatedTitleField  = str_replace('.', '', config('skylight.field_mappings.Title', ''));
        $relatedAuthorField = str_replace('.', '', config('skylight.field_mappings.Author', 'dc.contributor.author.en'));
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
                    $liClass = '';
                    if ($index === 0) {
                        $liClass = ' class="first"';
                    } elseif ($index === $relatedCount - 1) {
                        $liClass = ' class="last"';
                    }
                @endphp
                <li{!! $liClass !!}>
                    <a class="related-record" href="./record/{{ $docId }}" title="{{ $docTitle }}">{{ $docTitle }}</a>

                    <div class="tags">
                        @if($relatedAuthorField !== '' && ! empty($doc[$relatedAuthorField]))
                            @foreach((is_array($doc[$relatedAuthorField]) ? $doc[$relatedAuthorField] : [$doc[$relatedAuthorField]]) as $author)
                                @php
                                    $orig  = ucwords(urlencode($author));
                                    $lower = urlencode(strtolower($author));
                                @endphp
                                <a href="./search/*:*/Maker:%22{{ $lower }}+%7C%7C%7C+{{ $orig }}%22">{{ $author }}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
@endsection
