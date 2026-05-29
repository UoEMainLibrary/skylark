<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <base href="{{ url('/geddes/') }}/">
    <title>@yield('title', 'Evergreen - Geddes Project')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/geddes/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/geddes/images/d13c43a7566f69e0106ba22b0be2dff4.ico/apple-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7">
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/geddes/css/style.css') }}?v=2">
    <link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">

    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#geddesNav">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="geddesNav">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/geddes') }}">Home</a></li>
                    <li><a href="{{ url('/geddes/about') }}">About</a></li>
                    <li><a href="{{ url('/geddes/history') }}">History</a></li>
                    <li><a href="{{ url('/geddes/people') }}">People</a></li>
                    <li><a href="{{ url('/geddes/search') }}">Catalogue</a></li>
                    <li><a href="{{ url('/geddes/research') }}">Research Resources</a></li>
                    <li><a href="http://libraryblogs.is.ed.ac.uk/patrickgeddes/" target="_blank" rel="noopener">Blog</a></li>
                    <li><a href="{{ url('/geddes/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/geddes/feedback') }}">Feedback</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="container">
            <div class="header-normal">
                <a href="{{ url('/geddes') }}" id="collection-title" title="Home"></a>
            </div>
            <div id="collection-search">
                <form action="{{ url('/geddes/redirect') }}" method="post" class="navbar-form">
                    @csrf
                    <div class="input-group search-box">
                        <input type="text" class="form-control" placeholder="Search" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <div class="container content">
        <br>
        @yield('content')
    </div>

    <nav class="navbar navbar-default">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/geddes') }}">Home</a></li>
                <li><a href="{{ url('/geddes/about') }}">About</a></li>
                <li><a href="{{ url('/geddes/history') }}">History</a></li>
                <li><a href="{{ url('/geddes/people') }}">People</a></li>
                <li><a href="{{ url('/geddes/search') }}">Catalogue</a></li>
                <li><a href="{{ url('/geddes/research') }}">Research Resources</a></li>
                <li><a href="{{ url('/geddes/contact') }}">Contact</a></li>
                <li><a href="{{ url('/geddes/feedback') }}">Feedback</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <footer>
            <div class="col-md-12 col-sm-12 col-xs-12 footer-logos">
                <div class="center-block" id="footer-logos-area">
                    <a href="https://www.ed.ac.uk/" target="_blank" rel="noopener"><div class="uoe-logo"></div></a>
                    <a href="https://wellcome.ac.uk/" target="_blank" rel="noopener"><div class="wellcome-logo"></div></a>
                    <a href="https://www.strath.ac.uk/" target="_blank" rel="noopener"><div class="strath-logo"></div></a>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 footer-disclaimer">
                <div class="center-block footer-policies">
                    <a href="https://www.ed.ac.uk/about/website/privacy" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                    &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener">Takedown Policy</a>
                    &nbsp;&nbsp;<a href="{{ url('/geddes/licensing') }}">Licensing &amp; Copyright</a>
                    &nbsp;&nbsp;<a href="{{ url('/geddes/accessibility') }}">Accessibility</a>
                    <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk/" target="_blank" rel="noopener">University of Edinburgh</a> or <a href="https://www.strath.ac.uk/" target="_blank" rel="noopener">University of Strathclyde</a>.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
