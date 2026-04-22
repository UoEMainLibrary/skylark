@extends('layouts.cockburn')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}"
    @else
        Search Results
    @endif
@endsection

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
    $typeField = str_replace('.', '', $fieldMappings['Type'] ?? '');
    $bitstreamField = str_replace('.', '', $fieldMappings['Bitstream']  ?? '');
    $thumbnailField = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');
    $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
    $subjectField = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');

    $cleanBaseParameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters ?? '');
    $sortSep = $cleanBaseParameters === '' ? '?sort_by=' : '&sort_by=';
@endphp


    <div class="content">
        @if(isset($message))
            <div class="message">{!! $message !!}</div>
        @endif

        @if($rows == 0)
            <h1>No results found</h1>
            <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
        @else
            <div class="listing-filter">
                <span class="no-results">
                    <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                    <strong>{{ $rows }}</strong> results
                </span>

                <span class="sort">
                    <strong>Sort by</strong>
                    @foreach($sort_options as $label => $field)
                        @if($label === 'Relevancy')
                            <em>
                                <a href="{{ $base_search . $cleanBaseParameters . $sortSep . $field . '+desc' }}">
                                    {{ $label }}
                                </a>
                            </em>
                        @else
                            <em>{{ $label }}</em>
                            @if($label !== 'Date')
                                <a href="{{ $base_search . $cleanBaseParameters . $sortSep . $field . '+asc' }}">A-Z</a> |
                                <a href="{{ $base_search . $cleanBaseParameters . $sortSep . $field . '+desc' }}">Z-A</a>
                            @else
                                <a href="{{ $base_search . $cleanBaseParameters . $sortSep . $field . '+desc' }}">newest</a> |
                                <a href="{{ $base_search . $cleanBaseParameters . $sortSep . $field . '+asc' }}">oldest</a>
                            @endif
                        @endif
                    @endforeach
                </span>
            </div>

            <ul class="listing">
                @foreach($docs as $index => $doc)
                    @php
                        $type = 'Unknown';
                        if(isset($doc[$typeField]) && !empty($doc[$typeField])) {
                            $firstType = is_array($doc[$typeField]) ? $doc[$typeField][0] : $doc[$typeField];
                            $type = 'media-' . strtolower(str_replace(' ', '-', $firstType));
                        }

                        $docId = $doc['id'] ?? '';
                        if (is_array($docId)) {
                            $docId = $docId[0] ?? '';
                        }

                        $title = $doc[$titleField][0] ?? ($doc[$titleField] ?? 'Untitled');
                    @endphp

                    <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                        <div class="item-div">
                            <div class="iteminfo">

                                @if(array_key_exists($authorField, $doc))
                                    @php
                                        $authors = is_array($doc[$authorField]) ? $doc[$authorField] : [$doc[$authorField]];
                                    @endphp
                                    @foreach($authors as $author)
                                        @php
                                            $origFilter = urlencode($author);
                                            $lowerOrigFilter = urlencode(strtolower($author));
                                        @endphp
                                        <a class="author" href="./search/*:*/Author:%22{{ $lowerOrigFilter }}+%7C%7C%7C+{{ $origFilter }}%22">
                                            {{ $author }}
                                        </a>
                                    @endforeach
                                @endif

                                <h3>
                                    <a href="{{ url('/cockburn/record/' . $doc['id'].'?highlight='.$query) }}">
                                        {{ $title }}
                                    </a>
                                </h3>

                                <div class="tags">
                                    @if(array_key_exists($abstractField, $doc))
                                        @php
                                            $abstract = is_array($doc[$abstractField]) ? ($doc[$abstractField][0] ?? '') : $doc[$abstractField];
                                            $abstractWords = explode(' ', $abstract);
                                            $max = min(40, count($abstractWords));
                                            $suffix = count($abstractWords) > 40 ? '...' : '';
                                            $shortened = implode(' ', array_slice($abstractWords, 0, $max));
                                        @endphp
                                        <p>{{ $shortened }}{{ $suffix }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="thumbnail-image">
                                @php
                                    $displayedImage = false;
                                @endphp

                                @if(isset($doc[$imageUriField]))
                                    @php
                                        $imageUris = is_array($doc[$imageUriField]) ? $doc[$imageUriField] : [$doc[$imageUriField]];
                                    @endphp

                                    @foreach($imageUris as $imageUri)
                                        @php
                                            $imageUri = str_replace('http://', 'https://', $imageUri);
                                        @endphp

                                        @if(!$displayedImage && str_contains($imageUri, 'luna'))
                                            @php
                                                $size = @getimagesize($imageUri);
                                                $width = $size[0] ?? null;
                                                $height = $size[1] ?? null;

                                                if ($width && $height && $width > $height) {
                                                    $parms = '/120,/0/';
                                                } else {
                                                    $parms = '/,120/0/';
                                                }

                                                $thumbUrl = str_replace('/full/0/', $parms, $imageUri);
                                            @endphp

                                            <a title="{{ $title }}" class="fancybox" rel="group" href="{{ $imageUri }}">
                                                <img src="{{ $thumbUrl }}" class="record-thumbnail-search" title="{{ $title }}" />
                                            </a>

                                            @php $displayedImage = true; @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if(!$displayedImage && isset($doc[$bitstreamField]))
                                    @php
                                        $bitstreams = is_array($doc[$bitstreamField]) ? $doc[$bitstreamField] : [$doc[$bitstreamField]];
                                        $bitstreamArray = [];
                                        $minSeq = null;

                                        foreach($bitstreams as $bitstream) {
                                            $segments = explode('##', $bitstream);
                                            $filename = $segments[1] ?? null;
                                            $seq = $segments[4] ?? null;

                                            if($filename && $seq && (str_contains($filename, '.jpg') || str_contains($filename, '.JPG'))) {
                                                $bitstreamArray[$seq] = $bitstream;
                                                if($minSeq === null || $seq < $minSeq) {
                                                    $minSeq = $seq;
                                                }
                                            }
                                        }
                                    @endphp

                                    @if($minSeq !== null && count($bitstreamArray) > 0)
                                        @php
                                            $segments = explode('##', $bitstreamArray[$minSeq]);
                                            $filename = $segments[1] ?? '';
                                            $handle = $segments[3] ?? '';
                                            $seq = $segments[4] ?? '';
                                            $handleId = preg_replace('/^.*\//', '', $handle);
                                            $bitstreamUri = './record/' . $handleId . '/' . $seq . '/' . $filename;

                                            $thumbnailLink = '';
                                        @endphp

                                        @if(isset($doc[$thumbnailField]))
                                            @php
                                                $thumbnails = is_array($doc[$thumbnailField]) ? $doc[$thumbnailField] : [$doc[$thumbnailField]];
                                            @endphp

                                            @foreach($thumbnails as $thumbnail)
                                                @php
                                                    $tSegments = explode('##', $thumbnail);
                                                    $tFilename = $tSegments[1] ?? '';
                                                @endphp

                                                @if($tFilename === $filename . '.jpg')
                                                    @php
                                                        $tSeq = $tSegments[4] ?? '';
                                                        $thumbUri = './record/' . $handleId . '/' . $tSeq . '/' . $tFilename;
                                                        $thumbnailLink = '<a title="' . e($title) . '" class="fancybox" rel="group' . $index . '" href="' . $bitstreamUri . '"><img src="' . $thumbUri . '" class="search-thumbnail" title="' . e($title) . '" /></a>';
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @else
                                            @php
                                                $thumbnailLink = '<a title="' . e($title) . '" class="fancybox" rel="group' . $index . '" href="' . $bitstreamUri . '"><img src="' . $bitstreamUri . '" class="search-thumbnail" title="' . e($title) . '" /></a>';
                                            @endphp
                                        @endif

                                        {!! $thumbnailLink !!}
                                    @endif
                                @endif
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="pagination">
                <span class="no-results">
                    <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                    <strong>{{ $rows }}</strong> results
                </span>
                {!! $paginationLinks !!}
            </div>
        @endif
    </div>


@endsection
