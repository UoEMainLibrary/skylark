@extends('layouts.public-art')

@section('title', 'Art on Campus')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $imageField = str_replace('.', '', $fieldMappings['Image URI'] ?? 'dcidentifierimageUri');
    $altImageField = str_replace('.', '', $fieldMappings['Alt Image'] ?? 'dcimageprimaryen');
    $locationField = str_replace('.', '', $fieldMappings['Map Reference'] ?? 'dccoveragespatialcoorden');

    $type = request()->boolean('map') ? 'map' : 'images';
@endphp

<div class="container content col-xs-12">
    @if(isset($message))
        <div class="message">{!! $message !!}</div>
    @endif

    @if($total === 0)
        <div class="row">
            <div class="container-fluid">
                <div style="margin:15px; color:#d0006f;" class="animated flipInX slow delay-2s"><h1 class="display-1">Art on Campus</h1></div>
                <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
                <p>Try broadening your search or <a href="{{ url('/public-art/search/*:*') }}">browse all items</a>.</p>
            </div>
        </div>
    @elseif($type === 'images')
        <div class="row">
            <div class="container-fluid">
                <div style="margin:15px; color:#d0006f;" class="animated flipInX slow delay-2s">
                    <h1 class="display-1">Art on Campus</h1>
                </div>
                <div class="gallery-container">
                    @foreach($docs as $doc)
                        @php
                            $title = $doc[$titleField][0] ?? 'Untitled';
                            $rawImg = $doc[$imageField][0] ?? ($doc[$altImageField][0] ?? '');
                            $imgUrl = str_replace('/full/full/', '/full/!450,450/', $rawImg);
                            $docId = is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? '');
                        @endphp
                        <div class="row record">
                            <a class="record-link" href="{{ url('/public-art/record/' . $docId) }}" title="{{ $title }}">
                                <img class="img-responsive" src="{{ $imgUrl }}" title="{{ $title }}" alt="{{ $title }}" />
                            </a>
                            <div class="col-sm-9 hidden-xs result-info">
                                <div class="record-link-background">
                                    <h4>
                                        <a href="{{ url('/public-art/record/' . $docId) }}">{{ $title }}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <hr class="visible-xs">
                    @endforeach
                </div>

                <div class="row">
                    <div class="centered text-center">
                        <nav>
                            {!! $paginationLinks !!}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div id="map" class="full-width" style="height: 1500px;"></div>
        <script>
            var locationsArray = [];
            @foreach($docs as $doc)
                @php
                    $title = addslashes($doc[$titleField][0] ?? 'Untitled');
                    $locStr = $doc[$locationField][0] ?? '';
                    $rawImg = $doc[$imageField][0] ?? '';
                    $thumb = str_replace('/full/full/', '/full/50,/', $rawImg);
                    $docId = is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? '');
                @endphp
                @if($locStr !== '')
                    @php
                        $parts = explode(',', $locStr);
                    @endphp
                    @if(count($parts) === 2)
                        locationsArray.push([{{ trim($parts[1]) }}, {{ trim($parts[0]) }}, '{{ url('/public-art/record/' . $docId) }}', '{{ $title }}', '{{ $thumb }}']);
                    @endif
                @endif
            @endforeach
        </script>
        <script src="{{ asset('collections/public-art/locations/bundle.js') }}"></script>
    @endif
</div>
@endsection
