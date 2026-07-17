@extends('layouts.bodylanguage')

@section('title', $browseFacet.' - Body Language')

@section('content')
<div class="content">
    <h1>Browse by {{ $browseFacet }}</h1>

    @if(! empty($browseData['terms']))
        <ul class="browse-list">
            @foreach($browseData['terms'] as $term)
                @php
                    $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                @endphp
                <li>
                    <a href='{{ $collectionUrl("search/*:*/{$browseFacet}:\"{$encodedTerm}\"") }}'>
                        {{ $term['display_name'] }} ({{ $term['count'] }})
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No terms available.</p>
    @endif
</div>
@endsection
