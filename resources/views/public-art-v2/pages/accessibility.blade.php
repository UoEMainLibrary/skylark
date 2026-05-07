@extends('layouts.public-art-v2')

@section('title', 'Accessibility | Art on Campus')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">University Art Collection</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Accessibility statement for Art on Campus</h1>

    <div class="prose prose-lg mt-8 max-w-none text-pa-ink-700">
        <p>
            This accessibility statement applies to the <em>Art on Campus</em> website at
            <a href="{{ url('/art-on-campus') }}">{{ rtrim(url('/'), '/') }}/art-on-campus</a>.
        </p>
        <p>
            This website is run by the Library and University Collections Directorate,
            Information Services Group at the University of Edinburgh. We want as many people
            as possible to be able to use it. For example, that means you should be able to:
        </p>
        <ul>
            <li>change most colours using browser settings;</li>
            <li>magnify content to 200% without losing information or function;</li>
            <li>experience no time limits when using the website;</li>
            <li>navigate the site, including the artwork map, using a keyboard;</li>
            <li>use screen-reader and voice-recognition software with the site&rsquo;s primary content.</li>
        </ul>
        <p>
            We have also made the website text as simple as possible to understand. Some of
            our content is technical, and we use technical terms where there is no easier
            wording without changing what the text means.
        </p>

        <h2>Customising the website</h2>
        <p>
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://abilitynet.org.uk/',
                'label' => 'AbilityNet',
            ])
            has advice on making your device easier to use if you have a disability, including
            their
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://mcmw.abilitynet.org.uk/',
                'label' => 'My Computer My Way',
            ])
            guides.
        </p>
        <p>
            If you are a member of University staff or a student, you can use the free
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.ed.ac.uk/information-services/help-consultancy/accessibility/sensusaccess',
                'label' => 'SensusAccess accessible document conversion service',
            ]).
        </p>

        <h2>How accessible this website is</h2>
        <p>
            This site has been rebuilt with accessibility in mind. The redesigned interface
            (Art on Campus V2) addresses several issues identified in the previous version of
            the site, including:
        </p>
        <ul>
            <li>a &ldquo;Skip to main content&rdquo; link is provided on every page (WCAG 2.4.1);</li>
            <li>the homepage no longer uses an auto-rotating image carousel or a loading overlay (2.2.2);</li>
            <li>links that open in a new tab are announced visually and to assistive technology (3.2.2);</li>
            <li>colour combinations used for body text, links, headings and interactive controls are checked against WCAG 2.2 AA contrast ratios (1.4.3) by automated tests in our build pipeline;</li>
            <li>artwork records use a single-scroll layout with a labelled map region, &ldquo;Skip interactive map&rdquo; link, textual location, approximate coordinates and external map links as alternatives (1.4.1, 2.1.1);</li>
            <li>the artwork map page provides a textual list of every mapped artwork as an alternative to the interactive map (1.1.1, 2.1.1);</li>
            <li>image zoom uses a native HTML <code>&lt;dialog&gt;</code> with focus management and keyboard close (2.1.1, 4.1.2); without JavaScript a &ldquo;View larger image&rdquo; link opens the source image in a new tab;</li>
            <li>headings are nested in a logical, hierarchical order;</li>
            <li>form controls and search use explicit labels with visible focus rings;</li>
            <li>the layout reflows to mobile, tablet and desktop widths without horizontal scrolling at 320 CSS pixels (1.4.10).</li>
        </ul>

        <h2>Known limitations</h2>
        <p>We are aware that some areas of the site are not yet fully accessible:</p>
        <ul>
            <li>
                <strong>Embedded videos.</strong> Captions, transcripts and audio description
                are provided through the host platform (Media Hopper or Vimeo) and depend on
                what the publisher has uploaded. Where these are missing, this is a known
                non-compliance with WCAG 2.2 success criteria 1.2.2 (Captions, Pre-recorded),
                1.2.3 (Audio Description or Media Alternative) and 1.2.5 (Audio Description,
                Pre-recorded). We provide a link to the full-page version of each video so
                users can use the host&rsquo;s own caption controls and any transcript provided
                there.
            </li>
            <li>
                <strong>Interactive maps.</strong> Maps are currently outside the scope of the
                UK accessibility regulations. The interactive map is rendered by OpenLayers and
                some screen readers cannot meaningfully interact with map markers. We provide a
                textual list of all mapped artworks beneath the map, a &ldquo;Skip interactive
                map&rdquo; link for keyboard users, plus links to OpenStreetMap and Google
                Maps for each artwork.
            </li>
            <li>
                <strong>Legacy descriptive text.</strong> Some older artwork descriptions
                inherited from the previous catalogue may not yet meet current plain-language
                guidance. We are revising this content over time.
            </li>
            <li>
                <strong>Alternative text quality.</strong> All artwork images carry alternative
                text derived from the artwork title; thumbnails are marked decorative. Where
                Solr exposes a richer alt-text field we will adopt it (1.1.1).
            </li>
        </ul>

        <h2>Feedback and contact information</h2>
        <p>
            If you need information from this site in a different format (for example,
            accessible PDF, large print, audio recording or braille), or if you find any
            accessibility problem, please contact the Library and University Collections
            Information Services Helpline:
        </p>
        <ul>
            <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
            <li>Telephone: <a href="tel:+441316515151">+44 (0)131 651 5151</a></li>
            <li>
                British Sign Language (BSL) users can contact us via
                @include('public-art-v2.partials.external-link', [
                    'href' => 'https://contactscotland-bsl.org/',
                    'label' => 'Contact Scotland BSL',
                ]),
                the on-line BSL interpreting service.
            </li>
        </ul>
        <p>We will consider your request and get back to you within 5 working days.</p>

        <h2>Enforcement procedure</h2>
        <p>
            The Equality and Human Rights Commission (EHRC) is responsible for enforcing the
            Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility
            Regulations 2018 (the &ldquo;accessibility regulations&rdquo;). If you are not
            happy with how we respond to your complaint please contact the
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.equalityadvisoryservice.com/',
                'label' => 'Equality Advisory and Support Service (EASS)',
            ]).
        </p>
        <p>
            The government has produced
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.gov.uk/guidance/accessibility-requirements-for-public-sector-websites-and-apps',
                'label' => 'guidance on accessibility requirements for public sector websites and apps',
            ]).
        </p>

        <h2>Technical information about this website&rsquo;s accessibility</h2>
        <p>
            The University of Edinburgh is committed to making its websites and applications
            accessible, in accordance with the Public Sector Bodies (Websites and Mobile
            Applications) (No. 2) Accessibility Regulations 2018.
        </p>

        <h3>Compliance status</h3>
        <p>
            This website is partially compliant with the
            @include('public-art-v2.partials.external-link', [
                'href' => 'https://www.w3.org/TR/WCAG22/',
                'label' => 'Web Content Accessibility Guidelines (WCAG) 2.2 AA standard',
            ])
            because of the non-compliances listed below.
        </p>

        <h3>Non-accessible content</h3>
        <p>The content listed below is non-accessible for the following reasons.</p>

        <h4>Non-compliance with the accessibility regulations</h4>
        <p>The following items do not yet meet the WCAG 2.2 AA success criteria:</p>
        <ul>
            <li>1.2.2 Captions (Pre-recorded) &mdash; not all embedded videos have human-corrected captions on the host platform.</li>
            <li>1.2.3 Audio Description or Media Alternative (Pre-recorded) &mdash; transcripts are not yet provided for every embedded video.</li>
            <li>1.2.5 Audio Description (Pre-recorded) &mdash; audio description is not yet provided for every embedded video.</li>
            <li>1.4.10 Reflow &mdash; the embedded video components may not reflow fully at 400% zoom because of host-player constraints.</li>
            <li>1.4.5 Images of Text &mdash; legacy artwork records may include scanned text within imagery.</li>
        </ul>

        <h4>Content that&rsquo;s not within the scope of the accessibility regulations</h4>
        <p><strong>Maps.</strong> Maps are not within the scope of the regulations. The interactive map on this site is rendered by OpenLayers and may not be fully accessible with all assistive technologies. The following items relating to the map do not meet the WCAG 2.2 AA success criteria:</p>
        <ul>
            <li>1.1.1 Non-text Content &mdash; map markers do not all have text alternatives.</li>
            <li>1.4.1 Use of Colour &mdash; the map uses colour to indicate marker positions.</li>
            <li>2.1.1 Keyboard &mdash; map markers cannot all be reached by keyboard.</li>
            <li>4.1.2 Name, Role, Value &mdash; the map is not fully compatible with assistive software.</li>
        </ul>
        <p>
            Information about the location of each artwork is also provided in text on the
            artwork record, and a textual list of all mapped artworks is provided as an
            alternative to the map view.
        </p>

        <h3>Disproportionate burden</h3>
        <p>
            We are not currently claiming that any accessibility problems would be a
            disproportionate burden to fix.
        </p>

        <h2>What we&rsquo;re doing to improve accessibility</h2>
        <p>
            We will continue to address and make significant improvements to the accessibility
            issues highlighted. Unless specified otherwise, a complete solution or significant
            improvement will be in place by March 2027. While we are in the process of
            resolving these accessibility issues we will ensure reasonable adjustments are in
            place to make sure no user is disadvantaged. As changes are made, we will continue
            to review and retest the accessibility of this website.
        </p>

        <h2>Preparation of this accessibility statement</h2>
        <p>
            This statement was prepared on 20 March 2026. It was last reviewed on
            {{ \Illuminate\Support\Carbon::parse('2026-05-03')->format('j F Y') }}
            following the rebuild of the website on the new Skylark platform.
        </p>
        <p>
            The website was last tested in October 2025 by Library and University Collections,
            Information Services Group at the University of Edinburgh using both automated and
            manual methods. The site was tested on a PC, primarily using Microsoft Edge
            alongside Mozilla Firefox and Google Chrome. Testing covered:
        </p>
        <ul>
            <li>scaling and reflow at different resolutions;</li>
            <li>options to customise the interface (magnification, font, background colour);</li>
            <li>keyboard navigation and keyboard traps;</li>
            <li>warning of links opening in a new tab or window;</li>
            <li>information conveyed by colour or sound only;</li>
            <li>flashing, moving or scrolling text;</li>
            <li>use with screen-reading software (e.g. JAWS, VoiceOver, TalkBack);</li>
            <li>assistive software (TextHelp Read &amp; Write, Windows Magnifier, ZoomText, Dragon NaturallySpeaking);</li>
            <li>tooltips and text alternatives for non-text content;</li>
            <li>time limits;</li>
            <li>compatibility with mobile accessibility functionality (Android and iOS);</li>
            <li>any drag functionality and its alternatives;</li>
            <li>consistent help function;</li>
            <li>submission and re-entry of data.</li>
        </ul>

        <h2>Change log</h2>
        <p>This section will receive updates as and when accessibility improvements are made to the website.</p>
        <ul>
            <li>
                <strong>{{ \Illuminate\Support\Carbon::parse('2026-05-03')->format('F Y') }}</strong> &mdash;
                Rebuilt the public site as Skylark V2. Added skip-to-content and skip-map links;
                replaced the homepage carousel and loading banner with static content;
                rewrote the artwork record gallery to use a native HTML <code>&lt;dialog&gt;</code>
                for image zoom; added a textual list of all mapped artworks; raised
                colour-contrast tokens to meet WCAG 2.2 AA against white and the off-white
                surface; added consistent &ldquo;opens in a new tab&rdquo; disclosure on every
                external link; and added a textual transcript / full-page link beside every
                embedded video.
            </li>
            <li>
                <strong>March 2026</strong> &mdash; Initial accessibility statement prepared
                following manual testing of the legacy site in October 2025.
            </li>
        </ul>
    </div>
</article>
@endsection
