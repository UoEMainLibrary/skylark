@extends('layouts.iconics')

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
    $bitstreamField = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
    $thumbnailField = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');

    $cleanBaseParameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters ?? '');
    $sortSep = $cleanBaseParameters === '' ? '?sort_by=' : '&sort_by=';
@endphp

    @if(isset($message))
        <div class="message">{!! $message !!}</div>
    @endif

    @if($total === 0)
        <div class="search_results">
            <p>There were no matching records. Please try again.</p>
        </div>
    @else
        <nav>
            <div class="listing-filter">
                <span class="no-results">
                    <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                    <strong>{{ number_format($total) }}</strong> results
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
        </nav>

        <div class="container-fluid">
            <div class="row">
                @foreach($docs as $index => $doc)
                    @php
                        $docId = $doc['id'] ?? '';
                        if (is_array($docId)) {
                            $docId = $docId[0] ?? '';
                        }

                        $title = $doc[$titleField][0] ?? ($doc[$titleField] ?? 'Untitled');

                        $thumbUri = null;
                        $bitstreamUri = null;

                        if ($bitstreamField && ! empty($doc[$bitstreamField])) {
                            $bitstreams = is_array($doc[$bitstreamField]) ? $doc[$bitstreamField] : [$doc[$bitstreamField]];
                            $bitstreamArray = [];
                            $minSeq = null;

                            foreach ($bitstreams as $bitstream) {
                                $segments = explode('##', $bitstream);
                                $filename = $segments[1] ?? '';
                                $seq = $segments[4] ?? null;

                                if ($seq !== null && (str_contains($filename, '.jpg') || str_contains($filename, '.JPG'))) {
                                    $bitstreamArray[$seq] = $bitstream;
                                    if ($minSeq === null || $seq < $minSeq) {
                                        $minSeq = $seq;
                                    }
                                }
                            }

                            if ($minSeq !== null && count($bitstreamArray) > 0) {
                                $bSegments = explode('##', $bitstreamArray[$minSeq]);
                                $bFilename = $bSegments[1] ?? '';
                                $bHandle = $bSegments[3] ?? '';
                                $bSeq = $bSegments[4] ?? '';
                                $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
                                $bitstreamUri = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;

                                $thumbUri = $bitstreamUri;

                                if ($thumbnailField && ! empty($doc[$thumbnailField])) {
                                    $thumbnails = is_array($doc[$thumbnailField]) ? $doc[$thumbnailField] : [$doc[$thumbnailField]];
                                    foreach ($thumbnails as $thumbnail) {
                                        $tSegments = explode('##', $thumbnail);
                                        $tFilename = $tSegments[1] ?? '';
                                        if ($tFilename === $bFilename.'.jpg') {
                                            $tSeq = $tSegments[4] ?? '';
                                            $thumbUri = './record/'.$bHandleId.'/'.$tSeq.'/'.$tFilename;
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        if ($thumbUri === null) {
                            $thumbUri = asset('collections/iconics/images/comingsoon.gif');
                        }
                    @endphp

                    <div class="col-xs-6 col-md-3">
                        <div class="thumbnail results-thumbnail">
                            <a href="./record/{{ $docId }}" title="{{ $title }}">
                                <img src="{{ $thumbUri }}" class="search-thumbnail" title="{{ $title }}" alt="{{ $title }}" />
                            </a>
                            <p>
                                <a href="./record/{{ $docId }}?highlight={{ $query }}">{{ $title }}</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <nav>
            <div class="pagination">
                <span class="no-results">
                    <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                    <strong>{{ number_format($total) }}</strong> results
                </span>
                {!! $paginationLinks !!}
            </div>
        </nav>
    @endif
@endsection
