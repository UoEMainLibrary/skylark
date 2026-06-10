@extends('layouts.pointsofarrival')

@section('title', 'Hirshow | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar -->
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->
    
    <div id="poa-film">

        <div class="back-link">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"> </span><a href="./films">Back to Film List</a>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">

            <h1 class="poa-page-title ind-film-title">Isaac Hirshow</h4>
            <div class="film-cont">
                <div class="ifilm-img-cont">
                    <img class="ivideo-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/hirshow.jpg">
                    <p class="film-credits">Narrated by Syrian-Kurdish musician Adnan Shamdin, film by Chris Leslie.<p>
                </div> 
                <div class="ifilm-text-cont" id="hirshow-text">
                    <p>
                        <abbr data-title="Synagogue: Jewish place of worship.">Synagogue</abbr> cantor Isaac Hirshow was born to a poor family in Russia in 1883. In 1922, he and his family emigrated to Glasgow and Isaac began work in the Gorbals. 
                        An inspirational teacher and community leader, Isaac also became – at the age of 45 – Glasgow University’s first ever graduate in music.
                        <br><br>
                        Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_0uw6a2ca" alt="External link to video" title="Link to video">Original</a> 
                        or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_45a0nz8u" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                    </p>
                    <p class="film-themes-p">
                        <strong>Themes:</strong><br>
                        <a href="./religion">Jewish Religion</a> || 
                        <a href="./easterneurope">Jewish Life in Eastern Europe</a> || 
                        <a href="./synagoguemusic">Synagogue Music</a> || 
                        <a href="./greatmigration">The Great Migration</a> || 
                        <a href="./languages">Jewish languages</a> || 
                        <a href="./history">History of Jews in Scotland</a> || 
                        <a href="./gorbals">The Gorbals</a> || 
                        <a href="./muisc">Music as a Global Language</a> || 
                        <a href="./adnan">Adnan Shamdin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
