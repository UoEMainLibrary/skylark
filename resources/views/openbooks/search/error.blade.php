@extends('layouts.openbooks')

@section('title', 'Search Error - Open Books')

@section('content')
<div class="content">
    <h1>Search Error</h1>
    <p>There was a problem performing your search. Please try again later.</p>
    @if(isset($error))
        <p><em>{{ $error }}</em></p>
    @endif
    <p><a href="{{ $collectionUrl() }}">Return to homepage</a></p>
</div>
@endsection
