@extends('layouts.lhsacasenotes')

@section('title', 'Catalogues - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="content byEditor">
        <h1 class="itemtitle">How to use the catalogues</h1>

        <p>You can access LHSA's case note catalogues from these pages.</p>

        <h3>Norman Dott&rsquo;s Neurosurgical Case Notes (1920 &ndash; 1960)</h3>
        <p>There are four main groups (or series) of case notes created by Norman Dott:</p>
        <ul>
            <li>Private practice and early Royal Infirmary of Edinburgh case notes (LHB1 CC/20/PR1)</li>
            <li>Royal Infirmary of Edinburgh, Ward 20 case notes (LHB1 CC/24/PR2)</li>
            <li>Filed by Disease case notes, Royal Infirmary of Edinburgh (LHB1 CC/22/PR4)</li>
            <li>Second World War case notes from Bangour General (Emergency Medical Service) Hospital (LHB40 CC/2/PR3)</li>
        </ul>

        <p>The catalogue description for each series of case notes describes the historical context behind the files and the types of documents represented in them.</p>

        <p>Different language is used in different parts of the case descriptions to make them as accessible as possible.
            Medical conditions are described in modern clinical terms taken from the
            <a href="https://www.nlm.nih.gov/mesh/MBrowser.html" title="MESH" target="_blank" rel="noopener">Medical Subject Headings thesaurus (MeSH)</a>
            as &lsquo;Subjects&rsquo;, whereas medical conditions are expressed in terms from the case notes themselves in the
            &lsquo;Scope and Contents&rsquo; part of the description. For example, a male patient might be described as suffering
            from &lsquo;fainting&rsquo; in the text of the case notes (recorded in the &lsquo;Scope and Contents&rsquo; part of the catalogue entry),
            but in the &lsquo;Subject&rsquo; field, we would describe his condition as &lsquo;Syncope&rsquo; (the modern medical term used for fainting).
        </p>

        <p>Catalogues can be searched by subject, covering medical condition and general type of
            treatment received, also visible in menus at the side of the screen. Clicking on a subject will take you to
            a list of catalogue entries which mention this condition or treatment. You can also search by mention of
            notable medical practitioners.
        </p>

        <img src="{{ asset('collections/lhsacasenotes/images/confused_man.gif') }}" alt="Confused Man" class="img-responsive pull-right img-rounded" />

        <p>In the public catalogues, there are certain aspects of the descriptions that have been removed to protect
            the anonymity of patients &ndash; these include the name of each patient and (in some cases) their occupation.
            We can reveal other details about each case, since it would be hard to identify the patient from those factors
            &ndash; such as their age in years (rather than their date of birth) or whether they are male or female. Sometimes,
            a form of information &ndash; such as medical condition &ndash; can be revealed in certain circumstances
            (the occurrence of a common type of brain tumour would not in itself identify someone), but not others
            (a rare, genetic condition might easily be linked to a particular individual).
        </p>

        <p>Confidential, unredacted catalogues have also been produced, which can be viewed by legitimate researchers
            who meet strict conditions on the use of patient-identifiable data. Access to the unredacted catalogue and
            to physical confidential case notes is determined by means of an application to NHS Lothian through the
            LHSA Archivist. These highly confidential resources can only be consulted in person in our reading room in
            the Centre for Research Collections, University of Edinburgh. Please contact us at
            <a href="mailto:lhsa@ed.ac.uk" title="LHSA Email Address">lhsa@ed.ac.uk</a> for further details.</p>
    </div>
</div>

@include('lhsacasenotes.partials.sidebar')
@endsection
