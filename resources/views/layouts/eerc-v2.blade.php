<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RESP Archive Project')</title>

    <meta name="description" content="The RESP Archive Project preserves and shares oral history recordings from communities across Scotland, collected by local volunteers under the guidance of the Regional Ethnology of Scotland Project.">
    <meta name="author" content="RESP Archive Project, University of Edinburgh">

    <link rel="shortcut icon" href="{{ asset('collections/eerc/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('collections/eerc/images/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

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

<body class="min-h-screen bg-gray-50 text-gray-800 antialiased">
    {{-- Skip to content link for accessibility --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-md focus:bg-resp-teal-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to main content
    </a>

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 bg-resp-slate-600 text-white shadow-md" aria-label="Main navigation">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                {{-- Mobile menu button --}}
                <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:bg-resp-slate-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white lg:hidden"
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden'); this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true')">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>

                {{-- Desktop navigation --}}
                <div class="hidden lg:flex lg:items-center lg:gap-0.5 lg:py-0 lg:text-sm">
                    @foreach($navItems ?? [] as $item)
                        <a href="{{ $item['url'] }}"
                           class="rounded-md px-3 py-3 font-medium transition-colors hover:bg-resp-slate-400 hover:text-white {{ request()->url() === $item['url'] ? 'bg-resp-slate-500' : '' }}"
                           @if(isset($item['title'])) title="{{ $item['title'] }}" @endif>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Mobile menu --}}
            <div class="hidden lg:hidden" id="mobile-menu">
                <div class="space-y-1 pb-3 pt-2">
                    @foreach($navItems ?? [] as $item)
                        <a href="{{ $item['url'] }}"
                           class="block rounded-md px-3 py-2 text-base font-medium text-gray-200 hover:bg-resp-slate-500 hover:text-white {{ request()->url() === $item['url'] ? 'bg-resp-slate-500 text-white' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    {{-- Header --}}
    <header class="bg-resp-teal-600 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 py-6 sm:flex-row sm:items-center sm:justify-between">
                {{-- Logo and Title --}}
                <a href="{{ url('/eerc') }}" class="flex shrink-0 items-center gap-3" title="RESP Archive Project homepage">
                    <img src="{{ asset('collections/eerc/images/v2/eerc_horse_logo_transp.png') }}"
                         alt=""
                         class="h-16 w-auto sm:h-20">
                    <span class="text-xl font-semibold leading-tight tracking-tight text-white sm:text-2xl">Regional Ethnology<br>of Scotland Archive Project</span>
                </a>

                {{-- Search --}}
                <div class="w-full sm:max-w-sm">
                    <form action="{{ url('/eerc/redirect') }}" method="post" role="search">
                        @csrf
                        <label for="site-search" class="sr-only">Search the archive</label>
                        <div class="flex">
                            <input type="text"
                                   id="site-search"
                                   name="q"
                                   value="{{ $searchbox_query ?? '' }}"
                                   placeholder="Search the archive..."
                                   class="w-full rounded-l-md border-0 bg-white/10 px-4 py-2.5 text-white placeholder-white/60 backdrop-blur-sm focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50">
                            <button type="submit"
                                    class="rounded-r-md bg-white/20 px-4 transition-colors hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50"
                                    aria-label="Search">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main id="main-content" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {{-- Partner logos --}}
            <div class="flex flex-wrap items-center justify-center gap-8 border-b border-gray-200 pb-8">
                <a href="https://www.ed.ac.uk" target="_blank" rel="noopener" title="The University of Edinburgh" class="opacity-70 transition-opacity hover:opacity-100">
                    <div class="uoe-logo h-12 w-36 bg-contain bg-center bg-no-repeat" style="background-image: url('{{ asset('collections/eerc/images/bg-icons.png') }}'); background-position: 0 -80px;"></div>
                    <span class="sr-only">University of Edinburgh (opens in a new tab)</span>
                </a>
                <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/cultural-heritage-collections/crc" target="_blank" rel="noopener" title="Centre for Research Collections" class="opacity-70 transition-opacity hover:opacity-100">
                    <img src="{{ asset('collections/eerc/images/CRC_logo.gif') }}" alt="Centre for Research Collections" class="h-12 w-auto">
                    <span class="sr-only">(opens in a new tab)</span>
                </a>
                <a href="https://www.ed.ac.uk/literatures-languages-cultures/celtic-scottish-studies/research/eerc" target="_blank" rel="noopener" title="EERC" class="opacity-70 transition-opacity hover:opacity-100">
                    <img src="{{ asset('collections/eerc/images/eerc_horse_logo_transp.png') }}" alt="EERC" class="h-12 w-auto">
                    <span class="sr-only">(opens in a new tab)</span>
                </a>
                <a href="https://libraryblogs.is.ed.ac.uk/resp/" target="_blank" rel="noopener" title="RESP Blog" class="opacity-70 transition-opacity hover:opacity-100">
                    <img src="{{ asset('collections/eerc/images/blogs_icon.png') }}" alt="RESP Blog" class="h-10 w-auto">
                    <span class="sr-only">(opens in a new tab)</span>
                </a>
                <a href="https://www.instagram.com/RESParchiveproject/" target="_blank" rel="noopener" title="RESP Instagram" class="opacity-70 transition-opacity hover:opacity-100">
                    <img src="{{ asset('collections/eerc/images/instagram.png') }}" alt="RESP Instagram" class="h-10 w-auto">
                    <span class="sr-only">(opens in a new tab)</span>
                </a>
            </div>

            {{-- Footer links --}}
            <div class="pt-6 text-center text-sm text-gray-500">
                <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                    <a href="https://www.ed.ac.uk/about/website/privacy" target="_blank" rel="noopener" class="hover:text-resp-teal-600">Privacy &amp; Cookies</a>
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener" class="hover:text-resp-teal-600">Takedown Policy</a>
                    <a href="{{ url('/eerc/using') }}" class="hover:text-resp-teal-600">Licensing &amp; Copyright</a>
                    <a href="{{ url('/eerc/accessibility') }}" class="hover:text-resp-teal-600">Accessibility</a>
                </div>
                <p class="mt-4">
                    Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }}
                    <a href="https://www.ed.ac.uk" target="_blank" rel="noopener" class="hover:text-resp-teal-600">University of Edinburgh</a>.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
