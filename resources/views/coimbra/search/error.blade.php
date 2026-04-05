@extends('layouts.art')

@section('title', 'Search Error - University of Edinburgh Art Collection')

@section('content')
<div class="content">
    <h1>Search Error</h1>
    <p>Sorry, there was an error processing your search. Please try again.</p>
    <p><a href="{{ url('/art') }}">Return to the Art Collection homepage</a></p>
</div>
@endsection
