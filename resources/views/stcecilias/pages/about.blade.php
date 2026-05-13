@extends('layouts.stcecilias')

@section('title', "About — St Cecilia's Hall")

@section('body_class', 'about')

@section('content')
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">
            <h1>About St Cecilia&rsquo;s Hall</h1>

            <p>Originally opened in 1763, St Cecilia&rsquo;s Hall is the oldest purpose-built concert hall in Scotland. It is the only place in the world where it is possible to hear eighteenth century music in an eighteenth century concert hall played on eighteenth century instruments. Owned by The University of Edinburgh, it contains one of the world&rsquo;s most important collections of historic musical instruments, many of which remain playable in a concert setting.</p>

            <p>The new St Cecilia&rsquo;s Hall museum brings this collection under one roof, allowing the story of the collection as a whole to be presented and enabling visitors to truly engage with the objects and their stories. The elegant oval concert hall on the first floor of the building has been in continuous use since it opened in the eighteenth century and remains at the heart of the Georgian building, but is now complemented by four galleries on both ground and first floor. The restoration work, which began work in 2015, allows the University to offer more performances, enhance access by increasing the opening hours of the museum and provide new ways for more visitors to engage, participate and learn about its world-class collection of instruments.</p>

            <p>The museum re-opened its doors to the public in May 2017. Find out more about visiting the museum at the
                <a href="https://www.stcecilias.ed.ac.uk" title="Visit St Cecilia's Hall" target="_blank" rel="noopener">St Cecilia&rsquo;s Hall website (opens in a new tab)</a>.</p>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/StCeciliasHall1a.jpg') }}" title="The Sypert Concert Room" alt="The Sypert Concert Room" class="img-responsive pull-left img-about" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/StCeciliasHall10a.jpg') }}" title="St Cecilia's Hall, Musical Instruments Museum" alt="St Cecilia's Hall, Musical Instruments Museum" class="img-responsive pull-left img-about" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/0027122da.jpg') }}" title="St Cecilia's Hall, Musical Instruments Museum, instrument performance" alt="St Cecilia's Hall, Musical Instruments Museum, instrument performance" class="img-responsive pull-left img-about" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/0143017d.jpg') }}" title="St Cecilia's Hall, Musical Instruments Museum Entrance" alt="St Cecilia's Hall, Musical Instruments Museum Entrance" class="img-responsive pull-left img-about" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/0143033d.jpg') }}" title="St Cecilia's Hall, The Sypert Concert Room" alt="St Cecilia's Hall, The Sypert Concert Room" class="img-responsive pull-left img-about" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <img src="{{ asset('collections/stcecilia/images/0143036d.jpg') }}" title="St Cecilia's Hall, The Laigh Hall" alt="St Cecilia's Hall, The Laigh Hall" class="img-responsive pull-left img-about" />
        </div>

        <div class="clearfix"></div>
        <div class="spacer"></div>
        <div class="clearfix"></div>
    </div>
@endsection
