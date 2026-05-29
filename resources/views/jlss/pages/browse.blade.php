@extends('layouts.jlss')

@section('title', 'Browse '.$browseFacet.' - Jewish Lives Scottish Spaces')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <h1>Browse {{ $browseFacet }}</h1>
    <ul class="list-group" id="browse-list">
        @foreach(($browseData['terms'] ?? []) as $term)
            <li class="list-group-item">
                <span class="badge">{{ $term['count'] ?? 0 }}</span>
                {{ $term['display_name'] ?? ($term['name'] ?? '') }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
