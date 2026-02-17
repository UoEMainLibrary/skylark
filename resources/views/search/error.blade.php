@extends('layouts.app')

@section('title', 'Search Error - University of Edinburgh Collections')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <h2>Search Error</h2>
                <p>An error occurred while searching for "{{ $query }}".</p>
                <p><strong>Error:</strong> {{ $error }}</p>
                <p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Return to Homepage</a>
                    <a href="{{ url('/search/*') }}" class="btn btn-default">View All Results</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
