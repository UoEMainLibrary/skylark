<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <base href="{{ url('/towardsdolly/') }}/">

    <title>@yield('title', 'Towards Dolly')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', 'Towards Dolly')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/towardsdolly/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/towardsdolly/images/favicon.ico') }}">

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Metrophobic" />
    <link rel="stylesheet" href="{{ asset('collections/towardsdolly/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.css') }}?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css') }}?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('assets/flowplayer-7.0.4/skin/skin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
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
    <script>
        flowplayer.conf = {
            analytics: "{{ config('skylight.ga_code') }}"
        };
    </script>

    @stack('styles')
</head>
<body>
    <div id="container">
        <header>
            <nav id="menu">
                <ul class="menu-links">
                    <li><a href="{{ url('/towardsdolly/feedback') }}" title="Feedback Form">Feedback</a></li>
                    <li><a href="http://libraryblogs.is.ed.ac.uk/towardsdolly/" title="Towards Dolly Blog Link" target="_blank" rel="noopener">Project Blog</a></li>
                    <li><a href="{{ url('/towardsdolly/audio') }}" title="Oral Histories Link">Oral Histories</a></li>
                    <li><a href="{{ url('/towardsdolly/people') }}" title="People Link">People</a></li>
                    <li><a href="{{ url('/towardsdolly/catalogues') }}" title="Catalogues Link">Catalogues</a></li>
                    <li><a href="{{ url('/towardsdolly/history') }}" title="History Link">History</a></li>
                    <li><a href="{{ url('/towardsdolly/about') }}" title="About Link">About</a></li>
                    <li><a href="{{ url('/towardsdolly') }}" title="Towards Dolly Home Link">Towards Dolly</a></li>
                </ul>
            </nav>

            <a href="{{ url('/towardsdolly') }}" title="Towards Dolly Home">
                <div id="collection-logo"></div>
            </a>
            <a href="{{ url('/towardsdolly') }}" title="Towards Dolly Home">
                <div id="collection-title"></div>
            </a>
            <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">
                <div id="uoe-logo-header"></div>
            </a>

            <div class="clearfix"></div>

            <div id="collection-search">
                <form action="{{ url('/towardsdolly/redirect') }}" method="post">
                    @csrf
                    <fieldset class="search">
                        <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                    </fieldset>
                </form>
            </div>
        </header>

        <div id="main" role="main" class="clearfix">
            <div class="col-main">
                @yield('content')
                <footer>
                    <div class="footer-links">
                        <div class="site-links">
                            <a href="{{ url('/towardsdolly/about') }}">About</a>
                            <a href="{{ url('/towardsdolly/history') }}">History</a>
                            <a href="{{ url('/towardsdolly/catalogues') }}">Catalogues</a>
                            <a href="{{ url('/towardsdolly/people') }}">People</a>
                            <a href="{{ url('/towardsdolly/audio') }}">Oral Histories</a>
                            <a href="http://libraryblogs.is.ed.ac.uk/towardsdolly/" target="_blank" rel="noopener">Project Blog</a>
                            <a href="{{ url('/towardsdolly/feedback') }}" class="last">Feedback</a>
                        </div>
                    </div>

                    <div class="footer-disclaimer">
                        <div class="footer-policies">
                            <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                            &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener" title="Takedown Policy Link">Takedown Policy</a>
                            &nbsp;&nbsp;<a href="{{ url('/towardsdolly/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                            &nbsp;&nbsp;<a href="https://library.ed.ac.uk/accessibility-statements/towards-dolly" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility</a>
                            <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh</a>.</p>
                        </div>
                    </div>
                    <div class="footer-logos">
                        <a href="https://www.ed.ac.uk" target="_blank" rel="noopener"><div class="uoe-logo"></div></a>
                        <a href="https://www.wellcome.ac.uk/" target="_blank" rel="noopener"><div class="wellcome-logo"></div></a>
                    </div>
                </footer>
            </div>

            @hasSection('sidebar')
                @yield('sidebar')
            @else
                @include('towardsdolly.partials.sidebar')
            @endif
        </div>
    </div>

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>

    @stack('scripts')
</body>
</html>
