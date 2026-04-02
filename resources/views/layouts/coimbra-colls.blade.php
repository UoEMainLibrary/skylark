<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Coimbra Collections')</title>

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
    Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->

    <link rel="shortcut icon" href="{{ asset('collections/coimbra-colls/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/coimbra-colls/images/apple-touch-icon.png') }}">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('collections/coimbra-colls/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('collections/coimbra-colls//css/animate.css')}}">

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCF95rAHOZQlQ7atjmr9HC2e4M2cS-u1Gs" async defer></script>
    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js')}}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js')}}"></script>
    <script src="{{ asset('collections/coimbra-colls/js/google_map.js')}}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js')}}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/google-analytics/analytics.js')}}"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('skylight.ga_code') }}');
    </script>
    <!-- End Google Analytics -->

    <script src="{{ asset('assets/flowplayer-7.0.4/flowplayer.min.js')}}"></script>

    <!-- global options -->
    <script>
        flowplayer.conf = {
             analytics: "{{ config('skylight.ga_code') }}"
        };
    </script>

    <?php /* if (isset($solr)) { ?><link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
        <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />

        <?php

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
    <div class="skip-links">
        <a class="screen-reader-text" href="{{ url()->current() }}#main">Skip to content</a>
    </div>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" title="Coimbra Group Website link" target="_blank" href="http://www.coimbra-group.eu/"><span class="visually-hidden"> (opens in a new tab)</span></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active dropdown"><a href={{ url('/coimbra-colls/') }}>Home</a></li>
                    <li><a href="{{ url('/coimbra-colls/feedback') }}">Feedback</a></li>
                    <li><a href="{{ url('/coimbra-colls/about') }}">About</a></li>
                    <li><a href="{{ url('/coimbra-colls/virtual-exhibition') }}">Virtual Exhibition</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./search">All records</a></li>
                    <li class="search">
                        <form role="search" action="{{ url('/coimbra-colls/redirect') }}" method="post">
                            @csrf
                            <input id="uoe-search" type="text"
                                   placeholder="Search..." name="q"
                                   value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}"/>
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

</div> <!--END of ROW - move into col sidebar -->
</div><!--END of container - move into col sidebar -->
<div class="footer">
    <div class="hidden-xs col-md-2 text-center">
        <a href="https://www.ed.ac.uk" title="Link to University of Edinburgh Home Page" target="_blank" href="https://www.ed.ac.uk"> <img
                style="height: 100px; width: 100px; position: relative; margin: 25px auto"
                src="{{ asset('collections/coimbra-colls/images/eduni-logo.png') }}"
                alt="University of Edinburgh Logo"></a>
    </div>
    <div class="col-xs-12 col-md-10">
        <ul>
            <li><a href="https://www.ed.ac.uk/about/website/website-terms-conditions">Terms &amp; conditions</a></li>
            <li><a title="Website Accessibility Link" target="_blank" href="{{url('/coimbra-colls/accessibility')}}">Accessibility (Opens in a new tab)</a></li>
            <li><a href="https://www.ed.ac.uk/about/website/privacy">Privacy &amp; cookies</a></li>

        </ul>

        <p>Hosted by The University of Edinburgh</p>
        <p>Copyright © 2017 Coimbra Group</p>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="newTabNotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notice</h4>
            </div>
            <div class="modal-body">
                <p>This link will open in a new tab. Would you like to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="openTab" type="button" class="btn btn-primary">Proceed</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#newTabNotice').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var href = button.data('href');

        var modal = $(this);
        modal.find('#openTab').off('click').on('click', function () {
            window.open(href, '_blank');
            modal.modal('hide');
        });
    });
</script>

<script src="{{ asset('collections/coimbra-colls/js/script.js')}}"></script>

<script src="{{ asset('collections/coimbra-colls/js/disable_map_scroll.js')}}"></script>
<script src="{{ asset('collections/coimbra-colls/js/home_page_slideshow.js')}}"></script>
<script src="{{ asset('collections/coimbra-colls/js/map_view.js')}}"></script>
<script src="{{ asset('collections/coimbra-colls/js/visible.js')}}"></script>
</body>

</html>
