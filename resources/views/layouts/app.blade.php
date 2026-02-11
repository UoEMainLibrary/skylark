<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="HandheldFriendly" content="true">

    <meta name="description" content="The University of Edinburgh Collections">
    <meta name="author" content="The University of Edinburgh">
    <meta name="keywords" content="art, museums, rare books, exhibitions, collections, mimed, musical instruments, archives, st cecilia, iiif" />

    <base href="{{ url('/') }}/">

    <title>@yield('title', 'University of Edinburgh Collections')</title>

    <link rel="pingback" href="{{ url('/pingback') }}" />

    <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/socialicon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/secondmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/picgallery.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2">

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @if(config('services.google_analytics.tracking_id'))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.tracking_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.google_analytics.tracking_id') }}');
    </script>
    <!-- End Google Analytics -->
    @endif

    @stack('styles')
</head>
<body>

<script>
    function warnNewTab() {
      return confirm("This link will open in a new tab. Proceed?");
    }
</script>

@include('partials.nav')

@include('partials.collection-search')

@yield('content')

@include('partials.footer-content')

@stack('scripts')
</body>
</html>
