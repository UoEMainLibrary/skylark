@extends('layouts.geddes')

@section('title', 'Browse '.$browseFacet.' - Evergreen - Geddes Project')

@section('content')
<div class="browse_results">
    <h1>Browse {{ $browseFacet }}</h1>
    <ul class="list-group">
        @foreach(($browseData['terms'] ?? []) as $term)
            <li class="list-group-item">
                <span class="badge">{{ $term['count'] ?? 0 }}</span>
                {{ $term['display_name'] ?? ($term['name'] ?? '') }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
