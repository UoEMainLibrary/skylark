@extends('layouts.app')

@section('title', 'Accessibility Statement - University of Edinburgh Collections')

@push('styles')
<style type="text/css">
    #content, .tab-heading, .navbar, footer {
        display: none;
    }
    
    .accessibility-content {
        margin-top: 50px;
        margin-bottom: 50px;
        padding: 25px;
    }
    
    .accessibility-content h1, 
    .accessibility-content h2, 
    .accessibility-content h3 {
        color: #2f5496;
        margin-bottom: 0.5cm;
    }
    
    .accessibility-content h1 {
        font-size: 24pt;
    }
    
    .accessibility-content h2 {
        font-size: 20pt;
    }
    
    .accessibility-content h3 {
        font-size: 16pt;
    }
    
    .accessibility-content a:link, 
    .accessibility-content a:visited {
        color: #0563c1;
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="container accessibility-content">
    <h1>Accessibility statement for <a href="https://collections.ed.ac.uk/">Collections</a></h1>

    <p>Website accessibility statement inline with Public Sector Body (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018</p>

    <p>This accessibility statement applies to:</p>
    <p><a href="https://collections.ed.ac.uk/">https://collections.ed.ac.uk/</a></p>

    <p>This website is run by the Library and University Collections Directorate which is part of Information Services Group at the University of Edinburgh. We want as many people as possible to be able to use this application. For example, that means you should be able to:</p>

    <ul>
        <li>Change most colours and contrast levels</li>
        <li>Magnify text to 200%</li>
        <li>Experience no cognitive test</li>
        <li>Experience no time limits when using the website</li>
    </ul>

    <p>We've also made the website text as simple as possible to understand. However, some of our content is technical, and we use technical terms where there is no easier wording we could use without changing what the text means.</p>

    <h2>Customising the website</h2>

    <p>AbilityNet has advice on making your device easier to use if you have a disability. This is an external site with suggestions to make your computer more accessible:</p>

    <p><a href="https://mcmw.abilitynet.org.uk/" target="_blank">AbilityNet - My Computer My Way <span class="sr-only">(opens in a new tab)</span></a></p>

    <p>With a few simple steps you can customise the appearance of our website using your browser settings to make it easier to read and navigate:</p>

    <p><a href="https://www.ed.ac.uk/about/website/accessibility/customising-site" target="_blank">Additional information on how to customise our website appearance <span class="sr-only">(opens in a new tab)</span></a></p>

    <p>If you are a member of University staff or a student, you can use the free SensusAccess accessible document conversion service:</p>

    <p><a href="https://www.ed.ac.uk/student-disability-service/staff/supporting-students/accessible-technology" target="_blank">Information on SensusAccess <span class="sr-only">(opens in a new tab)</span></a></p>

    <h2>How accessible this website is</h2>

    <p>We know some parts of this website are not fully accessible:</p>

    <ul>
        <li>There are examples of text as images for logos</li>
        <li>Several images do not have any or informative alternative text</li>
        <li>Reflow is not operational to 400%</li>
        <li>Some new tab/windows and pop ups open without alerting the user</li>
        <li>Not all hyperlinks are formatted with meaningful hypertext</li>
        <li>There are some instances of colour contrast issues on the site</li>
        <li>Not all content can be reached by keyboard navigation alone</li>
        <li>Headings are not properly coded and some heading levels are skipped</li>
        <li>Some information is conveyed by colour only</li>
        <li>There is some moving content which cannot be paused or stopped by user</li>
        <li>No transcript or human corrected captions are present for the audio-visual content</li>
        <li>Not all videos have audio description</li>
        <li>Screen readers are not fully compatible with the site</li>
        <li>Voice recognition software is not fully compatible with the site</li>
        <li>Some portable document format (PDF) files are not fully accessible</li>
    </ul>

    <h2>Feedback and contact information</h2>

    <p>If you need information on this website in a different format, including accessible PDF, large print, audio recording or braille:</p>

    <ul>
        <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
        <li>Telephone: +44 (0)131 651 5151</li>
        <li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/" target="_blank">IS Helpline online contact form <span class="sr-only">(opens in a new tab)</span></a></li>
        <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank">Contact Scotland BSL <span class="sr-only">(opens in a new tab)</span></a>, the on-line BSL interpreting service</li>
    </ul>

    <p>We'll consider your request and get back to you in 5 working days.</p>

    <h2>Reporting accessibility problems with this website</h2>

    <p>We are always looking to improve the accessibility of this website. If you find any problems not listed on this page, or think we're not meeting accessibility requirements, please contact:</p>

    <ul>
        <li>Email: <a href="mailto:Information.systems@ed.ac.uk">Information.systems@ed.ac.uk</a></li>
        <li>Telephone: +44 (0)131 651 5151</li>
        <li>Use the <a href="https://www.ishelpline.ed.ac.uk/forms/" target="_blank">IS Helpline online contact form <span class="sr-only">(opens in a new tab)</span></a></li>
        <li>British Sign Language (BSL) users can contact us via <a href="https://contactscotland-bsl.org/" target="_blank">Contact Scotland BSL <span class="sr-only">(opens in a new tab)</span></a>, the on-line BSL interpreting service</li>
    </ul>

    <p>We will consider your request and get back to you in 5 working days.</p>

    <h2>Enforcement procedure</h2>

    <p>The Equality and Human Rights Commission (EHRC) is responsible for enforcing the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018 (the 'accessibility regulations'). If you're not happy with how we respond to your complaint please contact the Equality Advisory and Support Service (EASS) directly:</p>

    <p><a href="https://www.equalityadvisoryservice.com/" target="_blank">Contact details for the Equality Advisory and Support Service (EASS) <span class="sr-only">(opens in a new tab)</span></a></p>

    <p>The government has produced information on how to report accessibility issues:</p>

    <p><a href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website" target="_blank">Reporting an accessibility problem on a public sector website <span class="sr-only">(opens in a new tab)</span></a></p>

    <h2>Contacting us by phone using British Sign Language Service</h2>

    <p>Contact Scotland BSL runs a service for British Sign Language users and all of Scotland's public bodies using video relay. This enables sign language users to contact public bodies and vice versa. The service operates from 8.00am to 12.00am, 7 days a week.</p>

    <p><a href="https://contactscotland-bsl.org/" target="_blank">Contact Scotland BSL service details <span class="sr-only">(opens in a new tab)</span></a></p>

    <h2>Technical information about this website's accessibility</h2>

    <p>The University of Edinburgh is committed to making its websites and applications accessible, in accordance with the Public Sector Bodies (Websites and Mobile Applications) (No. 2) Accessibility Regulations 2018.</p>

    <h2>Compliance Status</h2>

    <p>This website is partially compliant with the Web Content Accessibility Guidelines (WCAG) 2.2 AA standard, due to the non-compliances listed below.</p>

    <p>The full guidelines are available at:</p>

    <p><a href="https://www.w3.org/TR/WCAG22/" target="_blank">Web Content Accessibility Guidelines (WCAG) 2.2 AA standard <span class="sr-only">(opens in a new tab)</span></a></p>

    <h2>Non accessible content</h2>

    <p>The content listed below is non-accessible for the following reasons.</p>

    <h3>Noncompliance with the accessibility regulations</h3>

    <p>The following items do not comply with the WCAG 2.2 AA success criteria. For full details, please refer to the complete accessibility statement available from the Information Services helpdesk.</p>

    <h2>What we're doing to improve accessibility</h2>

    <p>We are committed to making this website accessible and will continue to audit the website and address any issues identified.</p>

    <h2>Preparation of this accessibility statement</h2>

    <p>This statement was prepared in accordance with regulations. It was last reviewed in 2024.</p>

    <p>This website was last tested in 2024. Testing was carried out by the University of Edinburgh Library and University Collections team using both automated and manual testing methods.</p>
</div>
@endsection
