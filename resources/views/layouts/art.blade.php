<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'University of Edinburgh Art Collection')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('collections/art/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/art/images/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4" type="text/css" media="screen" />
    <link rel="stylesheet" href="https://releases.flowplayer.org/6.0.4/skin/minimalist.css">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="{{ asset('assets/modernizr/modernizr-1.7.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
    <script src="https://cdn.rawgit.com/mejackreed/Leaflet-IIIF/master/leaflet-iiif.js"></script>
    <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>

    @if(config('skylight.ga_code'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('skylight.ga_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ config('skylight.ga_code') }}');
    </script>
    @endif

    <script src="https://releases.flowplayer.org/6.0.4/flowplayer.min.js"></script>
    <script>
        flowplayer.conf = {
            analytics: "{{ config('skylight.ga_code') }}"
        };
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3321181a33.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('collections/art/css/style.css') }}?v=2">
</head>

<body>
    <script>
        function warnNewTab() {
            return confirm("This link will open in a new tab. Proceed?");
        }
    </script>
    <div class="skip-links" style="position: absolute;">
        <a class="screen-reader-text" href="{{ url()->current() }}#main">Skip to content</a>
    </div>
    <div id="container">
        {{-- Utility bar mirroring the Art on Campus header (P012 / 2026 edits). --}}
        <div class="container-fluid d-flex justify-content-between py-2 small border-bottom" style="background:#fff;">
            <a href="https://www.ed.ac.uk" target="_blank" rel="noopener" class="text-secondary">
                The University of Edinburgh
                <span class="sr-only">(opens in a new tab)</span>
            </a>
            <a href="https://collections.ed.ac.uk" target="_blank" rel="noopener" class="text-secondary">
                All Collections
                <span class="sr-only">(opens in a new tab)</span>
            </a>
        </div>
        <header>
            <div class="container-fluid header">
                <div class="header-logo">
                    <a href="{{ url('/art') }}">
                        <img class="header-img"
                            onmouseout="this.src='{{ asset('collections/art/images/UoE_Stacked-Logo_Blue-dark.png') }}'"
                            onmouseover="this.src='{{ asset('collections/art/images/UoE_Stacked-Logo_Blue-light.png') }}'"
                            src="{{ asset('collections/art/images/UoE_Stacked-Logo_Blue-dark.png') }}">
                    </a>
                </div>
                <nav class="navbar navbar-expand-lg navbar-light custom-nav">
                    <div class="d-flex flex-grow-1">
                        <span class="w-100 d-lg-none d-block"></span>
                        <a class="navbar-brand-two mx-auto d-lg-none d-inline-block" href="#">
                        <div class="w-100 text-right">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
                        <ul class="navbar-nav ml-auto flex-nowrap">
                            <li class="nav-item">
                                <a href="{{ url('/art') }}" class="nav-link text-nowrap m-2 menu-item">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/art/focus') }}" class="nav-link text-nowrap m-2 menu-item">In Focus</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/art/comissioning') }}" class="nav-link text-nowrap m-2 menu-item">Commissioning</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/art/loans') }}" class="nav-link text-nowrap m-2 menu-item">Loans</a>
                            </li>
                            <li class="nav-item">
                                <a href="#contact" class="nav-link text-nowrap m-2 menu-item b-right">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>

            </div>
            <section class="search">
                <form action="{{ url('/art/redirect') }}" method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="input-group">
                            <input type="text" class="form-control"
                                placeholder="Search 8,000 artworks spanning two millenia"
                                aria-describedby="basic-addon2" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q">
                            <div class="input-group-append">
                                <input type="submit" class="btn btn-outline-secondary" name="submit_search"
                                    value="Search" id="submit_search" />
                                <input type="button" class="btn btn-outline-secondary" name="submit_search"
                                    value="Advanced Search" onclick="location.href='{{ url('/art/advanced') }}';" />
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </header>

        <div id="main" role="main" class="clearfix">

            @yield('content')

</div><footer class="page-footer font-small stylish-color-dark pt-4">

    <div class="container text-center text-md-left">

        <hr>

        <ul id="contact" class="list-unstyled list-inline text-center py-2">
            <li class="list-inline-item">
                <h5 class="mb-1">For more information on borrowing, gifting or of viewing artwork</h5>
            </li>
            <li class="list-inline-item">
                <a href="mailto:HeritageCollections@ed.ac.uk" class="btn btn-danger btn-rounded">Contact us!</a>
            </li>
        </ul>

        <hr>

        <div class="row">

            <div class="col-md-4 mx-auto">
                <h5 class="font-weight-bold mt-3 mb-4">Art Collections Curator</h5>
                <p>University of Edinburgh<br/>
                    Main Library<br/>
                    30 George Square<br/>
                    Edinburgh<br/>
                    EH8 9LJ<br/>
                </p>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-md-2 mx-auto">
                <h5 class="font-weight-bold mt-3 mb-4">Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/art') }}">UoE Art Collection</a></li>
                    <li><a href="{{ url('/art/about') }}">About</a></li>
                    <li><a href="{{ url('/art/iiif') }}">IIIF</a></li>
                    <li><a href="{{ url('/art/feedback') }}">Feedback</a></li>
                </ul>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-md-2 mx-auto">
                <h5 class="font-weight-bold mt-3 mb-4">Links</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.ed.ac.uk/about/website/privacy">Privacy & Cookies</a></li>
                    <li><a href="{{ url('/art/takedown') }}">Takedown Policy</a></li>
                    <li><a href="{{ url('/art/licensing') }}">Licensing & Copyright</a></li>
                    <li><a href="{{ url('/art/accessibility') }}">Accessibility</a></li>
                </ul>
            </div>

            <hr class="clearfix w-100 d-md-none">

        </div>

    </div>

    <ul class="list-unstyled list-inline text-center">
        <li class="list-inline-item">
            <a href="https://www.facebook.com/UniversityOfEdinburghFineArtCollection" class="btn-floating btn-fb mx-1" title="UoE Fine Art Collection Facebook Page">
                <i class="fab fa-facebook-f"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a href="https://twitter.com/UoEArtColl" class="btn-floating btn-tw mx-1" title="UoE Fine Art Collection Twitter Page">
                <i class="fab fa-twitter"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a href="https://uoeartandarchives.tumblr.com/" class="btn-floating btn-gplus mx-1" title="UoE Fine Art Collection Tumblr Page">
                <i class="fab fa-tumblr"></i>
            </a>
        </li>
        <li class="list-inline-item">
            <a href="https://podcasts.apple.com/gb/podcast/the-collection-podcast/id1086099131" class="btn-floating btn-dribbble mx-1" title="UoE The Collection Podcast">
                <i class="fab fa-itunes-note"></i>
            </a>
        </li>
    </ul>

    <div class="footer-copyright text-center py-3">This collection is part of <a href="https://collections.ed.ac.uk/">University Collections.</a><br/>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }}
        <a href="https://www.ed.ac.uk/">University of Edinburgh.</a>
    </div>

</footer>
<script type="text/javascript" src="{{ asset('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
<script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-buttons.js') }}?v=1.0.5"></script>
<script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-media.js') }}?v=1.0.5"></script>
<script type="text/javascript" src="{{ asset('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js') }}?v=1.0.7"></script>
<script src="{{ asset('collections/art/js/script.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>
    </div>
</body>
</html>
