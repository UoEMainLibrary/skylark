<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">
    <title>@yield('title', 'Points Of Arrival')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('meta_description', 'Points of Arrival — a digital resource pack for schools on historical Jewish immigration to Scotland.')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/pointsofarrival/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7">
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/pointsofarrival/css/style.css') }}?v=2">
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet">

    @stack('styles')

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/masonry/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>

    @if(config('skylight.ga_code'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('skylight.ga_code') }}');
        </script>
        <script src="{{ asset('assets/flowplayer-7.0.4/flowplayer.min.js') }}"></script>
        <script>
            flowplayer.conf = { analytics: '{{ config('skylight.ga_code') }}' };
        </script>
    @endif
</head>
<body class="@yield('body_class', 'record')">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="col-lg-8 col-md-8 col-sm-9 hidden-xs">
            <div class="nav-title">
                <a title="Home link" href="./" alt="Points of Arrival">
                    <img class="nav-logo" src="{{ asset('collections/pointsofarrival/images/site-logos/navbar-logo-w.png') }}" alt="Points of Arrival Logo">
                </a>
                <p title="Points of Arrival tagline">A digital resource pack for schools on historical Jewish immigration to Scotland</p>
            </div>
            <div class="right-nav">
                <a href="https://www.sjac.org.uk/" target="_blank" rel="noopener"><img src="{{ asset('collections/pointsofarrival/images/site-logos/sjac_logo_clear.png') }}" alt="Scottish Jewish Archives Centre"></a>
                <a href="https://www.ed.ac.uk/" target="_blank" rel="noopener"><img id="uoe" src="{{ asset('collections/pointsofarrival/images/logos/uoe-logo.png') }}" alt="University of Edinburgh"></a>
                <a href="https://www.gla.ac.uk/" target="_blank" rel="noopener"><img id="uog" src="{{ asset('collections/pointsofarrival/images/logos/uog-logo.png') }}" alt="University of Glasgow"></a>
            </div>
        </div>
    </nav>

    <div class="poa-img-banner">
        <div><img class="video-still" src="{{ asset('collections/pointsofarrival/images/video-stills/stills-banner.png') }}" alt=""></div>
    </div>

    @yield('content')

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>
    <script src="{{ asset('collections/pointsofarrival/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
