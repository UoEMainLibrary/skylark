<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <base href="{{ \App\Support\CollectionUrl::baseHref() }}">
    <title>@yield('title', 'Open Books')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="title" content="@yield('title', 'Open Books')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/openbooks/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/openbooks/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('collections/openbooks/css/style.css') }}?v=4">
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
</head>

<body>
<script>
    function warnNewTab() {
        return confirm("This link will open in a new tab. Proceed?");
    }
</script>
<div class="skip-links">
    <a class="screen-reader-text" href="{{ url()->current() }}#main">Skip to content</a>
</div>
<div id="container">
    <header>
        <div id="collection-title">
            <a href="{{ $collectionUrl() }}" class="oblogo" title="University of Edinburgh Open Books Collection Home">
                <span>Open Books</span>
            </a>
            <a href="https://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Home" target="_blank" rel="noopener noreferrer"><span class="visually-hidden"> (opens in a new tab)</span></a>
        </div>
        <div id="collection-search">
            <form action="{{ $collectionUrl('redirect') }}" method="post">
                @csrf
                <fieldset class="search">
                    <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                    <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                    <div style="text-align:center;"><a href="{{ $collectionUrl('advanced') }}" class="advanced">Advanced<br>search</a></div>
                </fieldset>
            </form>
        </div>
    </header>

    <div id="main" role="main" class="clearfix">
        <div class="col-main">
            @yield('content')
            @include('openbooks.partials.footer')
        </div>
        <div class="col-sidebar">
            @hasSection('sidebar')
                @yield('sidebar')
            @else
                @include('openbooks.partials.sidebar-facets', [
                    'facets' => $sidebar_facets ?? [],
                    'base_search' => $sidebar_base_search ?? $collectionUrl('search/*:*'),
                    'delimiter' => $sidebar_delimiter ?? config('skylight.filter_delimiter'),
                    'base_parameters' => $sidebar_base_parameters ?? '',
                ])
            @endif
        </div>
    </div>
</div>

    <script src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
    <script src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
    <script src="{{ asset('assets/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>
    <script src="{{ asset('collections/openbooks/js/script.js') }}"></script>
    <script>$(document).ready(function() { $(".fancybox").fancybox(); });</script>

    @stack('scripts')
</body>
</html>
