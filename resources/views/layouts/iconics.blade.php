<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">
    <title>@yield('title', 'Library and University Collections - Iconics')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="Library and University Collections - Iconics">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/iconics/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/iconics/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/iconics/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>

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
    @if(config('skylight.ga_code'))
        <script>
            flowplayer.conf = {
                analytics: @json(config('skylight.ga_code'))
            };
        </script>
    @endif

    @yield('head')
    @stack('styles')
</head>

<body>
    <div class="skip-links">
        <a class="sr-only" href="{{ url()->current() }}#main">Skip to content</a>
    </div>

    <div id="container">
        <header>
            <nav id="menu">
                <ul class="social-links">
                    <li><a href="https://www.facebook.com/crc.edinburgh" class="facebook-icon" target="_blank" rel="noopener noreferrer" title="CRC on Facebook"><span class="sr-only">CRC on Facebook (opens in a new tab)</span></a></li>
                    <li><a href="https://twitter.com/CRC_EdUni" class="twitter-icon" target="_blank" rel="noopener noreferrer" title="CRC on Twitter"><span class="sr-only">CRC on Twitter (opens in a new tab)</span></a></li>
                    <li><a href="https://www.flickr.com/photos/crcedinburgh" class="flickr-icon" target="_blank" rel="noopener noreferrer" title="CRC on Flickr"><span class="sr-only">CRC on Flickr (opens in a new tab)</span></a></li>
                </ul>
                <ul class="menu-links">
                    <li><a href="{{ url('/iconics/feedback') }}" title="Feedback Link" class="last">Feedback</a></li>
                    <li><a href="https://www.ed.ac.uk/schools-departments/information-services/library-museum-gallery/crc/projects" title="CRC Projects Link" target="_blank" rel="noopener noreferrer">Projects</a></li>
                    <li><a href="http://libraryblogs.is.ed.ac.uk/" title="Library and University Collections Blog" target="_blank" rel="noopener noreferrer">Blog</a></li>
                    <li><a href="https://www.ed.ac.uk/schools-departments/information-services/library-museum-gallery/crc" title="Centre for Research Collections Link" target="_blank" rel="noopener noreferrer">CRC</a></li>
                    <li><a href="{{ url('/iconics/about') }}" title="About this site">About</a></li>
                    <li><a href="{{ url('/iconics') }}" title="University Collections Home">Home</a></li>
                </ul>
            </nav>
            <div class="clearfix"></div>
            <div id="collection-title">
                <a href="https://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Home" target="_blank" rel="noopener noreferrer"><span class="sr-only">The University of Edinburgh Home (opens in a new tab)</span></a>
                <a href="{{ url('/iconics') }}" class="iconicslogo" title="University of Edinburgh Collections Home"><span class="sr-only">University of Edinburgh Iconics Home</span></a>
            </div>
            <div id="collection-search">
                <form action="{{ url('/iconics/redirect') }}" method="post">
                    @csrf
                    <fieldset class="search">
                        <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" placeholder="search the iconics" />
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                    </fieldset>
                </form>
            </div>
        </header>

        @php
            $iconicsLayout = trim($__env->yieldContent('layout', 'sidebar'));
        @endphp

        <div id="main" role="main" class="clearfix">
            @if($iconicsLayout === 'full')
                <div class="col-main-full">
                    @yield('content')

                    @include('iconics.partials.footer')
                </div>
            @else
                <div class="col-main">
                    @yield('content')

                    @include('iconics.partials.footer')
                </div>

                <div class="col-sidebar">
                    @hasSection('sidebar')
                        @yield('sidebar')
                    @else
                        @include('defaults.search.partials.facets')
                    @endif
                </div>
            @endif
        </div> <!-- close main -->
    </div> <!-- close container -->

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>

    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>

    @stack('scripts')
</body>
</html>
