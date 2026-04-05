@extends('layouts.guardbook')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - {{ config('skylight.fullname') }}
    @else
        Search Results - {{ config('skylight.fullname') }}
    @endif
@endsection

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $title_field = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $subject_field = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $shelfmark_field = str_replace('.', '', $fieldMappings['Shelfmark'] ?? '');
    $bitstream_field = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');

    $clean_base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters ?? '');
    $sort = $clean_base_parameters === '' ? '?sort_by=' : '&sort_by=';
@endphp

<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="content">
        @if(isset($message))
            <div class="message">{!! $message !!}</div>
        @endif
    </div>

    @if($total === 0)
        <div class="content">
            <h1>No results found</h1>
            <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
            <p>Try broadening your search or <a href="{{ url('/guardbook/search/*:*') }}">browse all items</a>.</p>
        </div>
    @else
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination pagination-sm pagination-xs">
                        {!! $paginationLinks !!}
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row search-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num">
                <h5 class="text-muted">Showing {{ $rows }} results</h5>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num sort">
                <h5 class="text-muted">
                    Sort By:
                    @foreach($sort_options as $label => $field)
                        @if($label === 'Relevancy')
                            <em>
                                <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">{{ $label }}</a>
                            </em>
                        @else
                            <em>{{ $label }}</em>
                            @if($label !== 'Date')
                                <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+asc' }}">A-Z</a> |
                                <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">Z-A</a>
                            @else
                                <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">newest</a> |
                                <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+asc' }}">oldest</a>
                            @endif
                        @endif
                    @endforeach
                </h5>
            </div>
        </div>

        @foreach($docs as $index => $doc)
            @php
                $title = $doc[$title_field][0] ?? 'Untitled';
                $docId = $doc['id'] ?? '';
                if (is_array($docId)) {
                    $docId = $docId[0] ?? '';
                }

                $shelfmark = '';
                if ($shelfmark_field !== '' && isset($doc[$shelfmark_field])) {
                    $rawShelfmark = $doc[$shelfmark_field];
                    $shelfmark = is_array($rawShelfmark) ? (string) ($rawShelfmark[0] ?? '') : (string) $rawShelfmark;
                }

                $pdfStreams = [];
                if ($bitstream_field !== '' && isset($doc[$bitstream_field])) {
                    $rawStreams = $doc[$bitstream_field];
                    $streams = is_array($rawStreams) ? $rawStreams : [$rawStreams];

                    $pdfStreams = \App\Helpers\BitstreamHelper::orderPdfBitstreamsForDownload(
                        array_map(static fn ($bs): string => (string) $bs, $streams)
                    );
                }
            @endphp

            <div class="row search-row">
                <h3>
                    <a href="{{ url('/guardbook/record/' . $docId) }}?highlight={{ urlencode($query) }}">
                        {{ $title }}
                    </a>
                </h3>

                <p>
                    @if($shelfmark !== '')
                        Shelfmark: {{ $shelfmark }}
                    @endif
                </p>

                @if($bitstream_field !== '' && isset($doc[$bitstream_field]))
                    <p>
                        @if(count($pdfStreams) > 1)
                            Multiple PDFs. Open the record to view them all.
                        @elseif(count($pdfStreams) === 1)
                            @php
                                $t_segments = explode("##", $pdfStreams[0]);
                                $t_filename = $t_segments[1];
                            @endphp
                            <a
                                href="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl(\App\Helpers\BitstreamHelper::getCollectionProxiedUrl($pdfStreams[0])) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="downloadButton"
                            >
                                Download {{$t_filename}}<span class="visually-hidden"> (opens in a new tab)</span>
                            </a>
                        @else
                            <div class="record-bitstreams">
                                <a href="./unavailable" title="Click here to find out why this may be unavailable">PDF unavailable</a>
                            </div>
                        @endif
                    </p>
                @else
                    <p>
                        <a href="./unavailable" title="Click here to find out why this paper may be unavailable">PDF unavailable</a>
                    </p>
                @endif
            </div>
        @endforeach

        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination pagination-sm pagination-xs">
                        {!! $paginationLinks !!}
                    </ul>
                </nav>
            </div>
        </div>
    @endif
</div>

<div class="col-sidebar">
    @include('guardbook.search.partials.facets')
</div>
@endsection
