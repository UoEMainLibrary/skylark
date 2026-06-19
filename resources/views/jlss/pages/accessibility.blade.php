@extends('layouts.jlss')

@section('title', 'Accessibility - Jewish Lives Scottish Spaces')

@section('content')
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

    .accessibility-statement a:link,
    .accessibility-statement a:visited {
        color: #0563c1 !important;
        text-decoration: underline;
    }

    .accessibility-statement ul {
        list-style-type: disc;
        margin-left: 1.5em;
        padding-left: 0.5em;
    }

    .accessibility-statement ul ul { list-style-type: circle; }
    .accessibility-statement ol { list-style-type: decimal; margin-left: 1.5em; padding-left: 0.5em; }
    .accessibility-statement li { margin-bottom: 0.1cm; }
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="content byEditor accessibility-statement">
        <h1>Accessibility statement for the <a href="{{ \App\Support\CollectionUrl::url() }}">Scottish Jewish Archives Centre (SJAC) Digital Collection</a></h1>

        <p>Website accessibility statement inline with Public Sector Body (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018</p>

        <p>This accessibility statement applies to:</p>
        <p><a href="{{ \App\Support\CollectionUrl::url() }}">{{ \App\Support\CollectionUrl::url() }}/</a></p>

        <p>This website is run by Library and University Collections, Information Services Group at the University of Edinburgh. We want as many people as possible to be able to use this application. For example, that means you should be able to:</p>

        <ul>
            <li>Change colours, contrast levels and fonts</li>
            <li>Magnify content to 500%</li>
            <li>Navigate most of the application using just a keyboard</li>
            <li>Navigate most of the website using speech recognition software</li>
            <li>Listen to most of the application using a screen reader (including the most recent versions of JAWS, NVDA and VoiceOver)</li>
            <li>Experience no time limits when using the site</li>
            <li>Not encounter any flashing, scrolling or moving text</li>
        </ul>

        <p>We&rsquo;ve also made the website text as simple as possible to understand.</p>

        <h2>Customising the website</h2>

        <p>AbilityNet has advice on making your device easier to use if you have a disability. This is an external site with suggestions to make your computer more accessible:</p>
        <p><a href="https://mcmw.abilitynet.org.uk/" target="_blank" rel="noopener">AbilityNet &mdash; My Computer My Way</a></p>

        <p>With a few simple steps you can customise the appearance of our website using your browser settings to make it easier to read and navigate:</p>
        <p><a href="https://www.ed.ac.uk/about/website/accessibility/customising-site" target="_blank" rel="noopener">Additional information on how to customise our website appearance</a></p>

        <p>If you are a member of University staff or a student, you can use the free SensusAccess accessible document conversion service:</p>
        <p><a href="https://www.ed.ac.uk/student-disability-service/staff/supporting-students/accessible-technology" target="_blank" rel="noopener">Information on SensusAccess</a></p>

        <h2>How accessible this website is</h2>

        <p>We know some parts of this website are not fully accessible:</p>
        <ul>
            <li>There are colour contrast errors present on the site</li>
            <li>Reflow is not enabled to 400%</li>
            <li>Not all images have meaningful alternative text</li>
            <li>Some information is conveyed by colour only</li>
            <li>Not all content can be reached by keyboard navigation alone and it can be difficult to tell where you have navigated to when using a keyboard only. Keyboard navigation does not always follow a logical order</li>
            <li>No skip to main content button on some of the webpages</li>
            <li>New tabs or windows open without alerting the user</li>
            <li>Pop-ups open without alerting the user</li>
            <li>Some URLs have no title HTML attribute, making Screen Readers read out the hyperlink&rsquo;s full URL, even though the user does not see a naked URL</li>
            <li>Not all headings are formatted correctly to be recognised by Screen Readers</li>
            <li>Tooltips do not appear when navigating with keyboard only, or with assistive software</li>
        </ul>

        <h2>Feedback and contact information</h2>

        <p>If you need information on this website in a different format, including accessible PDF, large print, audio recording or braille:</p>
        <ul>
            <li>Email: <a href="mailto:info@sjac.org.uk">info@sjac.org.uk</a></li>
            <li>Telephone: +44 (0)131 650 2600 (Tue-Sat)</li>
            <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL</a>, the on-line BSL interpreting service.</li>
        </ul>

        <p>We&rsquo;ll consider your request and get back to you in 5 working days.</p>

        <h2>Reporting accessibility problems with this website</h2>

        <p>We are always looking to improve the accessibility of this website. If you find any problems not listed on this page, or think we&rsquo;re not meeting accessibility requirements, please contact:</p>
        <ul>
            <li>Email: <a href="mailto:info@sjac.org.uk">info@sjac.org.uk</a></li>
            <li>Telephone: +44 (0)131 650 2600 (Tue-Sat)</li>
            <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL</a>, the on-line BSL interpreting service.</li>
        </ul>

        <p>We&rsquo;ll consider your request and get back to you in 5 working days.</p>

        <h2>Enforcement procedure</h2>

        <p>The Equality and Human Rights Commission (EHRC) is responsible for enforcing the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018 (the &lsquo;accessibility regulations&rsquo;). If you&rsquo;re not happy with how we respond to your complaint please contact the Equality Advisory and Support Service (EASS) directly:</p>
        <p><a href="https://www.equalityadvisoryservice.com/" target="_blank" rel="noopener">Contact details for the Equality Advisory and Support Service (EASS)</a></p>

        <p>The government has produced information on how to report accessibility issues:</p>
        <p><a href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website" target="_blank" rel="noopener">Reporting an accessibility problem on a public sector website</a></p>

        <h2>Contacting us by phone using British Sign Language</h2>

        <p>British Sign Language service</p>
        <p>Contact Scotland BSL runs a service for British Sign Language users and all of Scotland&rsquo;s public bodies using video relay. This enables sign language users to contact public bodies and vice versa. The service operates from 8.00am to 12.00am, 7 days a week.</p>
        <p><a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL service details</a></p>

        <h2>Technical information about this website&rsquo;s accessibility</h2>

        <p>The University of Edinburgh is committed to making its websites and applications accessible, in accordance with the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>

        <h3>Compliance status</h3>

        <p>This website is partially compliant with the Web Content Accessibility Guidelines (WCAG) 2.2 AA standard, due to the non-compliances listed below.</p>
        <p>The full guidelines are available at:</p>
        <p><a href="https://www.w3.org/TR/WCAG22/" target="_blank" rel="noopener">Web Content Accessibility Guidelines (WCAG) 2.2 AA standard</a></p>

        <h3>Non accessible content</h3>

        <p>The content listed below is non-accessible for the following reasons.</p>

        <h3>Noncompliance with the accessibility regulations</h3>

        <p>The following items to not comply with the WCAG 2.2 AA success criteria:</p>
        <ul>
            <li>Not all non-text items have alternative text
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#non-text-content" target="_blank" rel="noopener">1.1.1 &mdash; Non-text Content</a></li>
                </ul>
            </li>
            <li>Keyboard navigation does not always follow a logical order
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#meaningful-sequence" target="_blank" rel="noopener">1.3.2 &mdash; Meaningful Sequence</a></li>
                </ul>
            </li>
            <li>Some hyperlinks and headings are conveyed with colour only
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#use-of-color" target="_blank" rel="noopener">1.4.1 &mdash; Use of Color</a></li>
                </ul>
            </li>
            <li>There were several colour contrast issues
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#contrast-minimum" target="_blank" rel="noopener">1.4.3 &mdash; Contrast (Minimum)</a></li>
                </ul>
            </li>
            <li>Reflow is not enabled to 400%
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#reflow" target="_blank" rel="noopener">1.4.10 &mdash; Reflow</a></li>
                </ul>
            </li>
            <li>Not all content can be reached by keyboard
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#keyboard-accessible" target="_blank" rel="noopener">2.1.1 &mdash; Keyboard Accessible</a></li>
                </ul>
            </li>
            <li>No skip to main content button is enabled on some pages of the site
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#bypass-blocks" target="_blank" rel="noopener">2.4.1 &mdash; Bypass Blocks</a></li>
                </ul>
            </li>
            <li>Some links do not contain meaningful hypertext to inform the user of their target location
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#link-purpose-in-context" target="_blank" rel="noopener">2.4.4 &mdash; Link Purpose in Context</a></li>
                </ul>
            </li>
            <li>Headings are not formatted correctly, which affects screen reader software
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#headings-and-labels" target="_blank" rel="noopener">2.4.6 &mdash; Headings and Labels</a></li>
                </ul>
            </li>
            <li>The focus indicator is not clearly visible
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#focus-visible" target="_blank" rel="noopener">2.4.7 &mdash; Focus Visible</a></li>
                </ul>
            </li>
            <li>Some hyperlinks open link in new tab/window, and some popups do not alert the user this will happen
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#on-input" target="_blank" rel="noopener">3.2.2 &mdash; On Input</a></li>
                </ul>
            </li>
            <li>The website is not fully compatible with assistive software as not all items are coded correctly
                <ul>
                    <li><a href="https://www.w3.org/TR/WCAG22/#name-role-value" target="_blank" rel="noopener">4.1.2 &mdash; Name, Role, Value</a></li>
                </ul>
            </li>
        </ul>

        <p>We aim to improve our websites accessibility on a regular and continuous basis. See the section below (&lsquo;What we&rsquo;re doing to improve accessibility&rsquo;) on how we are improving our site accessibility.</p>
        <p>We are working towards solving these problems and expect significant improvements by February 2025. The site is fully within our control</p>

        <h3>Disproportionate burden</h3>

        <p>We are not currently claiming that any accessibility problems would be a disproportionate burden to fix.</p>

        <h3>Content that&rsquo;s not within the scope of the accessibility regulations</h3>

        <p>At this time, we believe no content is outwith the scope of the accessibility regulations.</p>

        <h2>What we&rsquo;re doing to improve accessibility</h2>

        <p>We will continue to address and make improvements to the accessibility issues highlighted. Unless specified otherwise, a complete solution or significant improvement will be in place by February 2025.</p>
        <p>While we are in the process of resolving these accessibility issues we will ensure reasonable adjustments are in place to make sure no user is disadvantaged. As changes are made, we will continue to review accessibility and retest the accessibility of this website.</p>

        <h2>Preparation of this accessibility statement</h2>

        <p><strong>This statement was prepared on 15 September 2021. It was last reviewed on 14 March 2024.</strong></p>
        <p><strong>The website was last tested in February 2024. The testing was carried out by Library and University Collections, Information Services Group at the University of Edinburgh</strong> using both automated and manual methods. The site was tested on a PC, primarily using Microsoft Edge alongside Mozilla Firefox and Google Chrome.</p>

        <p>Recent world-wide usage levels survey for different screen readers and browsers shows that Chrome, Mozilla Firefox and Microsoft Edge are increasing in popularity and Google Chrome is now the favoured browser for screen readers:</p>
        <p><a href="https://webaim.org/projects/screenreadersurvey9/" target="_blank" rel="noopener">WebAIM: Screen Reader User Survey</a></p>

        <p>The aforementioned three browsers have been used in certain questions for reasons of breadth and variety.</p>

        <p>We ran automated testing using <a href="https://wave.webaim.org/" target="_blank" rel="noopener">WAVE WebAIM</a> and then manual testing that included:</p>
        <ul>
            <li>Spell check functionality;</li>
            <li>Scaling using different resolutions and reflow;</li>
            <li>Options to customise the interface (magnification, font, background colour, etc);</li>
            <li>Keyboard navigation and keyboard traps;</li>
            <li>Data validation;</li>
            <li>Warning of links opening in new tab or window;</li>
            <li>Information conveyed in the colour or sound only;</li>
            <li>Flashing, moving or scrolling text;</li>
            <li>Operability if JavaScript is disabled;</li>
            <li>Use with screen reading software (for example JAWS);</li>
            <li>Assistive software (TextHelp Read and Write, Windows Magnifier, ZoomText, Dragon Naturally Speaking, TalkBack and VoiceOver);</li>
            <li>Tooltips and text alternatives for any non-text content;</li>
            <li>Time limits;</li>
            <li>Compatibility with mobile accessibility functionality (Android and iOS).</li>
        </ul>
    </div>
</div>
@endsection
