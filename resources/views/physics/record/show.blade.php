@extends('layouts.physics')

@section('title', $recordTitle . ' - School of Physics and Astronomy Image Archive')

@section('content')
@php


    $fieldMappings = config('skylight.field_mappings', []);
    /*
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
    $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
    $subjectField = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    */

    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $typeField = str_replace('.', '', $fieldMappings['Type'] ?? '');
    $bitstreamField = str_replace('.', '', $fieldMappings['Bitstream']  ?? '');
    $thumbnailField = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $permalinkField = str_replace('.', '', $fieldMappings['Permalink'] ?? '');
    $accNoField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');

    $filters = array_keys(config('skylight.filters', []));
    $mediaUri = config('skylight.media_url_prefix');
    $schema = config('skylight.schema_links', []);

    $type = 'Unknown';
    if (isset($record[$typeField])) {
        $typeValue = is_array($record[$typeField]) ? ($record[$typeField][0] ?? '') : $record[$typeField];
        $type = 'media-' . strtolower(str_replace(' ', '-', $typeValue));
    }

    $manifest = null;
    $jsonLink = '';
    $accno = '';
@endphp

@if(isset($record[$bitstreamField]))
    @php
        $bitstreamArray = [];
        foreach ($record[$bitstreamField] as $bitstreamForArray) {
            $segments = explode('##', $bitstreamForArray);
            $seq = $segments[4] ?? null;
            if ($seq !== null) {
                $bitstreamArray[$seq] = $bitstreamForArray;
            }
        }
        ksort($bitstreamArray);
    @endphp

    @foreach($bitstreamArray as $bitstream)
        @php
            $bSegments = explode('##', $bitstream);
            $bFilename = $bSegments[1] ?? '';
            $bHandle = $bSegments[3] ?? '';
            $bSeq = $bSegments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', $bHandle);
        @endphp

        @if(str_contains(strtolower($bFilename), '.json'))
            @php
                if (isset($record[$accNoField])) {
                    $accno = is_array($record[$accNoField]) ? ($record[$accNoField][0] ?? '') : $record[$accNoField];
                }

                $manifest = url('/physics/record/' . $bHandleId . '/' . $bSeq . '/' . $bFilename);

                $jsonLink  = '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"></a></span>';
                $jsonLink .= '<span class="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest=' . $manifest . '" class="miradorlogo" title="View in Mirador"></a></span>';
                $jsonLink .= '<span class="json-link-item"><a href="' . $manifest . '" target="_blank" class="iiiflogo" title="IIIF manifest"></a></span>';
            @endphp
        @endif
    @endforeach
