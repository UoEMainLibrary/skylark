<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Evergreen - Geddes Project')</title>

    <link rel="shortcut icon" href="{{ asset('collections/geddes/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/geddes/images/d13c43a7566f69e0106ba22b0be2dff4.ico/apple-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

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

<body class="min-h-screen bg-geddes-forest font-sans text-gray-600 antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-md focus:bg-geddes-accent focus:px-4 focus:py-2 focus:text-white">
        Skip to main content
    </a>

    @php
        $navItems = [
            ['label' => 'Home', 'url' => url('/geddes')],
            ['label' => 'About', 'url' => url('/geddes/about')],
            ['label' => 'History', 'url' => url('/geddes/history')],
            ['label' => 'People', 'url' => url('/geddes/people')],
            ['label' => 'Catalogue', 'url' => url('/geddes/search')],
            ['label' => 'Research Resources', 'url' => url('/geddes/research')],
            ['label' => 'Blog', 'url' => 'http://libraryblogs.is.ed.ac.uk/patrickgeddes/', 'external' => true],
            ['label' => 'Contact', 'url' => url('/geddes/contact')],
            ['label' => 'Feedback', 'url' => url('/geddes/feedback')],
        ];
        $footerNavItems = array_filter($navItems, fn (array $item): bool => ($item['label'] ?? '') !== 'Blog');
    @endphp

    <nav class="bg-transparent text-white" aria-label="Main navigation">
        <div class="mx-auto max-w-7xl bg-white px-4 sm:px-6">
            <div class="flex items-center justify-between py-2">
                <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-geddes-heading hover:bg-geddes-accent hover:text-white focus:outline-none focus:ring-2 focus:ring-geddes-accent lg:hidden"
                        aria-controls="geddes-mobile-menu"
                        aria-expanded="false"
                        onclick="document.getElementById('geddes-mobile-menu').classList.toggle('hidden'); this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true')">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>

                <div class="hidden flex-wrap lg:flex">
                    @foreach($navItems as $item)
                        <a href="{{ $item['url'] }}"
                           @if(!empty($item['external'])) target="_blank" rel="noopener" @endif
                           class="px-3 py-2 text-sm font-medium text-geddes-heading transition-colors hover:bg-geddes-accent hover:text-white {{ request()->url() === $item['url'] ? 'bg-geddes-accent text-white' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden pb-3 lg:hidden" id="geddes-mobile-menu">
                <div class="space-y-1">
                    @foreach($navItems as $item)
                        <a href="{{ $item['url'] }}"
                           @if(!empty($item['external'])) target="_blank" rel="noopener" @endif
                           class="block rounded-md px-3 py-2 text-base font-medium text-geddes-heading hover:bg-geddes-accent hover:text-white {{ request()->url() === $item['url'] ? 'bg-geddes-accent text-white' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-geddes-forest">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <a href="{{ url('/geddes') }}" class="block py-2" title="Home">
                <picture>
                    <source media="(min-width: 1200px)" srcset="{{ asset('collections/geddes/images/n-header-doves.png') }}">
                    <source media="(min-width: 992px)" srcset="{{ asset('collections/geddes/images/n-header-lg-doves.png') }}">
                    <source media="(min-width: 768px)" srcset="{{ asset('collections/geddes/images/n-header-md-doves.png') }}">
                    <source media="(min-width: 480px)" srcset="{{ asset('collections/geddes/images/n-header-sm-doves.png') }}">
                    <img src="{{ asset('collections/geddes/images/n-header-xs.png') }}"
                         alt="Evergreen: Patrick Geddes and the Environment in Equilibrium"
                         class="h-auto w-full max-w-full">
                </picture>
            </a>
        </div>

        <div class="bg-geddes-forest px-4 py-3 sm:px-6">
            <form action="{{ url('/geddes/redirect') }}" method="post" class="mx-auto flex max-w-3xl" role="search">
                @csrf
                <label for="geddes-search" class="sr-only">Search</label>
                <input type="text"
                       id="geddes-search"
                       name="q"
                       value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}"
                       placeholder="Search"
                       class="w-full rounded-l-md border-0 bg-white px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-geddes-accent">
                <button type="submit"
                        class="rounded-r-md bg-geddes-accent px-4 text-white transition-colors hover:bg-white hover:text-geddes-forest focus:outline-none focus:ring-2 focus:ring-white"
                        aria-label="Search">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </button>
            </form>
        </div>
    </header>

    <main id="main-content" class="mx-auto max-w-7xl bg-white px-4 py-6 sm:px-6">
        @yield('content')
    </main>

    <nav class="border-t border-geddes-accent/30 bg-white" aria-label="Footer navigation">
        <div class="mx-auto flex max-w-7xl flex-wrap px-4 py-2 sm:px-6">
            @foreach($footerNavItems as $item)
                <a href="{{ $item['url'] }}"
                   class="px-3 py-2 text-sm font-medium text-geddes-heading transition-colors hover:bg-geddes-accent hover:text-white">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>

    <footer class="bg-white pb-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex flex-wrap items-center justify-center gap-6 py-6">
                <a href="https://www.ed.ac.uk/" target="_blank" rel="noopener" class="block w-1/4 min-w-[140px] max-w-[220px]">
                    <img src="{{ asset('collections/geddes/images/geddes-edinburgh.jpg') }}" alt="University of Edinburgh" class="mx-auto h-auto max-h-28 w-full object-contain">
                </a>
                <a href="https://wellcome.ac.uk/" target="_blank" rel="noopener" class="block w-1/4 min-w-[140px] max-w-[220px]">
                    <img src="{{ asset('collections/geddes/images/geddes-wellcome.jpg') }}" alt="Wellcome Trust" class="mx-auto h-auto max-h-28 w-full object-contain">
                </a>
                <a href="https://www.strath.ac.uk/" target="_blank" rel="noopener" class="block w-1/4 min-w-[140px] max-w-[220px]">
                    <img src="{{ asset('collections/geddes/images/geddes-strathclyde.jpg') }}" alt="University of Strathclyde" class="mx-auto h-auto max-h-28 w-full object-contain">
                </a>
            </div>

            <div class="text-center text-sm text-gray-600">
                <p class="mb-2">
                    <a href="https://www.ed.ac.uk/about/website/privacy" target="_blank" rel="noopener" class="text-geddes-accent hover:underline">Privacy &amp; Cookies</a>
                    &nbsp;&nbsp;
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener" class="text-geddes-accent hover:underline">Takedown Policy</a>
                    &nbsp;&nbsp;
                    <a href="{{ url('/geddes/licensing') }}" class="text-geddes-accent hover:underline">Licensing &amp; Copyright</a>
                    &nbsp;&nbsp;
                    <a href="{{ url('/geddes/accessibility') }}" class="text-geddes-accent hover:underline">Accessibility</a>
                </p>
                <p class="text-xs text-gray-500">
                    Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }}
                    <a href="https://www.ed.ac.uk/" target="_blank" rel="noopener" class="text-geddes-accent hover:underline">University of Edinburgh</a>
                    or
                    <a href="https://www.strath.ac.uk/" target="_blank" rel="noopener" class="text-geddes-accent hover:underline">University of Strathclyde</a>.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
