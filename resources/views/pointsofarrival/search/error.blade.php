@extends('layouts.pointsofarrival')

@section('title', "Search Error — Points Of Arrival")

@section('body_class', 'search-error')

@section('content')
    <div class="container-fluid content">
        <div class="col-sm-12 col-xs-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <h1>Search Error</h1>
            <p>There was a problem performing your search. Please try again later.</p>

            @if (! empty($error) && config('app.debug'))
                <pre style="white-space: pre-wrap;">{{ $error }}</pre>
            @endif

            <p><a href="{{ url('/pointsofarrival') }}">Return to the homepage</a>.</p>
        </div>
    </div>
@endsection
