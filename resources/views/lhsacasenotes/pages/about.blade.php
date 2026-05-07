@extends('layouts.lhsacasenotes')

@section('title', 'About - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="content byEditor">
        <h1 class="itemtitle">Case note cataloguing at LHSA</h1>

        <p>Modern archival case records are rich resources for medical humanities researchers, clinicians and genealogists
            alike, giving context to ground-breaking procedures and telling fascinating stories about the development of
            medical care in the twentieth century. Case notes are collected documents produced during the treatment and
            care of a particular patient. Loose notes in folders superseded the use of bound books from the mid-1920s,
            and they record the progress of patients in a range of ways, from typed summaries and charts to
            handwritten notes, x-rays, photographs, drawings and letters.</p>

        <p>Despite case notes&rsquo; potential as academic resources, their research use to date has been limited. Researchers
            can be deterred by case notes&rsquo; physical condition (often housed in original folders), the sheer number of
            records produced, time-consuming searches for a particular category of data and case notes&rsquo; extremely specialist
            medical language. Confidentiality restrictions on modern health records also mean that potential researchers
            have to meet strict conditions for access even for scoping purposes. Previous grants from the Wellcome Trust
            have rehoused many of LHSA's most significant collections of
            <a href="http://www.lhsa.lib.ed.ac.uk/conservation/conserv_case_notes.htm" title="Case Notes" target="_blank" rel="noopener">case notes</a>,
            removing physical barriers to their access. LHSA&rsquo;s case note cataloguing aims to remove more intellectual hurdles.</p>

        <p>Funded by the Wellcome Trust, in 2012 LHSA began a
            <a href="http://www.lhsa.lib.ed.ac.uk/projects/Cataloguingcasenotes.htm" title="Cataloguing Case Notes" target="_blank" rel="noopener">project</a> to catalogue
            over 26,500 cases created by renowned Edinburgh neurosurgeon, Norman Dott.
            <i>Cataloguing Norman Dott&rsquo;s neurosurgical case notes (1920 &ndash; 1960)</i> developed a methodology that describes each
            case in language accessible to researchers from different backgrounds whilst protecting patient privacy. Using
            the Encoded Archival Description (EAD) eXtensible Mark-up Language (XML) standard along with tailored index terms
            enables confidential data to be hidden from a public, online catalogue whilst emphasising other, non-identifying
            details for search.</p>

        <p>When LHSA was awarded a further Wellcome Trust Research Resources grant in 2013, the same methodology was used
            to describe cases from a very different specialism. <i>RVH v TB: a project to catalogue LHSA&rsquo;s Royal Victoria Hospital
            Tuberculosis and Diseases of the Chest Case Notes and Registers</i> will catalogue over 24,000 individual cases
            treated in the Royal Victoria Hospital, in its dispensary and sanatoriums and in the Scottish Mass Miniature
            Radiography (MMR) campaigns of 1957 and 1958. Although the cataloguing methodology remains basically the same
            as that used for Dott&rsquo;s cases, the nature of tuberculosis means that certain details are emphasised above
            others for search.</p>

        <h1>Contact Details</h1>
        <p>For further information please contact:</p>
        <p><strong>Lothian Health Services Archive</strong><br>
            Centre for Research Collections<br>
            University of Edinburgh<br>
            Main Library<br>
            30 George Square<br>
            Edinburgh,<br>
            EH8 9LJ<br>
            Tel: 0131 650 3392<br>
            Email: <a class="email" href="mailto:lhsa@ed.ac.uk">lhsa@ed.ac.uk</a><br/>
        </p>
    </div>
</div>

@include('lhsacasenotes.partials.sidebar')
@endsection
