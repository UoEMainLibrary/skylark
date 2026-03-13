@extends('layouts.eerc-v2')

@section('title', 'Browse the Collections - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Browse the Collections</h1>

        <div class="mt-6">
            @if(!empty($tree['children']))
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm" x-data="{ openNodes: {} }">
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
