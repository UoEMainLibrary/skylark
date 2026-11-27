<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Musical Instrument Collection')</title>
    <link rel="icon" href="{{ asset('collections/mimed/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('collections/mimed/css/catalogue.css') }}">
    @yield('head')
</head>
<body class="mimed-catalogue">
    <a class="mimed-skip" href="#main">Skip to content</a>
    <div class="mimed-university"><div class="mimed-wrap">
        <a href="https://www.ed.ac.uk/"><img src="{{ asset('collections/mimed/images/university-logo.png') }}" width="831" height="199" alt="The University of Edinburgh"></a>
        <a href="{{ url('/') }}">Library &amp; University Collections <span aria-hidden="true">↗</span></a>
    </div></div>
    <header class="mimed-header">
        <div class="mimed-wrap mimed-header-inner">
            <a href="{{ route('mimed.home') }}" class="mimed-wordmark"><strong>MIMEd</strong><span>Musical Instrument Collection, University of Edinburgh</span></a>
            <nav aria-label="Main navigation">
                <a href="{{ route('mimed.search.index', ['query' => '*:*']) }}" @if(request()->routeIs('mimed.search.index', 'mimed.record.show')) aria-current="true" @endif>Catalogue</a>
                <a href="{{ route('mimed.about') }}" @if(request()->routeIs('mimed.about')) aria-current="page" @endif>About the collection</a>
                <a class="mimed-visit-link" href="{{ route('stcecilias.home') }}">Visit St Cecilia’s Hall <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>
    <main id="main">@yield('content')</main>
    <div class="mimed-library-baton"><div class="mimed-wrap"><img src="{{ asset('collections/mimed/images/library-branding-baton.png') }}" alt="University of Edinburgh Library" width="5612" height="346"></div></div>
    <footer class="mimed-footer"><div class="mimed-wrap">
        <div class="mimed-footer-main">
            <div><a href="{{ route('mimed.home') }}" class="mimed-footer-name">Musical Instrument Collection</a><p>Library &amp; University Collections</p></div>
            <nav aria-label="Collection links">
                <a href="{{ route('mimed.about') }}">About the collection</a>
                <a href="{{ route('mimed.iiif') }}">IIIF</a>
                <a href="{{ route('mimed.feedback') }}">Feedback</a>
                <a href="{{ route('stcecilias.home') }}">St Cecilia’s Hall</a>
            </nav>
            <nav aria-label="Policies">
                <a href="https://www.ed.ac.uk/about/website/website-terms-conditions">Terms &amp; conditions</a>
                <a href="{{ route('mimed.accessibility') }}">Accessibility statement</a>
                <a href="{{ route('mimed.licensing') }}">Licensing &amp; copyright</a>
                <a href="{{ route('mimed.takedown') }}">Takedown policy</a>
                <a href="https://www.ed.ac.uk/about/website/privacy">Privacy &amp; cookies</a>
            </nav>
            <a class="mimed-recognition" href="https://www.museumsgalleriesscotland.org.uk/standards/recognition/"><img src="{{ asset('collections/mimed/images/recognised.gif') }}" alt="Recognised Collection of National Significance"></a>
        </div>
        <div class="mimed-footer-bottom">
            <span>© {{ date('Y') }} The University of Edinburgh</span>
            <div><a href="https://www.facebook.com/pages/Edinburgh-University-Collection-of-Historic-Musical-Instruments-EUCHMI/144892895544842">Facebook</a><a href="https://twitter.com/MIMEdinburgh">X</a></div>
        </div>
    </div></footer>
    @if(config('skylight.ga_code'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', {{ Illuminate\Support\Js::from(config('skylight.ga_code')) }});
        </script>
    @endif
    @stack('scripts')
</body>
</html>
