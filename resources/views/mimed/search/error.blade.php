@extends('layouts.mimed')

@section('title', 'Search Error - MIMEd')

@section('content')
<div class="content">
    <h1>Search Error</h1>
    <p>Your search for <strong>{{ $query }}</strong> encountered an error.</p>
    <p>{{ $error }}</p>
    <p><a href="{{ url('/mimed') }}">Return to the MIMEd homepage</a></p>
</div>
@endsection
