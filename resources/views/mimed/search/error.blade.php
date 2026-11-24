@extends('layouts.mimed-catalogue')

@section('title', 'Search unavailable - Musical Instrument Collection')

@section('content')
<div class="mimed-wrap mimed-support-page">
    <h1>Search unavailable</h1>
    <p>There was a problem performing your search. Please try again later.</p>
    @include('mimed.search.partials.form')
</div>
@endsection
