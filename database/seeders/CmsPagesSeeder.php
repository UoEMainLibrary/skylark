<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Seed every CMS-managed page (per config/cms.php) with the verbatim
 * static HTML currently in the matching Blade view's @else fallback
 * branch — so flipping CMS_ENABLED on for a freshly-seeded install
 * yields visually identical output to leaving it off.
 *
 * Uses firstOrCreate keyed on (collection, slug) so production runs
 * and re-seeds NEVER overwrite a row that's already been edited via
 * Filament. Companion data migration
 * `2026_05_15_115544_migrate_resp_home_contents_into_cms_pages` runs
 * before the seeder and copies any legacy resp_home_contents row into
 * cms_pages first, so client edits to the RESP home survive the
 * cutover unaltered.
 */
class CmsPagesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $row) {
            CmsPage::query()->firstOrCreate(
                ['collection' => $row['collection'], 'slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'body' => trim($row['body']),
                    'image_1_alt' => $row['image_1_alt'] ?? null,
                ]
            );
        }
    }

    /**
     * Render the public-art-v2.partials.external-link partial as an HTML
     * string so the seeded body matches the static fallback verbatim
     * (icon + sr-only "(opens in a new tab)" disclosure).
     */
    protected function extLink(string $href, string $label, string $extra = ''): string
    {
        $class = trim('underline underline-offset-2 hover:decoration-2 '.$extra);
        $svg = '<svg class="ms-1 inline-block h-3 w-3 -translate-y-px align-baseline opacity-70" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>';

        return "<a href=\"{$href}\" target=\"_blank\" rel=\"noopener\" class=\"{$class}\">{$label}<span class=\"sr-only\"> (opens in a new tab)</span>{$svg}</a>";
    }

    /**
     * @return iterable<int, array{collection: string, slug: string, title: string, body: string, image_1_alt?: string}>
     */
    protected function pages(): iterable
    {
        // ---- RESP / EERC -------------------------------------------------

        yield [
            'collection' => 'eerc',
            'slug' => 'home',
            'title' => 'Home',
            'body' => $this->respHomeBody(),
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'about',
            'title' => 'About',
            'body' => '<p>The Regional Ethnology of Scotland Archive Project preserves and shares oral history recordings from communities across Scotland.</p>',
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'resp',
            'title' => 'About the Project',
            'image_1_alt' => 'RESP interviewee at home',
            'body' => $this->respAboutProjectBody(),
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'project-history',
            'title' => 'Project History (also rendered at /eerc/people)',
            'image_1_alt' => 'Interactive map of Scotland showing interview locations',
            'body' => $this->respProjectHistoryBody(),
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'overview',
            'title' => 'Browse the Collections (intro paragraph)',
            'body' => '<p>Explore the RESP archive by browsing the collection tree below. Click the + and &minus; buttons to expand or collapse each section.</p>',
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'contact',
            'title' => 'Contact (intro paragraph)',
            'body' => '<p>Enquiries regarding the RESP Archive should be directed in the first instance to: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>. Please address your enquiry to &lsquo;<em>RESP Archive</em>&rsquo;.</p>',
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'accessibility',
            'title' => 'Accessibility',
            'body' => $this->respAccessibilityBody(),
        ];

        yield [
            'collection' => 'eerc',
            'slug' => 'bsl',
            'title' => 'British Sign Language (BSL)',
            'body' => '<p>BSL content for this page is forthcoming. Please check back soon.</p>',
        ];

        // ---- Public Art --------------------------------------------------

        yield [
            'collection' => 'public-art',
            'slug' => 'home',
            'title' => 'Home (welcome paragraph only)',
            'body' => $this->publicArtHomeBody(),
        ];

        yield [
            'collection' => 'public-art',
            'slug' => 'licensing',
            'title' => 'Licensing & Copyright',
            'body' => $this->publicArtLicensingBody(),
        ];

        yield [
            'collection' => 'public-art',
            'slug' => 'takedown',
            'title' => 'Takedown Policy',
            'body' => $this->publicArtTakedownBody(),
        ];

        yield [
            'collection' => 'public-art',
            'slug' => 'accessibility',
            'title' => 'Accessibility',
            'body' => $this->publicArtAccessibilityBody(),
        ];

        yield [
            'collection' => 'public-art',
            'slug' => 'feedback',
            'title' => 'Contact (Feedback)',
            'body' => $this->publicArtFeedbackBody(),
        ];
    }

    // ====== Body strings (verbatim from each Blade fallback) ============

    protected function respHomeBody(): string
    {
        $galleryUrl = url('/eerc/exhibition_gallery');

        return <<<HTML
<p>The RESP Archive Project was established in 2018 in collaboration with the Centre for Research Collections at the University of Edinburgh. Originally conceived as a cataloguing project to improve the discoverability of hundreds of audio recordings created by the RESP, the project has developed through the creation of this website to ensure that the collections are both readily accessible and carefully curated and digitally preserved for future access.</p>

<p>The central ethos of the RESP is to make the collections freely available for study, teaching and community access. The project has achieved this by creating a digital platform that allows users to explore and engage with the collection with full access to audio recordings, photographs, and transcripts all in the one place. We have also provided space to engage with creative output in our <a href="{$galleryUrl}">Exhibition gallery</a>.</p>

<p>Digital materials are often at risk of being lost so through careful curation we can allow all of our content to be open and accessible for research, teaching, and community engagement. Each individual item has been digitally preserved in order to safeguard our collection and with the aim to ensure that the materials and stories within remain available for generations to come.</p>

<p>Over the years, the project has spanned Dumfries &amp; Galloway and East Lothian and also the Western Isles, Tayside, Edinburgh, the Scottish Borders, Argyll and West Lothian creating a geographically and thematically broad collection.</p>

<p>The RESP Archive is managed and maintained as a University of Edinburgh Collection.</p>
HTML;
    }

    protected function respAboutProjectBody(): string
    {
        return <<<'HTML'
<p>The RESP Archive Project was established in 2018 in collaboration with the Centre for Research Collections at the University of Edinburgh. Originally conceived as a cataloguing project to ensure the ongoing digital security of this collection and improve the discoverability of the audio recordings created by the RESP the remit was soon expanded to include the creation of this website.</p>

<p>A central ethos of the RESP was to make the recordings fully accessible and freely available, both now and for future generations, whether for research, as a teaching resource or wider community use — particularly within the communities where the recordings were made. This website aims to fulfil this remit by ensuring full access to the audio recordings, photographs, and transcripts for each interviewee, presented on dedicated interviewee pages. Additional pages have been included to enhance engagement and include: an Exhibition Gallery, which showcases creative outputs from the Project; a Kids Only page of resources designed to encourage children to learn more about oral history; and an interactive map to help with place-based research.</p>

<p>Over the course of the Project, the RESP has gathered fieldwork from Dumfries &amp; Galloway and East Lothian and, to a smaller extent, the Western Isles, Tayside, Edinburgh, the Scottish Borders, Argyll and West Lothian. The Collection covers all aspects of our cultural lives: from birth customs to working practices, foodways to transport, landscape to law &amp; order, shops to gardens and fashion to schooldays. Including the donated recordings, the timespan when the recordings were made covers over 50 years, from the 1970s to the 2020s, and with Interviewees ranging in age from 7 to 102, the first-person accounts shared here take us from the present day back to the Victorian era, in over 1,000 recordings and more than 700 hours of audio.</p>

<p>The result is a Collection which is broad in timespan, geography and subject matter and offers enormous potential for dedicated and comparative research either within the Collection itself, or in providing comparative material for studies more broadly.</p>
HTML;
    }

    protected function respProjectHistoryBody(): string
    {
        $pdfUrl = asset('collections/eerc/documents/background-to-the-resp-26-3-26.pdf');

        return <<<HTML
<p>The Regional Ethnology of Scotland Archive Project grew out of an earlier initiative, The Regional Ethnology of Scotland Project (RESP), which had been active since 2011. The RESP trained over 250 local volunteer fieldworkers who then went on to make recordings in their own area and with whoever they chose. And the RESP, in turn, was a progression of the work of the EERC (European Ethnological Research Centre, established 1989), which was established and funded by the Scotland Inheritance Fund and had been producing books with a focus on ethnological research.</p>

<p>Ethnology, in its widest definition the study of culture, is centred on the assertion that personal testimony can enlighten and enrich our understanding of a particular time and place and lead us to a better understanding of our shared cultural lives. And people are at the heart of this discipline, as both practitioners and participants. As the founder of the EERC, Professor Sandy Fenton, asserted:</p>

<blockquote>
    <p>&ldquo;[Ethnology] is a subject that relates to each and every one of us and there is no one who cannot be a practitioner. It is one in which personal roots, the home and environment within which the researcher is brought up, become part of the research apparatus of national identity.&rdquo;</p>
</blockquote>

<p>This quote is at the very heart of the work of the RESP where local partnerships and volunteers have been central to the success of our work: both in terms of how much the Project has been able to achieve, and in the authenticity and relevance of the resulting archive of material.</p>

<p>To date, around 280 volunteer fieldworkers and 585 volunteer interviewees, who range in age from 8 to 102, have contributed over 1,000 recordings (more than 700 hours of spoken word testimony) as well as many hundreds of images and supporting documents.</p>

<p>The work of the EERC and the RESP has been entirely funded by the Scotland Inheritance Fund and now, through this website, is preserved and made available on an open access basis under the ongoing care of the Centre for Research Collections at the University of Edinburgh.</p>

<p>You can <a href="{$pdfUrl}" target="_blank" rel="noopener">read more about the EERC, RESP and the Archive Project<span class="sr-only"> (opens in a new tab)</span></a> here.</p>
HTML;
    }

    protected function respAccessibilityBody(): string
    {
        return trim(view('eerc-v2.partials.accessibility_statement_body')->render());
    }

    protected function publicArtHomeBody(): string
    {
        // Verbatim "Welcome" prose from public-art-v2/home.blade.php (the
        // two paragraphs below the lead sentence and above the Spotlight
        // section). The lead sentence and the Spotlight / Runestone /
        // CRC blocks below stay in the template — they each have
        // bespoke layout, external embeds or config dependencies that
        // don't belong in a single rich-text body.
        $loansLink = $this->extLink('https://collections.ed.ac.uk/art', 'Commission and Loans pages', 'text-pa-accent');

        return <<<HTML
<p>Ranging from historic memorials to contemporary creative interventions, Art on Campus includes externally sited sculptures and commissioned installations which reflect on, and respond to, the history and physical environment of the University.</p>
<p>The University Art Collection manages both permanent and temporary commissions connected to campus and research at the University, as well as overseeing the movement and presentation of works from the Collection across University buildings. More information is available on the {$loansLink}.</p>
HTML;
    }

    protected function publicArtLicensingBody(): string
    {
        $imageLink = $this->extLink(
            'https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing',
            'image licensing pages'
        );

        return <<<HTML
<p>Unless explicitly stated otherwise, all material on this website is copyright &copy; the University of Edinburgh.</p>

<h2>Image licensing</h2>
<p>Many images on this site are made available under a Creative Commons Attribution licence (CC BY 4.0). Where an alternative licence applies, this is noted on the individual artwork record.</p>
<p>For higher-resolution images or commercial use enquiries, please see the University&rsquo;s {$imageLink}.</p>

<h2>Copyright in the artworks</h2>
<p>Copyright in many of the artworks shown on this site is held by the artist or the artist&rsquo;s estate. Where an artwork is in copyright, reproduction or reuse may require permission from the rights holder.</p>

<h2>Contact</h2>
<p>For licensing or copyright enquiries, please contact <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>.</p>
HTML;
    }

    protected function publicArtTakedownBody(): string
    {
        $policyLink = $this->extLink(
            'https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy',
            'University’s Takedown Policy'
        );

        return <<<HTML
<p>The University of Edinburgh takes intellectual property rights and the privacy of individuals seriously. We have made every effort to ensure that the content on this site is shared appropriately, but we recognise that some material may have been published in error.</p>
<p>If you have concerns about any material on this website &mdash; for example, you believe content infringes your copyright, or contains material you consider to be defamatory, sensitive or otherwise inappropriate &mdash; please get in touch.</p>

<h2>How to make a takedown request</h2>
<p>Please follow the {$policyLink} when making a request.</p>
<p>Or contact us directly: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>.</p>
HTML;
    }

    protected function publicArtFeedbackBody(): string
    {
        $privacyLink = $this->extLink('https://www.ed.ac.uk/about/website/privacy', 'University’s privacy statement');

        return <<<HTML
<p>We welcome your comments, corrections and questions about the artworks featured on Art on Campus.</p>

<h2>Get in touch</h2>
<p>Please email <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a> with feedback about this website, or <a href="mailto:art.collection@ed.ac.uk">art.collection@ed.ac.uk</a> for queries about the artworks themselves.</p>

<h2>Address</h2>
<address class="not-italic">
    Centre for Research Collections<br>
    Edinburgh University Library<br>
    George Square<br>
    Edinburgh<br>
    EH8 9LJ<br>
    Tel: <a href="tel:+441316508379">+44 (0)131 650 8379</a>
</address>

<h2>Privacy</h2>
<p>Any personal information you share with us will be handled in accordance with the {$privacyLink}.</p>
HTML;
    }

    protected function publicArtAccessibilityBody(): string
    {
        $publicSiteUrl = url('/art-on-campus');
        $publicSiteVisible = rtrim(url('/'), '/').'/art-on-campus';

        $abilityNet = $this->extLink('https://abilitynet.org.uk/', 'AbilityNet');
        $myComputerMyWay = $this->extLink('https://mcmw.abilitynet.org.uk/', 'My Computer My Way');
        $sensusAccess = $this->extLink(
            'https://www.ed.ac.uk/information-services/help-consultancy/accessibility/sensusaccess',
            'SensusAccess accessible document conversion service'
        );
        $contactScotlandBsl = $this->extLink('https://contactscotland-bsl.org/', 'Contact Scotland BSL');
        $eass = $this->extLink('https://www.equalityadvisoryservice.com/', 'Equality Advisory and Support Service (EASS)');
        $govGuidance = $this->extLink(
            'https://www.gov.uk/guidance/accessibility-requirements-for-public-sector-websites-and-apps',
            'guidance on accessibility requirements for public sector websites and apps'
        );
        $wcag = $this->extLink('https://www.w3.org/TR/WCAG22/', 'Web Content Accessibility Guidelines (WCAG) 2.2 AA standard');

        // The static fallback Blade resolves these dates with
        // Carbon::parse('2026-05-03'); resolving them at seed time keeps
        // the seeded body byte-for-byte stable.
        $reviewDate = Carbon::parse('2026-05-03')->format('j F Y');
        $changeMonth = Carbon::parse('2026-05-03')->format('F Y');

        return <<<HTML
<p>This accessibility statement applies to the <em>Art on Campus</em> website at <a href="{$publicSiteUrl}">{$publicSiteVisible}</a>.</p>
<p>This website is run by the Library and University Collections Directorate, Information Services Group at the University of Edinburgh. We want as many people as possible to be able to use it. For example, that means you should be able to:</p>
<ul>
    <li>change most colours using browser settings;</li>
    <li>magnify content to 200% without losing information or function;</li>
    <li>experience no time limits when using the website;</li>
    <li>navigate the site, including the artwork map, using a keyboard;</li>
    <li>use screen-reader and voice-recognition software with the site&rsquo;s primary content.</li>
</ul>
<p>We have also made the website text as simple as possible to understand. Some of our content is technical, and we use technical terms where there is no easier wording without changing what the text means.</p>

<h2>Customising the website</h2>
<p>{$abilityNet} has advice on making your device easier to use if you have a disability, including their {$myComputerMyWay} guides.</p>
<p>If you are a member of University staff or a student, you can use the free {$sensusAccess}.</p>

<h2>How accessible this website is</h2>
<p>This site has been rebuilt with accessibility in mind. The redesigned interface (Art on Campus V2) addresses several issues identified in the previous version of the site, including:</p>
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
    <li><strong>Embedded videos.</strong> Captions, transcripts and audio description are provided through the host platform (Media Hopper or Vimeo) and depend on what the publisher has uploaded. Where these are missing, this is a known non-compliance with WCAG 2.2 success criteria 1.2.2 (Captions, Pre-recorded), 1.2.3 (Audio Description or Media Alternative) and 1.2.5 (Audio Description, Pre-recorded). We provide a link to the full-page version of each video so users can use the host&rsquo;s own caption controls and any transcript provided there.</li>
    <li><strong>Interactive maps.</strong> Maps are currently outside the scope of the UK accessibility regulations. The interactive map is rendered by OpenLayers and some screen readers cannot meaningfully interact with map markers. We provide a textual list of all mapped artworks beneath the map, a &ldquo;Skip interactive map&rdquo; link for keyboard users, plus links to OpenStreetMap and Google Maps for each artwork.</li>
    <li><strong>Legacy descriptive text.</strong> Some older artwork descriptions inherited from the previous catalogue may not yet meet current plain-language guidance. We are revising this content over time.</li>
    <li><strong>Alternative text quality.</strong> All artwork images carry alternative text derived from the artwork title; thumbnails are marked decorative. Where Solr exposes a richer alt-text field we will adopt it (1.1.1).</li>
</ul>

<h2>Feedback and contact information</h2>
<p>If you need information from this site in a different format (for example, accessible PDF, large print, audio recording or braille), or if you find any accessibility problem, please contact the Library and University Collections Information Services Helpline:</p>
<ul>
    <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
    <li>Telephone: <a href="tel:+441316515151">+44 (0)131 651 5151</a></li>
    <li>British Sign Language (BSL) users can contact us via {$contactScotlandBsl}, the on-line BSL interpreting service.</li>
</ul>
<p>We will consider your request and get back to you within 5 working days.</p>

<h2>Enforcement procedure</h2>
<p>The Equality and Human Rights Commission (EHRC) is responsible for enforcing the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018 (the &ldquo;accessibility regulations&rdquo;). If you are not happy with how we respond to your complaint please contact the {$eass}.</p>
<p>The government has produced {$govGuidance}.</p>

<h2>Technical information about this website&rsquo;s accessibility</h2>
<p>The University of Edinburgh is committed to making its websites and applications accessible, in accordance with the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>

<h3>Compliance status</h3>
<p>This website is partially compliant with the {$wcag} because of the non-compliances listed below.</p>

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
<p>Information about the location of each artwork is also provided in text on the artwork record, and a textual list of all mapped artworks is provided as an alternative to the map view.</p>

<h3>Disproportionate burden</h3>
<p>We are not currently claiming that any accessibility problems would be a disproportionate burden to fix.</p>

<h2>What we&rsquo;re doing to improve accessibility</h2>
<p>We will continue to address and make significant improvements to the accessibility issues highlighted. Unless specified otherwise, a complete solution or significant improvement will be in place by March 2027. While we are in the process of resolving these accessibility issues we will ensure reasonable adjustments are in place to make sure no user is disadvantaged. As changes are made, we will continue to review and retest the accessibility of this website.</p>

<h2>Preparation of this accessibility statement</h2>
<p>This statement was prepared on 20 March 2026. It was last reviewed on {$reviewDate} following the rebuild of the website on the new Skylark platform.</p>
<p>The website was last tested in October 2025 by Library and University Collections, Information Services Group at the University of Edinburgh using both automated and manual methods. The site was tested on a PC, primarily using Microsoft Edge alongside Mozilla Firefox and Google Chrome. Testing covered:</p>
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
    <li><strong>{$changeMonth}</strong> &mdash; Rebuilt the public site as Skylark V2. Added skip-to-content and skip-map links; replaced the homepage carousel and loading banner with static content; rewrote the artwork record gallery to use a native HTML <code>&lt;dialog&gt;</code> for image zoom; added a textual list of all mapped artworks; raised colour-contrast tokens to meet WCAG 2.2 AA against white and the off-white surface; added consistent &ldquo;opens in a new tab&rdquo; disclosure on every external link; and added a textual transcript / full-page link beside every embedded video.</li>
    <li><strong>March 2026</strong> &mdash; Initial accessibility statement prepared following manual testing of the legacy site in October 2025.</li>
</ul>
HTML;
    }
}
