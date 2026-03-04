<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="{{ url('/eerc/') }}/">

    <title>@yield('title', 'Regional Ethnology of Scotland Project')</title>

    <meta name="description" content="The purpose of the Regional Ethnology of Scotland Project (RESP) is to enable communities across Scotland to work together to record information about their local life and society. This work is carried out on a regional basis by conducting fieldwork interviews. The RESP is managed by the European Ethnological Research Centre (EERC) at the University of Edinburgh.">
    <meta name="author" content="The European Ethnological Research Centre">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('collections/eerc/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/eerc/images/apple-touch-icon.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('collections/eerc/css/style.css') }}?v=2">
    <link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">

    @stack('styles')

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('collections/eerc/js/readmore.min.js') }}"></script>

    @if(config('skylight.ga_code'))
    <!-- Google Analytics -->
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
    <!-- Navigation -->
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
                    <li><a href="{{ url('/eerc') }}" title="EERC Home Link">Home</a></li>
                    <li><a href="{{ url('/eerc/overview') }}" title="Browse the Collections Link">Browse the Collections</a></li>
                    <li><a href="{{ url('/eerc/people') }}" title="People Link">People</a></li>
                    <li><a href="{{ url('/eerc/resp') }}" title="Regional Ethnology Scotland Archive Project">RESP Archive Project</a></li>
                    <li><a href="{{ url('/eerc/using') }}" title="Searching and Using the Collection">Searching and Using the Collection</a></li>
                    <li><a href="{{ url('/eerc/exhibition_gallery') }}" title="Exhibition Gallery">Exhibition Gallery</a></li>
                    <li><a href="{{ url('/eerc/kids_only') }}" title="Kids Only">Kids Only</a></li>
                    <li><a href="{{ url('/eerc/contact') }}" title="Contact">Contact</a></li>
                    <li><a href="{{ url('/eerc/map') }}">Map</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header with Logo and Search -->
    <header>
        <div class="container">
            <div class="header-normal">
                <div><a href="{{ url('/eerc') }}" class="eerc-logo" title="Regional Ethnology of Scotland Project homepage"></a></div>
                <div id="collection-title">
                    <a href="{{ url('/eerc') }}" title="Regional Ethnology of Scotland Project homepage">
                        Regional Ethnology<br>of Scotland Project
                    </a>
                </div>

                <div id="collection-search">
                    <form action="{{ url('/eerc/redirect') }}" method="post" class="navbar-form">
                        @csrf
                        <div class="input-group search-box">
                            <input type="text" aria-label="Search" class="form-control" placeholder="Search" name="q" value="{{ $searchbox_query ?? '' }}" id="q" />
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

    <!-- Main Content -->
    <div class="container content">
        <div class="container-fluid content">
            @yield('content')

            <!-- Footer -->
            <footer>
                <div class="col-md-9 col-sm-9 col-xs-12 footer-logos">
                    <div class="center-block">
                        <a href="https://www.ed.ac.uk" target="_blank" title="The University of Edinburgh">
                            <div class="uoe-logo"></div>
                            <span class="visually-hidden"> (opens in a new tab)</span>
                        </a>
                        <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/cultural-heritage-collections/crc" target="_blank" title="Centre for Research Collections">
                            <div class="crc-logo"></div>
                            <span class="visually-hidden"> (opens in a new tab)</span>
                        </a>
                        <a href="https://www.ed.ac.uk/literatures-languages-cultures/celtic-scottish-studies/research/eerc" target="_blank" title="Regional Ethnology of Scotland Project">
                            <div class="eerc-logo-small"></div>
                            <span class="visually-hidden"> (opens in a new tab)</span>
                        </a>
                        <a href="https://libraryblogs.is.ed.ac.uk/resp/" target="_blank" title="RESP Blog">
                            <div class="blogs-logo"></div>
                            <span class="visually-hidden"> (opens in a new tab)</span>
                        </a>
                        <a href="https://www.instagram.com/RESParchiveproject/" target="_blank" title="RESP Instagram">
                            <div class="instagram-logo"></div>
                            <span class="visually-hidden"> (opens in a new tab)</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12 footer-disclaimer">
                    <div class="center-block footer-policies">
                        <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank">Privacy &amp; Cookies <span class="sr-only">(opens in a new tab)</span></a>
                        &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank" title="Takedown Policy Link">Takedown Policy <span class="sr-only">(opens in a new tab)</span></a>
                        &nbsp;&nbsp;<a href="{{ url('/eerc/using') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                        &nbsp;&nbsp;<a href="{{ url('/eerc/accessibility') }}" title="Website Accessibility Link">Accessibility</a>
                        <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank">University of Edinburgh <span class="sr-only">(opens in a new tab)</span></a>.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')

    <!-- AddThis -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5dc14a4cd089c947"></script>
</body>
</html>
