@extends('layouts.physics')

@section('title', 'School of Physics and Astronomy Image Archive - Accessibility')

@section('content')
<div class="content byEditor">

{{-- Word-exported HTML preserved verbatim from the legacy SOPA site so the migrated accessibility statement is byte-for-byte identical (per Skylight). The outer <html>/<head>/<body> scaffolding is dropped (Blade layout already provides it) and one broken relative link to a local Outlook cache path has been replaced with the canonical WCAG 2.2 anchor. The block is wrapped in @verbatim to stop Blade interpreting the CSS @font-face / @page at-rules as directives. --}}

@verbatim

<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:"Calibri Light";
	panose-1:2 15 3 2 2 2 4 3 2 4;}
@font-face
	{font-family:"DengXian Light";
	panose-1:2 1 6 0 3 1 1 1 1 1;}
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;}
@font-face
	{font-family:"\@DengXian Light";}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	font-size:17.0px;
	font-family:"Calibri",sans-serif;}
h1
	{mso-style-link:"Heading 1 Char";
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	page-break-after:avoid;
	font-size:16.0pt;
	font-family:"Calibri Light",sans-serif;
	color:#2F5496;
	font-weight:normal;
	line-height: 1.1;}
h2
	{mso-style-link:"Heading 2 Char";
	margin-top:2.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	page-break-after:avoid;
	font-size:13.0pt;
	font-family:"Calibri Light",sans-serif;
	color:#2F5496;
	font-weight:normal;}
h3
	{mso-style-link:"Heading 3 Char";
	margin-top:2.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	page-break-after:avoid;
	font-size:17.0px;
	font-family:"Calibri Light",sans-serif;
	color:#1F3763;
	font-weight:normal;}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-link:"Title Char";
	margin:0in;
	font-size:28.0pt;
	font-family:"Calibri Light",sans-serif;
	letter-spacing:-.5pt;}
p.MsoTitleCxSpFirst, li.MsoTitleCxSpFirst, div.MsoTitleCxSpFirst
	{mso-style-link:"Title Char";
	margin:0in;
	font-size:28.0pt;
	font-family:"Calibri Light",sans-serif;
	letter-spacing:-.5pt;}
p.MsoTitleCxSpMiddle, li.MsoTitleCxSpMiddle, div.MsoTitleCxSpMiddle
	{mso-style-link:"Title Char";
	margin:0in;
	font-size:28.0pt;
	font-family:"Calibri Light",sans-serif;
	letter-spacing:-.5pt;}
p.MsoTitleCxSpLast, li.MsoTitleCxSpLast, div.MsoTitleCxSpLast
	{mso-style-link:"Title Char";
	margin:0in;
	font-size:28.0pt;
	font-family:"Calibri Light",sans-serif;
	letter-spacing:-.5pt;}
a:link, span.MsoHyperlink
	{color:#0563C1;
	text-decoration:underline;}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	font-size:17.0px;
	font-family:"Calibri",sans-serif;}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	font-size:17.0px;
	font-family:"Calibri",sans-serif;}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	font-size:17.0px;
	font-family:"Calibri",sans-serif;}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	font-size:17.0px;
	font-family:"Calibri",sans-serif;}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	mso-style-link:"Heading 1";
	font-family:"Calibri Light",sans-serif;
	color:#2F5496;}
