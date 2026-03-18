@extends('layouts.eerc-v2')

@section('title', 'Browse the Collections - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Browse the Collections</h1>

        {{-- Featured pages --}}
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ url('/eerc/exhibition') }}" class="group relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('collections/eerc/images/animal_encounters_resp.png') }}" alt="Exhibition Gallery" class="aspect-video w-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4">
                    <h3 class="text-lg font-bold text-white">Exhibition Gallery</h3>
                    <p class="mt-0.5 text-sm text-white/80">Films, exhibitions &amp; publications</p>
                </div>
            </a>
            <a href="{{ url('/eerc/kids') }}" class="group relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('collections/eerc/images/kids_only_1.png') }}" alt="Kids Activity Zone" class="aspect-video w-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-4">
                    <h3 class="text-lg font-bold text-white">Kids Activity Zone</h3>
                    <p class="mt-0.5 text-sm text-white/80">Worksheets &amp; activities for young learners</p>
                </div>
            </a>
        </div>

        {{-- Collection tree --}}
        <div class="mt-8">
            @if(!empty($tree['children']))
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <ul class="divide-y divide-gray-100 p-2">
                    @foreach($tree['children'] as $child)
                        @include('eerc-v2.partials.tree-node', ['node' => $child, 'depth' => 0])
                    @endforeach
                </ul>
            </div>
            @else
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
                <p>The collection tree is currently unavailable. Please try again later or use the search to find specific items.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
