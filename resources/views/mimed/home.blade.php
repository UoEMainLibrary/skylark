@extends('layouts.mimed-catalogue')

@section('content')
<section class="mimed-hero">
    <div class="mimed-wrap mimed-hero-grid">
        <div class="mimed-hero-copy">
            <h1>Musical Instrument Collection, University of Edinburgh</h1>
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
            <h2>About the Collection</h2>
            <p>The University of Edinburgh’s Musical Instrument Collection ranks among the world’s most important collections of musical heritage. It has official Recognised Collection of National Significance to Scotland status and holds Accreditation status with Arts Council England. The purpose of the Collection is to promote the study of the history, construction and functions of musical instruments as well as their cultural contexts. It is used for teaching, research and enjoyment within and beyond the University: tours, hands-on research for publication, making technical drawings, building replica instruments, demonstrations, recording etc. are actively encouraged and facilitated by Museum staff. It is also open to the public with an active programme of engagement activities and events throughout the year.</p>
            <p>The Collection covers the period from c1550 to the present day and includes instruments from many cultures around the world. There are particular strengths in keyboard instruments, brass instruments, guitars and clarinets as well as a focus on Scottish instruments. Important collections have come to us through many individuals including Mrs Gilbert Russell, Sir Nicholas Shackleton, Lynne and Rodger Mirrey, Anne Macaulay, Frank Tomes, Geoffrey Rendall, Peter Cook, Anthony Baines, James Blades and the Galpin Society. We are grateful to all of our donors and supporters.</p>
            <p>Many of the instruments are playable by expert musicians and, through an established concert programme throughout the year, the Concert Room provides an intimate setting for public performances of many kinds.</p>
            <p>The instruments are supplemented by an archive of original materials, working papers and a sound archive. The Collection as a whole attracts researchers from far and wide and is an extensively cited resource in international scholarship. Instruments are lent to prestigious exhibitions at home and internationally.</p>
            <a href="{{ route('mimed.about') }}">About this collection <span aria-hidden="true">→</span></a>
        </div>
        <div>
            <h2>St Cecilia’s Hall</h2>
            <p>St Cecilia’s Hall Concert Room &amp; Music Museum reopened in 2017 after a major redevelopment. The museum displays part of the University’s Musical Instrument Collection.</p>
            <a href="{{ route('stcecilias.home') }}">Visit St Cecilia’s Hall <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>

<section class="mimed-wrap mimed-research" aria-labelledby="research-title">
    <h2 id="research-title">Research</h2>
    <p>Information about conducting research with the Musical Instrument Collection and at the Centre for Research Collections will be added here.</p>
    <a href="https://library.ed.ac.uk/using-library/lib-locate/crc">Centre for Research Collections →</a>
</section>
@endsection
