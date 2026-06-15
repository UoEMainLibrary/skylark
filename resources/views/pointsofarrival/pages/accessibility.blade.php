@extends('layouts.pointsofarrival')

@section('title', 'Accessibility | Points Of Arrival')

@push('styles')
<style>
    .accessibility-statement,
    .accessibility-statement p,
    .accessibility-statement ul,
    .accessibility-statement ol,
    .accessibility-statement li {
        font-family: Arial, sans-serif !important;
        font-size: 12pt;
        line-height: 1.5;
        text-align: left;
        color: #000 !important;
    }

    .accessibility-statement h1,
    .accessibility-statement h2,
    .accessibility-statement h3,
    .accessibility-statement h4 {
        color: #2f5496 !important;
        font-family: Arial, sans-serif !important;
        margin-top: 0.75cm;
        margin-bottom: 0.5cm;
    }

    .accessibility-statement h1 { font-size: 24pt; }
    .accessibility-statement h2 { font-size: 20pt; }
    .accessibility-statement h3 { font-size: 16pt; }
    .accessibility-statement h4 { font-size: 14pt; }

    .accessibility-statement a:link,
    .accessibility-statement a:visited {
        color: #0563c1 !important;
        text-decoration: underline;
        display: inline;
    }

    .accessibility-statement a:hover,
    .accessibility-statement a:focus {
        color: #0563c1 !important;
        box-shadow: none !important;
    }

    .accessibility-statement ul {
        list-style-type: disc;
        margin-left: 1.5em;
        padding-left: 0.5em;
    }

    .accessibility-statement ul ul { list-style-type: circle; }
    .accessibility-statement ul ul ul { list-style-type: square; }

    .accessibility-statement ol {
        list-style-type: decimal;
        margin-left: 1.5em;
        padding-left: 0.5em;
    }

    .accessibility-statement li { margin-bottom: 0.1cm; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    @include('pointsofarrival.partials.poa_sidebar')

    <div id="poa-theme">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="content byEditor accessibility-statement">
<h1>Accessibility statement for <a href="https://pointsofarrival.is.ed.ac.uk/">Points of Arrival website</a></h1>
    <p><strong>Website accessibility statement inline with Public Sector Body (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018</strong></p>
    <p>This accessibility statement applies to  <a href="https://pointsofarrival.is.ed.ac.uk/">https://pointsofarrival.is.ed.ac.uk/</a></p>

    <p>This website is run by the Library and University Collections Directorate which is part of Information Services Group at the University of Edinburgh. We want as many people as possible to be able to use this website. For example, that means you should be able to:</p>
    <ul>
        <li>using your browser settings, change colours, contrast levels and fonts to some extent;</li>
        <li>navigate all of the website using just a keyboard;</li>
        <li>navigate all of the website using speech recognition software;</li>
        <li>listen to most of the website using a screen reader (including the most recent versions of Job Access with Speech (JAWS), NonVisual Desktop Access (NVDA) and VoiceOver);</li>
        <li>experience no time limits when using the site, and not encounter any flashing, scrolling or moving text.</li>
    </ul>

    <h2>Customising the website</h2>
    <p>AbilityNet has advice on making your device easier to use if you have a disability. This is an external site with suggestions to make your computer more accessible:</p>
    <p><a href="https://mcmw.abilitynet.org.uk/">AbilityNet - My computer my way</a></p>
    <p>With a few simple steps you can customise the appearance of our website using your browser settings to make it easier to read and navigate:</p>
    <p><a href="https://www.ed.ac.uk/about/website/accessibility/customising-site">Additional information on how to customise our website appearance</a></p>
    <p>If you are a member of University staff or a student, you can use the free SensusAccess accessible document conversion service:</p>
    <p><a href="https://www.ed.ac.uk/student-disability-service/staff/supporting-students/accessible-technology">Information on SensusAccess</a></p>

    <h2>How accessible this website is</h2>
    <p>We know some parts of this website are not fully accessible:</p>
    <ul>
        <li>not all links purposes are clear to the user;</li>
        <li>not all non-text content presented to users has alternative text and there are some instances of text as an image;</li>
        <li>there is no skip to main content function;</li>
        <li>not all colour contrasts meet the recommended Web Content Accessibility Guidelines 2.1 AA standard;</li>
        <li>there are some justified pieces of text;</li>
        <li>it can sometimes be hard to tell where you have navigated to using a keyboard;</li>
        <li>some links open in new windows or tabs without warning;</li>
        <li>some parts of the website are not able to be customised depending on the browser used;</li>
        <li>it is not possible to magnify the site above 200% with reflow without loss of content;</li>
        <li>some parts of the site especially the PDFs may not be fully compatible with screen reader software.</li>
    </ul>

    <h2>Feedback and contact information</h2>
    <p>If you need information on this website in a different format, including accessible PDF, large print, audio recording or braille:</p>
    <ul>
        <li>Email: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a></li>
        <li>Telephone: +44 (0)131 650 8379</li>
        <li>British Sign Language (BSL) users can contact us via Contact Scotland BSL, the on-line BSL interpreting service: <a href="https://contactscotland-bsl.org/">Contact Scotland BSL</a></li>
    </ul>

    <h2>Reporting accessibility problems with this website</h2>
    <p>We are always looking to improve the accessibility of this website. If you find any problems not listed on this page, or think we're not meeting accessibility requirements, please contact:</p>
    <ul>
        <li>Email: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a></li>
        <li>Telephone: +44 (0)131 650 8379</li>
        <li>British Sign Language (BSL) users can contact us via Contact Scotland BSL, the on-line BSL interpreting service: <a href="https://contactscotland-bsl.org/">Contact Scotland BSL</a></li>
    </ul>
    <p>We will consider your request and get back to you in 5 working days.</p>

    <h2>Enforcement procedure</h2>
    <p>The Equality and Human Rights Commission (EHRC) is responsible for enforcing the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018 (the 'accessibility regulations'). If you're not happy with how we respond to your complaint please contact the Equality Advisory and Support Service (EASS) directly:</p>
    <p><a href="https://www.equalityadvisoryservice.com/">Contact details for the Equality Advisory and Support Service (EASS)</a></p>
    <p>The government has produced information on how to report accessibility issues:</p>
    <p><a href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website">Reporting an accessibility problem on a public sector website</a></p>

    <h2>Contacting us by phone using British Sign Language</h2>
    <p>British Sign Language service Contact Scotland BSL runs a service for British Sign Language users and all of Scotland’s public bodies using video relay. This enables sign language users to contact public bodies and vice versa. The service operates 24 hours a day, 7 days a week.</p>
    <p><a href="https://contactscotland-bsl.org/">Contact Scotland BSL service details</a></p>

    <h2>Technical information about this website&rsquo;s accessibility</h2>
    <p>The University of Edinburgh is committed to making its websites and applications accessible, in accordance with the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>
    <p>This website is partially compliant with the Web Content Accessibility Guidelines (WCAG) 2.1 AA standard, due to the non-compliances listed below.</p>
    <p>The full guidelines are available at:</p>
    <p>&nbsp;<a href="https://www.w3.org/TR/WCAG21/">Web Content Accessibility Guidelines version 2.1</a></p>
    <h3>Non accessible content</h3>
    <p>The content listed below is non-accessible for the following reasons.</p>
    <h3>Noncompliance with the accessibility regulations</h3>
    <p>The following items to not comply with the WCAG 2.1 AA success criteria:</p>
    <ul>
        <li>Not all non-text content presented to users has alternative text
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#non-text-content">1.1.1 - Non-text Content</a></li>
            </ul>
        </li>
        <li>Information, structure and relationships conveyed through presentation cannot always be programmatically determined. This includes missing < h1 > tags, multiple < h1 > tags on a single page and skipping heading levels (i.e. an < h1 > and < h3 > exist on a page but no < h2 > tag).
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#info-and-relationships">1.3.1 - Info and Relationships</a></li>
            </ul>
        </li>
        <li>Some content is not read sequentially by screen readers
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#meaningful-sequence">1.3.2 – Meaningful Sequence</a></li>
            </ul>
        </li>
        <li>There may not be sufficient colour contrast between font and background colours, especially where the text size is small
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#contrast-minimum">1.4.3 - Contrast (Minimum)</a></li>
            </ul>
        </li>
        <li>It is not possible to resize text to 200% without assistive technology
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#resize-text">1.4.4. Resize Text</a></li>
            </ul>
        </li>
        <li>Information is conveyed as an image of text rather than as text itself, making it not compatible with screen readers and other assistive technology and is not fully customisable
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#images-of-text">1.4.5 - Images of text</a></li>
            </ul>
        </li>
        <li>Site is not fully compatible with browser customisation meaning that users do not have full control and functionality when customising the site (WCAG 2.1 AAA)
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#visual-presentation">1.4.8 - Visual Presentation (AAA) </a></li>
            </ul>
        </li>
        <li>Content cannot be presented without the user scrolling in two dimensions beyond 175%, with some content being lost altogether
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#reflow">1.4.10 - Reflow</a></li>
            </ul>
        </li>
        <li>Some tooltips do not appear when using the keyboard to navigate
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#content-on-hover-or-focus">1.4.13 - Content on Hover or Focus</a></li>
            </ul>
        </li>
        <li>It is not always possible to bypass blocks of content that are repeated on multiple Web pages
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#bypass-blocks">2.4.1 Bypass Blocks</a></li>
            </ul>
        </li>
        <li>Some of our page titles do not fully describe the page content whereas others are missing altogether
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#page-titled">2.4.2 - Page Titled</a></li>
            </ul>
        </li>
        <li>Link purpose is not always clear and some adjacent links go to the same location
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#link-purpose-in-context">2.4.4 - Link Purpose (In Context)</a></li>
            </ul>
        </li>
        <li>Information, structure and relationships conveyed through presentation cannot always be programmatically determined. This includes missing heading labels
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#headings-and-labels">2.4.6 – Headings and Labels</a></li>
            </ul>
        </li>
        <li>Visual information to identify user interface components, such as keyboard focus, do not always have a sufficient contrast ratio
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#focus-visible">2.4.7 – Focus Visible</a></li>
            </ul>
        </li>
        <li>Some links open in a new browser window without warning
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#on-input">3.2.2 - On Input</a></li>
            </ul>
        </li>
        <li>The search bar is missing a corresponding form label
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#labels-or-instructions">3.3.2 Labels or Instructions (Level A)</a></li>
            </ul>
        </li>
        <li>The website is not fully compatible with screen readers and voice recognition software
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#parsing">4.1.1 Parsing</a></li>
            </ul>
        </li>
        <li>Screen readers are not able to identify some parts of the page
            <ul>
                <li><a href="https://www.w3.org/TR/WCAG21/#name-role-value">4.1.2 - Name, Role, Value</a></li>
            </ul>
        </li>
    </ul>
    <p>At this time, we believe all items are within our control. Unless specified otherwise, a complete solution, or significant improvement, will be in place for those items within our control by March 2024.</p>
    <h3>Disproportionate burden</h3>
    <p>We are not currently claiming that any accessibility problems would be a disproportionate burden to fix.</p>
    <h3>Content that's not within the scope of the accessibility regulations</h3>
    <p>At this time, we do not believe that any content is outside the scope of the accessibility regulations.</p>

    <h2>What we're doing to improve accessibility</h2>
    <p>At this time, we believe all items are within our control. We will continue to address the accessibility issues highlighted to deliver a solution or suitable workaround. We are looking to move this site to a new content management system within the next 12 months and will be working to ensure this resolves the accessibility issues. Unless specified otherwise, a complete solution or significant improvement will be in place for those items within our control by March 2024.</p>
    <p>While we are in the process of resolving these accessibility issues, or where we are unable, we will ensure reasonable adjustments are in place to make sure no user is disadvantaged. As changes are made, we will continue to review accessibility and retest the accessibility of this website.</p>

    <h2>Preparation of this accessibility statement</h2>
    <p><strong>This statement was first prepared on 2rd March 2023 .It was last reviewed on 3rd March 2023.</strong></p>
    <p>This website was first tested on 3rd March 2023. . Testing was carried out by The University of Edinburgh Library and University Collections Digital Library Development team using the automated <a href="https://wave.webaim.org/">Wave WEBAIM</a> and <a href="https://littleforest.co.uk/">Little Forest</a> testing tool.</p>
    <p>This was primarily using the Google Chrome (100.0.4896.127), Mozilla Firefox (91.8.0esr), Internet Explorer (11.0) and Microsoft Edge (100.0.1185.39) browsers for comparative purposes.</p>
    <p>Recent world-wide usage levels survey for different screen readers and browsers shows that Chrome, Mozilla Firefox and Microsoft Edge are increasing in popularity and Google Chrome is now the favoured browser for screen readers:</p>
    <p><a href="https://webaim.org/projects/screenreadersurvey9/">WebAIM: Screen Reader User Survey</a></p>
    <p>The aforementioned three browsers have been used in certain questions for reasons of breadth and variety.</p>
    <p>We ran automated testing using <a href="https://wave.webaim.org/">Wave WEBAIM</a> and <a href="https://littleforest.co.uk/">Little Forest</a> then manual testing that included:</p>
    <ul>
        <li>Spell check functionality;</li>
        <li>Scaling using different resolutions and reflow;</li>
        <li>Options to customise the interface (magnification, font, background colour, etc);</li>
        <li>Keyboard navigation and keyboard traps;</li>
        <li>Data validation;</li>
        <li>Warning of links opening in a new tab or window;</li>
        <li>Information conveyed in colour or sound only;</li>
        <li>Flashing, moving or scrolling text;</li>
        <li>Operability if JavaScript is disabled;</li>
        <li>Use with screen reading software (for example, JAWS);</li>
        <li>Assistive software (TextHelp Read and Write, Windows Magnifier, ZoomText, Dragon NaturallySpeaking, TalkBack and VoiceOver);</li>
        <li>Tooltips and text alternatives for any non-text content;</li>
        <li>Time limits;</li>
        <li>Compatibility with mobile accessibility functionality (Android and iOS).</li>
    </ul>

    <h2>Change Log</h2>
    <p>Since our first evaluation and statement, which was based on automated testing, we have undertaken extensive manual testing. This includes utilising a range of assistive technology to ensure we have a clear picture of the accessibility issues and how best to resolve them.</p>
            </div>
        </div>
    </div>
</div>
@endsection
