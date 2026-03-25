@extends('layouts.eerc')

@section('title', 'Regional Ethnology of Scotland Project')

@push('styles')
<link rel="stylesheet" href="{{ asset('collections/eerc/css/jquery.justified.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('collections/eerc/js/jquery.justified.min.js') }}"></script>
@endpush

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <div class="pull-left" id="image-container"></div>

    <p>The Regional Ethnology of Scotland Project (RESP) works with people in communities across Scotland to collect material relating to local life and society through recorded fieldwork interviews. This work, which began in 2011 with a pilot study in Dumfries & Galloway, is conducted on a regional basis. Work is currently ongoing in several parts of Scotland, particularly East Lothian (2018-present), and also in the Western Isles and in Tayside, Edinburgh, the Scottish Borders, Argyll, West Lothian and the North-east.</p>
    <p>The RESP is a key focus of the work of the European Ethnological Research Centre (EERC) at the University of Edinburgh. Research staff at the Centre work in partnership with local people and organisations, such as archive and library services, voluntary organisations and schools, to reach as many people as possible so that the resulting archive of recordings can endeavour to represent people from across all parts of the community.</p>
    <p>The interviews are conducted by local volunteers who are trained and provided with ongoing support by the EERC. Those who conduct the interviews, and those who are interviewed, are able to choose to base their interview on whatever aspects of their lives and the places they live are most appropriate or meaningful to them. In this way, the RESP aspires to compile an archive which records, with nuance and detail, an accurate reflection of life and society as it is experienced by the individual in the place where the recording was made.</p>
    <p>This website provides access to the recordings made as part of the RESP. In order to encourage and facilitate access to this Collection, detailed summaries for each item are provided in the collections catalogue along with keyword, name and place search options. Most of the interviews have been transcribed in full and those transcriptions are also available on this site. The collection can be browsed using the dedicated search options, by clicking on any one of the photographs on the left hand panel on this page , or the 'People' page, or can be explored using free-text searching.</p>
    <p>The ethos of the RESP is that the collection is the creation of those who have made the recordings. As such, it is a central aim of the RESP that the recordings are made freely available in an easily accessible way. This archive interface, along with making the resources available to download through a Creative Commons licence, are the main ways in which we seek to meet this objective.</p>
    <p>More information about the RESP and the EERC can be found here:<br/> <a href="https://www.regionalethnologyscotland.llc.ed.ac.uk/spoken-word" target="_blank">https://www.regionalethnologyscotland.llc.ed.ac.uk/spoken-word <span class="sr-only">(opens in a new tab)</span></a>.</p>


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

<script>
$(document).ready(function(){
    var all = {!! file_get_contents(resource_path('data/eerc_photos.json')) !!};
    var start = Math.floor(Math.random()*(all.length-20));
    
    showPhotos(all.slice(start, start+20));
});

var showPhotos = function(photos){
    $('#image-container').justifiedImages({
        images : photos,
        rowHeight: 90,
        maxRowHeight: 150,
        template: function(data) {
            return '<div class="photo-container" style="height:' + data.displayHeight + 'px;margin-right:' + data.marginRight + 'px;">' +
                '<a href="{{ url('/eerc/record') }}/' + data.id + '" title="' + data.title + '">' +
                '<img class="image-thumb" src="' + data.src + '" alt="' + data.title + '" title="' + data.title + '"' +
                ' style="width:' + data.displayWidth + 'px;height:' + data.displayHeight + 'px;" >' +
                '</a></div>';
        },
        thumbnailPath: function(photo){
            return "{{ asset('collections/eerc/images/thumbs_processed') }}/" + photo.url;
        },
        getSize: function(photo){
            return {width: photo.width, height: photo.height};
        },
        margin: 1
    });
}
</script>
@endsection
