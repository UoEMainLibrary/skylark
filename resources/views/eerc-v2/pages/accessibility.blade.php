@extends('layouts.eerc-v2')

@section('title', 'Accessibility - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Accessibility</h1>

        <div class="mt-6 prose prose-lg max-w-none">
            @if($cmsEnabled && $cms)
                {!! $cms->body !!}
            @else
                @include('eerc-v2.partials.accessibility_statement_body')
            @endif
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
