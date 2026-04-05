<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Guardbook')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="University of Edinburgh">
    <meta name="title" content="@yield('title', 'Guardbook')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="{{ asset('collections/guardbook/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/guardbook/images/apple-touch-icon.png') }}">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('collections/guardbook/css/style.css') }}?v=4">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Brawler|IM+Fell+DW+Pica|PT+Mono|Palanquin|Pridi|Source+Sans+Pro');
    </style>

    <script src="{{ asset('assets/google-analytics/analytics.js') }}"></script>
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
    @if(config('skylight.ga_code'))
    <script>
        flowplayer.conf = { analytics: @json(config('skylight.ga_code')) };
    </script>
    @endif

    @yield('head')
    @stack('styles')

    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
    <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />


    @php
    $metafields = config('skylight.metafields');
    //var_dump($metafields);
    @endphp


    {{--@foreach($metafields as $label => $element)
        @php
        $field = "";
        @endphp
        @if(isset($recordDisplay[$label]))
            @php
            $field = $recordDisplay[$label];
            @endphp
            @if(isset($record[$field]))
                @php
                $values = $record[$field];
                @endphp
                @foreach($values as $value)
                     <meta name="{{ $element }}" content="{{ $value }}">
                @endforeach
            @endif
        @endif
    @endforeach--}}


</head>

    <body>
        <div class="skip-links">
            <a class="screen-reader-text" href="#content">Skip to content</a>
        </div>
        <!-- New tab notice script -->
        <script>
            function warnNewTab() {
              return confirm("This link will open in a new tab. Proceed?");
            }
        </script>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="uoe-logo"></div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/guardbook/about') }}" title ="About Link">About</a></li>
                        <!--<li><a href="{{ url('/guardbook/history') }}" title ="History Link">History</a></li>-->
                        <!--<li><a href="./catalogues" title="Catalogues Link">Catalogues</a></li>-->
                        <li><a href="{{ url('/guardbook/feedback') }}" title="Feedback Form">Feedback</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <header>
            <div class="container">

                <div class="header-normal">
                    <div id="collection-title"><a href="{{ url('/guardbook')}}" title="Guardbook Catalogue Home">{{config('skylight.fullname')}}</a>
                    </div>

                    <div id="collection-search">
                        <form action="{{ url('/guardbook/redirect') }}" method="post" class="navbar-form">
                            @csrf
                            <div class="input-group search-box">
                                <!--<fieldset class="search">-->
                                    <input type="text" name="q" aria-label="Website searchbox" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" class="form-control" placeholder="Search" name="q" />
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search"><i class="glyphicon glyphicon-search"></i></button>
                                    </span>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div id="content" class="container content">
             <div class="container-fluid">
        {{--<?php
        if(isset($page_heading)) {
            $page_title = $page_heading;
        }
        ?>--}}
            @yield('content')

        </div>

    </div>
     </div>
        <div class="container-fluid">
            <footer>
                <div class="col-sm-12 col-xs-12 footer-disclaimer">
                    <div class="center-block footer-policies">
                        <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link"  target="_blank">Privacy &amp; Cookies (opens in a new tab)</a>
                        &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank" title="Takedown Policy Link">Takedown Policy (opens in a new tab)</a>
                        &nbsp;&nbsp;<a href="{{ url('/guardbook/licensing')}}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                        &nbsp;&nbsp;<a href="{{ url('/guardbook/accessibility')}}" title="Website Accessibility Link" target="_blank">Accessibility (opens in a new tab)</a>
                        <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; <?php echo date("Y"); ?> <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank">University of Edinburgh (opens in a new tab)</a>.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
