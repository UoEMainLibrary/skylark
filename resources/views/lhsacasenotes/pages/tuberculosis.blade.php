@extends('layouts.lhsacasenotes')

@section('title', 'Tuberculosis - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="content byEditor">
        <h1 class="itemtitle">Tuberculosis and Diseases of the Chest Case Notes at Lothian Health Services Archive</h1>

        <p>In the 1880s, Edinburgh clinician Robert W Philip (1857-1939) was at the forefront of finding a holistic solution to the
            city&rsquo;s deadly tuberculosis problem. Philip pioneered a scheme, known as the Edinburgh Scheme, which took a three-strand
            approach to tackling the disease through prevention, detection, and treatment. In 1887, from just three rooms in Bank Street,
            Edinburgh, he set up the Royal Victoria Dispensary with the idea that tuberculosis patients and their whole families must be
            sought out for examination and followed up by nurses and health visitors.</p>

        <img src="{{ asset('collections/lhsacasenotes/images/Image_1.jpg') }}" alt="Anti tuberculosis measures" class="img-responsive" />

        <p>In the years following, specialist hospitals (such as the Royal Victoria Hospital and Southfield Sanatorium) were built
            where patients could either recuperate or (in the case of the City Hospital) be separated from the general population if their cases were very serious.
            Until the development of antibiotics (1940s), treatment involved bed-rest and exercise. Artificial
            pneumothorax (the surgical collapse of a lung), drug therapies and chemotherapy were added as the years went on.</p>

        <img src="{{ asset('collections/lhsacasenotes/images/Image_11.jpg') }}" alt="Covered Shelter in Grounds" class="img-responsive" />

        <p>The 1950s saw major breakthroughs in treatment. In 1950, the Royal Victoria Dispensary started to administer the BCG
            vaccine to children and young adults. A few years later, University of Edinburgh medic John Crofton (1912-2009) pioneered
            a tripartite combination of drugs which, combined with strict supervision, achieved a 100% cure rate in patients. Doctors
            were also looking out for early signs of tuberculosis with screening campaigns based on Mass Miniature Radiography (MMR) &ndash;
            small x-ray apparatus in vans which could travel to different areas to screen the population for tuberculosis and ensure
            that potentially ill patients could be followed up. Edinburgh&rsquo;s MMR campaign was in 1958, and screened nearly 85% of the
            city&rsquo;s population.</p>

        <img src="{{ asset('collections/lhsacasenotes/images/MMR_badge.jpg') }}" alt="MMR Badge" class="img-responsive pull-right img-circle" />

        <p>The history of Edinburgh&rsquo;s crusade against tuberculosis is reflected in case note collections from the Royal Victoria
            Dispensary, Hospital and Tuberculosis Trust (RVH) held by LHSA, from early treatments in Southfield Sanatorium in the
            1920s to 1950s&rsquo; clinics at the Royal Victoria Dispensary and the call-up letters and follow-up case notes from the 1958
            city-wide MMR campaign. Each one of these cases has been catalogued.</p>

        <p>There are five main groups (or series) of case notes in the catalogues:</p>
        <ul>
            <li>Royal Victoria Tuberculosis Trust, Southfield Sanatorium case files (LHB41 CC/1)</li>
            <li>Royal Victoria Dispensary for Diseases of the Chest case files (LHB41 CC/2)</li>
            <li>Regional Hospital Board National X-Ray Campaign letters (LHB41 CC/3)</li>
            <li>Regional Hospital Board National X-Ray Campaign follow-up case notes (LHB41 CC/3a)</li>
            <li>Royal Victoria Dispensary for Diseases of the Chest case files (LHB41 CC/4)</li>
        </ul>

        <p>Cases have been catalogued using LHSA&rsquo;s <a href="{{ url('/lhsacasenotes/about') }}" title="methodology">methodology</a>
            developed for neurosurgical case notes. However, adaptations have been made to reflect the infectious nature of tuberculosis: the location of a patient is recorded in slightly
            more detail, using Westminster electoral districts, and any family history of tuberculosis mentioned in the case is recorded.</p>

        <img src="{{ asset('collections/lhsacasenotes/images/TB_case.jpg') }}" alt="TB Case" class="img-responsive" />

        <p>Different language is used in different parts of the case descriptions to make them as accessible as possible. Medical
            conditions are described in modern clinical terms taken from the <a href="https://meshb.nlm.nih.gov/search" title="Medical Subject Headings thesaurus" target="_blank" rel="noopener">Medical Subject Headings thesaurus (MeSH)</a>
            as &lsquo;Subjects&rsquo;, whereas medical conditions are expressed in terms from the case notes themselves in the &lsquo;Scope and Contents&rsquo; part of the
            description.</p>
        <p>Catalogues can be searched by subject, covering medical condition and general type of treatment received, also visible
            in menus at the side of the screen. Clicking on a subject will take you to a list of catalogue entries which mention this
            condition or treatment.</p>
        <p>In these public catalogues, certain aspects of the descriptions have been removed to protect the anonymity of patients &ndash;
            mostly personal names. Other details about each case can be revealed, since it would be hard to identify individuals from
            those factors &ndash; such as age in years (rather than date of birth) and gender.</p>
        <p>Confidential, unredacted catalogues have also been produced, which can be viewed by legitimate researchers who meet
            strict conditions on the use of patient-identifiable data. Access to the unredacted catalogue and to physical confidential
            case notes is determined by means of an application to NHS Lothian through the LHSA Archivist. These highly confidential
            resources can only be consulted in person in our reading room in the Centre for Research Collections, University of Edinburgh.
            Please contact us at <a href="mailto:lhsa@ed.ac.uk">lhsa@ed.ac.uk</a> for further details.</p>
        <p>To place the case notes in context, LHSA&rsquo;s related (non-case note) collection for the RVH is <a href="http://www.lhsa.lib.ed.ac.uk/collections/LHB41/lhb41_index.htm" title="RVH case note" target="_blank" rel="noopener">here</a>.</p>
    </div>
</div>

@include('lhsacasenotes.partials.sidebar')
@endsection
