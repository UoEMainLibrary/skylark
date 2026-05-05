<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Art on Campus | University of Edinburgh')</title>

    <meta name="description" content="@yield('description', 'Art on Campus presents artworks from the University of Edinburgh\'s Art Collection that are visible across the University\'s campuses.')">
    <meta name="author" content="University of Edinburgh Art Collection">

    <link rel="shortcut icon" href="{{ asset('collections/public-art/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/public-art/images/apple-touch-icon.png') }}">

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

<body class="min-h-screen bg-white font-sans text-pa-ink-800 antialiased">
    {{-- Skip to content --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:rounded focus:bg-pa-ink-800 focus:px-4 focus:py-2 focus:text-white focus:outline-none">
        Skip to main content
    </a>

    {{-- Top utility bar --}}
    <div class="border-b border-pa-ink-100 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-2 text-xs text-pa-ink-600 sm:px-6 lg:px-8">
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.ed.ac.uk',
                'label' => 'The University of Edinburgh',
                'class' => 'hover:text-pa-ink-900',
            ])
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://collections.ed.ac.uk',
                'label' => 'All Collections',
                'class' => 'hover:text-pa-ink-900',
            ])
        </div>
    </div>

    {{-- Header --}}
    <header class="border-b border-pa-ink-100 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-8 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <a href="{{ url('/public-art') }}" class="group inline-block" aria-label="Art on Campus home">
                <span class="block text-4xl font-semibold tracking-tight text-pa-ink-900 transition-colors group-hover:text-pa-accent sm:text-5xl">
                    Art on Campus
                </span>
                <span class="mt-1 block text-xs uppercase tracking-[0.25em] text-pa-ink-600">University of Edinburgh Art Collection</span>
            </a>

            {{-- Primary nav --}}
            <nav aria-label="Primary navigation" class="flex flex-wrap items-center gap-1 text-sm">
                @php
                    $navItems = [
                        ['url' => url('/public-art'), 'label' => 'Home'],
                        ['url' => url('/public-art/search/*:*'), 'label' => 'Browse artworks'],
                        ['url' => url('/public-art/search/*:*/?map=true'), 'label' => 'Map'],
                        ['url' => url('/public-art/paolozzi'), 'label' => 'Paolozzi Project'],
                        ['url' => url('/public-art/about'), 'label' => 'About'],
                    ];
                @endphp
                @foreach($navItems as $item)
                    @php $active = rtrim(request()->url(), '/') === rtrim($item['url'], '/'); @endphp
                    <a href="{{ $item['url'] }}"
                       @if($active) aria-current="page" @endif
                       class="rounded px-3 py-2 font-medium uppercase tracking-wider transition-colors hover:text-pa-accent {{ $active ? 'text-pa-accent' : 'text-pa-ink-600' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Search --}}
        <div class="border-t border-pa-ink-100 bg-pa-ink-50">
            <div class="mx-auto max-w-6xl px-4 py-3 sm:px-6 lg:px-8">
                <form action="{{ url('/public-art/redirect') }}" method="post" role="search" class="flex items-center gap-2">
                    @csrf
                    <label for="site-search" class="sr-only">Search the Art on Campus collection</label>
                    <input type="text"
                           id="site-search"
                           name="q"
                           value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}"
                           placeholder="Search artworks, artists, locations…"
                           class="w-full rounded border border-pa-ink-400 bg-white px-4 py-2 text-base text-pa-ink-800 placeholder-pa-ink-500 focus:border-pa-ink-700 focus:outline-none focus:ring-2 focus:ring-pa-ink-700">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded bg-pa-ink-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-pa-ink-700 focus:outline-none focus:ring-2 focus:ring-pa-ink-400 focus:ring-offset-2">
                        <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        <span>Search</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main --}}
    <main id="main-content" class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 border-t border-pa-ink-100 bg-pa-ink-50">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-pa-ink-700">About</h2>
                    <p class="mt-3 text-sm leading-relaxed text-pa-ink-700">
                        Art on Campus is part of the University of Edinburgh Art Collection.
                        It documents artworks visible across the University&rsquo;s campuses.
                    </p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-pa-ink-700">Explore</h2>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ url('/public-art/search/*:*') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Browse artworks</a></li>
                        <li><a href="{{ url('/public-art/search/*:*/?map=true') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">View map</a></li>
                        <li><a href="{{ url('/public-art/paolozzi') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Paolozzi Mosaic Project</a></li>
                        <li><a href="{{ url('/public-art/artcollection') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">University Art Collection</a></li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-pa-ink-700">Information</h2>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ url('/public-art/about') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">About this site</a></li>
                        <li><a href="{{ url('/public-art/feedback') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Contact</a></li>
                        <li><a href="{{ url('/public-art/licensing') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Licensing &amp; copyright</a></li>
                        <li><a href="{{ url('/public-art/takedown') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Takedown policy</a></li>
                        <li><a href="{{ url('/public-art/accessibility') }}" class="text-pa-ink-700 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">Accessibility</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-4 border-t border-pa-ink-100 pt-6 text-xs text-pa-ink-700 md:flex-row md:items-center md:justify-between">
                <p>
                    Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }}
                    @include('public-art-v2.partials.external-link', [
                        'href' => 'https://www.ed.ac.uk',
                        'label' => 'The University of Edinburgh',
                    ]).
                </p>
                <ul class="flex flex-wrap gap-x-4 gap-y-2">
                    <li>
                        @include('public-art-v2.partials.external-link', [
                            'href' => 'https://www.ed.ac.uk/about/website/website-terms-conditions',
                            'label' => 'Terms & conditions',
                        ])
                    </li>
                    <li>
                        @include('public-art-v2.partials.external-link', [
                            'href' => 'https://www.ed.ac.uk/about/website/privacy',
                            'label' => 'Privacy & cookies',
                        ])
                    </li>
                    <li>
                        @include('public-art-v2.partials.external-link', [
                            'href' => 'https://www.ed.ac.uk/about/website/freedom-information',
                            'label' => 'FOI Publication Scheme',
                        ])
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
