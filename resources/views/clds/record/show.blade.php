@extends('layouts.app')

@section('title', $recordTitle . ' - University of Edinburgh Collections')

@section('content')
<div class="container">
    <h1 class="itemtitle">{{ $recordTitle }}</h1>

    <div class="content">
        <table class="table table-hover">
            <tbody>
            @foreach($recordDisplay as $label)
                @php
                    $fieldName = $fieldMappings[$label] ?? null;
                    if (!$fieldName) continue;
                    $element = str_replace('.', '', $fieldName);
                @endphp

                @if(isset($record[$element]) && !empty($record[$element]))
                    <tr>
                        <th>{{ $label }}</th>
                        <td>
                            @php
                                $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                            @endphp

                            @foreach($values as $index => $metadataValue)
                                @if(in_array($label, $filters))
                                    @php
                                        $origFilter = urlencode($metadataValue);
                                        $lowerFilter = strtolower($metadataValue);
                                        $lowerFilter = urlencode($lowerFilter);
                                        $searchUrl = "./search/*:*/{$label}:%22{$lowerFilter}+%7C%7C%7C+{$origFilter}%22";
                                    @endphp
                                    <a href="{{ $searchUrl }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>
                                @else
                                    {{ $metadataValue }}
                                @endif
                                @if($index < count($values) - 1); @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach

            {{-- Parent Collection Links --}}
            @if(isset($record[$parentCollectionField]) && !empty($record[$parentCollectionField]))
                <tr>
                    <th>Parent Collection</th>
                    <td>
                        @php
                            $parents = is_array($record[$parentCollectionField]) ? $record[$parentCollectionField] : [$record[$parentCollectionField]];
                            $handlePrefix = config('skylight.handle_prefix', '10683');
                        @endphp

                        @foreach($parents as $index => $parent)
                            @php
                                if (str_contains($parent, 'http://hdl.handle.net')) {
                                    $parts = explode('|', $parent);
                                    $handleUrl = $parts[0];
                                    $parentId = str_replace("http://hdl.handle.net/{$handlePrefix}/", '', $handleUrl);
                                    $parentName = $parts[1] ?? 'Parent Collection';
                                    echo '<a href="' . route('record.show', $parentId) . '">' . e($parentName) . '</a>';
                                } else {
                                    echo e($parent);
                                }
                                if ($index < count($parents) - 1) echo '; ';
                            @endphp
                        @endforeach
                    </td>
                </tr>
            @endif

            {{-- Sub Collections Links --}}
            @if(isset($record[$subCollectionField]) && !empty($record[$subCollectionField]))
                <tr>
                    <th>Sub Collections</th>
                    <td>
                        @php
                            $children = is_array($record[$subCollectionField]) ? $record[$subCollectionField] : [$record[$subCollectionField]];
                            $handlePrefix = config('skylight.handle_prefix', '10683');
                        @endphp

                        @foreach($children as $index => $child)
                            @php
                                if (str_contains($child, 'http://hdl.handle.net')) {
                                    $parts = explode('|', $child);
                                    $handleUrl = $parts[0];
                                    $childId = str_replace("http://hdl.handle.net/{$handlePrefix}/", '', $handleUrl);
                                    $childName = $parts[1] ?? 'Sub Collection';
                                    echo '<a href="' . route('record.show', $childId) . '">' . e($childName) . '</a>';
                                } else {
                                    echo e($child);
                                }
                                if ($index < count($children) - 1) echo '; ';
                            @endphp
                        @endforeach
                    </td>
                </tr>
            @endif

            {{-- PDF Files --}}
            @if(!empty($bitstreams['pdf']))
                <tr>
                    <th>Supporting Document:</th>
                    <td>
                        @foreach($bitstreams['pdf'] as $pdf)
                            Click <a href="{{ $pdf['uri'] }}" target="_blank">here</a> to download.
                            (<span class="bitstream_size">{{ $pdf['size'] }}</span>)
                        @endforeach
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

        <div class="record_bitstreams">
            {{-- Main Image with OpenSeadragon --}}
            @if($bitstreams['main_image'])
                <div class="main-image">
                    <div id="openseadragon" style="width: 100%; height: 600px;"></div>

                    @if(!empty($bitstreams['main_image']['description']))
                        <div>
                            <p><i>Image: {{ $bitstreams['main_image']['description'] }}</i></p>
                        </div>
                    @endif

                    <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>
                    <script type="text/javascript">
                        OpenSeadragon({
                            id: "openseadragon",
                            prefixUrl: "{{ asset('assets/openseadragon/images') }}/",
                            preserveViewport: false,
                            visibilityRatio: 1,
                            minZoomLevel: 0,
                            defaultZoomLevel: 0,
                            panHorizontal: true,
                            sequenceMode: true,
                            tileSources: [{
                                type: 'image',
                                url: '{{ $bitstreams['main_image']['uri'] }}'
                            }]
                        });
                    </script>
                </div>

                <div class="clearfix"></div>
            @endif

            {{-- Audio Player --}}
            @if(!empty($bitstreams['audio']))
                @foreach($bitstreams['audio'] as $audio)
                    <br>.<br>
                    <audio controls>
                        <source src="{{ $audio['uri'] }}" type="audio/mpeg">
                        Audio loading...
                    </audio>
                @endforeach
            @endif

            {{-- Video Player --}}
            @if(!empty($bitstreams['video']))
                @foreach($bitstreams['video'] as $video)
                    <br>.<br>
                    <video preload="auto" loop width="100%" height="auto" controls>
                        <source src="{{ $video['uri'] }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">
                        Video loading...
                    </video>
                @endforeach
            @endif
        </div>

        <div class="clearfix"></div>

        {{-- External URI Links --}}
        @if(isset($record[$internalUriField]) && !empty($record[$internalUriField]))
            @php
                $uris = is_array($record[$internalUriField]) ? $record[$internalUriField] : [$record[$internalUriField]];
            @endphp
            @foreach($uris as $uri)
                @php
                    $uri = str_replace('"', '%22', $uri);
                    $uri = str_replace('|', '%7C', $uri);
                @endphp
                <p class="collection-link">
                    <a href="{{ $uri }}" target="_blank">
                        View the items in the collection <i class="fa fa-external-link">&nbsp;</i>
                    </a>
                </p>
            @endforeach
        @endif

        @if(isset($record[$otherUriField]) && !empty($record[$otherUriField]))
            @php
                $uris = is_array($record[$otherUriField]) ? $record[$otherUriField] : [$record[$otherUriField]];
            @endphp
            @foreach($uris as $otherUri)
                @php
                    $separator = ' || ';
                    if (str_contains($otherUri, $separator)) {
                        $parts = explode($separator, $otherUri);
                        $url = $parts[0];
                        $label = ucwords($parts[1]);
                        echo '<p class="collection-link"><a href="' . e($url) . '" target="_blank">' . e($label) . ' <i class="fa fa-external-link">&nbsp;</i></a></p>';
                    } else {
                        echo '<p class="collection-link"><a href="' . e($otherUri) . '" target="_blank">View the resource externally <i class="fa fa-external-link">&nbsp;</i></a></p>';
                    }
                @endphp
            @endforeach
        @endif

        @if(isset($record[$aspaceUriField]) && !empty($record[$aspaceUriField]))
            @php
                $uris = is_array($record[$aspaceUriField]) ? $record[$aspaceUriField] : [$record[$aspaceUriField]];
            @endphp
            @foreach($uris as $aspaceUri)
                @php
                    $separator = ' || ';
                    if (str_contains($aspaceUri, $separator)) {
                        $parts = explode($separator, $aspaceUri);
                        $url = $parts[0];
                        $label = ucwords($parts[1]) . ' (Archives Space)';
                        echo '<p class="collection-link"><a href="' . e($url) . '" target="_blank">' . e($label) . ' <i class="fa fa-external-link">&nbsp;</i></a></p>';
                    } else {
                        echo '<p class="collection-link"><a href="' . e($aspaceUri) . '" target="_blank">View the items in the collection <i class="fa fa-external-link">&nbsp;</i></a></p>';
                    }
                @endphp
            @endforeach
        @endif

        @if(isset($record[$lunaUriField]) && !empty($record[$lunaUriField]))
            @php
                $uris = is_array($record[$lunaUriField]) ? $record[$lunaUriField] : [$record[$lunaUriField]];
            @endphp
            @foreach($uris as $lunaUri)
                <p class="collection-link">
                    <a href="{{ $lunaUri }}" target="_blank">
                        View the items in the collection <i class="fa fa-external-link">&nbsp;</i>
                    </a>
                </p>
            @endforeach
        @endif

        @if(isset($record[$lmsUriField]) && !empty($record[$lmsUriField]))
            @php
                $uris = is_array($record[$lmsUriField]) ? $record[$lmsUriField] : [$record[$lmsUriField]];
            @endphp
            @foreach($uris as $lmsUri)
                <p class="collection-link">
                    <a href="{{ $lmsUri }}" target="_blank">
                        View the items in the collection <i class="fa fa-external-link">&nbsp;</i>
                    </a>
                </p>
            @endforeach
        @endif

        {{-- Back Button --}}
        <button type="button" class="btn btn-custom" onclick="history.go(-1);">
            Back to Search Results
        </button>
    </div>
</div>

{{-- Related Results in separate container --}}
@if(!empty($relatedItems) && count($relatedItems) > 0)
    <div class="container related">
        <h4>Related Results</h4>
        @foreach($relatedItems as $relatedItem)
            @php
                $relatedTitleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
                $relatedTitle = 'Untitled';
                if (isset($relatedItem[$relatedTitleField])) {
                    $titleValue = $relatedItem[$relatedTitleField];
                    $relatedTitle = is_array($titleValue) ? ($titleValue[0] ?? 'Untitled') : $titleValue;
                }
                // Extract ID from handle or id field
                $relatedId = null;
                if (isset($relatedItem['handle'])) {
                    $handle = is_array($relatedItem['handle']) ? $relatedItem['handle'][0] : $relatedItem['handle'];
                    $relatedId = preg_replace('/^.*\//', '', $handle);
                } elseif (isset($relatedItem['id'])) {
                    $relatedId = is_array($relatedItem['id']) ? $relatedItem['id'][0] : $relatedItem['id'];
                }
            @endphp

            @if($relatedId)
                <div class="related-item">
                    <a class="related-record" href="{{ route('record.show', $relatedId) }}" title="{{ $relatedTitle }}">
                        {{ $relatedTitle }}
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@endif
@endsection
