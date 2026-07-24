<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">

    <title>@yield('title', 'Body Language')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', 'Body Language')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/bodylanguage/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/bodylanguage/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Metrophobic" />
    <link rel="stylesheet" href="{{ asset('collections/bodylanguage/css/style.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('collections/bodylanguage/css/bodylanguage.css') }}">
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

    @stack('styles')
</head>
<body>
    <div class="skip-links" style="position: absolute;">
        <a class="sr-only" href="#main">Skip to content</a>
    </div>

    <div id="container">
        <header>
            <nav id="menu">
                <ul class="menu-links">
                    <li><a href="{{ $collectionUrl('about') }}" title="About Link">About</a></li>
                    <li><a href="{{ $collectionUrl('catalogue') }}" title="Catalogues Link">Catalogue</a></li>
                    <li><a href="{{ $collectionUrl('people') }}" title="People Link">People</a></li>
                    <li><a href="{{ $collectionUrl('contact') }}" title="Contact Us Link">Contact Us</a></li>
                    <li><a href="{{ $collectionUrl('') }}" title="{{ config('skylight.fullname') }} Home">Home</a></li>
                </ul>
            </nav>

            <a href="{{ $collectionUrl('') }}" title="{{ config('skylight.fullname') }} Home">
                <div id="collection-title"></div>
            </a>

            <div class="clearfix"></div>

            <h3 class="site-tag">An online portal to collections of movement, dance and physical education archives in Scotland, 1890-1990</h3>

            <div class="quick-links">
                <ul>
                    <li><a class="quick-link" href="{{ $collectionUrl('about') }}#project-anchor">About the Project</a></li>
                    <li><a class="quick-link" href="{{ $collectionUrl('catalogue') }}">View the Catalogue</a></li>
                    <li><a class="quick-link" href="{{ $collectionUrl('people') }}">Meet the People</a></li>
                </ul>
            </div>
        </header>

        <div id="main" role="main" class="clearfix">
            <div class="col-main">
                @yield('content')

                <footer>
                    <div class="footer-links">
                        <div class="site-links">
                            <div><a class="footer-link" href="{{ $collectionUrl('about') }}">About</a></div>
                            <div><a class="footer-link" href="{{ $collectionUrl('catalogue') }}">Catalogue</a></div>
                            <div><a class="footer-link" href="{{ $collectionUrl('people') }}">People</a></div>
                            <div><a class="footer-link last" href="{{ $collectionUrl('contact') }}">Contact Us</a></div>
                        </div>
                    </div>

                    <div class="footer-disclaimer">
                        <a href="https://www.ed.ac.uk" target="_blank" rel="noopener"><div class="uoe-logo"></div></a>
                        <div class="footer-policies">
                            <a class="footer-link" href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener">Privacy &amp; Cookies</a>
                            &nbsp;&nbsp;<a class="footer-link" href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener" title="Takedown Policy Link">Takedown Policy</a>
                            &nbsp;&nbsp;<a class="footer-link" href="{{ $collectionUrl('licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                            &nbsp;&nbsp;<a class="footer-link" href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener">Accessibility</a>
                            <p class="footer-copyright">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener">University of Edinburgh</a>.</p>
                        </div>
                        <a href="https://www.ed.ac.uk" target="_blank" rel="noopener"><div class="uoe-logo"></div></a>
                    </div>
                </footer>
            </div>

            @hasSection('sidebar')
                @yield('sidebar')
            @else
                @include('bodylanguage.partials.sidebar')
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
