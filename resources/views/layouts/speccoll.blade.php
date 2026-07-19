<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">

    <title>@yield('title', 'Special Collections')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', 'Special Collections')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/speccoll/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/speccoll/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/speccoll/css/style.css') }}?v=2">
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet">

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

<body class="record">
    <div class="skip-links" style="position: absolute;">
        <a class="sr-only" href="#main" onclick="event.preventDefault(); document.getElementById('main').focus();">Skip to content</a>
    </div>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="col-lg-8 col-md-8 col-sm-9 hidden-xs">
            <a href="{{ url('/speccoll') }}" class="home-icon" title="Special Collections Home"><i class="fa fa-home fa-lg"></i></a>
            <form class="navbar-form navbar-left" role="search" action="{{ url('/speccoll/redirect') }}" method="post">
                @csrf
                <div class="input-group search-box">
                    <input id="uoe-search" type="text" class="form-control" placeholder="Search the collections" name="q" value="<?php if (isset($searchbox_query)) {
                        echo urldecode($searchbox_query);
                    } ?>" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search">
                            <i class="glyphicon glyphicon-search"></i>&nbsp;Search
                        </button>
                    </span>
                </div>
            </form>
        </div>

        <div class="hidden-lg hidden-md hidden-sm col-xs-7">
            <a href="{{ url('/speccoll') }}" class="home-icon" title="Special Collections Home"><i class="fa fa-home fa-lg"></i></a>
            <form class="navbar-form navbar-left" role="search" action="{{ url('/speccoll/redirect') }}" method="post">
                @csrf
                <div class="input-group search-box">
                    <input id="uoe-search-sm" type="text" class="form-control" placeholder="Search" name="q" value="<?php if (isset($searchbox_query)) {
                        echo urldecode($searchbox_query);
                    } ?>" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>

        <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
            <div class="navbar-right sch-link">
                <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" title="Visit CRC" target="_blank" rel="noopener">CRC Rare Books &amp; Manuscripts<span class="sr-only"> (Opens in a new tab)</span></a>
            </div>
        </div>
        <div class="hidden-lg hidden-md col-sm-3 hidden-xs">
            <div class="navbar-right sch-link sch-link-sm">
                <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" title="Visit CRC" target="_blank" rel="noopener">CRC Rare Books &amp; Manuscripts<span class="sr-only"> (Opens in a new tab)</span></a>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-5">
            <div class="navbar-right sch-link sch-link-xs">
                <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" title="Visit CRC" target="_blank" rel="noopener">CRC Rare Books &amp; Manuscripts<span class="sr-only"> (Opens in a new tab)</span></a>
            </div>
        </div>
    </nav>

    <div id="main" tabindex="-1" role="main">
        <div class="col-main">
            @yield('content')
        </div>

        @hasSection('sidebar')
            @yield('sidebar')
        @endif
    </div>

    @include('speccoll.partials.footer')

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>
</body>
</html>
