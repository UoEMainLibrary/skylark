@extends('layouts.eerc')

@section('title', ucfirst(str_replace('_', ' ', '${page}')) . ' - EERC')

@push('styles')
<link rel="stylesheet" href="{{ asset('collections/eerc/css/style.css') }}">
<link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <h1>$(echo "${page}" | tr '_' ' ' | sed 's/.*/\u&/')</h1>
            <p>Content coming soon...</p>
        </div>
    </div>
</div>
@endsection
