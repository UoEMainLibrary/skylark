@extends('layouts.openbooks')

@section('title', 'Accessibility - '.config('skylight.fullname'))

@section('content')
<div class="content">
    <div class="content">
        <div class="content byEditor">
            <h1>Website accessibility</h1>
            <p>We aim to make this site as accessible as possible. If you encounter barriers, please let us know via the
                <a href="{{ $collectionUrl('feedback') }}">feedback</a> page.</p>
            <p>This resource is available at<br>
                <a href="{{ $collectionUrl() }}">{{ $collectionUrl() }}</a></p>
        </div>
    </div>
</div>
@endsection
