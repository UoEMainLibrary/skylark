@extends('layouts.public-art-v2')

@section('title', 'Accessibility | Art on Campus')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-400">University Art Collection</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Accessibility statement</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <p>
            This statement applies to the Art on Campus website at
            <a href="{{ url('/public-art') }}">{{ rtrim(url('/'), '/') }}/public-art</a>.
            It is run by the University of Edinburgh, which is committed to making its digital services accessible to
            as wide an audience as possible. We aim to meet
            <a href="https://www.w3.org/TR/WCAG22/" target="_blank" rel="noopener">WCAG 2.2 Level AA</a>.
        </p>

        <h2>How accessible this website is</h2>
        <p>This website has been redesigned with accessibility in mind. We have made the following commitments:</p>
        <ul>
            <li>Colour contrast meets WCAG 2.2 Level AA for body text and interactive elements.</li>
            <li>The site is fully navigable using a keyboard.</li>
            <li>A &ldquo;Skip to main content&rdquo; link is provided at the top of every page.</li>
            <li>Headings are nested in a logical, hierarchical order to support assistive technologies.</li>
            <li>All images of artworks have descriptive alternative text where one has been authored.</li>
            <li>Forms have explicit labels and visible focus styles.</li>
            <li>The layout adapts to mobile, tablet and desktop screens.</li>
            <li>Pages do not rely on auto-playing carousels or animations to convey information.</li>
            <li>Where embedded videos are used, captions are provided through the host platform.</li>
        </ul>

        <h2>Known limitations</h2>
        <p>We are aware that some areas of the site have known accessibility limitations:</p>
        <ul>
            <li>
                <strong>Maps.</strong> The interactive map is provided via OpenLayers; some screen readers may not be
                able to interact meaningfully with map markers. Each artwork record includes a textual description of
                the location and links to OpenStreetMap and Google Maps as alternatives.
            </li>
            <li>
                <strong>Image zoom.</strong> Where IIIF deep-zoom is offered for high-resolution photographs, a
                full-image fallback is provided as a regular link.
            </li>
            <li>
                <strong>Legacy content.</strong> Some older descriptive text may not yet match current plain-language
                guidance. We are working to revise this content over time.
            </li>
        </ul>

        <h2>Reporting accessibility issues</h2>
        <p>
            If you find an accessibility issue, or need information from this site in a different format (for example,
            large print, audio description, easy-read), please contact
            <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>.
            We aim to respond within 5 working days.
        </p>

        <h2>University of Edinburgh accessibility statement</h2>
        <p>
            For the University&rsquo;s overarching accessibility statement, please see the
            <a href="https://www.ed.ac.uk/about/website/accessibility" target="_blank" rel="noopener">University of Edinburgh accessibility page</a>.
        </p>

        <h2>Enforcement procedure</h2>
        <p>
            If you are not happy with how we respond to your complaint, contact the
            <a href="https://www.equalityadvisoryservice.com/" target="_blank" rel="noopener">Equality Advisory and Support Service (EASS)</a>.
        </p>
    </div>
</article>
@endsection
