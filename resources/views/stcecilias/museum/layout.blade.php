<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->seo_title ?: ($page->slug === 'home' ? 'St Cecilia’s Hall · Concert Room & Music Museum' : $page->title.' · St Cecilia’s Hall') }}</title>
    <meta name="description" content="{{ $page->seo_description ?: $page->intro }}">
    <meta property="og:title" content="{{ $page->seo_title ?: $page->title }}">
    <meta property="og:description" content="{{ $page->seo_description ?: $page->intro }}">
    @if($page->imageUrl())<meta property="og:image" content="{{ $page->imageUrl() }}">@endif
    <link rel="canonical" href="{{ url()->current() }}">
    @vite('resources/css/stcecilias.css')
</head>
<body class="sch-site">
<a class="sch-skip" href="#main">Skip to main content</a>
<div class="sch-university"><span>The University of Edinburgh</span><a href="{{ url('/') }}">Library &amp; University Collections ↗</a></div>
<header class="sch-header">
    <a class="sch-wordmark" href="{{ route('stcecilias.home') }}" aria-label="St Cecilia’s Hall home"><img src="{{ asset('collections/stcecilia/images/official-logo-black.png') }}" alt="St Cecilia’s Hall — Concert Room &amp; Music Museum" width="827" height="199"></a>
    <details class="sch-mobile-menu">
        <summary>Menu <span aria-hidden="true">☰</span></summary>
        @include('stcecilias.museum.navigation', ['navigationLabel' => 'Mobile navigation'])
    </details>
    <div class="sch-desktop-menu">
        @include('stcecilias.museum.navigation', ['navigationLabel' => 'Main navigation'])
    </div>
</header>
@if($visitorInformation)
<div class="sch-opening-bar" aria-label="Visitor information">
    <span><strong>{{ $visitorInformation['admission'] ?? '' }}</strong></span>
    <span>{{ $visitorInformation['opening_hours'] ?? '' }} <span class="sch-opening-detail"><span class="sch-hours-separator" aria-hidden="true">· </span>{{ $visitorInformation['last_entry'] ?? '' }}</span></span>
    <a href="{{ route('stcecilias.museum.page', ['slug' => 'planning-your-visit']) }}">Plan your visit <span aria-hidden="true">→</span></a>
</div>
@if(! empty($visitorInformation['notice']))<div class="sch-visitor-notice" role="note">{{ $visitorInformation['notice'] }}</div>@endif
@endif
<main id="main">@yield('content')</main>
<footer class="sch-footer">
    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
        <div><a href="{{ route('stcecilias.home') }}"><img class="sch-footer-logo" src="{{ asset('collections/stcecilia/images/official-logo-white.png') }}" alt="St Cecilia’s Hall — Concert Room &amp; Music Museum" width="827" height="199"></a><p>{{ $visitorInformation['address'] ?? '50 Niddry Street, Edinburgh EH1 1LG' }}</p><p><a href="mailto:SCHEvents@ed.ac.uk">SCHEvents@ed.ac.uk</a><br><a href="tel:+441316502600">0131 650 2600</a></p></div>
        <div><h2>Visit the museum</h2>@if($visitorInformation)<p>{{ $visitorInformation['opening_hours'] ?? '' }}<br>{{ $visitorInformation['last_entry'] ?? '' }}<br>{{ $visitorInformation['closed_days'] ?? '' }}</p><p>{{ $visitorInformation['admission'] ?? '' }}</p>@endif<p><a href="{{ route('stcecilias.museum.page', ['slug' => 'planning-your-visit']) }}">Directions &amp; accessibility →</a></p></div>
        <nav aria-label="Footer useful links"><h2>Discover &amp; experience</h2>@foreach($footerPages as $footerPage)<p><a href="{{ route('stcecilias.museum.page', ['slug' => $footerPage->slug]) }}">{{ $footerPage->title }}</a></p>@endforeach<p><a href="{{ route('stcecilias.museum.events') }}">What’s on</a></p><p><a href="{{ route('stcecilias.museum.page', ['slug' => 'venue-hire']) }}">Venue hire</a></p><p><a href="{{ $collectionSearchUrl }}">Explore the collection on MIMEd ↗</a></p><p><a href="https://guides.bloombergconnects.org/en-US/guide/stCeciliasHallTheUniversityOfEdinburgh">Free digital guide ↗</a></p></nav>
        <div><h2>Stay connected</h2><p><a href="https://www.facebook.com/stceciliashall">Facebook</a><br><a href="https://www.instagram.com/stceciliashall/">Instagram</a><br><a href="https://www.youtube.com/@StCeciliasHall">YouTube</a></p><h2>The University of Edinburgh</h2><p>Library &amp; University Collections<br><a href="https://library.ed.ac.uk/heritage-collections">Heritage Collections ↗</a></p></div>
    </div>
    <div class="sch-footer-bottom"><span>© {{ date('Y') }} The University of Edinburgh</span><a href="https://www.ed.ac.uk/about/website/privacy">Privacy &amp; cookies</a><a href="{{ route('stcecilias.accessibility') }}">Accessibility statement</a></div>
</footer>
</body>
</html>
