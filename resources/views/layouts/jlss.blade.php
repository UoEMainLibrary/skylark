<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">
    <title>@yield('title', 'Jewish Lives Scottish Spaces')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/jlss/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7">
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('collections/jlss/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('collections/jlss/css/picgallery.css') }}">

    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>
</head>
<body>
    <div class="skip-links" style="position: absolute;">
        <a class="screen-reader-text" href="{{ url()->current() }}#main">Skip to content</a>
    </div>

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#jlssNav">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="jlssNav">
                <ul class="nav navbar-nav">
                    <li><a href="{{ \App\Support\CollectionUrl::url() }}" class="nav-link">Home</a></li>
                    <li><a href="{{ \App\Support\CollectionUrl::url('about') }}" class="nav-link">About</a></li>
                    <li><a href="https://www.sjac.org.uk/" target="_blank" rel="noopener" class="nav-link">SJAC</a></li>
                    <li><a href="http://jewishmigrationtoscotland.is.ed.ac.uk/" target="_blank" rel="noopener" class="nav-link">JLSS Blog</a></li>
                    <li><a href="https://www.sjac.org.uk/about/donations/" target="_blank" rel="noopener" class="nav-link">Donate</a></li>
                    <li><a href="{{ \App\Support\CollectionUrl::url('feedback') }}" class="nav-link">Feedback</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="container">
            <div class="header-normal">
                <div id="collection-logo">
                    <a href="{{ \App\Support\CollectionUrl::url() }}" title="Home">
                        <img src="{{ asset('collections/jlss/images/sjac_logo.png') }}" alt="Scottish Jewish Archives Logo" class="img-responsive pull-right img-circle">
                    </a>
                </div>
                <a href="{{ \App\Support\CollectionUrl::url() }}" title="Home">
                    <div id="collection-title">Scottish Jewish Archives Centre <br>
                        <div id="collection-sub-title">Digital Collection</div>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <div id="main" class="container content">
        @yield('content')
    </div>

    <div class="content-divider-footer"><p>divider</p></div>
    <footer>
        <div class="col-sm-12 col-xs-12 footer-disclaimer">
            <div class="footer-policies">
                <a class="footer-policies" href="https://www.ed.ac.uk/about/website/privacy" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                &nbsp;&nbsp;<a class="footer-policies" href="{{ \App\Support\CollectionUrl::url('takedown') }}">Takedown Policy</a>
                &nbsp;&nbsp;<a class="footer-policies" href="{{ \App\Support\CollectionUrl::url('licensing') }}">Licensing &amp; Copyright</a>
                &nbsp;&nbsp;<a class="footer-policies" href="{{ \App\Support\CollectionUrl::url('accessibility') }}">Accessibility</a>
                <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a class="footer-policies" href="https://www.sjac.org.uk" target="_blank" rel="noopener">Scottish Jewish Archives Centre</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
