@extends('layouts.geddes-v2')

@section('title', 'Evergreen - Geddes Project')

@section('content')
<div class="geddes-content">
    <h1 class="warning">THIS SITE IS IN BETA TESTING AND IS NOT YET AN AUTHORITATIVE RESOURCE</h1>
    <p>‘Evergreen: Patrick Geddes and the Environment in Equilibrium’, preserved, conserved, catalogued, made accessible and virtually reunited
        two collections of the papers of Sir Patrick Geddes (1854-1932) held by the Universities of Edinburgh and Strathclyde.
        Read more about the project <a href="{{ url('/geddes/about') }}" title="About the project">here</a>.</p>

    @include('geddes-v2.partials.home_slideshow')

    <p class="quote">“Patrick Geddes was one of the key thinkers of the early twentieth century.
        His interdisciplinary ecological and cultural vision continues to have international impact. This major cataloguing project makes possible a new era of Geddes research.”</p>
    <p class="cite">-Professor Murdo MacDonald, Emeritus Professor of History of Scottish Art at the University of Dundee, and author of 'Patrick Geddes’s Intellectual Origins'</p>
</div>
@endsection
