@extends('layouts.eerc-v2')

@section('title', 'Search Results - RESP Archive')

@push('styles')
<style>
    .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.625rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 150ms;
        border: 1px solid #d1d5db;
        color: #374151;
        background-color: white;
    }
    .pagination li a:hover {
        background-color: var(--color-resp-teal-50);
        border-color: var(--color-resp-teal-300);
        color: var(--color-resp-teal-700);
    }
    .pagination li.active span {
        background-color: var(--color-resp-teal-600);
        border-color: var(--color-resp-teal-600);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    {{-- Search results --}}
    <div class="lg:col-span-3">
        @if($total > 0)
            {{-- Results header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ number_format($total) }} {{ Str::plural('result', $total) }}
                </h2>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span>Sort by Title:</span>
                    @php
                        $currentSort = request('sort_by', '');
                        $isAscending = $currentSort && str_contains($currentSort, 'asc');
                        $isDescending = $currentSort && str_contains($currentSort, 'desc');
                    @endphp
                    @if($isAscending)
                        <span class="font-semibold text-gray-900">A-Z</span>
                        <span class="text-gray-300">|</span>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort desc']) }}" class="text-resp-teal-600 hover:underline">Z-A</a>
                    @elseif($isDescending)
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort asc']) }}" class="text-resp-teal-600 hover:underline">A-Z</a>
                        <span class="text-gray-300">|</span>
                        <span class="font-semibold text-gray-900">Z-A</span>
                    @else
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort asc']) }}" class="text-resp-teal-600 hover:underline">A-Z</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort desc']) }}" class="text-resp-teal-600 hover:underline">Z-A</a>
                    @endif
                </div>
            </div>

            {{-- Pagination top --}}
            <div class="mt-4">
                <nav class="flex justify-center" aria-label="Pagination">
                    <div class="flex gap-1 text-sm">{!! $paginationLinks !!}</div>
                </nav>
            </div>

            {{-- Results list --}}
            <div class="mt-6 space-y-4">
                @foreach($docs as $doc)
                    @php
                        $uri = $doc['_raw']['uri'] ?? $doc['uri'] ?? '';
                        $ancestors = $doc['_raw']['ancestors'] ?? $doc['ancestors'] ?? [];
                        $excludedUris = [
                            '/repositories/15/archival_objects/190197',
                            '/repositories/15/archival_objects/208190',
                            '/repositories/15/archival_objects/228537',
                        ];

                        $skip = in_array($uri, $excludedUris);
                        if (!$skip && is_array($ancestors)) {
                            foreach ($ancestors as $ancestor) {
                                if (in_array($ancestor, $excludedUris)) { $skip = true; break; }
                            }
                        }
                    @endphp

                    @if(!$skip)
                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
                        @php
                            $fullId = $doc['Id'] ?? $doc['id'] ?? '';
                            $idParts = explode('/', $fullId);
                            $numericId = end($idParts);
                            $rawTypes = $doc['_raw']['types'] ?? [];
                            $type = is_array($rawTypes) ? ($rawTypes[0] ?? 'archival_object') : ($rawTypes ?? 'archival_object');
                            $title = is_array($doc['Title'] ?? null) ? ($doc['Title'][0] ?? 'Untitled') : ($doc['Title'] ?? 'Untitled');
                            $cleanTitle = preg_replace('/,\s*,.*$/', '', $title);
                        @endphp

                        <h3 class="text-lg font-semibold">
                            <a href="{{ url('/eerc/record/' . $numericId . '/' . $type) }}" class="text-resp-navy hover:text-resp-teal-600 hover:underline">
                                {{ $cleanTitle }}
                            </a>
                        </h3>

                        @if(isset($doc['Component Unique Identifier']) && !empty($doc['Component Unique Identifier']))
                            <p class="mt-1 text-xs text-gray-400">
                                {{ is_array($doc['Component Unique Identifier']) ? ($doc['Component Unique Identifier'][0] ?? '') : ($doc['Component Unique Identifier'] ?? '') }}
                            </p>
                        @endif

                        @if(isset($doc['Subject']) && !empty($doc['Subject']))
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @php $subjects = is_array($doc['Subject']) ? $doc['Subject'] : [$doc['Subject']]; @endphp
                                @foreach($subjects as $subject)
                                    @php $encodedSubject = str_replace(' ', '+', urlencode($subject)); @endphp
                                    <a href="{{ url('/eerc/search/*:*/Subject:\"' . $encodedSubject . '\"') }}"
                                       class="inline-flex items-center rounded-full bg-resp-teal-50 px-2.5 py-0.5 text-xs font-medium text-resp-teal-700 hover:bg-resp-teal-100">
                                        {{ $subject }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if(isset($doc['Interview summary']) && !empty($doc['Interview summary']))
                            <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                                {{ is_array($doc['Interview summary']) ? ($doc['Interview summary'][0] ?? '') : ($doc['Interview summary'] ?? '') }}
                            </p>
                        @endif
                    </article>
                    @endif
                @endforeach
            </div>

            {{-- Pagination bottom --}}
            <div class="mt-6">
                <nav class="flex justify-center" aria-label="Pagination">
                    <div class="flex gap-1 text-sm">{!! $paginationLinks !!}</div>
                </nav>
            </div>
        @else
            <div class="rounded-lg border border-gray-200 bg-white p-12 text-center">
                <h3 class="text-lg font-medium text-gray-900">No results found</h3>
                <p class="mt-2 text-gray-500">Your search for &ldquo;{{ $query }}&rdquo; returned no results.</p>
            </div>
        @endif
    </div>

    {{-- Facets sidebar --}}
    <div class="mt-8 lg:mt-0">
        <aside class="space-y-6" aria-label="Filter results">
            @if(count($facets) > 0)
                @foreach($facets as $facet)
                    @if(count($facet['terms']) > 0)
                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="bg-resp-slate-500 px-4 py-3">
                            <h3 class="text-sm font-semibold tracking-wide text-white uppercase">{{ $facet['name'] }}</h3>
                        </div>
                        <ul class="divide-y divide-gray-100">
                            @foreach($facet['terms'] as $term)
                            <li class="group">
                                @if($term['active'])
                                    <div class="flex items-center justify-between bg-resp-teal-50 px-4 py-2.5 text-sm">
                                        <span class="font-medium text-resp-teal-800">{{ $term['display_name'] }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center rounded-full bg-resp-plum px-2.5 py-0.5 text-xs font-medium text-white">{{ $term['count'] }}</span>
                                            @php
                                                $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                                $pattern = '/' . rawurlencode($facet['name']) . ':\"' . $encodedTerm . '\"';
                                                $removeUrl = str_replace($pattern, '', request()->path());
                                                $removeUrl = rtrim($removeUrl, '/');
                                                if (empty($removeUrl) || $removeUrl === 'eerc/search') {
                                                    $removeUrl = '/eerc/search/*:*';
                                                }
                                            @endphp
                                            <a href="{{ url($removeUrl) }}" class="text-gray-400 hover:text-red-500" title="Remove filter">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                        $currentPath = request()->path();
                                        $addUrl = $currentPath . '/' . $facet['name'] . ':"' . $encodedTerm . '"';
                                    @endphp
                                    <a href="{{ url($addUrl) }}"
                                       class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 transition-colors hover:bg-resp-teal-50 hover:text-resp-teal-700">
                                        <span class="group-hover:underline">{{ $term['display_name'] }}</span>
                                        <span class="ml-2 inline-flex items-center rounded-full bg-resp-plum px-2.5 py-0.5 text-xs font-medium text-white">{{ $term['count'] }}</span>
                                    </a>
                                @endif
                            </li>
                            @endforeach
                            @if(count($facet['terms']) >= 10)
                            <li>
                                <a href="{{ url('/eerc/browse/' . $facet['name']) }}" class="block px-4 py-2.5 text-center text-sm font-medium text-resp-teal-600 transition-colors hover:bg-resp-teal-50">
                                    View all &rarr;
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                @endforeach
            @endif
        </aside>
    </div>
</div>
@endsection
