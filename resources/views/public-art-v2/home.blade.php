@extends('layouts.public-art-v2')

@section('title', 'Art on Campus | University of Edinburgh')

@section('description', 'Artworks from the University of Edinburgh\'s Art Collection, visible across campus, including externally sited sculptures and commissioned installations.')

@section('content')
{{-- Hero / intro --}}
<section class="border-b border-pa-ink-100 pb-12">
    <div class="grid gap-10 lg:grid-cols-12 lg:gap-12">
        <div class="lg:col-span-8">
            <h1 class="sr-only">Art on Campus</h1>
            <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-accent">Welcome</p>
            <p class="mt-3 text-2xl font-light leading-snug text-pa-ink-900 sm:text-3xl">
                Artworks from the University of Edinburgh&rsquo;s Art Collection,
                visible across campus.
            </p>
            <div class="mt-6 max-w-3xl space-y-4 text-lg leading-relaxed text-pa-ink-700">
                <p>
                    Ranging from historic memorials to contemporary creative interventions, Art on Campus includes externally
                    sited sculptures and commissioned installations which reflect on, and respond to, the history and physical
                    environment of the University.
                </p>
                <p>
                    The University Art Collection manages both permanent and temporary commissions connected to campus and
                    research at the University, as well as overseeing the movement and presentation of works from the
                    Collection across University buildings. More information is available on the
                    @include('public-art-v2.partials.external-link', [
                        'href' => 'https://collections.ed.ac.uk/art',
                        'label' => 'Commission and Loans pages',
                        'class' => 'text-pa-accent',
                    ]).
                </p>
            </div>
        </div>

        {{-- Search/explore actions (replaces the old icon row & blue band) --}}
        <aside class="lg:col-span-4" aria-label="Explore Art on Campus">
            <div class="rounded border border-pa-ink-100 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-pa-ink-700">Explore</h2>
                <ul class="mt-4 divide-y divide-pa-ink-100 text-base">
                    <li>
                        <a href="{{ url('/public-art/search/*:*') }}" class="group flex items-center justify-between py-3 text-pa-ink-800 hover:text-pa-accent">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-pa-ink-600 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                                <span>Browse all artworks</span>
                            </span>
                            <svg class="h-4 w-4 text-pa-ink-500 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/public-art/search/*:*/?map=true') }}" class="group flex items-center justify-between py-3 text-pa-ink-800 hover:text-pa-accent">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-pa-ink-600 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m-.75-9.75-3.75-2.25-4.5 2.25-4.5-1.5v15.75l4.5 1.5 4.5-2.25 4.5 2.25 4.5-1.5V5.25l-4.5 1.5Z" /></svg>
                                <span>View by map</span>
                            </span>
                            <svg class="h-4 w-4 text-pa-ink-500 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/public-art/paolozzi') }}" class="group flex items-center justify-between py-3 text-pa-ink-800 hover:text-pa-accent">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-pa-ink-600 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A.75.75 0 0 1 4.5 6h15a.75.75 0 0 1 0 1.5h-15a.75.75 0 0 1-.75-.75ZM3.75 12a.75.75 0 0 1 .75-.75h15a.75.75 0 0 1 0 1.5h-15a.75.75 0 0 1-.75-.75ZM3.75 17.25a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75Z" /></svg>
                                <span>Paolozzi Mosaic Project</span>
                            </span>
                            <svg class="h-4 w-4 text-pa-ink-500 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</section>

