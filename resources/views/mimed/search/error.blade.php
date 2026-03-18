@extends('layouts.mimed')

@section('title', 'Search Error - Musical Instrument Museums Edinburgh')

@section('content')
<div class="col-main">
    <div class="content">
        <h1>Search Error</h1>
        <p>There was a problem performing your search. Please try again later.</p>
        @if(isset($error))
            <p><em>{{ $error }}</em></p>
        @endif
        <p><a href="{{ url('/mimed') }}">Return to homepage</a></p>
    </div>
</div>
@endsection
