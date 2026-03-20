@extends('layouts.art')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - University of Edinburgh Art Collection
    @else
        Search Results - University of Edinburgh Art Collection
    @endif
@endsection

@section('content')
<div class="row">
    <div class="col-lg-9">
        @if(isset($searchFields))

<h3 class="adv-search">Advanced Search</h3>

<p class="adv-search"><strong><a href="#" id="showform">Change Advanced Search options</a></strong></p>

<div class="searchform" style="display:none">
    <p><strong>Hint: </strong> To match an exact phrase, try using quotation marks, eg. <em>"a search phrase"</em></p>
<form action="{{ url('/art/advanced/post') }}" method="post" accept-charset="utf-8">
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

        @if($total === 0)
            <div class="content">
                <h1>No results found</h1>
                <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
                <p>Try broadening your search or <a href="{{ url('/art/search/*:*') }}">browse all items</a>.</p>
            </div>
        @else
        @php
            $sortParam = empty($base_parameters) ? '?sort_by=' : '&sort_by=';
        @endphp
        <div class="listing-filter">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ $total }}</strong> results
            </span>

            <span class="sort">
                <strong>Sort by</strong>
                @foreach($sort_options as $label => $field)
                    @if($label === 'Relevancy')
                        <em><a href="{{ $base_search }}{{ $base_parameters }}{{ $sortParam }}{{ $field }}+desc" title="{{ $label }}">{{ $label }}</a></em>
                    @else
                        <em>{{ $label }}</em>
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortParam }}{{ $field }}+asc" title="Sort by alphabetical order">A-Z</a> |
                        <a href="{{ $base_search }}{{ $base_parameters }}{{ $sortParam }}{{ $field }}+desc" title="Sort by reverse alphabetical order">Z-A</a>
                    @endif
                @endforeach
            </span>
        </div>

        <ul class="listing">
            @foreach($docs as $index => $doc)
                @php
                    $fieldMappings = config('skylight.field_mappings', []);
                    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
                    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
                    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
                    $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
                    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');

                    $title = $doc[$titleField][0] ?? 'Untitled';
                    $docId = $doc['id'] ?? '';
                    if (is_array($docId)) { $docId = $docId[0] ?? ''; }
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                    <div class="item-div">
                        <div class="iteminfo">
                            @if(isset($doc[$authorField]) && !empty($doc[$authorField]))
                                @php $authors = is_array($doc[$authorField]) ? $doc[$authorField] : [$doc[$authorField]]; @endphp
                                @foreach($authors as $author)
                                    @php
                                        $origFilter = urlencode($author);
                                        $lowerFilter = urlencode(strtolower($author));
                                    @endphp
                                    <a class="artist" href="{{ url('/art/search/*:*/Artist:%22' . $lowerFilter . '%7C%7C%7C' . $origFilter . '%22') }}" title="{{ $author }}">{{ $author }}</a>
                                @endforeach
                            @endif

                            <h3 class="record-title">
                                <a href="{{ url('/art/record/' . $docId) }}?highlight={{ urlencode($query) }}">{{ $title }}@if(isset($doc[$dateField])) ({{ $doc[$dateField][0] }})@endif</a>
                            </h3>

                            <div class="tags">
                                @if(isset($doc[$abstractField]) && !empty($doc[$abstractField]))
                                    @php
                                        $abstract = is_array($doc[$abstractField]) ? $doc[$abstractField][0] : $doc[$abstractField];
                                        $words = explode(' ', $abstract);
                                        $max = min(40, count($words));
                                        $suffix = count($words) > 40 ? '...' : '';
                                        $shortened = implode(' ', array_slice($words, 0, $max));
                                    @endphp
                                    <p>{{ $shortened }}{{ $suffix }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="thumbnail-image-search">
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
                                    $iiifUrlSmall = $imageUri ? str_replace('/full/0/', '/!250,250/0/', $imageUri) : null;
                                @endphp
                                @if($imageUri)
                                    <a title="{{ $title }}" class="fancybox" rel="group" href="{{ $imageUri }}">
                                        <img src="{{ $iiifUrlSmall }}" class="record-thumbnail-search" alt="{{ $title }}" loading="lazy" />
                                    </a>
                                @endif
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="pagination search">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ $total }}</strong> results
            </span>
            <div class="page-links">{!! $paginationLinks !!}</div>
        </div>

        <br/>
        <br/>
        @endif
    </div>
    <div class="col-lg-3 search facets">
        @include('art.search.partials.facets')
    </div>
</div>
@endsection
