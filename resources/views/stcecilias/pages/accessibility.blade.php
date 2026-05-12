@extends('layouts.stcecilias')

@section('title', "Accessibility Statement — St Cecilia's Hall")

@section('body_class', 'accessibility')

@section('content')
    <div class="container-fluid">
        <div class="content byEditor accessibility-statement">
            <h1>Accessibility statement for <a href="{{ url('/stcecilias') }}">St Cecilia&rsquo;s Hall</a></h1>

            <p>Website accessibility statement inline with Public Sector Body (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>

            <p>This accessibility statement applies to: <a href="{{ url('/stcecilias') }}">{{ url('/stcecilias') }}/</a></p>

            <p>This website is run by the Library and University Collections Directorate, Information Services Group at the University of Edinburgh. We want as many people as possible to be able to use this application. For example, that means you should be able to:</p>
            <ul>
                <li>Use browser settings to change colours, contrast levels and fonts</li>
                <li>Navigate most of the website using just a keyboard</li>
                <li>Listen to most of the website using a screen reader (including the most recent versions of JAWS, NVDA and VoiceOver)</li>
                <li>Navigate most of the site using voice recognition software (e.g. Dragon NaturallySpeaking)</li>
                <li>Experience no time limits when using the website</li>
                <li>Use the site without encountering any scrolling, flashing or moving text</li>
            </ul>

            <p>We&rsquo;ve also made the website text as simple as possible to understand. However, some of our content is technical, and we use technical terms where there is no easier wording we could use without changing what the text means.</p>

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
                <li>Not all link purposes are clear to the user;</li>
                <li>Not all non-text content presented to users has alternative text;</li>
                <li>Not all colour contrasts meet the recommended Web Content Accessibility Guidelines 2.1 AA standard;</li>
                <li>Users may not be able to access all content by using the keyboard alone;</li>
                <li>The site is not fully compatible with assistive software such as voice recognition software or screen reader software;</li>
                <li>You cannot magnify the site above 240% without text overlapping;</li>
                <li>Reflow is not enabled to 400% on all content;</li>
                <li>There are PDFs that are not fully accessible;</li>
                <li>Some headings are coded incorrectly and some heading levels are missed.</li>
            </ul>

            <h2>Feedback and contact information</h2>
            <p>If you need information on this website in a different format, including accessible portable document format (PDF), large print, audio recording or braille:</p>
            <ul>
                <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
                <li>Telephone: +44 (0)131 651 5151</li>
                <li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/" target="_blank" rel="noopener">IS Helpline online contact form</a></li>
                <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL</a>, the on-line BSL interpreting service.</li>
            </ul>
            <p>We&rsquo;ll consider your request and get back to you in 5 working days.</p>

            <h2>Reporting accessibility problems with this website</h2>
            <p>We are always looking to improve the accessibility of this website. If you find any problems not listed on this page, or think we&rsquo;re not meeting accessibility requirements, please contact:</p>
            <ul>
                <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
                <li>Telephone: +44 (0)131 651 5151</li>
                <li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/" target="_blank" rel="noopener">IS Helpline online contact form</a></li>
                <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL</a>, the on-line BSL interpreting service.</li>
            </ul>
            <p>We&rsquo;ll consider your request and get back to you in 5 working days.</p>

            <h2>Enforcement procedure</h2>
            <p>The Equality and Human Rights Commission (EHRC) is responsible for enforcing the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018 (the &lsquo;accessibility regulations&rsquo;). If you&rsquo;re not happy with how we respond to your complaint please contact the Equality Advisory and Support Service (EASS) directly:</p>
            <p><a href="https://www.equalityadvisoryservice.com/" target="_blank" rel="noopener">Contact details for the Equality Advisory and Support Service (EASS)</a></p>
            <p>The government has produced information on how to report accessibility issues:</p>
            <p><a href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website" target="_blank" rel="noopener">Reporting an accessibility problem on a public sector website</a></p>

            <h2>Contacting us by phone using British Sign Language</h2>
            <p>British Sign Language service: Contact Scotland BSL runs a service for British Sign Language users and all of Scotland&rsquo;s public bodies using video relay. This enables sign language users to contact public bodies and vice versa. The service operates from 8.00am to 12.00am, 7 days a week.</p>
            <p><a href="https://contactscotland-bsl.org/" target="_blank" rel="noopener">Contact Scotland BSL service details.</a></p>

            <h2>Technical information about this website&rsquo;s accessibility</h2>
            <p>The University of Edinburgh is committed to making its websites and applications accessible, in accordance with the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>

            <h2>Compliance status</h2>
            <p>This website is partially compliant with the Web Content Accessibility Guidelines (WCAG) 2.2 AA standard, due to the non-compliances listed below.</p>
            <p>The full guidelines are available at: <a href="https://www.w3.org/TR/WCAG22/" target="_blank" rel="noopener">Web Content Accessibility Guidelines (WCAG) 2.2 AA standard</a></p>

            <h2>Non-accessible content</h2>
            <p>The content listed below is non-accessible for the following reasons.</p>

            <h3>Non-compliance with the accessibility regulations</h3>
            <ul>
                <li>Not all non-text content presented to users has alternative text. (<a href="https://www.w3.org/TR/WCAG22/#non-text-content" target="_blank" rel="noopener">1.1.1 &mdash; Non-text Content</a>)</li>
                <li>Information, structure and relationships conveyed through presentation cannot always be programmatically determined. This includes missing heading tags. (<a href="https://www.w3.org/TR/WCAG22/#info-and-relationships" target="_blank" rel="noopener">1.3.1 &mdash; Info and Relationships</a>, <a href="https://www.w3.org/TR/WCAG22/#headings-and-labels" target="_blank" rel="noopener">2.4.6 &mdash; Headings and Labels</a>)</li>
                <li>There may not be sufficient colour contrast between font and background colours. (<a href="https://www.w3.org/TR/WCAG22/#contrast-minimum" target="_blank" rel="noopener">1.4.3 &mdash; Contrast (Minimum)</a>)</li>
                <li>It is not possible to magnify all content to 200% without loss of content. (<a href="https://www.w3.org/TR/WCAG22/#resize-text" target="_blank" rel="noopener">1.4.4 &mdash; Resize text</a>)</li>
                <li>When pages are magnified the content does not reflow. (<a href="https://www.w3.org/TR/WCAG22/#reflow" target="_blank" rel="noopener">1.4.10 &mdash; Reflow</a>)</li>
                <li>Some tooltips, which appear on mouse hover, do not do so when using the keyboard to navigate. (<a href="https://www.w3.org/TR/WCAG22/#content-on-hover-or-focus" target="_blank" rel="noopener">1.4.13 &mdash; Content on Hover or Focus</a>)</li>
                <li>It is not possible to use a keyboard to access all the content. (<a href="https://www.w3.org/TR/WCAG22/#keyboard" target="_blank" rel="noopener">2.1.1 &mdash; Keyboard</a>)</li>
                <li>Some of our page titles do not fully describe the page content and some pages are missing titles. (<a href="https://www.w3.org/TR/WCAG22/#page-titled" target="_blank" rel="noopener">2.4.2 &mdash; Page Titled</a>)</li>
                <li>The purpose of each link cannot be determined from the text alone. (<a href="https://www.w3.org/TR/WCAG22/#link-purpose-in-context" target="_blank" rel="noopener">2.4.4 &mdash; Link Purpose (In Context)</a>)</li>
                <li>Mobile touch targets are less than 9mm by 9mm apart. (<a href="https://www.w3.org/TR/WCAG22/#target-size" target="_blank" rel="noopener">2.5.5 &mdash; Target Size</a>)</li>
                <li>There are missing labels present in the website that fail to describe the purpose of the input form. (<a href="https://www.w3.org/TR/WCAG22/#labels-or-instructions" target="_blank" rel="noopener">3.3.2 &mdash; Labels or Instructions</a>)</li>
                <li>The site is not fully compatible with assistive software such as screen readers or voice recognition software, e.g. elements do not only use supported ARIA attributes. (<a href="https://www.w3.org/TR/WCAG22/#name-role-value" target="_blank" rel="noopener">4.1.2 &mdash; Name, Role, Value</a>)</li>
                <li>There are PDFs that are not fully accessible. (<a href="https://www.w3.org/TR/WCAG22/#keyboard" target="_blank" rel="noopener">2.1.1 &mdash; Keyboard</a>, <a href="https://www.w3.org/TR/WCAG22/#name-role-value" target="_blank" rel="noopener">4.1.2 &mdash; Name, Role, Value</a>)</li>
            </ul>

            <p>We aim to improve our website&rsquo;s accessibility on a regular and continuous basis. See the section below (&lsquo;What we&rsquo;re doing to improve accessibility&rsquo;) on how we are improving our site accessibility.</p>
            <p>We are working towards solving these problems and expect significant improvements by June 2026. The site is fully within our control.</p>

            <h3>Disproportionate burden</h3>
            <p>We are not currently claiming that any accessibility problems would be a disproportionate burden to fix.</p>

            <h3>Content that&rsquo;s not within the scope of the accessibility regulations</h3>
            <p>At this time we believe no content is outwith the scope of the accessibility regulations.</p>

            <h2>What we&rsquo;re doing to improve accessibility</h2>
            <p>We will continue to address and make significant improvements to the accessibility issues highlighted. Unless specified otherwise, a complete solution or significant improvement will be in place by June 2026.</p>
            <p>While we are in the process of resolving these accessibility issues we will ensure reasonable adjustments are in place to make sure no user is disadvantaged. As changes are made, we will continue to review accessibility and retest the accessibility of this website.</p>

            <h2>Preparation of this accessibility statement</h2>
            <p><strong>This statement was prepared on 10th September 2020. It was last reviewed on 15th July 2025.</strong></p>
            <p><strong>The website was last tested on 15th June 2025. The testing was carried out by Library and University Collections, Information Services Group at the University of Edinburgh</strong> using both automated and manual methods. The site was tested on a PC, primarily using Microsoft Edge alongside Mozilla Firefox and Google Chrome.</p>
            <p>Recent world-wide usage levels survey for different screen readers and browsers shows that Chrome, Mozilla Firefox and Microsoft Edge are increasing in popularity and Google Chrome is now the favoured browser for screen readers:</p>
            <p><a href="https://webaim.org/projects/screenreadersurvey9/" target="_blank" rel="noopener">WebAIM: Screen Reader User Survey</a></p>
            <p>The aforementioned three browsers have been used in certain questions for reasons of breadth and variety.</p>
            <p>We ran automated testing using <a href="https://www.deque.com/axe/devtools/chrome-browser-extension/" target="_blank" rel="noopener">AXE Devtools</a> and then manual testing that included:</p>
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
                <li>Compatibility with mobile accessibility functionality (Android and iOS);</li>
                <li>Any drag functionality and alternatives;</li>
                <li>Consistent help function;</li>
                <li>Submission and re-entry of data;</li>
                <li>Any cognitive tests.</li>
            </ul>

            <h2>Change Log</h2>
            <p>Since the previous test, the following fixes were implemented in August 2024 based on the manual testing done.</p>
            <ul>
                <li>The search bar colour contrast issues have been resolved to meet WCAG 2.2 AA standards. (16/08/2024). This partially but does not fully resolve the error: <a href="https://www.w3.org/TR/WCAG22/#contrast-minimum" target="_blank" rel="noopener">1.4.3 &mdash; Contrast (Minimum)</a></li>
                <li>Changed the text alignment from justified to left aligned (16/08/2024). <a href="https://www.w3.org/TR/WCAG22/#visual-presentation" target="_blank" rel="noopener">1.4.8 &mdash; Visual Presentation</a></li>
                <li>Added a skip to main content button on each page. (16/08/2024). <a href="https://www.w3.org/TR/WCAG22/#bypass-blocks" target="_blank" rel="noopener">2.4.1 &mdash; Bypass Blocks</a></li>
                <li>Implemented a consistent, high contrast focus highlighter function website wide. (16/08/2024). <a href="https://www.w3.org/TR/WCAG22/#focus-visible" target="_blank" rel="noopener">2.4.7 &mdash; Focus Visible</a></li>
                <li>Added a popup to notify users that a new tab is about to be opened after clicking on a link. (16/08/2024). <a href="https://www.w3.org/TR/WCAG22/#on-input" target="_blank" rel="noopener">3.2.2 &mdash; On Input</a></li>
                <li>Removed the transparency of the text over images. (16/08/2024).</li>
                <li>Increased font size to at least 12pt. (16/08/2024).</li>
            </ul>
        </div>
    </div>
@endsection
