@extends('layouts.eerc-v2')

@section('title', 'Browse ' . $browseFacet . ' - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Browse by {{ $browseFacet }}</h1>
        <p class="mt-2 text-gray-600">Select a term to view matching catalogue records.</p>

        @if(! empty($browseData['terms']))
            <ul class="mt-8 divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                @foreach($browseData['terms'] as $term)
                <li>
                    <a href="{{ url('/eerc/search/*:*/' . $browseFacet . ':"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}"
                       class="flex items-center justify-between px-4 py-3 text-sm text-gray-800 transition-colors hover:bg-resp-teal-50 hover:text-resp-teal-800">
                        <span class="font-medium">{{ $term['display_name'] }}</span>
                        <span class="ml-3 inline-flex shrink-0 items-center rounded-full bg-resp-plum px-2.5 py-0.5 text-xs font-medium text-white">
                            {{ $term['count'] }}
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        @else
            <p class="mt-8 text-gray-600">No terms are available to browse at the moment.</p>
        @endif
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
