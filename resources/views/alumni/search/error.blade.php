@extends('layouts.alumni')

@section('title', 'Search Error - University of Edinburgh Historical Alumni')

@section('content')
<div class="content">
    <h1>Search Error</h1>
    <p>Sorry, there was an error processing your search. Please try again.</p>
    <p><a href="{{ url('/alumni') }}">Return to the University of Edinburgh Historical Alumni homepage</a></p>
</div>
@endsection
