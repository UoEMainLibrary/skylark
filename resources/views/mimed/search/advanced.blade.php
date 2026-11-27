@extends('layouts.mimed-catalogue')

@section('title', 'Advanced search - Musical Instrument Collection')

@section('content')
<div class="mimed-wrap mimed-support-page">
    <h1>Advanced search</h1>
    @include('mimed.search.partials.advanced-form')
</div>
@endsection
