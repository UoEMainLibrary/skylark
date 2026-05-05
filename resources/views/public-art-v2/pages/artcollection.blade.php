@extends('layouts.public-art-v2')

@section('title', 'University Art Collection | Art on Campus')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">University of Edinburgh</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">The University Art Collection</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <p>
            The University of Edinburgh has been collecting art for over 350 years. The Art Collection comprises over
            8,500 artworks including paintings, sculptures, prints, drawings, photographs, ceramics, glass and
            installations.
        </p>
        <p>
            Highlights include works by Eduardo Paolozzi, William McTaggart, Sir Henry Raeburn, John Bellany, Joan Eardley,
            Anne Redpath, Elizabeth Blackadder, and Stephen Conroy, among many others.
        </p>
        <p>
            The Collection is used in teaching, research and public engagement, and is displayed across the
            University&rsquo;s campuses for the benefit of staff, students and visitors.
        </p>

        <h2>Commissions and loans</h2>
        <p>
            The University Art Collection manages both permanent and temporary art commissions and campus displays for
            University buildings and as part of research. More information is available on the
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://collections.ed.ac.uk/art',
                'label' => 'Commission and Loans pages',
            ]).
        </p>

        <h2>Contact</h2>
        <p>
            For more information please contact
            <a href="mailto:art.collection@ed.ac.uk">art.collection@ed.ac.uk</a>.
        </p>
    </div>
</article>
@endsection
