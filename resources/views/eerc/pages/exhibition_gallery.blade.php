@extends('layouts.eerc')

@section('title', 'Exhibition Gallery - EERC')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <br>
    <blockquote>
        <h1 style="text-align: center">"Animal Encounters in the RESP Archive"</h1>
    </blockquote>
    <h3 style="text-align: center">Exploring animal-human relationships across the Regional Ethnology of Scotland Project</h3>
    <br>
    <div style="text-align: center">
        <img src="{{ asset('collections/eerc/images/animal_encounters_resp.png') }}" style="width: 80%"><br>
        <br>
        <a href='https://exhibitions.ed.ac.uk/exhibitions/animal-encounters' target="_blank">https://exhibitions.ed.ac.uk/exhibitions/animal-encounters <span class="sr-only">(opens in a new tab)</span></a><br>
    </div>
    <br>
    <p>
        To explore RESP's online exhibition Animal Encounters in the RESP Archive please click on the link above. The exhibition,
        curated and illustrated by Rebekah Day, reveals the varied and complex relationships that can exist between people and animals.
        Through carefully selected audio recordings, images, and videos the exhibition highlights how connections between humans and
        animals have shifted in recent decades: reflecting wider culture and environmental concerns present in Scottish society today.
    </p>
    <br>
    <hr>
    <br>
    <blockquote>
        <h1 style="text-align: center">"This was a right industrial wee town!"</h1>
    </blockquote>
    <h3 style="text-align: center">A film about life and work in the Musselburgh Mills</h3>
    <br>
    <p>
        The 'Honest Toun' is a place that, to some extent, sits on its own. Part of Midlothian until its governance transferred to East Lothian in 1975.
        The size of Musselburgh's population and the scale and range of its economy has, for long, reflected its historic status as a burgh.
        Industry having been a key aspect of that large and diverse economy. Beginning in the nineteenth century through to the late twentieth century,
        three large industrial endeavours were based in the town: Stuarts Net Mill; Bruntons Wire Mill and Inveresk Paper Mill.
    </p>
    <p>
        This film tells the story of these mills through the words of those who worked and lived in the town and beyond. In partnership with the John Gray
        Centre and Musselburgh Museum, the EERC interviewed a number of folk about their experiences in the mills. This film provides an introduction into
        these very different workplaces which were such a significant part of the Town's life for well over 100 years.<br>
        Mark Mulhern, 2024
    </p>
    <br>
    <div style="text-align: center">
        <video controls width="600" preload="auto" title="MILLS-revised" poster="{{ asset('collections/eerc/images/MILLS-revised-720.png') }}">
            <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/56448/MILLS-revised-720.mp4') }}">
            Sorry, your browser doesn't support embedded videos.
        </video>
    </div>
    <br>
    <p>
        Editor: Colin Gateley <br>
        Music by: Enid Forsyth <br>
        Moving images: Courtesy of moving Image Archive, National Library of Scotland
    </p>
    <hr>
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
