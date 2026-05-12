<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <base href="{{ url('/stcecilias/') }}/">

    <title>@yield('title', "St Cecilia's Hall")</title>

    <link rel="pingback" href="{{ url('/pingback') }}" />

    <meta name="description" content="@yield('meta_description', "Online catalogue of St Cecilia's Hall, the University of Edinburgh's musical instrument collection.")">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', "St Cecilia's Hall")">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/stcecilia/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/stcecilia/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/stcecilia/css/style.css') }}?v=2">
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
            flowplayer.conf = {
                analytics: '{{ config('skylight.ga_code') }}'
            };
        </script>
    @endif
</head>

<body class="@yield('body_class', 'record')">
<script>
    function warnNewTab() {
        return confirm("This link will open in a new tab. Proceed?");
    }
</script>

<div class="skip-links">
    <a class="screen-reader-text" href="{{ url()->current() }}#content">Skip to content</a>
</div>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="col-lg-8 col-md-8 col-sm-9 hidden-xs">
        <div class="nav-logo">
            <a class="nav-logo-link" href="https://www.stcecilias.ed.ac.uk" title="Return to the home page">
                <img class="nav-logo-img" src="{{ asset('collections/stcecilia/images/StCsNavLogo.png') }}" alt="St Cecilia's Hall">
            </a>
        </div>

        <form id="nav-cont" class="navbar-form navbar-left" role="search" action="{{ url('/stcecilias/redirect') }}" method="post">
            @csrf
            <div class="input-group search-box">
                <input id="uoe-search" type="text" class="form-control" placeholder="Search the museum collections" name="q" value="{{ isset($searchbox_query) ? str_replace('"', '', urldecode($searchbox_query)) : '' }}" title="Enter a search for St Cecilia's Collection" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search1" title="Search St Cecilia's Collection">
                        <i class="glyphicon glyphicon-search"></i>&nbsp;Search
                    </button>
                </span>
            </div>
        </form>

        <div class="navbar-right sch-link" id="full-visit">
            <a style="line-height: normal; text-align:center; display: block;" href="https://www.stcecilias.ed.ac.uk/visit/" title="Visit St Cecilia's Hall" target="_blank" rel="noopener">Visit St Cecilia's Hall <br /><span style="font-size:16px;">(opens in a new tab)</span></a>
        </div>
        <div class="navbar-right sch-link" id="smol-visit">
            <a style="line-height: normal; text-align:center; display: block;" href="https://www.stcecilias.ed.ac.uk/visit/" title="Visit St Cecilia's Hall" target="_blank" rel="noopener">Visit St Cecilia's <br /><span style="font-size:16px;">(opens in a new tab)</span></a>
        </div>
        <div class="navbar-right sch-link" id="xtra-smol-visit">
            <a style="line-height: normal; text-align:center; display: block;" href="https://www.stcecilias.ed.ac.uk/visit/" title="Visit St Cecilia's Hall" target="_blank" rel="noopener">Visit Us <br /><span style="font-size:16px;">(opens in a new tab)</span></a>
        </div>
    </div>

    <div class="hidden-lg hidden-md hidden-sm col-xs-7">
        <div class="nav-logo">
            <a class="nav-logo-link" href="https://www.stcecilias.ed.ac.uk">
                <img class="nav-logo-img" src="{{ asset('collections/stcecilia/images/StCsNavLogo.png') }}" alt="St Cecilia's Hall">
            </a>
        </div>

        <form id="nav-cont" class="navbar-form navbar-left" role="search" action="{{ url('/stcecilias/redirect') }}" method="post">
            @csrf
            <div class="input-group search-box">
                <input id="uoe-search-sm" type="text" class="form-control" placeholder="Search" name="q" value="{{ isset($searchbox_query) ? str_replace('"', '', urldecode($searchbox_query)) : '' }}" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search2">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
            </div>
        </form>

        <div class="navbar-right sch-link" id="full-visit">
            <a style="line-height: normal; text-align:center; display: block;" href="https://www.stcecilias.ed.ac.uk/visit/" title="Visit St Cecilia's Hall" target="_blank" rel="noopener">Visit St Cecilia's Hall <br /><span style="font-size:16px;">(opens in a new tab)</span></a>
        </div>
    </div>
</nav>

{{-- Mobile-only search bar --}}
<form id="body-cont" class="navbar-form navbar-left" role="search" action="{{ url('/stcecilias/redirect') }}" method="post">
    @csrf
    <div class="input-group search-box">
        <input id="uoe-search" type="text" class="form-control" placeholder="Search the museum collections" name="q" value="{{ isset($searchbox_query) ? str_replace('"', '', urldecode($searchbox_query)) : '' }}" />
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search1">
                <i class="glyphicon glyphicon-search"></i>&nbsp;Search
            </button>
        </span>
    </div>
