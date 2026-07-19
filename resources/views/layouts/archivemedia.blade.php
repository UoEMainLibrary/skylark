<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Archives Media')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="Archives Media">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">

    <link rel="shortcut icon" href="{{ asset('collections/archivemedia/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/archivemedia/images/apple-touch-icon.png') }}">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="{{ asset('collections/archivemedia/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
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
                <a href="{{ url('/archivemedia') }}" class="archlogo" title="Archives Media Home"></a>
                <a href="{{ url('/archivemedia') }}" class="menulogo" title="Archives Media Home"></a>
            </div>
            <div id="collection-search">
                <form action="{{ url('/archivemedia/redirect') }}" method="post">
                    @csrf
                    <fieldset class="search">
                        <input type="text" name="q" value="<?php if (isset($searchbox_query)) {
                            echo urldecode($searchbox_query);
                        } ?>" id="q" />
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                        <a href="{{ url('/archivemedia/advanced') }}" class="advanced">Advanced search</a>
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
                            <a href="{{ url('/archivemedia') }}">Archivemedia</a>
                            <a href="{{ url('/archivemedia/iiif') }}">IIIF</a>
                            <a href="{{ url('/archivemedia/feedback') }}" class="last">Feedback</a>
                        </div>

                        {{--
                            Social links are inherited verbatim from the legacy Skylight archivemedia footer
                            (theme copy-paste from the Art Collection). They point at Art Collection accounts
                            rather than archivemedia-specific channels; retained for parity with the live site.
                        --}}
                        <div class="social-links">
                            <ul class="social-icons">
                                <li><a href="https://itunes.apple.com/gb/podcast/2-the-art-of-hiding/id1086099131?i=363892837&mt=2" class="itunes-icon" target="_blank" title="Art Collection on iTunes"><i class="fa fa-music fa-2x fa-fw"></i><span class="sr-only"> (opens in a new tab)</span></a></li>
                                <li><a href="https://www.facebook.com/UniversityOfEdinburghFineArtCollection" target="_blank" title="Art Collection on Facebook"><i class="fa fa-facebook fa-2x fa-fw"></i><span class="sr-only"> (opens in a new tab)</span></a></li>
                                <li><a href="https://twitter.com/UoEArtColl" target="_blank" title="Art Collection on Twitter"><i class="fa fa-twitter fa-2x fa-fw"></i><span class="sr-only"> (opens in a new tab)</span></a></li>
                                <li><a href="http://uoeartandarchives.tumblr.com/" target="_blank" title="Art Collection on Tumblr"><i class="fa fa-tumblr fa-2x fa-fw"></i><span class="sr-only"> (opens in a new tab)</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-disclaimer">
                        <div class="footer-logo">
                            <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" class="luclogo" title="Library &amp; University Collections Home"><span class="sr-only">(opens in a new tab)</span></a>
                        </div>
                        <div class="footer-policies">
                            <p>This collection is part of <a href="{{ url('/') }}" title="University Collections Home">University Collections</a>.</p>
                            <p>
                                <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank">Privacy &amp; Cookies<span class="sr-only"> (opens in a new tab)</span></a>
                                &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" title="Takedown Policy Link" target="_blank">Takedown Policy<span class="sr-only"> (opens in a new tab)</span></a>
                                &nbsp;&nbsp;<a href="{{ url('/archivemedia/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                                &nbsp;&nbsp;<a href="{{ url('/archivemedia/accessibility') }}" title="Website Accessibility Link" target="_blank">Accessibility<span class="sr-only"> (opens in a new tab)</span></a>
                            </p>
                            <p>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank">University of Edinburgh<span class="sr-only"> (opens in a new tab)</span></a>.</p>
                        </div>
                        <div class="is-logo">
                            <a href="https://www.ed.ac.uk/information-services" target="_blank" class="islogo" title="University of Edinburgh Information Services Home"><span class="sr-only">(opens in a new tab)</span></a>
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

        </div> <!-- close main -->
    </div> <!-- close container -->

    <!-- Add mousewheel plugin (this is optional) -->
    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <!-- Add fancyBox -->
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>

    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>

</body>
</html>
