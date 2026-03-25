@extends('layouts.eerc')

@section('title', 'Browse ' . $browseFacet . ' - Regional Ethnology of Scotland Project')

@section('content')
<div class="row">
    <div class="col-md-9">
        <h1>Browse by {{ $browseFacet }}</h1>
        <p class="lead">Select a term to view matching catalogue records.</p>

        @if(! empty($browseData['terms']))
            <ul class="list-group" style="margin-top: 1.5em;">
                @foreach($browseData['terms'] as $term)
                <li class="list-group-item">
                    <a href="{{ url('/eerc/search/*:*/' . $browseFacet . ':"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}">
                        {{ $term['display_name'] }}
                        <span class="badge pull-right">{{ $term['count'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        @else
            <p>No terms are available to browse at the moment.</p>
        @endif
    </div>
</div>
@endsection
