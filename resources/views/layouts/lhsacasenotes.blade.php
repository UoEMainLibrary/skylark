<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <base href="{{ url('/lhsacasenotes/') }}/">

    <title>@yield('title', 'Lothian Health Service Archives: Medical Case Notes')</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', 'Lothian Health Service Archives: Medical Case Notes')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/lhsacasenotes/images/favicon.ico') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('collections/lhsacasenotes/css/style.css') }}?v=2">
    <link href="https://fonts.googleapis.com/css?family=Special+Elite&display=swap" rel="stylesheet">

    @stack('styles')

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
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/lhsacasenotes') }}" title="Medical Case Notes Home Link">Home</a></li>
                    <li><a href="{{ url('/lhsacasenotes/about') }}" title="About Link">About</a></li>
                    <li><a href="{{ url('/lhsacasenotes/history') }}" title="History Link">History</a></li>
                    <li><a href="{{ url('/lhsacasenotes/tuberculosis') }}" title="Tuberculosis">Tuberculosis</a></li>
                    <li><a href="{{ url('/lhsacasenotes/catalogues') }}" title="Catalogues Link">Catalogues</a></li>
                    <li><a href="{{ url('/lhsacasenotes/people') }}" title="People Link">People</a></li>
                    <li><a href="{{ url('/lhsacasenotes/achievements') }}" title="Achievements Link">Achievements</a></li>
                    <li><a href="https://lhsa.blogspot.co.uk/" title="LHSA Blog Link" target="_blank" rel="noopener">LHSA Blog</a></li>
                    <li><a href="{{ url('/lhsacasenotes/feedback') }}" title="Feedback Form">Feedback</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="container">
            <div class="header-normal">
                <div id="collection-title">Medical Records Revived:
                    <div id="collection-sub-title">Case Note Catalogues at <br />Lothian Health Services Archive</div>
                </div>

                <div id="collection-search">
                    <form action="{{ url('/lhsacasenotes/redirect') }}" method="post" class="navbar-form">
                        @csrf
                        <div class="input-group search-box">
                            <input type="text" aria-label="Search" class="form-control" placeholder="Search" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="container content">
        @yield('content')
    </div>

    <div class="container-fluid">
        <footer>
            <div class="col-md-12 col-sm-12 col-xs-12 footer-logos ">
                <div class="center-block">
                    <a href="https://www.wellcome.ac.uk/" target="_blank" rel="noopener" title="Wellcome Trust"><div class="wellcome-logo"></div></a>
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" target="_blank" rel="noopener" title="Centre for Research Collections"><div class="crc-logo"></div></a>
                    <a href="https://www.lhsa.lib.ed.ac.uk" target="_blank" rel="noopener" title="Lothian Health Services Archive"><div class="lhsa-logo"></div></a>
                    <a href="https://www.nhslothian.scot.nhs.uk" target="_blank" rel="noopener" title="NHS Lothian"><div class="nhs-logo"></div></a>
                    <a href="https://www.ed.ac.uk" target="_blank" rel="noopener" title="University of Edinburgh"><div class="uoe-logo"></div></a>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 footer-disclaimer">
                <div class="center-block footer-policies">
                    <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                    &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener" title="Takedown Policy Link">Takedown Policy</a>
                    &nbsp;&nbsp;<a href="{{ url('/lhsacasenotes/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                    &nbsp;&nbsp;<a href="{{ url('/lhsacasenotes/accessibility') }}" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility</a>
                    <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh</a>.</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
