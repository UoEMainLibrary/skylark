@extends('layouts.eerc')

@section('title', 'Contact - EERC')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <div class="content byEditor">
        <h1 class="itemtitle">Contact</h1>
        <p>Enquiries regarding the RESP Archive should be directed in the first instance to: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>. Please address your enquiry to '<i>RESP Archive</i>'.</p>

        <p><strong>Privacy Statement:</strong></p>

        <p>Information about you: how we use it and with whom we share it.</p>

        <p>The information you provide will be used only for purposes of your enquiry. We will not share your personal information with any third party or use it for any other purpose. We are using information about you because it is necessary to contact you regarding your enquiry. By providing your personal data when submitting an enquiry to us, consent for your personal data to be used in this way is implied.</p>

        <p>We will hold the personal data you provided us for 6 years. We do not use profiling or automated decision-making processes.</p>

        <p>Our takedown statement can be viewed on the '<a href="{{ url('/eerc/using') }}">Searching and Using the Collection</a>' tab.</p>
    </div>
</div>

<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @if(isset($subjectFacet) && !empty($subjectFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ route('eerc.browse', ['facet' => 'Subject']) }}">
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
                <li class="list-group-item"><a href="{{ route('eerc.browse', ['facet' => 'Subject']) }}">More ...</a></li>
                @endif
            </ul>
            @endif
            
            @if(isset($personFacet) && !empty($personFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ route('eerc.browse', ['facet' => 'Person']) }}">
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
                <li class="list-group-item"><a href="{{ route('eerc.browse', ['facet' => 'Person']) }}">More ...</a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
