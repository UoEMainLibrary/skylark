<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Musical Instrument Museums Edinburgh">
    <meta name="author" content="The University of Edinburgh">

    <base href="{{ url('/mimed') }}/">

    <title>@yield('title', 'Musical Instrument Museums Edinburgh')</title>

    <link rel="shortcut icon" href="{{ asset('collections/mimed/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/mimed/images/apple-touch-icon.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="{{ asset('collections/mimed/css/style.css') }}?v=2">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @if(config('skylight.ga_code'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('skylight.ga_code') }}');
    </script>
    @endif

    @stack('styles')
</head>
<body>
    <div id="container">
        <div class="skip-links">
            <a class="screen-reader-text" href="#main">Skip to content</a>
        </div>
        <header>
            <div id="collection-title">
                <div class="logo-title-group">
                    <a href="https://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Homepage Link" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a>
                    <a href="{{ url('/mimed') }}" class="mimedlogo" title="Musical Instrument Museums Edinburgh Home"></a>
                </div>
                <a href="http://www.stcecilias.ed.ac.uk/" class="menulogo" title="St Cecilia's Hall Link" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a>
            </div>
            <div id="collection-search">
                <form action="{{ url('/mimed/redirect') }}" method="post">
                    @csrf
                    <fieldset class="search">
                        <input type="text" name="q" aria-label="Website searchbox" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" aria-label="Submit search button"/>
                        <a href="{{ url('/mimed/advanced') }}" class="advanced">Advanced<br>Search</a>
                    </fieldset>
                </form>
            </div>
        </header>

        <div id="main" role="main" class="clearfix">
            @yield('content')
        </div>

        <footer>
            <div class="footer-links">
                <div class="site-links">
                    <a href="{{ url('/mimed') }}">Musical Instrument Museums Edinburgh</a>
                    <a href="{{ url('/mimed/about') }}">About this Collection</a>
                    <a href="{{ url('/mimed/iiif') }}">IIIF</a>
                    <a href="{{ url('/mimed/feedback') }}" class="last">Feedback</a>
                </div>
                <div class="social-links">
                    <ul class="social-icons">
                        <li><a href="https://www.facebook.com/pages/Edinburgh-University-Collection-of-Historic-Musical-Instruments-EUCHMI/144892895544842" class="facebook-icon" target="_blank" title="MIMEd on Facebook"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                        <li><a href="https://twitter.com/MIMEdinburgh" class="twitter-icon" target="_blank" title="MIMEd on Twitter"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-disclaimer">
                <div class="footer-logo">
                    <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" class="luclogo" title="Library &amp; University Collections Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
                </div>
                <div class="footer-policies">
                    <p>This collection is part of <a href="{{ url('/') }}" title="University Collections Home">University Collections</a>.</p>
                    <p><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank">Privacy &amp; Cookies (opens in a new tab)</a>
                        &nbsp;&nbsp;<a href="{{ url('/mimed/takedown') }}" title="Takedown Policy Link">Takedown Policy</a>
                        &nbsp;&nbsp;<a href="{{ url('/mimed/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                        &nbsp;&nbsp;<a href="{{ url('/mimed/accessibility') }}" title="Website Accessibility Link" target="_blank">Accessibility (opens in a new tab)</a></p>
                    <p>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank">University of Edinburgh (opens in a new tab)</a>.</p>
                </div>
                <div class="is-logo">
                    <a href="https://www.ed.ac.uk/information-services" target="_blank" class="islogo" title="University of Edinburgh Information Services Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
                </div>
                <div class="recognised-logo">
                    <a href="https://www.museumsgalleriesscotland.org.uk/standards/recognition/" target="_blank" class="recognisedlogo" title="Recognised Collection of National Significance Link"><span class="visually-hidden"> (opens in a new tab)</span></a>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
        <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=2.1.4"></script>
        <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=2.1.4"></script>
        <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=2.1.4"></script>
        <script src="{{ asset('collections/mimed/js/script.js') }}"></script>
        <script>
            $(document).ready(function() {
                $(".fancybox").fancybox();
            });
        </script>

        @stack('scripts')
    </div>
</body>
</html>
