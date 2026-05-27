@extends('layouts.towardsdolly')

@section('title', 'Browse ' . $browseFacet . ' - Towards Dolly')

@section('content')
<div class="content">
    <h1>Browse {{ $browseFacet }}</h1>

    @if(!empty($browseData['terms']))
        <ul class="listing">
            @foreach($browseData['terms'] as $index => $term)
                <li @class(['first' => $index === 0, 'last' => $index === count($browseData['terms']) - 1])>
                    <div class="item-div">
                        <a href='{{ url('/towardsdolly/search/*:*/' . $browseFacet . ':"' . ($term['name'] ?? '') . '"') }}'>
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
