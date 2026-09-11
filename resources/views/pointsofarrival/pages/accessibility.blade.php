@extends('layouts.pointsofarrival')

@section('title', 'Accessibility | Points Of Arrival')

@section('body_class', 'poa-accessibility')

@push('styles')
<style>
    html:has(body.poa-accessibility),
    body.poa-accessibility {
        background: #fff !important;
    }

    body.poa-accessibility .container-fluid,
    body.poa-accessibility #poa-theme .col-xs-12 {
        background: #fff;
    }

    body.poa-accessibility #poa-theme {
        left: 265px;
        right: 0;
        width: auto;
        margin-left: 0;
        background: transparent;
    }

    body.poa-accessibility .content.accessibility-statement {
        background: #fff;
    }

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
<h1>Accessibility
statement for the <a href="https://pointsofarrival.is.ed.ac.uk/">Points of Arrival</a></h1>
</p>
<p>

</p>
<p>Website accessibility statement inline with Public Sector Body (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018</p>
<p>

{{-- change URL --}}
</p>
<p>This accessibility statement applies to:</p>
<p><a href="https://pointsofarrival.is.ed.ac.uk/">https://pointsofarrival.is.ed.ac.uk/</a>
</p>

<p>
</p>

{{--The site may not be in full control. If it isn't, the below is likely incorrect and will need to be edited--}}

<p>This website is run by Library and University Collections, Information Services Group at the University of Edinburgh. We want as many people as possible to be
able to use this application. For example, that means you should be
able to:</p>
<p>

{{--This sections varies. Check the items listed below match with the approved Statement - add/delete items as necessary --}}

</p>
<ul>
<li>Change most colours and contrast levels.</li>
<li>Navigate most of the website using just a keyboard.</li>
<li>Listen to most of the website using a screen reader (including the most recent versions of JAWS, NVDA and VoiceOver).</li>
<li>Navigate most of the site using voice recognition software, e.g. Dragon.</li>
<li>Experience no time limits when using the website.</li>
<li>Use the site without encountering any scrolling, flashing or moving text.</li>
</ul>
<p>

</p>
<p>We’ve also made the website text as simple as possible to understand.</p>
<p>

</p>
<h2>Customising the website</h2>
<p>
AbilityNet
has advice on making your device easier to use if you have a
disability. This is an external site with suggestions to make your
computer more accessible:</p>
<p>

</p>
<p><a href="https://mcmw.abilitynet.org.uk/">AbilityNet
- My Computer My Way</a></p>
<p>

</p>
<p>With
a few simple steps you can customise the appearance of our website
using your browser settings to make it easier to read and navigate:</p>
<p>

</p>
<p><a href="https://www.ed.ac.uk/about/website/accessibility/customising-site" target="Customising our site">Additional
information on how to customise our website appearance</a></p>
<p>

</p>
<p>If
you are a member of University staff or a student, you can use the free SensusAccess accessible document conversion service:</p>
<p>

</p>
<p><a href="https://disability-learning-support-service.ed.ac.uk/staff/accessible-design-and-inclusive-learning-resources">Information
on SensusAccess</a></p>
<p>

</p>
<h2>How accessible this website is</h2>
<p>

</p>
<p>We know some parts of this website are not fully accessible:</p>
<p>

</p>

{{--This section varies according to the site. Edit as appropriate--}}

<ul>
<li>Some images do not have alternative text</li>
<li>Videos do not provide a corresponding transcript alongside their captions</li>
<li>The site is not properly navigable in both portrait and landscape orientation for mobile users</li>
<li>Videos do not have audio descriptions</li>
<li>Content cannot be magnified to 200% without issue</li>
<li>Overlaps and distortions occur at higher magnification levels</li>
<li>Images of text are used in place of actual text</li>
<li>Reflow does not operate correctly up to 400%</li>
<li>No Skip to Content option is available for keyboard users</li>
<li>Not all hyperlinks are formatted correctly with meaningful hypertext</li>
<li>A correct heading structure is not used</li>
<li>Keyboard order does not follow a logical sequence, e.g. some links require more than one tab to navigate</li>
<li>The site is not fully compatible with assistive software</li>
</ul>
<p>

</p>
<h2>Feedback and contact information</h2>
<p>

</p>
<p>If
you need information on this website in a different format, including
accessible PDF, large print, audio recording or braille:
</p>

{{--You may need to change the contact details if the site is not within the control of L&UC--}}


<ul>
	<li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
	<li>Telephone: +44 (0)131 651 5151</li>
	<li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/">IS Helpline online contact form</a></li>
	<li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/">Contact
Scotland BSL</a>, the on-line BSL interpreting service
</ul>

<p>We’ll consider your request and get back to you in 5 working days.</p>
<p>

</p>
<h2>Reporting accessibility problems with this website</h2>
<p>
We are always looking to improve the accessibility of this website. If
you find any problems not listed on this page, or think we’re not
meeting accessibility requirements, please contact:&nbsp;


</p>

{{--You may need to change the contact details if the site is not within the control of L&UC--}}

<ul>
	<li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
	<li>Telephone: +44 (0)131 651 5151</li>
	<li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/">IS Helpline online contact form</a></li>
	<li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/">Contact
Scotland BSL</a>, the on-line BSL interpreting service.
</ul>
<p>We
will consider your request and get back to you in 5 working days.</p>
<p>

</p>
<h2>Enforcement procedure</h2>
<p>
The
Equality and Human Rights Commission (EHRC) is responsible for
enforcing the Public Sector Bodies (Websites and Mobile Applications)
(No. 2) Accessibility Regulations 2018 (the ‘accessibility
regulations’). If you’re not happy with how we respond to your
complaint please contact the Equality Advisory and Support Service
(EASS) directly:</p>
<p>

</p>
<p><a href="https://www.equalityadvisoryservice.com/">Contact
details for the Equality Advisory and Support Service (EASS)</a></p>
<p>

</p>
<p>The
government has produced information on how to report accessibility
issues:</p>
<p>

</p>
<p><a href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website">Reporting
an accessibility problem on a public sector website</a></p>
<p>

</p>
<h2>Contacting us by phone using British Sign Language</h2>
<p>
British
Sign Language service</p>
<p>Contact
Scotland BSL runs a service for British Sign Language users and all
of Scotland’s public bodies using video relay. This enables sign
language users to contact public bodies and vice versa. The service
operates from 8.00am to 12.00am, 7 days a week.</p>
<p><a href="https://contactscotland-bsl.org/">Contact
Scotland BSL service details.</a></p>
<p>


</p>
<h2>Technical information about this website’s accessibility</h2>
<p>The
University of Edinburgh is committed to making its websites and
applications accessible, in accordance with the Public Sector Bodies
(Websites and Mobile Applications) (No. 2) Accessibility Regulations
2018.</p>
<p>

</p>
<h2>Compliance Status</h2>
<p>This website is partially compliant with the Web Content Accessibility Guidelines (WCAG) 2.2 AA standard, due to the non-compliances listed below.</p>
<p>

</p>
<p>The
full guidelines are available at:</p>
<p>

</p>
<p><a href="https://www.w3.org/TR/WCAG22/">Web
Content Accessibility Guidelines (WCAG) 2.2 AA standard</a></p>
<p>

</p>
<h2>Non accessible content</h2>
<p>

</p>
<p>The
content listed below is non-accessible for the following reasons.</p>
<p></p>
<h3>Noncompliance with the accessibility regulations


</h3>
<p>The
following items to not comply with the WCAG 2.2 AA success criteria:</p>
<p>

</p>
<p>

</p>


{{--Add sections which apply to this statement--}}
{{--Maintain the formatting of the items, as shown below in the examples below--}}


    <ul><li>Not all images have meaningful alternative text<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#non-text-content">1.1.1 – Non-text Content</a></p>

    <ul><li>Videos do not provide a corresponding transcript in addition to their captions<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#audio-only-and-video-only-prerecorded">1.2.1 – Audio-only and Video-only (Prerecorded)</a></p>

    <ul><li>Videos do not have audio descriptions<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#audio-description-prerecorded">1.2.5 – Audio Description (Prerecorded)</a></p>

    <ul><li>The site is not properly navigable in both portrait and landscape orientation for mobile users<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#orientation">1.3.4 – Orientation</a></p>

    <ul><li>Keyboard tab order does not always follow a meaningful sequence<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#meaningful-sequence">1.3.2 – Meaningful Sequence</a></p>

    <ul><li>Keyboard tab order does not always follow a meaningful sequence<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#focus-order">2.4.3 – Focus Order</a></p>

    <ul><li>Content cannot be magnified without issue to a minimum of 200%<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#resize-text">1.4.4 – Resize Text</a></p>

    <ul><li>Images of text are used in place of actual text<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#images-of-text">1.4.5 – Images of Text</a></p>

    <ul><li>Reflow does not operate correctly to 400%<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#reflow">1.4.10 – Reflow</a></p>

    <ul><li>No Skip to Content option is available for keyboard users<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#bypass-blocks">2.4.1 – Bypass Blocks</a></p>

    <ul><li>Links do not have meaningful hypertext<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#link-purpose-in-context">2.4.4 – Link Purpose (In Context)</a></p>

    <ul><li>A correct heading structure is not used<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#headings-and-labels">2.4.6 – Headings and Labels</a></p>

    <ul><li>Overlaps and distortions occur at higher magnification levels<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#focus-not-obscured-minimum">2.4.11 – Focus Not Obscured (Minimum)</a></p>

    <ul><li>The site is not fully compatible with assistive software<p></li></ul>
	<p><a href="https://www.w3.org/TR/WCAG22/#name-role-value">4.1.2 – Name, Role, Value</a></p>

	


<p>We
aim to improve our websites accessibility on a regular and continuous
basis. See the section below ('What we're doing to improve
accessibility') on how we are improving our site accessibility. 
</p>
<p>

{{--The site may not be in full control. If it isn't, the below is likely incorrect--}}
{{--Add DATE_FOR_IMPROVEMENTS = Date Statement was approved + 11 months--}}
</p>
<p>We
are working towards solving these problems and expect significant
improvements by September 2027. The site is fully within our control.</p>
<p>

{{--The statement may make claims of disproportionate burden, double-check that it matches below--}}

</p>
<h3>Disproportionate burden</h3>
<p>
We
are not currently claiming that any accessibility problems would be a
disproportionate burden to fix.</p>
<p>

{{--The statement may make claims of not within scope of regulations, double-check that it matches below--}}

</p>
<h3>Content that’s not within the scope of the accessibility regulations</h3>
<p>

</p>
<p>At
this time we believe no content is outwith the scope of the accessibility regulations.</p>
<p>

</p>
<h2>What we’re doing to improve accessibility</h2>
<p>

</p>

{{--The site may not be in full control. If it isn't, the below is likely incorrect--}}
{{--Add DATE_FOR_IMPROVEMENTS = Date Statement was approved + 11 months--}}

<p>We
will continue to address and make significant improvements to the
accessibility issues highlighted. Unless specified otherwise, a
complete solution or significant improvement will be in place by September 2027.
<p>

</p>
<p>While
we are in the process of resolving these accessibility issues we will
ensure reasonable adjustments are in place to make sure no user is
disadvantaged. As changes are made, we will continue to review
accessibility and retest the accessibility of this website.</p>
<p>

</p>
<p>

{{--Add the required dates to this section--}}
{{--FIRST_STATEMENT_DATE = the date of the FIRST version of this statement--}}
{{--LAST_REVIEW_DATE = the date this version of the statement was approved by Viki's team --}}
{{--TESTING_DATE = the date this version of the statement was tested.  If it was tested over multiple days then use the last day--}}

</p>
<h2>Preparation of this accessibility statement</h2>
<p><b>This statement was prepared on 2nd March 2023. It was last reviewed on 24th August 2026.</b></p> 

<p><b>The website was last tested on 18 August 2026. The
testing was carried out by Library
and University Collections, Information Services Group at the University of Edinburgh</b> using
both automated and manual methods. The site was tested on a PC,
primarily using Microsoft Edge alongside Mozilla Firefox and Google
Chrome.</p>
<p>

</p>
<p>Recent
world-wide usage levels survey for different screen readers and
browsers shows that Chrome, Mozilla Firefox and Microsoft Edge are
increasing in popularity and Google Chrome is now the favoured
browser for screen readers:</p>
<p>

</p>
<p><a href="https://webaim.org/projects/screenreadersurvey10/">WebAIM:
Screen Reader User Survey</a></p>
<p>

</p>
<p>The
aforementioned three browsers have been used in certain questions for
reasons of breadth and variety.</p>
<p>

</p>
<p>We
ran automated testing using <a href="https://www.deque.com/axe/devtools/chrome-browser-extension/">AXE Devtools</a> and
then manual testing that included:</p>

{{--Check the items on the list below match with the approved statement - add/delete as appropriate--}}

<ul>
	<li>Spell
	check functionality;</li>
	<li>Scaling
	using different resolutions and reflow;</li>
	<li>Options
	to customise the interface (magnification, font, background colour,
	etc);</li>
	<li>Keyboard
	navigation and keyboard traps;</li>
	<li>Data
	validation;</li>
	<li>Warning
	of links opening in new tab or window;</li>
	<li>Information
	conveyed in the colour or sound only;</li>
	<li>Flashing,
	moving or scrolling text;</li>
	<li>Operability if JavaScript is disabled;</li>
	<li>Use
	with screen reading software (for example JAWS);</li>
	<li>Assistive
	software (TextHelp Read and Write, Windows Magnifier, ZoomText,
	Dragon Naturally Speaking, TalkBack and VoiceOver);</li>
	<li>Tooltips
	and text alternatives for any non-text content;</li>
	<li>Time
	limits;</li>
	<li>Compatibility
	with mobile accessibility functionality (Android and iOS);</li>
	<li>Any
	drag functionality and alternatives;</li>
	<li>Consistent
	help function;</li>
	<li>Submission and re-entry of data;</li>
	<li>Any
	cognitive tests.
	</li>
</ul>

{{--Delete the entire Change Log section if this is the first manual test - i.e. no fixes have been implemented--}}
{{--The fixes should be grouped by date.  They should contain a description of the fix and the WCAG element referred to - see example below. Entries should follow the same format as below--}}

<h2>Change Log</h2>
<p>
Since our initial report, we have undertaken more extensive manual testing with assistive software to get a better understanding of the accessibility issues on this website. This section will receive updates as and when accessibility improvements are made to the website.</p>
<h3>DATE OF FIX(ES)</h3>
<p>
</p>
    <ul>
	<li>Ensured that all links are underlined.
		<p><a href="https://www.w3.org/TR/WCAG22/#use-of-color">1.4.1 – Use of Colour</a></p></li>
	<li>Ensured the focus outline is visible throughout the page.
		<p><a href="https://www.w3.org/TR/WCAG22/#focus-visible">2.4.7 – Focus Visible</a></p></li>
	<li>Ensured that links that open in a new tab have an indication that they do so.
		<p><a href="https://www.w3.org/TR/WCAG22/#on-input">3.2.2 – On Input</a></p></li>
	</ul>
<p>
</p>
            </div>
        </div>
    </div>
</div>
@endsection
