@extends('layouts.public-art-v2')

@section('title', 'Licensing & Copyright | Art on Campus')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">University Art Collection</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Licensing &amp; Copyright</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <p>
            Unless explicitly stated otherwise, all material on this website is copyright &copy; the University of
            Edinburgh.
        </p>

        <h2>Image licensing</h2>
        <p>
            Many images on this site are made available under a Creative Commons Attribution licence (CC BY 4.0). Where
            an alternative licence applies, this is noted on the individual artwork record.
        </p>
        <p>
            For higher-resolution images or commercial use enquiries, please see the University&rsquo;s
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing',
                'label' => 'image licensing pages',
            ]).
        </p>

        <h2>Copyright in the artworks</h2>
        <p>
            Copyright in many of the artworks shown on this site is held by the artist or the artist&rsquo;s estate.
            Where an artwork is in copyright, reproduction or reuse may require permission from the rights holder.
        </p>

        <h2>Contact</h2>
        <p>
            For licensing or copyright enquiries, please contact
            <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>.
        </p>
    </div>
</article>
@endsection
