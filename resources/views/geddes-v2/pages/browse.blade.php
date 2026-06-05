@extends('layouts.geddes-v2')

@section('title', 'Browse '.$browseFacet.' - Evergreen - Geddes Project')

@section('content')
<div class="geddes-content max-w-3xl">
    <h1>Browse {{ $browseFacet }}</h1>
    <ul class="geddes-facet-list list-none p-0">
        @foreach(($browseData['terms'] ?? []) as $term)
            <li class="flex items-center justify-between gap-2">
                <span>{{ $term['display_name'] ?? ($term['name'] ?? '') }}</span>
                <span class="shrink-0 rounded bg-gray-500 px-2 py-0.5 text-xs text-white">{{ $term['count'] ?? 0 }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