</form>

<div id="content"></div>

@yield('content')

<footer class="footer bg-secondary">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="centered text-center">
                <ul class="nav nav-pills">
                    <li><a href="{{ url('/stcecilias') }}" title="St Cecilia's Hall Home"><i class="fa fa-home fa-lg">&nbsp;</i></a></li>
                    <li><a href="{{ url('/stcecilias/about') }}" title="About St Cecilia's Hall"><i class="fa fa-info fa-lg">&nbsp;</i></a></li>
                    <li><a href="https://www.facebook.com/pages/Edinburgh-University-Collection-of-Historic-Musical-Instruments-EUCHMI/144892895544842" target="_blank" rel="noopener" title="MIMEd on Facebook"><i class="fa fa-facebook fa-lg">&nbsp;</i><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                    <li><a href="https://twitter.com/MIMEdinburgh" target="_blank" rel="noopener" title="MIMEd on Twitter"><i class="fa fa-twitter fa-lg">&nbsp;</i><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                    <li><a href="{{ url('/stcecilias/feedback') }}" title="Provide feedback"><i class="fa fa-envelope fa-lg">&nbsp;</i></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs">
            <a class="navbar-brand navbar-left" href="https://www.ed.ac.uk" title="The University of Edinburgh Homepage Link" target="_blank" rel="noopener"><img src="{{ asset('collections/stcecilia/images/UoETransparentWhite.png') }}" class="img-responsive uoe_logo" alt="University of Edinburgh link" /><span class="visually-hidden"> (opens in a new tab)</span></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 hidden-xs hidden-lg hidden-md">
            <ul>
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies (opens in a new tab)</a></li>
                <li><a href="https://www.ed.ac.uk/library/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" title="Takedown Policy Link">Takedown Policy</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 hidden-xs hidden-lg hidden-md">
            <ul>
                <li><a href="{{ url('/stcecilias/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility (opens in a new tab)</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 hidden-lg hidden-md hidden-sm">
            <ul class="small">
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies (opens in a new tab)</a></li>
                <li><a href="{{ url('/stcecilias/takedown') }}" title="Takedown Policy Link">Takedown Policy</a></li>
            </ul>
        </div>
        <div class="col-xs-6 hidden-lg hidden-md hidden-sm">
            <ul class="small">
                <li><a href="{{ url('/stcecilias/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility (opens in a new tab)</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="centered text-center hidden-sm hidden-xs">
            <ul class="list-inline">
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies (opens in a new tab)</a></li>
                <li><a href="https://www.ed.ac.uk/library/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" title="Takedown Policy Link">Takedown Policy</a></li>
                <li><a href="{{ url('/stcecilias/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="{{ url('/stcecilias/accessibility') }}" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility (opens in a new tab)</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 hidden-xs text-center">
            <span><a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener" title="Library &amp; University Collections Home">Library and University Collections (opens in a new tab)</a> is a division of <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener" class="islogo" title="University of Edinburgh Information Services Home">Information Services (opens in a new tab)</a>.</span><br />
            <span>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh (opens in a new tab)</a>.</span><br />
            <span>MIMEd is a <a href="http://www.museumsgalleriesscotland.org.uk/standards/recognition/" target="_blank" rel="noopener" title="Recognised Collection of National Significance Link">Recognised Collection of National Significance (opens in a new tab)</a>.</span>
        </div>
        <div class="col-xs-12 hidden-lg hidden-md hidden-sm text-center">
            <span class="small"><a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener" title="Library &amp; University Collections Home">Library and University Collections (opens in a new tab)</a> is a division of
            <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener" class="islogo" title="University of Edinburgh Information Services Home">Information Services (opens in a new tab)</a>.</span><br />
            <span class="small">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh (opens in a new tab)</a>.</span><br />
            <span class="small">MIMEd is a <a href="https://www.museumsgalleriesscotland.org.uk/standards/recognition/" target="_blank" rel="noopener" title="Recognised Collection of National Significance Link">Recognised Collection of National Significance (opens in a new tab)</a>.</span>
        </div>
    </div>

    <div class="spacer"></div>
</footer>

<script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
<script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
<script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
<script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
<script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
<script src="{{ asset('assets/plugins/plugins.js') }}"></script>
<script src="{{ asset('assets/script/script.js') }}"></script>
<script src="{{ asset('collections/stcecilia/js/script.js') }}"></script>

@stack('scripts')
</body>
</html>
