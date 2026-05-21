@extends('layouts.public-art-v2')

@section('title', 'Cast Collections | Art on Campus')

@section('description', 'The University of Edinburgh\'s Cast Collections: historic plaster casts of Antique, Renaissance and Gothic sculpture, architectural fragments and the Parthenon frieze casts at Edinburgh College of Art.')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">Art on Campus</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">University Cast Collections</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <p>
            The Cast Collections at The University of Edinburgh brings together one of Scotland&rsquo;s most significant
            collections of historic plaster casts, including Antique, Renaissance and Gothic sculptures, architectural
            fragments and the Parthenon frieze casts. Originally assembled for the teaching of artists and classical
            scholars in the late eighteenth and nineteenth centuries, the collection of casts continues to support
            research, learning and public engagement today.
        </p>
        <p>
            Explore the history and highlights of the Cast Collections at Edinburgh College of Art with this downloadable
            pamphlet:
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://era.ed.ac.uk/server/api/core/bitstreams/c0c13972-6155-499b-a9fb-8d55768092eb/content',
                'label' => 'Cast Collection brochure (PDF)',
                'class' => 'text-pa-accent',
            ]).
        </p>
    </div>

    {{-- Image supplied by the client (see Cast Collection_tab edits.docx). --}}
    <figure class="mt-10 overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
        <img src="{{ asset('collections/public-art/images/cast-collections/east-pediment-cast.jpg') }}"
             alt="Plaster cast of two seated, draped female figures (the goddesses from the east pediment of the Parthenon), displayed on a low plinth against a pale grey wall."
             loading="lazy"
             class="h-auto w-full" />
        <figcaption class="px-3 py-2 text-xs text-pa-ink-700">
            Plaster cast from the Parthenon east pediment, University of Edinburgh Cast Collections.
        </figcaption>
    </figure>

    <div class="prose prose-lg mt-10 max-w-none text-pa-ink-700">
        <h2>More information: Past Projects</h2>
        <p>
            Between 2006 and 2012, the Edinburgh College of Art (ECA) and the University of Edinburgh undertook a major
            project focused on the research, conservation, and interpretation of the historic ECA Cast Collections. The
            initiative aimed to preserve and re-evaluate one of the UK&rsquo;s most significant surviving plaster cast
            collections, while also reconnecting it with contemporary artistic and public audiences.
        </p>
        <p>
            You can explore the project archive and collection information at
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://blogs.ed.ac.uk/casts/the-collection/',
                'label' => 'the Edinburgh Cast Collection project site',
                'class' => 'text-pa-accent',
            ]).
        </p>
        <p>
            The project was coordinated by Dr Ruxandra-Iulia Stoica, with Margaret Stewart serving as Cast Curator.
            Conservation expertise was led by Graciela Ainsworth. Funding support came from the Heritage Lottery Fund
            Scotland, the Esm&eacute;e Fairbairn Foundation, and the Carnegie Trust for the Universities of Scotland.
        </p>
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
