@extends('layouts.eerc-v2')

@section('title', 'Searching and Using the Collection - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Searching and Using the Collection</h1>

        <div class="mt-6 prose prose-lg max-w-none">
            <div class="float-left mr-6 mb-4 hidden sm:block">
                <img src="{{ asset('collections/eerc/images/v2/MG-0690-crop2.jpg') }}" alt="Photograph from the RESP archive collection" class="w-64 rounded-lg shadow-sm">
            </div>

            <p>At the heart of the Regional Ethnology of Scotland Project (RESP) is a collection of digital audio files containing hundreds of hours of fieldwork recordings which provide a rich and fascinating insight into many aspects of life and society in Scotland. The collections are arranged initially by geographic study area, then named interviewer and then by interviewee. When searching the catalogue you will find all digital files, including audio recordings, transcriptions and any available photographs located on the individual interviewee pages or fieldworker page.</p>

            <div class="clear-both">
                <img src="{{ asset('collections/eerc/images/resp-handwriting2.png') }}" alt="Part of a handwritten transcription from an interview" class="my-6 w-full rounded-lg shadow-sm">
            </div>

            <div class="float-right ml-6 mb-4 hidden sm:block">
                <img src="{{ asset('collections/eerc/images/thumbs_processed/thumbnail_DG3-3-4-14.jpeg') }}" alt="Interviews of John Armstrong aged 72" class="w-72 rounded-lg shadow-sm">
            </div>

            <h2>Browse the Collections</h2>

            <p>The <a href="{{ url('/eerc/overview') }}">Browse the Collections</a> page will take you to the full searchable catalogue of the collection. To browse you can click through a series of drop down lists by using the + and &minus; buttons. The arrangement reflects the full archival catalogue and is by regional study, fieldworker, then individual interviewee.</p>

            <p>All audio recordings relating to individual interviews will be found by clicking on <em>Interviews of</em> pages.</p>

            <p>If you know the name of the individual interviewer or interviewee you are looking for, have the unique reference number or an idea of the subject area that you would like to explore you can search using the search box located on the header of each page. For best results when carrying out a name search, use surname only in the first instance. Alternatively you can click through listings of subjects and named persons, which are located on the left of each web page.</p>

            <p>You can click on the thumbnail images located on the &lsquo;Home&rsquo; and &lsquo;People&rsquo; pages to take you through to the relevant catalogue record.</p>

            <div class="not-prose clear-both my-8 flex flex-col items-center">
                <img src="{{ asset('collections/eerc/images/v2/montage.jpg') }}" alt="Montage of RESP interviewees and community events" class="max-w-2xl rounded-lg shadow-sm">
            </div>

            <div class="not-prose my-8 flex flex-col items-center gap-6 sm:flex-row sm:items-center">
                <div class="hidden shrink-0 sm:block">
                    <img src="{{ asset('collections/eerc/images/example-map.png') }}" alt="Example Map" class="w-56 rounded-lg shadow-sm">
                </div>
                <p class="text-base text-gray-700 sm:flex-1">Alternatively, you can explore the collection geographically via our <a href="{{ url('/eerc/map') }}" class="font-medium text-resp-teal-600 hover:underline">Interactive Map</a>. Zoom in and out of the map and click on the pins to link through to a list of relevant interviews.</p>
            </div>

            <h2>Access and Restrictions</h2>

            <p>Unless otherwise stated, permission for the material within this collection to be accessed as an on-line educational resource has expressly been given by all contributing parties.</p>

            <p>We give permission for the re-use of our collections material for non-commercial purposes under the <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank" rel="noopener">Creative Commons Attribution Non-commercial 4.0 International Licence</a>.</p>

            <p>If you intend to re-use any of the material with this collection please ensure that you attribute appropriately. We suggest use of the following statement &lsquo;Recording courtesy of the Regional Ethnology of Scotland Project, European Ethnological Research Centre, University of Edinburgh. Copyright: Creative Commons Attribution Non-commercial 4.0 International Licence.&rsquo;</p>

            <p>Please note that there may be instances of poor sound quality within recordings due to unavoidable issues with legacy recordings.</p>

            <h2>Redactions</h2>

            <p>To ensure compliance with General Data Protection Regulations (GDPR) requirements, redactions have been made to some audio files where there may be personal or sensitive material. Should you experience short gaps in any of the recordings or notice episodes of &lsquo;brown noise&rsquo; this may be where sound files have been redacted.</p>

            <p>In all cases the original unredacted sound file has been digitally preserved and is securely stored.</p>

            <h2>Sensitive Material</h2>

            <p>The nature of historical materials and material which reflects personal viewpoints may mean that occasionally language is used or opinions given that are no longer consistent with what is deemed acceptable. In rare cases there may be language used that may be deemed as offensive.</p>

            <p>All RESP material available via the website has been fully reviewed and screened prior to release. However, should any objections be raised to particular material deemed to be of a sensitive or potentially offensive nature there are actions that may be taken, including:</p>

            <ul>
                <li>Provision for additional descriptive information to warn of material of a sensitive nature.</li>
                <li>In extreme cases redactions may be considered to material deemed to be of a sensitive nature or potentially offensive.</li>
            </ul>

            <h2>Takedown Policy</h2>

            <p>In making material available online RESP acts in good faith. However, despite appropriate safeguards and due diligence searches prior to the release of any material, we recognise that from time to time material published online may be in breach of GDPR, contain sensitive personal data, or include content that may be regarded by some as offensive or defamatory. If you are concerned that you have found material on this website, which you feel is offensive or defamatory, or you are concerned that material pertaining to yourself is on this website without your permission, please contact us in writing and this issue will be dealt with immediately. For further advice regarding appropriate reporting procedures please follow this link <a href="https://www.ed.ac.uk/library/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener">Takedown Policy</a>.</p>

            <img src="{{ asset('collections/eerc/images/resp-handwriting3.png') }}" alt="Part of a handwritten transcription from an interview" class="my-6 w-full rounded-lg shadow-sm">
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