@endif

    <h1 class="itemtitle">{{ $recordTitle }}</h1>

    <div class="tags">
        @if(isset($record[$authorField]))
            @foreach($record[$authorField] as $author)
                @php
                    $origFilter = preg_replace('/ /', '+', $author);
                    $origFilter = preg_replace('/,/', '%2C', $origFilter);
                @endphp
                <a href='./search/*/Author:"{{ $origFilter }}"'>{{ $author }}</a>
            @endforeach
        @endif
    </div>

    <div class="content">
        @if(isset($manifest))
            <div class="img-container">
                <iframe
                    class="img-frame"
                    src="{{ url('/physics/mirador') }}?manifest={{ urlencode($manifest) }}"
                    height="100%"
                    width="100%"
                    title="Image Showcase">
                </iframe>
            </div>
            <div class="json-link">
                <p>{!! $jsonLink !!}</p>
            </div>
        @endif

        <table>
            <caption>Description</caption>
            <tbody>
            @php $excludes = ['']; @endphp
            @foreach($recordDisplay as $key)
                @php
                    $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                @endphp

                @if(isset($record[$element]) && !in_array($key, $excludes))
                    <tr>
                        <th>{{ $key }}</th>
                        <td>
                            @foreach($record[$element] as $index => $metadatavalue)
                                @if(in_array($key, $filters))
                                    @php
                                        $origFilter = urlencode($metadatavalue);
                                        $lowerOrigFilter = urlencode(strtolower($metadatavalue));
                                    @endphp
                                    <a href="./search/*:*/{{ $key }}:%22{{ $lowerOrigFilter }}+%7C%7C%7C+{{ $origFilter }}%22" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a>
                                @else
                                    {{ $metadatavalue }}
                                @endif

                                @if($index < count($record[$element]) - 1)
                                    ;
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        @if(isset($record[$bitstreamField]))
            @php
                $bitstreamArray = [];
                foreach ($record[$bitstreamField] as $bitstreamForArray) {
                    $segments = explode('##', $bitstreamForArray);
                    $seq = $segments[4] ?? null;
                    if ($seq !== null) {
                        $bitstreamArray[$seq] = $bitstreamForArray;
                    }
                }
                ksort($bitstreamArray);

                $thumbnailLinks = [];
                $numThumbnails = 0;
                $mainImage = false;
                $mainImageHtml = '';
                $audioFile = false;
                $videoFile = false;
                $audioLink = '';
                $videoLink = '';
            @endphp

            <div class="record_bitstreams">
                <h3>Digital Objects</h3>

                <p>Click on the thumbnail to see the image in greater detail.</p>

                @foreach($bitstreamArray as $bitstream)
                    @php
                        $mp4ok = false;
                        $bSegments = explode('##', $bitstream);
                        $bFilename = $bSegments[1] ?? '';
                        $bHandle = $bSegments[3] ?? '';
                        $bSeq = $bSegments[4] ?? '';
                        $bHandleId = preg_replace('/^.*\//', '', $bHandle);
                        $bUri = './record/' . $bHandleId . '/' . $bSeq . '/' . $bFilename;
                    @endphp

                    @if(str_contains(strtolower($bUri), '.jpg'))
                        @if(!$mainImage)
                            @php
                                $mainImageHtml = '<div class="main-image">';
                                $mainImageHtml .= '<a title="' . e($recordTitle) . '" class="fancybox" rel="group" href="' . $bUri . '">';
                                $mainImageHtml .= '<img class="record-main-image" src="' . $bUri . '" alt="' . e($recordTitle) . '">';
                                $mainImageHtml .= '</a></div>';
                                $mainImage = true;
                            @endphp
                        @else
                            @if(isset($record[$thumbnailField]))
                                @foreach($record[$thumbnailField] as $thumbnail)
                                    @php
                                        $tSegments = explode('##', $thumbnail);
                                        $tFilename = $tSegments[1] ?? '';
                                    @endphp

                                    @if($tFilename === $bFilename . '.jpg')
                                        @php
                                            $tSeq = $tSegments[4] ?? '';
                                            $tUri = './record/' . $bHandleId . '/' . $tSeq . '/' . $tFilename;

                                            $thumb = '<div class="thumbnail-tile';
                                            if ($numThumbnails % 4 === 0) {
                                                $thumb .= ' first';
                                            }
                                            $thumb .= '"><a title="' . e($recordTitle) . '" class="fancybox" rel="group" href="' . $bUri . '">';
                                            $thumb .= '<img src="' . $tUri . '" class="record-thumbnail" title="' . e($recordTitle) . '" /></a></div>';

                                            $thumbnailLinks[] = $thumb;
                                            $numThumbnails++;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endif

                    @elseif(str_contains(strtolower($bUri), '.mp3'))
                        @php
                            $audioLink .= '<audio controls>';
                            $audioLink .= '<source src="' . $bUri . '" type="audio/mpeg" />Audio loading...';
                            $audioLink .= '</audio>';
                            $audioFile = true;
                        @endphp

                    @elseif(str_contains(strtolower($bFilename), '.mp4'))
                        @php
                            $bUri = $mediaUri . $bHandleId . '/' . $bSeq . '/' . $bFilename;
                            $ua = request()->userAgent();

                            if (!str_contains($ua, 'Chrome') || str_contains($ua, 'Edge')) {
                                $mp4ok = true;
                            }

                            if ($mp4ok) {
                                $videoLink .= '<div class="flowplayer" title="' . e($recordTitle) . ': ' . e($bFilename) . '">';
                                $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                                $videoLink .= '<source src="' . $bUri . '" type="video/mp4" />Video loading...';
                                $videoLink .= '</video></div>';
                                $videoFile = true;
                            }
                        @endphp

                    @elseif(str_contains(strtolower($bFilename), '.webm'))
                        @php
                            $ua = request()->userAgent();
                            if (!str_contains($ua, 'Edge') && str_contains($ua, 'Chrome')) {
                                $bUri = $mediaUri . $bHandleId . '/' . $bSeq . '/' . $bFilename;
                                $videoLink .= '<div class="flowplayer" title="' . e($recordTitle) . ': ' . e($bFilename) . '">';
                                $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                                $videoLink .= '<source src="' . $bUri . '" type="video/webm" />Video loading...';
                                $videoLink .= '</video></div>';
                                $videoFile = true;
                            }
                        @endphp
                    @endif
                @endforeach

                @if($mainImage)
                    {!! $mainImageHtml !!}
                    <div class="clearfix"></div>
                @endif

                @if($numThumbnails > 0)
                    @php $i = 0; $newStrip = false; @endphp
                    <div class="thumbnail-strip">
                        @foreach($thumbnailLinks as $thumb)
                            @if($newStrip)
                                </div><div class="clearfix"></div><div class="thumbnail-strip">
                                @php $newStrip = false; @endphp
                            @endif

                            {!! $thumb !!}

                            @php
                                $i++;
                                if ($i % 4 === 0) {
                                    $newStrip = true;
                                }
                            @endphp
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                @endif

                @if($audioFile)
                    <br>.<br>{!! $audioLink !!}
                @endif

                @if($videoFile)
                    <br>.<br>{!! $videoLink !!}
                @endif

                {{-- Legacy "high resolution" note mirrored from the live SOPA record page. --}}
                <p>Please note: for performance and security reasons, we only show low resolution media on this site. If you need access to the high resolution original, please send the School of Physics and Astronomy an <a href="{{ url('/physics/feedback') }}">email</a>.</p>
            </div>
            <div class="clearfix"></div>
        @endif
    </div>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">