{{-- Spotlight: Ideas at the King's Buildings --}}
<section class="border-b border-pa-ink-100 py-14" aria-labelledby="spotlight-heading">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-pa-accent">Spotlight</p>
    <h2 id="spotlight-heading" class="mt-2 text-3xl font-semibold tracking-tight text-pa-ink-900">
        Ideas at the King&rsquo;s Buildings campus
    </h2>

    <div class="mt-8 grid gap-10 lg:grid-cols-2 lg:items-start">
        <div class="aspect-video w-full overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
            <iframe src="https://media.ed.ac.uk/embed/secure/iframe/entryId/1_lh3jbplo/showInfo/false/showTitle/false/embedPlaceholder/true"
                    title="Video about Ideas by Katie Paterson at the King's Buildings (Media Hopper)"
                    allow="autoplay *; fullscreen *; encrypted-media *"
                    loading="lazy"
                    frameborder="0"
                    class="h-full w-full"></iframe>
        </div>
        <p class="mt-2 text-sm text-pa-ink-700">
            Captions are available within the video player. A
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://media.ed.ac.uk/media/1_lh3jbplo',
                'label' => 'transcript and full-page version of this video',
                'class' => 'text-pa-accent',
            ])
            are available on Media Hopper.
        </p>

        <div class="prose prose-lg max-w-none text-pa-ink-700">
            <p>
                In 2019 the artist <strong>Katie Paterson</strong> was chosen to produce a new artwork for the King&rsquo;s
                Buildings campus to mark its centenary. <em>Ideas</em> takes the form of one hundred three-line sentences cut in
                metal &mdash; each one an &ldquo;Idea&rdquo; &mdash; situated in a variety of locations in and around KB.
            </p>
            <p>
                Find out more and explore the artwork using the accompanying digital website and map at
                @include('public-art-v2.partials.external-link', [
                    'href' => 'https://ideas.is.ed.ac.uk/',
                    'label' => 'ideas.is.ed.ac.uk',
                    'class' => 'text-pa-accent',
                ]).
            </p>
            <p class="not-prose mt-4">
                <a href="{{ url('/public-art/search/*:*') }}?q=Ideas"
                   class="inline-flex items-center gap-2 rounded border border-pa-ink-400 px-4 py-2 text-sm font-medium text-pa-ink-800 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2">
                    Find Ideas in the collection
                    <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
            </p>
        </div>
    </div>
</section>

{{-- More information --}}
<section class="py-14" aria-labelledby="more-info-heading">
    <h2 id="more-info-heading" class="text-2xl font-semibold tracking-tight text-pa-ink-900">More information</h2>
    <p class="mt-3 max-w-3xl text-pa-ink-700">
        Watch a series of short videos by the Art Collection and the Cultural Heritage Digitisation Service about some
        of these sculptures, or listen to a former Heritage Collections intern&rsquo;s podcast series.
    </p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="https://media.ed.ac.uk/playlist/dedicated/229339282/1_4n2k0ev6/1_lh3jbplo"
           target="_blank" rel="noopener"
           class="group flex items-start justify-between gap-4 rounded border border-pa-ink-100 bg-white p-5 transition-shadow hover:border-pa-ink-400 hover:shadow-sm">
            <span class="block">
                <span class="block text-base font-medium text-pa-ink-900 group-hover:text-pa-accent">Public Art Shorts<span class="sr-only"> (opens in a new tab)</span></span>
                <span class="mt-1 block text-sm text-pa-ink-700">Short videos on Media Hopper (opens in a new tab)</span>
            </span>
            <svg class="mt-1 h-5 w-5 shrink-0 text-pa-ink-600 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
        </a>

        <a href="https://heritage-blog.is.ed.ac.uk/category/the-collection-public-art-podcast/"
           target="_blank" rel="noopener"
           class="group flex items-start justify-between gap-4 rounded border border-pa-ink-100 bg-white p-5 transition-shadow hover:border-pa-ink-400 hover:shadow-sm">
            <span class="block">
                <span class="block text-base font-medium text-pa-ink-900 group-hover:text-pa-accent">The Collection: Public Art Podcast<span class="sr-only"> (opens in a new tab)</span></span>
                <span class="mt-1 block text-sm text-pa-ink-700">Heritage Collections intern series (opens in a new tab)</span>
            </span>
            <svg class="mt-1 h-5 w-5 shrink-0 text-pa-ink-600 group-hover:text-pa-accent" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
        </a>
    </div>

    <p class="mt-8 text-xs text-pa-ink-700">
        This site was created by a student intern and the Digital Library team in 2018/9 as part of an ISG Innovation Grant.
    </p>
</section>
@endsection
