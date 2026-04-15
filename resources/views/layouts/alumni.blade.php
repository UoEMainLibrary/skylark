<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'University of Edinburgh Alumni Collection')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/alumni/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/alumni/images/apple-touch-icon.png') }}">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="{{ asset('collections/alumni/css/style.css')}}?v=2">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css')}}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css')}}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css')}}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css')}}">

    <!-- Uncomment if you are specifically targeting less enabled mobile browsers
    <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js')}}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js')}}"></script>
    <script src="{{ asset('ssets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js')}}"></script>
    <script src="{{ asset('assets/google-analytics/analytics.js')}}"></script>

    @if(config('skylight.ga_code'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ config('skylight.ga_code') }}');
    </script>
    @endif

    <script src="https://releases.flowplayer.org/6.0.4/flowplayer.min.js"></script>
    <script>
        flowplayer.conf = {
            analytics: "{{ config('skylight.ga_code') }}"
        };
    </script>

    <?php
    /*
    commenting for now

        foreach($metafields as $label => $element) {
            $field = "";
            if(isset($recorddisplay[$label])) {
                $field = $recorddisplay[$label];
                if(isset($solr[$field])) {
                    $values = $solr[$field];
                    foreach($values as $value) {
                        ?>  <meta name="<?php echo $element; ?>" content="<?php echo $value; ?>"> <?php
                    }
                }
            }
        }

    } */?>

</head>

<body>
    <script>
        function warnNewTab() {
            return confirm("This link will open in a new tab. Proceed?");
        }
    </script>
    <div class="skip-links" style="position: absolute;">
        <a class="screen-reader-text" href="{{ url()->current() }}#main">Skip to content</a>
    </div>
    <div id="container">
        <header>
            <div id="collection-title">
                <a href="https://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Home" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a>
                <a href="{{ url('/alumni/home') }}" class="logo" title="University of Edinburgh Historical Alumni Home"></a>
                <a href="{{ url('/alumni/home') }}" class="menulogo" title="University of Edinburgh Historical Alumni  Home"></a>
            </div>
            <div id="collection-search">
            <!--<section class="search">-->
                <form action="{{ url('/alumni/redirect') }}" method="post">
                    @csrf
                    <!--<div class="container-fluid">
                        <div class="input-group">-->
                            <fieldset class="search">
                                <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q">
                                <!--<div class="input-group-append">-->
                                <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                                    <!--<input type="button" class="btn btn-outline-secondary" name="submit_search"
                                        value="Advanced Search" onclick="location.href='{{ url('/art/advanced') }}';" />-->
                                <!--</div>-->
                            </fieldset>
                        <!--</div>
                    </div>-->
                </form>
            <!--</section>-->

        <div id="main" role="main" class="clearfix">

            @yield('content')
        <footer>
            <div class="footer-links">
                <div class="site-links">
                    <a href="{{ url('/alumni/home') }}">University of Edinburgh Historical Alumni</a>
                    <a href="{{ url('/alumni/about') }}">About</a>
                    <a href="{{ url('/alumni/feedback') }}" class="last">Contact Us</a>
                </div>
                <div class="social-links">
                    <ul class="social-icons">
                        <li><a href="https://www.facebook.com/crc.edinburgh" class="facebook-icon" target="_blank" title="CRC on Facebook"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                        <li><a href="https://twitter.com/CRC_EdUni" class="twitter-icon" target="_blank" title="CRC on Twitter"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                        <li><a href="https://www.flickr.com/photos/crcedinburgh" class="flickr-icon" target="_blank" title="CRC on Flickr"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                        <li><a href="http://libraryblogs.is.ed.ac.uk/" class="wordpress-icon" target="_blank" title="L&UC Blogs"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-disclaimer">
                <div class="footer-logo">
                    <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" class="luclogo" title="Library &amp; University Collections Home"></a>
                </div>
                <div class="footer-policies">
                    <p>This collection is part of <a href="{{ url('/clds/home') }}" title="University Collections Home">University Collections</a>.</p>
                    <p><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link"  target="_blank">Privacy &amp; Cookies (opens in a new tab)</a>
                        &nbsp;&nbsp;<a href="{{ url('/alumni/takedown') }}" title="Takedown Policy Link">Takedown Policy</a>
                        &nbsp;&nbsp;<a href="{{ url('/alumni/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                        &nbsp;&nbsp;<a href="{{ url('/alumni/accessibility') }}" title="Website Accessibility Link" target="_blank">Accessibility (opens in a new tab)</a></p>
                    <p>Unless explicitly stated otherwise, all material is copyright &copy; <?php echo date("Y"); ?> <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank">University of Edinburgh (opens in a new tab)</a>.</p>
                </div>
                <div class="is-logo">
                    <a href="https://www.ed.ac.uk/information-services" target="_blank" class="islogo" title="University of Edinburgh Information Services Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
