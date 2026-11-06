@extends('stcecilias.museum.layout')
@section('content')
@if($page->slug === 'home')
<section class="sch-hero">
    <div class="sch-hero-copy"><p class="sch-eyebrow">Edinburgh · Since 1763</p><h1>{{ $page->title }}</h1><p class="sch-lead">{{ $page->intro }}</p><a class="sch-button" href="{{ route('stcecilias.museum.page', ['slug' => 'planning-your-visit']) }}">Plan your visit <span aria-hidden="true">↗</span></a><a class="sch-hero-events-link" href="#whats-on">See what’s on <span aria-hidden="true">↓</span></a>
        @if($events->isNotEmpty())<a class="sch-next-event" href="#whats-on"><span>Next at the Hall · {{ $events->first()->starts_at->timezone('Europe/London')->format('d M') }}</span>{{ $events->first()->title }} <span aria-hidden="true">→</span></a>@endif
    </div>
    @if($page->imageUrl())<figure><img src="{{ $page->imageUrl() }}" alt="{{ $page->image_alt }}" fetchpriority="high" width="2000" height="1600"><figcaption>St Cecilia’s Hall · The University of Edinburgh</figcaption></figure>@endif
</section>

@else
<section class="sch-page-heading"><p class="sch-eyebrow"><a href="{{ route('stcecilias.home') }}">St Cecilia’s Hall</a> / {{ $page->title }}</p><h1>{{ $page->title }}</h1><p class="sch-lead">{{ $page->intro }}</p></section>
@endif
@if($page->slug === 'home')
<section class="sch-events-section sch-home-events" id="whats-on"><div class="sch-section-title"><div><p class="sch-eyebrow">Experience St Cecilia’s</p><h2>What’s on</h2></div><a href="{{ route('stcecilias.museum.events') }}">See all events <span aria-hidden="true">→</span></a></div>@include('stcecilias.museum.event-cards')</section>
@endif
<div class="sch-content-shell">
    @if($page->slug !== 'home' && count($page->sections ?? []))
    <aside class="sch-on-this-page"><p class="sch-eyebrow">On this page</p><nav aria-label="On this page">@foreach($page->sections as $section)<a href="#section-{{ $loop->index }}">{{ $section['heading'] }}</a>@endforeach</nav></aside>
    @endif
    <article class="sch-article">
        @if($page->body)<div class="sch-rich">{!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($page->body)->toHtml() !!}</div>@endif
        @if($page->slug !== 'home' && $page->imageUrl())<figure class="sch-page-image"><img src="{{ $page->imageUrl() }}" alt="{{ $page->image_alt }}" width="1536" height="1229"><figcaption>{{ $page->image_alt }}</figcaption></figure>@endif
        @if($page->slug === 'planning-your-visit' && $visitorInformation)
            <section class="sch-visitor-overview"><p class="sch-eyebrow">Your visit at a glance</p><h2>{{ $visitorInformation['admission'] ?? '' }}</h2><p>{{ $visitorInformation['opening_hours'] ?? '' }}<br>{{ $visitorInformation['last_entry'] ?? '' }} · {{ $visitorInformation['closed_days'] ?? '' }}</p><p>{{ $visitorInformation['address'] ?? '' }}</p></section>
        @endif
        @foreach($page->sections ?? [] as $section)
            
            <section class="sch-content-section" id="section-{{ $loop->index }}"><h2>{{ $section['heading'] }}</h2>@if(str_contains($section['content'] ?? '', '<table'))<p class="sch-table-hint">Scroll horizontally to see all prices and additional charges.</p>@endif
            <div class="sch-rich" @if(str_contains($section['content'] ?? '', '<table')) tabindex="0" role="region" aria-label="{{ $section['heading'] }} — scroll to see all columns" @endif>{!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($section['content'] ?? '')->toHtml() !!}</div>
            @if(! empty($section['video_url']) && str_starts_with($section['video_url'], 'https://'))
                <video class="sch-video" controls preload="none" aria-label="Visitor information in British Sign Language"><source src="{{ $section['video_url'] }}" type="video/mp4">Your browser does not support this video.</video>
                <p><a href="{{ $section['video_url'] }}">Watch the visitor information video in British Sign Language</a></p>
            @endif
            </section>
        @endforeach
        @if($page->gallery)
            <section class="sch-content-section"><h2>Discover our spaces</h2><div class="sch-gallery" tabindex="0" role="region" aria-label="Venue photographs. Scroll to see all images.">
                @foreach($page->gallery as $image)<figure><a href="{{ Storage::disk('public')->url($image['path']) }}"><img src="{{ Storage::disk('public')->url($image['path']) }}" alt="{{ $image['alt'] }}" loading="lazy" width="1000" height="800"></a><figcaption>{{ $image['caption'] ?? '' }}</figcaption></figure>@endforeach
            </div></section>
        @endif
    </article>
</div>
@if($page->slug === 'home')

<section class="sch-collection-banner"><p class="sch-eyebrow">Discover the instruments</p><h2>Centuries of music.<br>A world of stories.</h2><p>Explore St Cecilia’s Hall items in the Musical Instrument Museums Edinburgh catalogue.</p><a class="sch-button" href="{{ $collectionSearchUrl }}">Explore on MIMEd <span aria-hidden="true">↗</span></a></section>
@endif
@endsection
