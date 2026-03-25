@extends('layouts.eerc')

@section('title', 'People - EERC')

@push('styles')
<link rel="stylesheet" href="{{ asset('collections/eerc/css/jquery.justified.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('collections/eerc/js/jquery.justified.min.js') }}"></script>
@endpush

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <div class="content byEditor">
        <h1 class="itemtitle">People</h1>

        <p>The RESP began in Dumfries and Galloway and now continues in East Lothian and elsewhere. The recordings collected in Dumfries & Galloway and many of those from East Lothian are available here. Over time, collections from other areas will be added to this resource.</p>

        <p>A number of individuals and groups have participated in the RESP as both fieldworkers and as interviewees. The collection also includes recordings made before the RESP was created by groups and individuals. One group, the Stranraer and District Local History Trust, shared their recordings (made between 1999 and 2016) and these formed the, foundation of the D&G collection.</p>

        <p>The interviewees range in age from 8 years old to 102 years old. The proportion of male and female interviewees and fieldworkers is approximately 50:50.</p>

        <p>Local people, whether volunteer fieldworkers or interviewees, are central to the RESP. Fieldworkers are provided with training and ongoing support and guidance. Participation in follow-up community based events is also encouraged and community participation and life-long learning are integral to the ethos of the RESP.</p>

        <p>The RESP is currently active in East Lothian, the North-East, Dundee, Edinburgh and Lewis and Harris.</p>

        <p>Further information on the conduct of the RESP can be found here: <a href="https://www.regionalethnologyscotland.llc.ed.ac.uk/spoken-word" target="_blank">https://www.regionalethnologyscotland.llc.ed.ac.uk/spoken-word <span class="sr-only">(opens in a new tab)</span></a></p>

        <div id="image-container-people"></div>
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

<script>
$(document).ready(function(){
    var all = {!! file_get_contents(resource_path('data/eerc_photos.json')) !!};
    var start = Math.floor(Math.random()*(all.length-20));
    
    showPhotos(all.slice(start, start+15));
});

var showPhotos = function(photos){
    $('#image-container-people').justifiedImages({
        images : photos,
        rowHeight: 140,
        maxRowHeight: 250,
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
