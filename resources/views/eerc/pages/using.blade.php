@extends('layouts.eerc')

@section('title', 'Searching and Using the Collection - EERC')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <div class="content byEditor">
        <img src="{{ asset('collections/eerc/images/thumbs_processed/thumbnail_DG38-3-4-1.JPG') }}" alt="Interviews of Ena Forteath aged 78" width="300" class="img-responsive pull-left padded_images" />

        <h1 class="itemtitle">Searching and Using the Collection</h1>

        <p>At the heart of the Regional Ethnology of Scotland Project (RESP) is a collection of digital audio files containing hundreds of hours of fieldwork recordings which provide a rich and fascinating insight into many aspects of life and society in Scotland. The collections are arranged initially by geographic study area, then named interviewer and then by interviewee. When searching the catalogue you will find all digital files, including audio recordings, transcriptions and any available photographs located on the individual interviewee pages or fieldworker page.</p>

        <img src="{{ asset('collections/eerc/images/resp-handwriting2.png') }}" alt="Part of a handwritten transcription from an interview" class="img-responsive center-block padded_images" style="margin-top: 1em; clear:both;" />

        <img src="{{ asset('collections/eerc/images/thumbs_processed/thumbnail_DG3-3-4-14.JPG') }}" alt="Interviews of John Armstrong aged 72" width="300" class="img-responsive pull-right padded_images" />

        <p><strong>Browse the Collections</strong></p>

        <p>The <a href="{{ url('/eerc/overview') }}">Browse the Collections</a> page will take you to full searchable catalogue of the collection. To browse you can click through a series of drop down lists by using the + and – buttons. The arrangement reflects the full archival catalogue and is by regional study, fieldworker, then individual interviewee.</p>

        <p>All audio recordings relating to individual interviews will be found by clicking on <i>Interviews of</i> pages.</p>

        <p>If you know the name of the individual interviewer or interviewee you are looking for, have the unique reference number or an idea of the subject area that you would like to explore you can search using the search box located on the header of each page. For best results when carrying out a name search, use surname only in the first instance. Alternatively you can click through listings of subjects and named persons, which are located on the left of each web page.</p>

        <p>You can click on the thumbnail images located on the 'Home' and 'People' pages to take you through to the relevant catalogue record.</p>

        <img src="{{ asset('collections/eerc/images/resp-montage.png') }}" alt="Montage of interview photographs" class="img-responsive center-block padded_images" style="margin-top: 1em; clear:both;" />

        <span style="clear:both;">
            <img src="{{ asset('collections/eerc/images/example-map.png') }}" alt="Example Map" width="300" class="img-responsive pull-right padded_images" />
            <br style="line-height:400%;"/>
            <p>Alternatively, you can explore the collection geographically via our <a href="{{ url('/eerc/map') }}">Interactive Map</a>. Zoom in and out of the map and click on the pins to link through to a list of relevant interviews.</p>
            <br style="line-height:600%;"/>
        </span>
        
        <p><strong>Access and Restrictions</strong></p>

        <p>Unless otherwise stated, permission for the material within this collection to be accessed as an on-line educational resource has expressly been given by all contributing parties.</p>

        <p>We give permission for the re-use of our collections material for non-commercial purposes under the <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">Creative Commons Attribution Non-commercial 4.0 International Licence <span class="sr-only">(opens in a new tab)</span></a>.</p>

        <p>If you intend to re-use any of the material with this collection please ensure that you attribute appropriately. We suggest use of the following statement 'Recording courtesy of the Regional Ethnology of Scotland Project, European Ethnological Research Centre, University of Edinburgh. Copyright: Creative Commons Attribution Non-commercial 4.0 International Licence.' </p>

        <p>Please note that there may be instances of poor sound quality within recordings due to unavoidable issues with legacy recordings.</p>

        <p><strong>Redactions</strong></p>

        <p>To ensure compliance with General Data Protection Regulations (GDPR) requirements, redactions have been made to some audio files where there may be personal or sensitive material. Should you experience short gaps in any of the recordings or notice episodes of 'brown noise' this may be where sound files have been redacted.</p>

        <p>In all cases the original unredacted sound file has been digitally preserved and is securely stored.</p>

        <p><strong>Sensitive Material</strong></p>

        <p>The nature of historical materials and material which reflects personal viewpoints may mean that occasionally language is used or opinions given that are no longer consistent with what is deemed acceptable. In rare cases there may be language used that may be deemed as offensive.</p>

        <p>All RESP material available via the website has been fully reviewed and screened prior to release. However, should any objections be raised to particular material deemed to be of a sensitive or potentially offensive nature there are actions that may be taken, including:</p>

        <ul class="content">
            <li>Provision for additional descriptive information to warn of material of a sensitive nature.</li>
            <li>In extreme cases redactions may be considered to material deemed to be of a sensitive nature or potentially offensive.</li>
        </ul>

        <p><strong>Takedown Policy</strong></p>

        <p>In making material available online RESP acts in good faith. However, despite appropriate safeguards and due diligence searches prior to the release of any material, we recognise that from time to time material published online may be in breach of GDPR, contain sensitive personal data, or include content that may be regarded by some as offensive or defamatory. If you are concerned that you have found material on this website, which you feel is offensive or defamatory, or you are concerned that material pertaining to yourself is on this website without your permission, please contact us in writing and this issue will be dealt with immediately. For further advice regarding appropriate reporting procedures please follow this link <a href="https://www.ed.ac.uk/library/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank">Takedown Policy <span class="sr-only">(opens in a new tab)</span></a>.</p>

        <img src="{{ asset('collections/eerc/images/resp-handwriting3.png') }}" alt="Part of a handwritten transcription from an interview" class="img-responsive center-block padded_images" style="margin-top: 1em; clear:both;" />
    </div>
</div>

<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @if(isset($subjectFacet) && !empty($subjectFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ url('/eerc/browse/Subject') }}">
                        Subject
                    </h4>
                </li>
                
                @foreach($subjectFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Subject:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($subjectFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ url('/eerc/browse/Subject') }}">More ...</a></li>
                @endif
            </ul>
            @endif
            
            @if(isset($personFacet) && !empty($personFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ url('/eerc/browse/Person') }}">
                        Person
                    </h4>
                </li>
                
                @foreach($personFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Person:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($personFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ url('/eerc/browse/Person') }}">More ...</a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
