@extends('layouts.public-art-v2')

@section('title', 'Old College Artworks | Art on Campus')

@section('description', 'The Old College Heritage and Values Project: reviewing and updating portrait displays and contemporary artworks at Old College, University of Edinburgh.')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">Art on Campus</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Old College Artworks</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <h2>About the Old College Heritage and Values Project</h2>
        <p>
            The largest displays of the University&rsquo;s art collection on campus are at Old College, where
            approximately 100 portraits of figures connected to the University between the seventeenth and the
            twentieth centuries are on display. The Old College Heritage and Values Project (2023&ndash;ongoing)
            is a multi-year initiative focussed on reviewing and updating these displays and their interpretation.
        </p>

        <figure class="not-prose mx-auto my-8 w-4/5 max-w-2xl overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
            <img src="{{ asset('collections/public-art/images/old-college/main-stairway-chris-close.jpg') }}"
                 alt="The main stairway at Old College with historic gold-framed portraits on blue walls and a cluster of contemporary artworks on the lower wall beside the staircase."
                 loading="lazy"
                 class="h-auto w-full" />
            <figcaption class="px-3 py-2 text-xs text-pa-ink-700">
                Artwork displays in main stairway, 2024. Photography: Chris Close.
            </figcaption>
        </figure>

        <p>
            Built at the turn of the 19th century, Old College was the University&rsquo;s main campus in its time,
            housing everything from the library to natural history and anatomy museums. The building is often seen as
            a symbol of the Scottish Enlightenment due to its neoclassical architecture and the prominence of
            university professors associated with this period, many of whom are commemorated in its portrait displays.
            Today it is home to the Law School and the Talbot Rice Gallery as well as staff offices and event spaces.
        </p>
        <p>
            The Project aims to critically examine the displays in ways that acknowledge both the lack of diversity
            represented in the portraiture, which almost exclusively depicts white men of the middle and upper classes,
            and the histories and contributions that are not visible in the celebrated heritage of this University
            building. It takes into account the research and ongoing commitments from the University&rsquo;s Race
            Review published in July 2025 and the findings that link those commemorated in the artworks and the building
            itself to histories of colonialism, enslavement and empire. A key part of the process has involved working
            with staff and student groups to engage with the artworks and the histories of the site through teaching,
            research, creative responses, and consultation.
        </p>

        <div class="not-prose my-8 flex justify-center">
            <figure class="overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50" style="width: 50%; min-width: 10rem;">
                <img src="{{ asset('collections/public-art/images/old-college/main-stairway-milenka-soskin.png') }}"
                     alt="Isometric wireframe architectural drawing of the Old College main stairway hall, showing portrait placements along the staircase walls."
                     loading="lazy"
                     class="h-auto w-full" />
                <figcaption class="px-3 py-2 text-xs text-pa-ink-700">
                    Architectural drawing of Main Stairway by Milenka Soskin, Old College Project intern, 2025.
                </figcaption>
            </figure>
        </div>

        <p>
            Alongside the historic portraiture, a display of contemporary artworks from the collection was installed
            in the main stairway in 2024. This display signalled the beginning of the Old College Project and featured
            works by artists who are graduates or faculty of Edinburgh College of Art, and who have other connections
            with the University through its Heritage Collections or the Talbot Rice Gallery. Their works have been
            collected over the past decade in support of teaching and research activities across the institution. As
            such, they represent perspectives on many urgent issues of our time, including climate change, colonial
            histories, race and racism, feminist thought, housing and digital technologies.
        </p>

        <h2>Access</h2>
        <p>
            Please note that access to the artwork displays at Old College is limited as they are situated in spaces
            frequently used for private events and staff meetings. Proposals for wider access are being developed as
            part of the Old College Project and updates regarding access will be published on the project webpage
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://library.ed.ac.uk/heritage-collections/old-college-artwork',
                'label' => 'here',
                'class' => 'text-pa-accent',
            ]).
        </p>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <figure class="overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
            <img src="{{ asset('collections/public-art/images/old-college/raeburn-room-milenka-soskin.jpeg') }}"
                 alt="Isometric wireframe architectural drawing of the Raeburn Room at Old College, showing portrait placements on the walls."
                 loading="lazy"
                 class="h-auto w-full" />
            <figcaption class="px-3 py-2 text-xs text-pa-ink-700">
                Architectural drawing of Raeburn Room by Milenka Soskin, Old College Project intern, 2025.
            </figcaption>
        </figure>
        <figure class="overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
            <img src="{{ asset('collections/public-art/images/old-college/lee-elder-rooms-milenka-soskin.png') }}"
                 alt="Isometric wireframe architectural drawing of the Lee and Elder Rooms at Old College, showing portrait placements on the walls."
                 loading="lazy"
                 class="h-auto w-full" />
            <figcaption class="px-3 py-2 text-xs text-pa-ink-700">
                Architectural drawings of Lee and Elder Rooms by Milenka Soskin, Old College Project intern, 2025.
            </figcaption>
        </figure>
    </div>

    <div class="mt-12 flex flex-wrap gap-3">
        <a href="{{ url('/art-on-campus') }}"
           class="inline-flex items-center gap-2 rounded border border-pa-ink-400 px-4 py-2 text-sm font-medium text-pa-ink-800 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2">
            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Back to Art on Campus
        </a>
    </div>
</article>
@endsection
