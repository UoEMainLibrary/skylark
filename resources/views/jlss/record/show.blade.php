@extends('layouts.jlss')

@php
    $displayTitle = $recordTitle;
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $identifierField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
    $itemImageField = str_replace('.', '', $fieldMappings['ItemImage'] ?? '');
@endphp
@section('title', $displayTitle)

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <h1 class="itemtitle">{{ strip_tags($displayTitle) }}</h1>
    </div>

    @php
        $itemImageValue = $itemImageField !== '' ? ($record[$itemImageField] ?? null) : null;
        $itemImage = is_array($itemImageValue) ? ($itemImageValue[0] ?? null) : $itemImageValue;
        $tileSource = $itemImage ? config('skylight.image_server').'/iiif/2/'.$itemImage.'/info.json' : null;
    @endphp

    @if($tileSource)
        <div class="full-image">
            <div id="openseadragon" class="image-toggle"></div>
            <script>
                OpenSeadragon({
                    id: "openseadragon",
                    prefixUrl: "{{ asset('collections/jlss/images/buttons') }}/",
                    preserveViewport: false,
                    visibilityRatio: 1,
                    minZoomLevel: 0,
                    defaultZoomLevel: 0,
                    panHorizontal: true,
                    sequenceMode: false,
                    tileSources: ["{{ $tileSource }}"]
                });
            </script>
        </div>
        <div class="image-disclaimer">
            <p class="image-disclaimer">
                * All reasonable steps have been taken to establish copyright on the above image. If you feel that copyright has been infringed
                and would like to request that this image be taken down, please contact a member of <a href="https://www.sjac.org.uk/contact/"
                alt="link to sjac website" title="Click to contact SJAC via their website" class="image-disclaimer">SJAC</a>
            </p>
        </div>
    @endif

    <div class="row full-metadata">
        <table class="table">
            <tbody>
            @foreach($recordDisplay as $label)
                @php
                    $mappedField = str_replace('.', '', $fieldMappings[$label] ?? '');
                    $recordValues = $mappedField !== '' ? ($record[$mappedField] ?? null) : null;
                @endphp
                @if(!empty($recordValues))
                    <tr>
                        <th>{{ $label }}</th>
                        <td>
                            @foreach((array) $recordValues as $value)
                                {{ is_array($value) ? implode(', ', $value) : $value }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <button class="btn btn-info" onClick="history.go(-1);"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results</button>
    </div>
</div>

<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="header-search">
            <div id="collection-search">
                <form action="{{ \App\Support\CollectionUrl::url('search') }}" method="post" class="navbar-form">
                    @csrf
                    <div class="input-group search-box">
                        <input type="text" class="form-control" placeholder="Search" name="q" id="q">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="sidebar-nav related-items">
            <ul class="list-group">
                <li class="list-group-item active">Related Items</li>
                @if(!empty($relatedItems) && count($relatedItems) > 0)
                    @foreach($relatedItems as $relatedItem)
                        @php
                            $relatedTitleValue = $relatedItem[$titleField] ?? null;
                            $relatedIdentifierValue = $relatedItem[$identifierField] ?? null;
                            $relatedIdentifier = is_array($relatedIdentifierValue) ? ($relatedIdentifierValue[0] ?? null) : $relatedIdentifierValue;
                            $relatedTitle = is_array($relatedTitleValue)
                                ? ($relatedTitleValue[0] ?? ($relatedIdentifier ?: 'Untitled'))
                                : ($relatedTitleValue ?: ($relatedIdentifier ?: 'Untitled'));
                            $relatedId = $relatedItem['id'] ?? '';
                            if (is_array($relatedId)) {
                                $relatedId = $relatedId[0] ?? '';
                            }
                        @endphp
                        <li class="list-group-item">
                            <a class="related-record" href="{{ \App\Support\CollectionUrl::url('record/'.$relatedId) }}">{{ strip_tags((string) $relatedTitle) }}</a>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item">None.</li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
