<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'University of Edinburgh Anatomical Collection')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="University of Edinburgh Anatomical Collection">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">

    <link rel="shortcut icon" href="{{ asset('collections/anatomy/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/anatomy/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('collections/anatomy/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

    @if(config('skylight.ga_code'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ config('skylight.ga_code') }}');
        </script>
    @endif

    <script src="{{ asset('assets/flowplayer-7.0.4/flowplayer.min.js') }}"></script>
    <script>
        flowplayer.conf = {
            analytics: "{{ config('skylight.ga_code') }}"
        };
    </script>
</head>

<body>
    <div class="skip-links">
        <a class="sr-only" href="{{ url()->current() }}#main">Skip to content</a>
    </div>

    <div id="container">
        <header>
            <div id="collection-title">
                <a href="https://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Home (opens in a new tab)" target="_blank"><span class="sr-only">(Opens in a new tab)</span></a>
                <a href="{{ url('/anatomy') }}" class="anatomylogo" title="Anatomical Collection Home"></a>
                <a href="{{ url('/anatomy') }}" class="menulogo" title="Anatomical Collection Home"></a>
            </div>
            <div id="collection-search">
                <form action="{{ url('/anatomy/redirect') }}" method="post">
                    @csrf
                    <fieldset class="search">
                        <input type="text" name="q" value="<?php if (isset($searchbox_query)) {
                            echo urldecode($searchbox_query);
                        } ?>" id="q" />
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                        <a href="{{ url('/anatomy/advanced') }}" class="advanced">Advanced search</a>
                    </fieldset>
                </form>
            </div>
        </header>

        <div id="main" role="main" class="clearfix">
            <div class="col-main">

                @yield('content')

                <footer>
                    <div class="footer-links">
                        <div class="site-links">
                            <a href="{{ url('/anatomy') }}">University of Edinburgh Anatomical Collection</a>
                            <a href="{{ url('/anatomy/about') }}">About this Collection</a>
                            <a href="{{ url('/anatomy/feedback') }}" class="last">Feedback</a>
                        </div>
                        <div class="social-links">
                            <ul class="social-icons">
                                <li><a href="https://www.facebook.com/crc.edinburgh" class="facebook-icon" target="_blank" rel="noopener" title="CRC on Facebook"></a></li>
                                <li><a href="https://twitter.com/CRC_EdUni" class="twitter-icon" target="_blank" rel="noopener" title="CRC on Twitter"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-disclaimer">
                        <div class="footer-logo">
                            <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener" class="luclogo" title="Library &amp; University Collections Home"></a>
                        </div>
                        <div class="footer-policies">
                            <p>This collection is part of <a href="https://collections.ed.ac.uk/" title="University Collections Home">University Collections</a>.</p>
                            <p>
                                <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                                &nbsp;&nbsp;<a href="{{ url('/anatomy/takedown') }}" title="Takedown Policy Link">Takedown Policy</a>
                                &nbsp;&nbsp;<a href="{{ url('/anatomy/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                                &nbsp;&nbsp;<a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility</a>
                            </p>
                            <p>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh</a>.</p>
                        </div>
                        <div class="is-logo">
                            <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener" class="islogo" title="University of Edinburgh Information Services Home"></a>
                        </div>
                    </div>
                </footer>

            </div>

            <div class="col-sidebar">
                @hasSection('sidebar')
                    @yield('sidebar')
                @else
                    @include('defaults.search.partials.facets')
                @endif
            </div>

        </div>
    </div>

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>

    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>
</body>
</html>