@endsection

@if(! empty($relatedItems))
    @section('sidebar')
        @php
            $relatedTitleField = str_replace('.', '', config('skylight.field_mappings.Title', ''));
            $relatedTypeField = str_replace('.', '', config('skylight.field_mappings.Type', ''));
            $relatedDateField = str_replace('.', '', config('skylight.field_mappings.Date', ''));
            $relatedThumbnailField = str_replace('.', '', config('skylight.field_mappings.Thumbnail', ''));
            $relatedImageUriField = str_replace('.', '', config('skylight.field_mappings.ImageUri', ''));
            $relatedCount = count($relatedItems);
        @endphp

        <h4>Related Items</h4>
        <ul class="related">
            @foreach($relatedItems as $index => $relatedItem)
                @php
                    $relatedTitle = 'Untitled';
                    if (! empty($relatedItem[$relatedTitleField])) {
                        $titleValue = $relatedItem[$relatedTitleField];
                        $relatedTitle = is_array($titleValue) ? ($titleValue[0] ?? 'Untitled') : $titleValue;
                    }

                    $relatedId = null;
                    if (isset($relatedItem['id'])) {
                        $relatedId = is_array($relatedItem['id']) ? ($relatedItem['id'][0] ?? null) : $relatedItem['id'];
                    } elseif (isset($relatedItem['handle'])) {
                        $handle = is_array($relatedItem['handle']) ? ($relatedItem['handle'][0] ?? '') : $relatedItem['handle'];
                        $relatedId = preg_replace('/^.*\//', '', (string) $handle);
                    }

                    $relatedType = null;
                    if (! empty($relatedItem[$relatedTypeField])) {
                        $typeValue = $relatedItem[$relatedTypeField];
                        $relatedType = is_array($typeValue) ? ($typeValue[0] ?? null) : $typeValue;
                    }

                    $relatedDate = null;
                    if ($relatedDateField && ! empty($relatedItem[$relatedDateField])) {
                        $dateValue = $relatedItem[$relatedDateField];
                        $relatedDate = is_array($dateValue) ? ($dateValue[0] ?? null) : $dateValue;
                    }

                    $iconClass = 'small-icon';
                    if ($relatedType !== null) {
                        $iconClass .= ' media-' . strtolower(str_replace(' ', '-', $relatedType));
                    } else {
                        $iconClass .= ' media-image';
                    }

                    $liClass = '';
                    if ($index === 0) {
                        $liClass = ' class="first"';
                    } elseif ($index === $relatedCount - 1) {
                        $liClass = ' class="last"';
                    }
                @endphp

                <li{!! $liClass !!}>
                    <span class="{{ $iconClass }}"></span>
                    @if($relatedId)
                        <a href="./record/{{ $relatedId }}" title="{{ $relatedTitle }}">{{ $relatedTitle }}</a>
                    @else
                        <span>{{ $relatedTitle }}</span>
                    @endif

                    <div class="tags">
                        @if($relatedDate)
                            <span>({{ $relatedDate }})</span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endsection
@endif