span.Heading2Char
	{mso-style-name:"Heading 2 Char";
	mso-style-link:"Heading 2";
	font-family:"Calibri Light",sans-serif;
	color:#2F5496;}
span.Heading3Char
	{mso-style-name:"Heading 3 Char";
	mso-style-link:"Heading 3";
	font-family:"Calibri Light",sans-serif;
	color:#1F3763;}
span.TitleChar
	{mso-style-name:"Title Char";
	mso-style-link:Title;
	font-family:"Calibri Light",sans-serif;
	letter-spacing:-.5pt;}
span.secno
	{mso-style-name:secno;}
.MsoChpDefault
	{font-size:17.0px;
	font-family:"Calibri",sans-serif;}
@page WordSection1
	{size:595.0pt 842.0pt;
	margin:1.0in 1.0in 1.0in 1.0in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>


<div class=WordSection1>

<p class=MsoTitle><b><span lang=EN style='font-size:20.0pt;font-family:"Arial;line-height:1.1;",sans-serif'>Accessibility
statement for </span></b><span lang=EN-GB><a
href="https://sopacollection.ph.ed.ac.uk/"><b><span style='font-size:20.0pt;line-height:1.1;
font-family:"Arial",sans-serif;color:#0563C1;letter-spacing:0pt;border:none windowtext 1.0pt;
padding:0in'>School of Physics and Astronomy Image Archive (SOPA)</span></b></a></span></p>

<p class=MsoNormal><span lang=EN>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>Website
accessibility statement in line with Public Sector Body (Websites and Mobile
Applications) (No. 2) Accessibility Regulations 2018</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>This
accessibility statement applies to:</span></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://sopacollection.ph.ed.ac.uk/"><span style='font-family:"Arial",sans-serif'>https://sopacollection.ph.ed.ac.uk/</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>This
website is run by the School of Physics and Astronomy, University of Edinburgh.
We want as many people as possible to be able to use this application. For
example, that means you should be able to:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span lang=EN-GB
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Access
the site without a cognitive function test</span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Change the
majority of colours and contrast level</span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Magnify
the site to 500%</span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Experience
no time limits to accessing content</span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Experience
no flashing, scrolling or moving content </span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Interact
with site content without the need for dragging movements </span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Navigate
most of the website using just a keyboard</span></p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span lang=EN-GB
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Navigate
most of the website using speech recognition software</span></p>

<ul style='margin-top:0in' type=disc>
 <li class=MsoNormal style='margin-bottom:8.0pt;line-height:107%'><span
     lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp; &nbsp;Listen to most of the website
     using a screen reader (including the most recent versions of JAWS,
    TalkBack and VoiceOver)</span></li>
</ul>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We’ve
also made the website text as simple as possible to understand. However, some
of our content is technical, and we use technical terms where there is no
easier wording we could use without changing what the text means.</span></p>
<h1><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Customising
  the website</span></h1>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>AbilityNet has advice on making your device easier to use if you have a
disability. This is an external site with suggestions to make your computer
more accessible:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a href="https://mcmw.abilitynet.org.uk/"><span
style='font-family:"Arial",sans-serif;color:#346DBF;background:white'>AbilityNet
- My Computer My Way</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>With
a few simple steps you can customise the appearance of our website using your
browser settings to make it easier to read and navigate:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://www.ed.ac.uk/about/website/accessibility/customising-site"
title="Customising our site"><span style='font-family:"Arial",sans-serif;
color:#346DBF;background:white'>Additional information on how to customise our
website appearance</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>If
you are a member of University staff or a student, you can use the free
SensusAccess accessible document conversion service:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://www.ed.ac.uk/student-disability-service/staff/supporting-students/accessible-technology"><span
style='font-family:"Arial",sans-serif;color:#346DBF;background:white'>Information
on SensusAccess</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>How
accessible this website is</span></h2>
<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We
  know some parts of this website are not fully accessible:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpFirst style='margin-bottom:10.0pt;text-align:justify;
text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some
colours on our pages (particularly buttons, menus and tables) do not meet
current colour contrast recommendations</span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>The site
is not fully compatible with browser customisation, which means some user control
and functionality is lost</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There is
no reflow to 400% magnification so users have to scroll horizontally as well as
vertically</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some non-text
items have missing alt text descriptions </span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all
the controls on video content are focusable </span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Videos do
not display on Android mobile devices</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all
audio-visual content has transcripts, human-corrected captions or audio
descriptions</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some
links are not formatted correctly as meaningful hypertext</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some information
is conveyed by colour alone</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some
links open in a new tab or window without warning</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There is
no ‘Skip to main content’ button</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There are
missing headings and labels which affects navigation with screen reading
software</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>It can be
hard to tell where you have navigated to using the keyboard</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
contact email link does not appear in a consistent position or on every page</span></p>

<p class=MsoListParagraphCxSpLast><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Feedback
and contact information</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>If
you need information on this website in a different format, including
accessible PDF, large print, audio recording or braille:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpFirst style='margin-bottom:8.0pt;text-indent:-.25in;
line-height:107%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Use the
IS Helpline online contact form </span><span lang=EN-GB><a
href="https://www.ishelpline.ed.ac.uk/forms/"><span style='font-family:"Arial",sans-serif'>IS
Helpline contact form</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:8.0pt;text-indent:
-.25in;line-height:107%'><span class=MsoHyperlink><span lang=EN-GB
style='font-family:Symbol;color:windowtext;text-decoration:none'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Email
</span><span lang=EN-GB><a href="mailto:information.systems@ed.ac.uk"><span
style='font-family:"Arial",sans-serif'>Information.systems@ed.ac.uk</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:8.0pt;text-indent:
-.25in;line-height:107%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Call </span><span
lang=EN-GB style='font-family:"Arial",sans-serif'>+44 (0)131 651 5151</span></p>

<p class=MsoListParagraphCxSpLast style='margin-bottom:7.5pt;text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>British
Sign Language (BSL) users can contact us via </span><span lang=EN-GB><a
href="http://contactscotland-bsl.org/"><span style='font-family:"Arial",sans-serif'>Contact</span></a></span><span
class=MsoHyperlink><span lang=EN-GB style='font-family:"Arial",sans-serif'>
Scotland BSL</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif;
color:#333333'>, </span><span lang=EN-GB style='font-family:"Arial",sans-serif'>the
on-line BSL interpreting service.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We’ll
consider your request and get back to you in 5 working days.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Reporting
accessibility problems with this website</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We are always looking to improve the accessibility of this website. If you find
any problems not listed on this page, or think we’re not meeting accessibility
requirements, please contact:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpFirst style='margin-bottom:8.0pt;text-indent:-.25in;
line-height:107%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Use the
IS Helpline online contact form </span><span lang=EN-GB><a
href="https://www.ishelpline.ed.ac.uk/forms/"><span style='font-family:"Arial",sans-serif'>IS
Helpline contact form</span></a></span></p>

<p class=MsoListParagraphCxSpFirst style='margin-bottom:8.0pt;text-indent:-.25in;
line-height:107%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Email
</span><span lang=EN-GB><a href="mailto:information.systems@ed.ac.uk"><span
style='font-family:"Arial",sans-serif'>Information.systems@ed.ac.uk</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:8.0pt;text-indent:
-.25in;line-height:107%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Call </span><span
lang=EN-GB style='font-family:"Arial",sans-serif'>+44 (0)131 651 5151</span></p>

<p class=MsoListParagraphCxSpLast style='margin-bottom:7.5pt;text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>British
Sign Language (BSL) users can contact us via </span><span lang=EN-GB><a
href="http://contactscotland-bsl.org/"><span style='font-family:"Arial",sans-serif'>Contact</span></a></span><span
class=MsoHyperlink><span lang=EN-GB style='font-family:"Arial",sans-serif'>
Scotland BSL</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif;
color:#333333'>, </span><span lang=EN-GB style='font-family:"Arial",sans-serif'>the
on-line BSL interpreting service.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We’ll
consider your request and get back to you in 5 working days.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Enforcement
procedure</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The Equality and Human Rights Commission (EHRC) is responsible for enforcing
the Public Sector Bodies (Websites and Mobile Applications) (No. 2)
Accessibility Regulations 2018 (the ‘accessibility regulations’). If you’re not
happy with how we respond to your complaint please contact the Equality
Advisory and Support Service (EASS) directly:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://www.equalityadvisoryservice.com/"><span style='font-family:"Arial",sans-serif'>Contact
details for the Equality Advisory and Support Service (EASS)</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
government has produced information on how to report accessibility issues:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://www.gov.uk/reporting-accessibility-problem-public-sector-website"><span
style='font-family:"Arial",sans-serif;color:#346DBF;background:white'>Reporting
an accessibility problem on a public sector website</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Contacting
us by phone using British Sign Language</span></h2>

<p class=MsoNormal style='margin-top:15.0pt;margin-right:0in;margin-bottom:
7.5pt;margin-left:0in'><span lang=EN style='font-size:14.0pt;font-family:"Arial",sans-serif;
color:black'>British Sign Language service</span></p>

<p class=MsoNormal style='margin-bottom:7.5pt'><span lang=EN style='font-family:
"Arial",sans-serif'>Contact Scotland BSL runs a service for British Sign
Language users and all of Scotland’s public bodies using video relay. This
enables sign language users to contact public bodies and vice versa. The
service operates from 8.00am to 12.00am, 7 days a week.</span></p>

<p class=MsoNormal style='margin-bottom:7.5pt'><span lang=EN-GB><a
href="https://contactscotland-bsl.org/"><span lang=EN style='font-family:"Arial",sans-serif'>Contact
Scotland BSL service details</span><span lang=EN style='font-family:"Arial",sans-serif;
color:#333333;text-decoration:none'>.</span></a></span></p>

<p class=MsoNormal style='margin-bottom:7.5pt'><span lang=EN-GB
style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Technical
information about this website’s accessibility</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
University of Edinburgh is committed to making its websites and applications
accessible, in accordance with the Public Sector Bodies (Websites and Mobile
Applications) (No. 2) Accessibility Regulations 2018.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-size:14.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN style='font-size:16.0pt;font-family:"Arial",sans-serif'>Compliance
Status</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>This
website is partially compliant with the Web Content Accessibility Guidelines (WCAG)
2.2 AA standard, due to the non-compliances listed below.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
full guidelines are available at:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/"><span
style='font-family:"Arial",sans-serif;color:#346DBF;background:white'>Web
Content Accessibility Guidelines (WCAG) 2.2 AA standard</span></a></span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Non
accessible content</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
content listed below is non-accessible for the following reasons.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h3><b><span lang=EN-GB style='font-family:"Arial",sans-serif'>Noncompliance
with the accessibility regulations<br>
</span></b></h3>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
following items do not comply with the WCAG 2.2 AA success criteria:</span></p>

<p class=MsoNormal><span lang=EN-GB>&nbsp;</span></p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span lang=EN-GB
style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all
non-text items have alternative text </span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
class=MsoHyperlink><span lang=EN-GB style='font-family:"Courier New";
color:windowtext;text-decoration:none'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#non-text-content"><span style='font-family:
"Arial",sans-serif'>1.1.1 Non-text Content</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all
video content has a transcript, human-corrected captions or audio description</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#audio-only-and-video-only-prerecorded"><span
style='font-family:"Arial",sans-serif'>1.2.1 Audio-only and Video-only
(Prerecorded)</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#captions-prerecorded"><span
style='font-family:"Arial",sans-serif'>1.2.2 Captions (Prerecorded)</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#audio-description-prerecorded"><span
style='font-family:"Arial",sans-serif'>1.2.5 Audio Description (Prerecorded)</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some
actionable hyperlinks are shown by colour only</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span class=MsoHyperlink><span lang=EN-GB style='font-family:
"Courier New";color:windowtext;text-decoration:none'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#use-of-color"><span style='font-family:
"Arial",sans-serif'>1.4.1 Use of Colour</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There may
not be sufficient contrast between font and background colour, especially on
buttons, menus and tables</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span lang=EN-GB style='font-family:"Courier New"'>o<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#contrast-minimum"><span
style='font-family:"Arial",sans-serif'>1.4.3 Contrast (Minimum)</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
lang=EN-GB style='font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all text
can be scaled effectively up to 200% without distortion</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#resize-text"><span style='font-family:"Arial",sans-serif'>1.4.4
Resize Text</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in'><span lang=EN-GB
style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>When the
browser zoom is used to scale content to 400%, it does not reflow</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span lang=EN-GB style='font-family:"Courier New"'>o<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#reflow"><span
style='font-family:"Arial",sans-serif'>1.4.10 Reflow</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There is
no ‘Skip to main content’ option to avoid sections such as headers or
navigation links that are repeated on multiple pages </span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#bypass-blocks"><span style='font-family:
"Arial",sans-serif'>2.4.1 Bypass Blocks</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Not all
links are formatted correctly as meaningful hypertext</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span lang=EN-GB style='font-family:"Courier New"'>o<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#link-purpose-in-context"><span
style='font-family:"Arial",sans-serif'>2.4.4 Link Purpose (In Context)</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>There are
missing headings and labels which can hinder finding and navigating content</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
class=MsoHyperlink><span lang=EN-GB style='font-family:"Courier New";
color:windowtext;text-decoration:none'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span></span><span lang=EN-GB><a
href="https://www.w3.org/TR/WCAG22/#headings-and-labels"><span
style='font-family:"Arial",sans-serif'>2.4.6 Headings and Labels</span></a></span></p>

<p class=MsoListParagraph style='text-indent:-17.85pt;line-height:107%'><span
lang=EN-GB style='line-height:107%;font-family:Symbol;color:black'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
keyboard focus indicator </span><span class=secno><span lang=EN-GB
style='line-height:107%;font-family:"Arial",sans-serif;color:black'>is not
always clearly discernible due to poor colour contrast and weight</span></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span lang=EN-GB style='font-family:"Courier New"'>o<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#focus-visible"><span
style='font-family:"Arial",sans-serif'>2.4.7 Focus Visible</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-indent:
-.25in;line-height:115%'><span lang=EN-GB style='font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>Some
links open in a new tab or window without warning</span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-indent:-.25in;line-height:115%'><span
lang=EN-GB style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span><span lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#on-input"><span
style='font-family:"Arial",sans-serif'>3.2.2 On Input</span></a></span></p>

<p class=MsoListParagraphCxSpMiddle style='margin-bottom:10.0pt;text-align:
justify;text-indent:-.25in;line-height:115%'><span lang=EN-GB style='font-family:
Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
contact email link does not appear on every page in the same place</span></p>

<p class=MsoListParagraphCxSpLast style='margin-top:0in;margin-right:0in;
margin-bottom:10.0pt;margin-left:1.0in;text-align:justify;text-indent:-.25in;
line-height:115%'><span lang=EN-GB style='font-family:"Courier New"'>o<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span><span
lang=EN-GB><a href="https://www.w3.org/TR/WCAG22/#consistent-help"><span
style='font-family:"Arial",sans-serif'>3.2.6 Consistent Help</span></a></span></p>


<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We
aim to improve our websites accessibility on a regular and continuous basis.
See the section below ('What we're doing to improve accessibility') on how we
are improving our site accessibility. </span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We
are working towards solving these problems and expect several improvements by
September 2024. The site is fully within our control.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Disproportionate
burden</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>
We are not currently claiming that any accessibility problems would be a
disproportionate burden to fix.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h3><span lang=EN-GB style='font-size:18.0pt;font-family:"Arial",sans-serif'>Content
that’s not within the scope of the accessibility regulations</span></h3>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>At
this time we believe no content is outwith the scope of the accessibility
regulations.</span></p>

<p class=MsoNormal><span lang=EN-GB>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>What
we’re doing to improve accessibility</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We
will continue to address and make adequate improvements to the accessibility
issues highlighted. Unless specified otherwise, a complete solution or
significant improvement will be in place by September 2024. </span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>While
we are in the process of resolving these accessibility issues we will ensure
reasonable adjustments are in place to make sure no user is disadvantaged. As
changes are made, we will continue to review accessibility and retest the
accessibility of this website.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Preparation
of this accessibility statement
</span></h2>

<p class=MsoNormal><b><span lang=EN-GB style='font-family:"Arial",sans-serif; font-weight:bold;'>This
statement was prepared on 19<sup>th</sup> March 2024. It was last reviewed on 25th
March 2024.</span></b></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><b><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
website was last tested on 11<sup>th</sup> March 2024. The testing was carried
out by The University Library and University Collections Digital Library team at
the University of Edinburgh </span></b><span lang=EN-GB style='font-family:
"Arial",sans-serif'>using both automated and manual methods. The site was
tested on a PC, primarily using Microsoft Edge alongside Mozilla Firefox and
Google Chrome.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>Recent
world-wide usage levels survey for different screen readers and browsers shows
that Chrome, Mozilla Firefox and Microsoft Edge are increasing in popularity
and Google Chrome is now the favoured browser for screen readers:</span></p>

<p class=MsoNormal><u><span lang=EN-GB style='font-family:"Arial",sans-serif'><span
 style='text-decoration:none'>&nbsp;</span></span></u></p>

<p class=MsoNormal><span lang=EN-GB><a
href="https://webaim.org/projects/screenreadersurvey9/"><span style='font-family:
"Arial",sans-serif'>WebAIM: Screen Reader User Survey</span></a></span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>The
aforementioned three browsers have been used in certain questions for reasons
of breadth and variety.</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>We
ran automated testing using </span><span lang=EN-GB><a
href="https://wave.webaim.org/"><span style='font-family:"Arial",sans-serif'>WAVE
WebAIM</span></a></span><span lang=EN-GB style='font-family:"Arial",sans-serif'>
and then manual testing that included:</span></p>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<ul style='margin-top:0in' type=disc>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Spell check functionality;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Scaling using different resolutions
     and reflow;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Options to customise the interface
     (magnification, font, background colour, etc);</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Keyboard navigation and keyboard
     traps;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Data validation;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Warning of links opening in new tab
     or window;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Information conveyed in colour or
     sound only;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Flashing, moving or scrolling text;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Use with screen reading software
     (for example JAWS);</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Assistive software (TextHelp Read
     and Write, Windows Magnifier, ZoomText, Dragon Naturally Speaking,
     TalkBack and VoiceOver);</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Tooltips and text alternatives for
     any non-text content;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Time limits;</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Compatibility with mobile
     accessibility functionality (Android and iOS).</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Any drag functionality and
     alternatives</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Consistent help function</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>No need to re enter data already
     submitted</span></li>
 <li class=MsoNormal style='line-height:107%'><span lang=EN-GB
     style='font-family:"Arial",sans-serif'>Any cognitive tests </span></li>
</ul>

<p class=MsoNormal style='margin-left:.5in;line-height:107%'><span lang=EN-GB
style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.5in;line-height:107%'><span lang=EN-GB
style='font-family:"Arial",sans-serif'>&nbsp;</span></p>

<h2><span lang=EN-GB style='font-size:20.0pt;font-family:"Arial",sans-serif'>Change
Log</span></h2>

<p class=MsoNormal><span lang=EN-GB style='font-family:"Arial",sans-serif;
color:black'>Since our first evaluation and statement, which was based on
automated testing only, we have undertaken extensive manual testing. This
includes utilising a range of assistive technology to ensure we have a clearer
picture of the accessibility issues and how best to resolve them.</span></p>

</div>

@endverbatim

</div>

@endsection
