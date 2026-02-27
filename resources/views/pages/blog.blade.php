@extends('layouts.app')

@section('title', 'Latest News - University of Edinburgh Collections')

@section('content')
<div class="container">
    <div class="content byEditor">
        <h1>Latest news:</h1>
        
        @if(count($posts) > 0)
            @foreach($posts as $post)
                <p><strong><a href="{{ $post['link'] }}" title="{{ $post['title'] }}" target="_blank">{{ $post['title'] }} <span class="sr-only">(opens in a new tab)</span></a></strong><br />
                <small><em>Posted on {{ $post['date'] }}</em></small></p>
                <p>{{ $post['description'] }}</p>
            @endforeach
        @else
            <p>Unable to load blog posts at this time. Please visit <a href="http://libraryblogs.is.ed.ac.uk/" target="_blank">the library blog <span class="sr-only">(opens in a new tab)</span></a> directly.</p>
        @endif
    </div>
</div>
@endsection
