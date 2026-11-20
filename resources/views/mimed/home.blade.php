@extends('layouts.mimed-catalogue')

@section('content')
<section class="mimed-hero">
    <div class="mimed-wrap mimed-hero-grid">
        <div class="mimed-hero-copy">
            <h1>Musical Instrument<br>Museums Edinburgh</h1>
            <p>The University of Edinburgh’s collection of historic musical instruments.</p>
            @include('mimed.search.partials.form')
        </div>
        <figure class="mimed-hero-image">
            <a href="{{ route('mimed.record.show', ['id' => 16327]) }}">
                <img src="{{ asset('collections/mimed/images/bolcioni-harpsichord.webp') }}" alt="An ornate harpsichord with a painted lid and three stacked keyboards" width="682" height="1024" fetchpriority="high">
            </a>
            <figcaption><a href="{{ route('mimed.record.show', ['id' => 16327]) }}">Triple-manual harpsichord <span aria-hidden="true">↗</span></a><span class="mimed-image-credit">MIMEd · CC BY</span></figcaption>
        </figure>
    </div>
</section>

<section class="mimed-wrap mimed-featured" aria-labelledby="featured-title">
    <div class="mimed-section-header"><h2 id="featured-title">Featured instruments</h2><a href="{{ route('mimed.search.index', ['query' => '*:*']) }}">Explore the catalogue <span aria-hidden="true">→</span></a></div>
    <ul class="mimed-featured-grid">
        @foreach([
            ['id' => 14715, 'title' => 'Viola d’amore', 'image' => 'viola-damore'],
            ['id' => 16782, 'title' => 'Bāyā̃', 'image' => 'baya'],
            ['id' => 17120, 'title' => 'Sousaphone', 'image' => 'sousaphone'],
        ] as $instrument)
            <li>
                <a href="{{ route('mimed.record.show', ['id' => $instrument['id']]) }}">
                    <div class="mimed-featured-image"><img src="{{ asset('collections/mimed/images/'.$instrument['image'].'.webp') }}" alt="" loading="lazy"></div>
                    <span class="mimed-featured-label">{{ $instrument['title'] }} <span aria-hidden="true">↗</span></span>
                </a>
            </li>
        @endforeach
    </ul>
</section>

@if(!empty($facets))
<section class="mimed-wrap mimed-browse" aria-labelledby="browse-title">
    <h2 id="browse-title">Browse by catalogue field</h2>
    @include('mimed.search.partials.facets')
</section>
@endif

<section class="mimed-about-band">
    <div class="mimed-wrap mimed-about-grid">
        <div>
            <h2>About the collection</h2>
            <p>The University of Edinburgh’s collection of historic musical instruments ranks among the world’s most important collections of musical heritage. It has official Recognised Collection of National Significance to Scotland status.</p>
            <p>The emphasis of the Collection is on instruments that are no longer in regular current use and the collecting
                policy is to acquire instruments when they fall out of use rather than to collect instruments by contemporary
                makers. The Collection thus covers the period from the 16th century (the earliest from which examples are
                available for acquisition) to the 20th century (the most recent from which instruments can be regarded as
                historic).</p>
            <p>Many of the instruments are still playable and through an established concert programme and as a regular
                venue during the Edinburgh International Festival, the Concert Room provides a contemporaneous setting for
                performances, within which the audience can be seen as the interface between the University and the public.</p>
            <p>The instruments are supplemented by an archive of original materials, working papers and a sound archive.
                The Collection as a whole attracts researchers from far and wide and is an extensively cited resource in
                international scholarship. Instruments are lent to prestigious exhibitions at home and internationally.</p>
            <a href="{{ route('mimed.about') }}">About this collection <span aria-hidden="true">→</span></a>
        </div>
        <div>
            <h2>St Cecilia’s Hall</h2>
            <p>St Cecilia’s Hall Concert Room &amp; Music Museum reopened in 2017 after a major redevelopment. The museum displays part of the University’s Musical Instrument Collection.</p>
            <a href="{{ route('stcecilias.home') }}">Visit St Cecilia’s Hall <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>
@endsection
