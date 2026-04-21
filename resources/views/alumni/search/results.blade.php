@extends('layouts.alumni')

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
    $author_field = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $date_field = str_replace('.', '', $fieldMappings['Year'] ?? '');
    $type_field = str_replace('.', '', $fieldMappings['Type'] ?? '');
    $bitstream_field = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
    $thumbnail_field = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');
    $subject_field = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $collection_field = str_replace('.', '', $fieldMappings['Collection'] ?? '');

    $clean_base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters ?? '');
    $sort = $clean_base_parameters === '' ? '?sort_by=' : '&sort_by=';
@endphp

<div class="col-content">
    @if(isset($message))
        <div class="message">{!! $message !!}</div>
    @endif

    @if(empty($docs) || $rows == 0)
        <div class="content">
            <h1>No results found</h1>
            <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
            <p>Try broadening your search or <a href="{{ url('/alumni/search/*:*') }}">browse all items</a>.</p>
        </div>
    @else

        <div class="listing-filter">
            <span class="no-results">
                <strong>{{ $startrow }}-{{ $endrow }}</strong> of
                <strong>{{ $rows }}</strong> results
            </span>

            <span class="sort">
                <strong>Sort by</strong>
                @foreach($sort_options as $label => $field)
                    @if($label == 'Relevancy')
                        <em>
                            <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">
                                {{ $label }}
                            </a>
                        </em>
                    @else
                        <em>{{ $label }}</em>
                        @if($label != 'Year')
                            <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+asc' }}">A-Z</a> |
                            <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">Z-A</a>
                        @else
                            <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+desc' }}">newest</a> |
                            <a href="{{ $base_search . $clean_base_parameters . $sort . $field . '+asc' }}">oldest</a>
                        @endif
                    @endif
                @endforeach
            </span>
        </div>

        <ul class="listing">
            @foreach($docs as $index => $doc)
                @php
                    $type = 'Unknown';
                    if($type_field !== '' && isset($doc[$type_field])) {
                        $rawType = is_array($doc[$type_field]) ? ($doc[$type_field][0] ?? 'Unknown') : $doc[$type_field];
                        $type = 'media-' . strtolower(str_replace(' ', '-', $rawType));
                    }

                    $liClass = '';
                    if($index === 0) {
                        $liClass = 'first';
                    } elseif($index === count($docs) - 1) {
                        $liClass = 'last';
                    }

                    $docId = $doc['id'] ?? '';
                    if (is_array($docId)) {
                        $docId = $docId[0] ?? '';
                    }

                    $title = $doc[$title_field][0] ?? 'Untitled';
                    $bitstream_array = [];
                    $min_seq = null;
                    $thumbnailLink = '';
                @endphp

                <li @if($liClass) class="{{ $liClass }}" @endif>
                    <div class="item-div">
                        <div class="iteminfo">
                            <h3>
                                <a href="./record/{{ $docId }}?highlight={{ urlencode($query) }}">
                                    {{ $title }}
                                </a>
                            </h3>

                            <div class="tags">
                                @if($collection_field !== '' && array_key_exists($collection_field, $doc))
                                    @foreach($doc[$collection_field] as $collection)
                                        @php
                                            $orig_filter = urlencode($collection);
                                            $lower_orig_filter = urlencode(strtolower($collection));
                                        @endphp
                                        <a href="./search/*:*/Collection:%22{{ $lower_orig_filter }}+%7C%7C%7C+{{ $orig_filter }}%22">
                                            {{ $collection }}
                                        </a>
                                    @endforeach
                                @endif

                                @if($date_field !== '' && array_key_exists($date_field, $doc))
                                    @foreach($doc[$date_field] as $date)
                                        @php
                                            $orig_filter = urlencode($date);
                                            $lower_orig_filter = urlencode(strtolower($date));
                                        @endphp
                                        <a href="./search/*:*/Year:%22{{ $lower_orig_filter }}+%7C%7C%7C+{{ $orig_filter }}%22">
                                            {{ $date }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="thumbnail-image">
                            @if($bitstream_field !== '' && isset($doc[$bitstream_field]))
                                @foreach($doc[$bitstream_field] as $bitstream)
                                    @php
                                        $b_segments = explode('##', $bitstream);
                                        $b_filename = $b_segments[1] ?? '';
                                        $b_seq = $b_segments[4] ?? null;

                                        if (
                                            $b_seq !== null &&
                                            (str_contains($b_filename, '.jpg') || str_contains($b_filename, '.JPG'))
                                        ) {
                                            $bitstream_array[$b_seq] = $bitstream;

                                            if ($min_seq === null || $b_seq < $min_seq) {
                                                $min_seq = $b_seq;
                                            }
                                        }
                                    @endphp
                                @endforeach

                                @if($min_seq !== null && count($bitstream_array) > 0)
                                    @php
                                        $selectedBitstream = $bitstream_array[$min_seq];
                                        $b_segments = explode('##', $selectedBitstream);
                                        $b_filename = $b_segments[1] ?? '';
                                        $b_handle = $b_segments[3] ?? '';
                                        $b_seq = $b_segments[4] ?? '';
                                        $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
                                        $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                                    @endphp

                                    @if($thumbnail_field !== '' && isset($doc[$thumbnail_field]))
                                        @foreach($doc[$thumbnail_field] as $thumbnail)
                                            @php
                                                $t_segments = explode('##', $thumbnail);
                                                $t_filename = $t_segments[1] ?? '';
                                            @endphp

                                            @if($t_filename === $b_filename . '.jpg')
                                                @php
                                                    $t_seq = $t_segments[4] ?? '';
                                                    $t_uri = './record/' . $b_handle_id . '/' . $t_seq . '/' . $t_filename;
                                                    $thumbnailLink =
                                                        '<a title="' . e($title) . '" class="fancybox" rel="group' . $loop->parent->index . '" href="' . $b_uri . '">' .
                                                        '<img src="' . $t_uri . '" class="search-thumbnail" title="' . e($title) . '" />' .
                                                        '</a>';
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if($thumbnailLink === '')
                                            @php
                                                $thumbnailLink =
                                                    '<a title="' . e($title) . '" class="fancybox" rel="group' . $index . '" href="' . $b_uri . '">' .
                                                    '<img src="' . $b_uri . '" class="search-thumbnail" title="' . e($title) . '" />' .
                                                    '</a>';
                                            @endphp
                                        @endif
                                    @else
                                        @php
                                            $thumbnailLink =
                                                '<a title="' . e($title) . '" class="fancybox" rel="group' . $index . '" href="' . $b_uri . '">' .
                                                '<img src="' . $b_uri . '" class="search-thumbnail" title="' . e($title) . '" />' .
                                                '</a>';
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
                <strong>{{ $startrow }}-{{ $endrow }}</strong> of
                <strong>{{ $rows }}</strong> results
            </span>
            {!! $pagelinks !!}
        </div>

    @endif
</div>

<div class="col-sidebar">
    @include('alumni.search.partials.facets')
</div>
@endsection
