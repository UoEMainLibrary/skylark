@extends('layouts.mimed')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - Musical Instrument Museums Edinburgh
    @else
        Search Results - Musical Instrument Museums Edinburgh
    @endif
@endsection

@section('content')
<div class="col-main">
<div class="content">
    @if(isset($searchFields))

<h1>Advanced Search</h1>

<p><strong><a href="#" id="showform">Change Advanced Search options</a></strong></p>

<div class="searchform" style="display:none">
    <p><strong>Hint: </strong> To match an exact phrase, try using quotation marks, eg. <em>"a search phrase"</em></p>
<form action="{{ url('/mimed/advanced/post') }}" method="post" accept-charset="utf-8">
@csrf
@foreach($searchFields as $label => $field)
@php $escapedLabel = str_replace(' ', '_', $label); @endphp
<p><label for="{{ $escapedLabel }}" style="width: 100px; float: left; display: block; text-align: right;">{{ $label }}</label><input type="text" name="{{ $escapedLabel }}" value="" id="{{ $escapedLabel }}" style="margin-left: 15px;"  /></p>
@endforeach
<p><label for="operators" style="width: 100px; float: left; display: block; text-align: right;">Default search operator</label><select name="operator" style="margin-left:15px;">
<option value="OR"{{ ($operator ?? 'OR') === 'OR' ? ' selected="selected"' : '' }}>OR (any terms may match)</option>
<option value="AND"{{ ($operator ?? 'OR') === 'AND' ? ' selected="selected"' : '' }}>AND (all terms must match)</option>
</select></p><p style="margin-left: 120px;"><em>Use <strong>AND</strong> for narrow searches and <strong>OR</strong> for broad searches</em></p><input type="submit" name="search" value="Search" style="margin-left: 120px" class="btn" /></form>
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
</div>
    @if($total === 0)
        <div class="content">
            <h1>No results found</h1>
            <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
            <p>Try broadening your search or <a href="{{ url('/mimed/search/*:*') }}">browse all items</a>.</p>
        </div>
    @else
        <div class="listing-filter">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ number_format($total) }}</strong> results
            </span>
            <span class="sort">
                <strong>Sort by</strong>
                @foreach(config('skylight.sort_fields', []) as $label => $field)
                    @if($label === 'Relevancy')
                        <em><a href="{{ $base_search }}{{ $base_parameters }}{{ str_contains($base_parameters, '?') ? '&' : '?' }}sort_by={{ $field }}+desc">{{ $label }}</a></em>
                    @else
                        <em>{{ $label }}</em>
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ str_contains($base_parameters, '?') ? '&' : '?' }}sort_by={{ $field }}+asc">A-Z</a> |
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ str_contains($base_parameters, '?') ? '&' : '?' }}sort_by={{ $field }}+desc">Z-A</a>
                    @endif
                @endforeach
            </span>
        </div>

        <ul class="listing">
            @foreach($docs as $index => $doc)
                @php
                    $fieldMappings = config('skylight.field_mappings', []);
                    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
                    $authorField = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
                    $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
                    $typeField = str_replace('.', '', $fieldMappings['Instrument'] ?? $fieldMappings['Type'] ?? '');
                    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');

                    $title = $doc[$titleField][0] ?? 'Untitled';
                    $docId = $doc['id'] ?? '';
                    if (is_array($docId)) { $docId = $docId[0] ?? ''; }
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                    <div class="item-div">
                        <div class="iteminfo">
                            <h3><a href="{{ url('/mimed/record/' . $docId) }}?highlight={{ urlencode($query) }}">{{ $title }}</a></h3>
                            <div class="tags">
                                @if(isset($doc[$authorField]) && !empty($doc[$authorField]))
                                    @php
                                        $authors = is_array($doc[$authorField]) ? $doc[$authorField] : [$doc[$authorField]];
                                    @endphp
                                    @foreach($authors as $author)
                                        @php
                                            $origFilter = urlencode($author);
                                            $lowerFilter = urlencode(strtolower($author));
                                        @endphp
                                        <a href="{{ url('/mimed/search/*:*/Maker:%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}">{{ str_replace('|', "\u{00A0}", $author) }}</a>
                                    @endforeach
                                @endif

                                @if(isset($doc[$abstractField]) && !empty($doc[$abstractField]))
                                    @php
                                        $abstract = is_array($doc[$abstractField]) ? $doc[$abstractField][0] : $doc[$abstractField];
                                        $abstract = str_replace('|', "\u{00A0}", $abstract);
                                        $words = explode(' ', $abstract);
                                        $max = min(40, count($words));
                                        $suffix = count($words) > 40 ? '...' : '';
                                        $shortened = implode(' ', array_slice($words, 0, $max));
                                    @endphp
                                    <p>{{ $shortened }}{{ $suffix }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="thumbnail-image">
                            @if(isset($doc[$imageUriField]) && !empty($doc[$imageUriField]))
                                @php
                                    $imageUris = is_array($doc[$imageUriField]) ? $doc[$imageUriField] : [$doc[$imageUriField]];
                                    $imageUri = null;
                                    foreach ($imageUris as $uri) {
                                        $uri = str_replace('http://', 'https://', $uri);
                                        if (str_contains($uri, 'luna')) {
                                            $imageUri = $uri;
                                            break;
                                        }
                                    }
                                @endphp
                                @if($imageUri)
                                    <div class="thumbnail-placeholder"></div>
                                    <a title="{{ $title }}" class="fancybox" rel="group" href="{{ $imageUri }}">
                                        <img src="{{ $imageUri }}" class="record-thumbnail-search" title="{{ $title }}" loading="lazy"/>
                                    </a>
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
                <strong>{{ number_format($total) }}</strong> results
            </span>
            {!! $paginationLinks !!}
        </div>

        <script>
            const thumbnailImages = document.querySelectorAll(".thumbnail-image")
            thumbnailImages.forEach(div => {
                const img = div.querySelector("img")
                const placeholder = div.querySelector(".thumbnail-placeholder")
                if (!img || !placeholder) return;
                function loaded() { placeholder.style.display = "none"; }
                if (img.complete) { loaded() }
                else { img.addEventListener("load", loaded) }
            })
        </script>
    @endif
</div>

<div class="col-sidebar">
    @include('mimed.search.partials.facets')
</div>
@endsection
