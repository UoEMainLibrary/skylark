@extends('layouts.speccoll')

@section('title', $recordTitle . ' - Special Collections')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $manifestEndpoint = rtrim((string) config('skylight.manifest_endpoint', ''), '/').'/';

    $titleField     = str_replace('.', '', $fieldMappings['Title']     ?? 'dctitleen');
    $authorField    = str_replace('.', '', $fieldMappings['Author']    ?? '');
    $shelfmarkField = str_replace('.', '', $fieldMappings['Shelfmark'] ?? '');
    $dateField      = str_replace('.', '', $fieldMappings['Date']      ?? '');
    $manifestField  = str_replace('.', '', $fieldMappings['Manifest']  ?? '');
    $imageUriField  = str_replace('.', '', $fieldMappings['ImageURI']  ?? '');

    $firstValue = static function (array $doc, string $field, string $fallback = ''): string {
        if ($field === '' || ! isset($doc[$field])) {
            return $fallback;
        }
        $value = $doc[$field];

        return (string) (is_array($value) ? ($value[0] ?? $fallback) : $value);
    };

    // Legacy record.php builds the section-1 header by iterating every value of
    // each field and letting the last one win, so multi-value fields (like
    // Author) end up showing the last entry. Mirror that here so the title bar
    // reads identically to old.collections.
    $lastValue = static function (array $doc, string $field, string $fallback = ''): string {
        if ($field === '' || ! isset($doc[$field])) {
            return $fallback;
        }
        $value = $doc[$field];
        if (is_array($value)) {
            return (string) ($value[array_key_last($value)] ?? $fallback);
        }

        return (string) $value;
    };

    $title      = $lastValue($record, $titleField, 'Unnamed item');
    $maker      = $lastValue($record, $authorField, 'Unknown author');
    $date       = $lastValue($record, $dateField, 'Undated');
    $shelfmark  = $firstValue($record, $shelfmarkField);
    $manifestId = $firstValue($record, $manifestField);

    $manifest  = $manifestId !== '' && $manifestEndpoint !== '/'
        ? $manifestEndpoint.$manifestId.'/manifest'
        : null;

    $requestUri = request()->getRequestUri();
@endphp

<div class="container-fluid content">
    <nav class="navbar navbar-fixed-top second-navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#record-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div>
                <div class="collapse navbar-collapse" id="record-navbar">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ $requestUri }}#stc-section1">Top</a></li>
                        <li><a href="{{ $requestUri }}#stc-section2">Image</a></li>
                        <li><a href="{{ $requestUri }}#stc-section3">Description</a></li>
                        <li><a href="{{ $requestUri }}#stc-section5">Catalogue Data</a></li>
                        <li><a href="{{ $requestUri }}#stc-section6">Related Items</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="stc-section1" class="container-fluid record-content">
        <h2 class="itemtitle hidden-sm hidden-xs">{{ $title }} | {{ $maker }} | {{ $date }}</h2>
        <h4 class="itemtitle hidden-lg hidden-md">{{ $title }} | {{ $maker }} | {{ $date }}</h4>
    </div>

    @if($manifest)
        <div id="stc-section2" class="container-fluid">
            <div class="uv-cell">
                <div class="uv-fill">
                    <iframe class="uv-sizer" allowfullscreen="true" src="https://librarylabs.ed.ac.uk/iiif/uv/?manifest={{ $manifest }}"></iframe>
                </div>
            </div>
            <div class="json-link">
                <p>
                    <span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest={{ $manifest }}" target="_blank" rel="noopener" class="uvlogo" title="View in UV"></a></span>
                    <span class="json-link-item"><a target="_blank" rel="noopener" title="View in Mirador" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest={{ $manifest }}" class="miradorlogo"></a></span>
                    <span class="json-link-item"><a href="{{ $manifest }}" target="_blank" rel="noopener" class="iiiflogo" title="IIIF manifest"></a></span>
                </p>
            </div>
        </div>
    @endif

    <div id="stc-section5" class="panel panel-default container-fluid">
        <div class="panel-heading straight-borders">
            <h2 class="panel-title hidden-sm hidden-xs">
                <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Catalogue Data <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </h2>
            <h4 class="panel-title hidden-md hidden-lg">
                <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Catalogue Data <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                @if($shelfmark !== '')
                    <p><strong>Shelfmark:</strong> {{ $shelfmark }}</p>
                @endif
            </div>
        </div>
    </div>

    <div id="stc-section6" class="col-xs-12 related inactive container-fluid">
        <h2 class="itemtitle hidden-sm hidden-xs">Related Items</h2>
        <h4 class="itemtitle hidden-md hidden-lg">Related Items</h4>

        @if(! empty($relatedItems))
            <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 150 }'>
                @foreach($relatedItems as $relatedItem)
                    @php
                        $relatedTitle = $firstValue($relatedItem, $titleField, 'Untitled');

                        $relatedId = '';
                        if (isset($relatedItem['id'])) {
                            $relatedId = is_array($relatedItem['id'])
                                ? ($relatedItem['id'][0] ?? '')
                                : $relatedItem['id'];
                        }

                        $lunaUrl = null;
                        if ($imageUriField !== '' && ! empty($relatedItem[$imageUriField])) {
                            $imageUris = is_array($relatedItem[$imageUriField])
                                ? $relatedItem[$imageUriField]
                                : [$relatedItem[$imageUriField]];
                            foreach ($imageUris as $candidate) {
                                if (str_contains((string) $candidate, 'luna')) {
                                    $lunaUrl = str_replace('http://', 'https://', (string) $candidate);
                                    break;
                                }
                            }
                        }
                    @endphp

                    <div class="grid-item thumbnail">
                        @if($lunaUrl)
                            <a href="./record/{{ $relatedId }} " title="{{ $relatedTitle }}"><img src="{{ $lunaUrl }}" class="record-thumbnail-landscape" title="{{ $relatedTitle }}" alt="{{ $relatedTitle }}" /></a>
                        @else
                            <a href="./record/{{ $relatedId }}" title="{{ $relatedTitle }}"> No Image for this </a>
                        @endif
                        <p class="text-center hidden-xs">
                            <a href="./record/{{ $relatedId }} ">{{ $relatedTitle }}</a>
                        </p>
                        <p class="text-center hidden-md hidden-sm hidden-lg">
                            <small><a href="./record/{{ $relatedId }} ">{{ $relatedTitle }}</a></small>
                        </p>
                    </div>
                @endforeach
                <script>
                    var $grid = $('.grid').imagesLoaded( function() {
                        $grid.masonry({});
                    });
                </script>
            </div>
        @else
            None.
            <div class="spacer"></div>
        @endif
    </div>
</div>
@endsection
