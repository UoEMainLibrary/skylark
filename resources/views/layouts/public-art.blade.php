<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <base href="{{ url('/public-art') }}/">

    <link rel="pingback" href="{{ url('/pingback') }}" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>@yield('title', 'Public Art')</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/public-art/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/public-art/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/public-art/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/public-art/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/public-art/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/public-art/css/jquery.mCustomScrollbar.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('collections/public-art/lightSlider/css/lightslider.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('collections/public-art/lightSlider/css/lightslider-custom.css') }}" />

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('collections/public-art/js/pace.js') }}"></script>

    <script src="{{ asset('collections/public-art/js/visible.js') }}"></script>
    <script src="{{ asset('collections/public-art/js/viewportchecker.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="{{ asset('collections/public-art/lightSlider/js/lightslider.js') }}"></script>
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" type="text/css">

    @if(config('skylight.ga_code'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
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

    @yield('head')
    @stack('styles')
</head>

<body>
    <div id="loader"></div>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Home <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/public-art') }}">Home</a></li>
                            <li><a href="{{ url('/public-art/about') }}">About</a></li>
                            <li><a href="{{ url('/public-art/paolozzi') }}">Paolozzi Mosaics</a></li>
                            <li><a href="{{ url('/public-art/licensing') }}">Licensing</a></li>
                            <li><a href="{{ url('/public-art/search/*:*/?map=true') }}">Map</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/public-art/feedback') }}">Contact</a></li>
                    <li><a href="{{ url('/public-art/search/*:*/?map=true') }}">Map</a></li>
                    <li class="search">
                        <form role="search" action="{{ url('/public-art/redirect') }}" method="post">
                            @csrf
                            <input id="uoe-search" type="text"
                                   placeholder="Search..." name="q"
                                   value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}"
                                   aria-label="Search"/>
                            <button type="submit" name="submit_search" value="Search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="footer scroll">
        <ul>
            <li><a href="https://www.ed.ac.uk/about/website/website-terms-conditions">Terms &amp; conditions</a></li>
            <li><a href="https://www.ed.ac.uk/about/website/privacy">Privacy &amp; cookies</a></li>
            <li><a href="{{ url('/public-art/accessibility') }}" title="Website Accessibility Link" target="_blank">Accessibility</a></li>
            <li><a href="https://www.ed.ac.uk/about/website/freedom-information">Freedom of Information Publication Scheme</a></li>
        </ul>
        <p>Unless explicitly stated otherwise, all material is copyright &copy; The University of Edinburgh
            <script type="text/javascript">var year = new Date();document.write(year.getFullYear());</script>
        </p>
    </div>

    <script type="text/javascript" src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>

    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>
    <script src="{{ asset('collections/public-art/js/record_image.js') }}"></script>
    <script src="{{ asset('collections/public-art/js/home_page.js') }}"></script>
    <script src="{{ asset('collections/public-art/js/jquery.mCustomScrollbar.js') }}"></script>

    @stack('scripts')
</body>
</html>
