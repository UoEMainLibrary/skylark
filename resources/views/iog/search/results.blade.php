@extends('layouts.iog')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - {{ config('skylight.fullname') }}
    @else
        Search Results - {{ config('skylight.fullname') }}
    @endif
@endsection

@section('content')
@php
    $creatorFilterKey = 'Author';
@endphp
<div class="content search-results-page">
    @if(isset($searchFields))

        <h1>Advanced Search</h1>

        <p><strong><a href="#" id="showform">Change Advanced Search options</a></strong></p>

        <div class="searchform" style="display:none">
            <p><strong>Hint: </strong> To match an exact phrase, try using quotation marks, eg. <em>"a search phrase"</em></p>
            <form action="{{ $collectionUrl('advanced/post') }}" method="post" accept-charset="utf-8">
                @csrf
                @foreach($searchFields as $label => $field)
                    @php $escapedLabel = str_replace(' ', '_', $label); @endphp
                    <p><label for="{{ $escapedLabel }}" style="width: 100px; float: left; display: block; text-align: right;">{{ $label }}</label><input type="text" name="{{ $escapedLabel }}" value="" id="{{ $escapedLabel }}" style="margin-left: 15px;" /></p>
                @endforeach
                <p><label for="operators" style="width: 100px; float: left; display: block; text-align: right;">Default search operator</label><select name="operator" style="margin-left:15px;">
                        <option value="OR"{{ ($operator ?? 'OR') === 'OR' ? ' selected="selected"' : '' }}>OR (any terms may match)</option>
                        <option value="AND"{{ ($operator ?? 'OR') === 'AND' ? ' selected="selected"' : '' }}>AND (all terms must match)</option>
                    </select></p>
                <p style="margin-left: 120px;"><em>Use <strong>AND</strong> for narrow searches and <strong>OR</strong> for broad searches</em></p>
                <input type="submit" name="search" value="Search" style="margin-left: 120px" class="btn" />
            </form>
        </div>

        <script>
            $("#showform").click(function() {
                $(".searchform").show();
                $(this).hide();
                $(".message").hide();
                @if(isset($savedSearch))
                    @foreach($savedSearch as $key => $val)
                        $("input#{{ str_replace(' ', '_', $key) }}").val('{{ urldecode($val) }}');
                    @endforeach
                @endif
                return false;
            });
        </script>
    @endif

    @if(isset($message))
        <div class="message">{!! $message !!}</div>
    @endif

    @if($total === 0)
        <h1>No results found</h1>
        @if($query === '*:*' || $query === '*')
            <p>Your search did not return any results.</p>
        @else
            <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
        @endif
        <p>Try broadening your search or <a href="{{ $collectionUrl('search/*:*') }}">browse all items</a>.</p>
    @else
        <div class="listing-filter">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ number_format($total) }}</strong> results
            </span>
            <span class="sort">
                <strong>Sort by</strong>
                @foreach(config('skylight.sort_fields', []) as $label => $field)
                    @php
                        $field = trim($field);
                        $sortGlue = str_contains($base_parameters, '?') ? '&' : '?';
                    @endphp
                    @if($label === 'Relevancy')
                        <em><a href="{{ $base_search }}{{ $base_parameters }}{{ $sortGlue }}sort_by={{ $field }}+desc">{{ $label }}</a></em>
                    @elseif($label === 'Date')
                        <em>{{ $label }}</em>
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortGlue }}sort_by={{ $field }}+desc">newest</a> |
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortGlue }}sort_by={{ $field }}+asc">oldest</a>
                    @else
                        <em>{{ $label }}</em>
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortGlue }}sort_by={{ $field }}+asc">A-Z</a> |
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortGlue }}sort_by={{ $field }}+desc">Z-A</a>
                    @endif
                @endforeach
            </span>
        </div>

        <ul class="listing">
            @foreach($docs as $index => $doc)
                @php
                    $fieldMappings = config('skylight.field_mappings', []);
                    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
                    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
                    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
                    $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
                    $seriesField = str_replace('.', '', $fieldMappings['Series'] ?? '');

                    $title = $doc[$titleField][0] ?? 'Untitled';
                    $docId = $doc['id'] ?? '';
                    if (is_array($docId)) {
                        $docId = $docId[0] ?? '';
                    }
                    $date = '';
                    if ($dateField !== '' && isset($doc[$dateField])) {
                        $rawDate = $doc[$dateField];
                        $date = is_array($rawDate) ? (string) ($rawDate[0] ?? '') : (string) $rawDate;
                    } elseif (isset($doc['dateIssuedyear'])) {
                        $rawDate = $doc['dateIssuedyear'];
                        $date = is_array($rawDate) ? (string) ($rawDate[0] ?? '') : (string) $rawDate;
                    }

                    $abstract = '';
                    if ($abstractField !== '' && isset($doc[$abstractField])) {
                        $rawAbstract = $doc[$abstractField];
                        $abstract = is_array($rawAbstract) ? (string) ($rawAbstract[0] ?? '') : (string) $rawAbstract;
                        $words = explode(' ', $abstract);
                        $max = 40;
                        $suffix = count($words) > $max ? '...' : '';
                        $abstract = implode(' ', array_slice($words, 0, $max)).$suffix;
                    }

                    $series = '';
                    if ($seriesField !== '' && isset($doc[$seriesField])) {
                        $rawSeries = $doc[$seriesField];
                        $series = is_array($rawSeries) ? (string) ($rawSeries[0] ?? '') : (string) $rawSeries;
                    }
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                    <div class="iteminfo">
                        <h3><a href="{{ $collectionUrl('record/'.$docId) }}?highlight={{ urlencode($query) }}">{{ $title }}</a></h3>
                        <div class="tags">
                            @if($authorField !== '' && isset($doc[$authorField]) && ! empty($doc[$authorField]))
                                @php
                                    $authors = is_array($doc[$authorField]) ? $doc[$authorField] : [$doc[$authorField]];
                                @endphp
                                @foreach($authors as $author)
                                    {!! $loop->first ? '' : ' ' !!}
                                    @php
                                        $origFilter = urlencode($author);
                                        $lowerFilter = urlencode(strtolower($author));
                                    @endphp
                                    <a href="{{ $collectionUrl('search/*:*/'.$creatorFilterKey.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}">{{ str_replace('|', "\u{00A0}", $author) }}</a>
                                @endforeach
                            @endif
                            @if($date !== '')
                                <span>({{ $date }})</span>
                            @endif
                            @if($abstract !== '')
                                <p>{{ $abstract }}</p>
                            @endif
                        </div>

                        @if($series !== '')
                            <p>{{ $series }}</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="pagination">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ number_format($total) }}</strong> results
            </span>
            {!! $paginationLinks !!}
        </div>
    @endif
</div>
@endsection

@section('sidebar')
    @include('iog.partials.sidebar-facets', [
        'facets' => $facets,
        'base_search' => $base_search,
        'delimiter' => $delimiter,
        'base_parameters' => $base_parameters,
    ])
@endsection
