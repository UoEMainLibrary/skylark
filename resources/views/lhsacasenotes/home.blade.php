@extends('layouts.lhsacasenotes')

@section('title', 'Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <h1 class="itemtitle">Medical records revived: <small>Case Note Catalogues at Lothian Health Services Archive</small></h1>

    <p>
        Lothian Health Services Archive (LHSA) is the archive of NHS Lothian, based in the Centre for Research
        Collections, University of Edinburgh. The Archive collects evidence of the history of healthcare in
        Edinburgh and the Lothians, from records of how Edinburgh&rsquo;s NHS hospitals were founded and managed to
        privately donated collections gifted by individuals and organisations shaping the region&rsquo;s medical history.
        LHSA records date from 1594 to the present day.
    </p>

    <img src="{{ asset('collections/lhsacasenotes/images/P_PL1_B_E_101-RIE-Exterior-1985.gif') }}"
         alt="Royal Infirmary Edinburgh Exterior"
         class="img-responsive pull-right img-circle" />

    <p>
        Patient records are an invaluable way of bringing Edinburgh&rsquo;s historic breakthroughs in medical treatment and
        care to light. As well as bound accounts of treatment (dating back to the eighteenth century), LHSA holds over one million
        twentieth-century patient case notes in folders in one of the largest medical archives in the UK.
        The majority of these cases (although by no means all) were written in the Royal Infirmary of Edinburgh.
        They cover both specific medical specialisms (from neurosurgery, respiratory disease and psychiatric care
        to orthopaedics and obstetrics) and more general medicine and surgery.
    </p>

    <p>
        In 2012, LHSA developed a methodology for cataloguing these modern archival case notes. Catalogues describe
        individual cases for researchers whilst protecting the privacy of patients through careful
        redaction of potentially identifying details. This resource acts as a gateway to these anonymised case note
        catalogues. It will guide you in using the catalogues for the first time, give context to key people,
        subjects and places, and will provide information for legitimate researchers on applying to access the
        confidential documents that they describe. At present, finding aids for neurosurgical and tuberculosis case notes can be accessed,
        but new catalogues will be added as they are completed.
    </p>

    <p>
        The support of the <a href="https://wellcome.ac.uk/" target="_blank" rel="noopener">Wellcome Trust</a> is
        gratefully acknowledged. Research Resources funding has enabled the ongoing
        cataloguing of Norman Dott&rsquo;s neurosurgical case notes and those of the Royal Victoria Hospital, the Royal
        Victoria Dispensary for Diseases of the Chest, the Regional Hospital National X-ray Campaign and Southfield
        Sanitorium. <a href="http://www.lhsa.lib.ed.ac.uk/projects/Projects-WTProjects.htm" target="_blank" rel="noopener">Find out more about these projects here.</a>
    </p>

    <img src="{{ asset('collections/lhsacasenotes/images/dott-index-image.gif') }}"
         alt="Norman Dott Case Notes"
         class="img-responsive pull-right index-img" />
</div>

@include('lhsacasenotes.partials.sidebar')
@endsection
