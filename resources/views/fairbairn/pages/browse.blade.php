@extends('layouts.fairbairn')

@section('title', 'Browse ' . $browseFacet . ' - W. Ronald D. Fairbairn')

@section('content')
<div class="content">
    <h1>Browse {{ $browseFacet }}</h1>

    @if(!empty($browseData['terms']))
        <ul class="listing">
            @foreach($browseData['terms'] as $index => $term)
                @php
                    $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name'] ?? '');
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($browseData['terms']) - 1])>
                    <div class="item-div">
                        <a href='{{ $collectionUrl('search/*:*/' . $browseFacet . ':"' . $encodedTerm . '"') }}'>
                            {{ $term['display_name'] ?? '' }}
                        </a>
                        ({{ $term['count'] ?? 0 }})
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>No {{ strtolower($browseFacet) }} terms found.</p>
    @endif
</div>
@endsection
