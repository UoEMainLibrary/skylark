@extends('layouts.eerc-v2')

@section('title', 'About - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">About</h1>
        <div class="mt-6 prose prose-lg max-w-none">
            <p>The Regional Ethnology of Scotland Archive Project preserves and shares oral history recordings from communities across Scotland.</p>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
