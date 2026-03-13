@extends('layouts.eerc-v2')

@section('title', 'BSL Content - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">British Sign Language (BSL)</h1>

        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-6">
            <p class="text-sm text-amber-800">BSL content for this page is forthcoming. Please check back soon.</p>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
