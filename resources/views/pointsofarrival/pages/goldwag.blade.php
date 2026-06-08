@extends('layouts.pointsofarrival')

@section('title', 'Goldwag | Points Of Arrival')

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

            <h1 class="poa-page-title ind-film-title">Hilda Goldwag</h4>
            <div class="film-cont">
                <div class="ifilm-img-cont">
                    <img class="ivideo-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/goldwag.jpg">
                    <p class="film-credits">Narrated by artist Emma Newcombe, film by Chris Leslie.<p>
                </div>
                <div class="ifilm-text-cont" id="goldwag-text">
                    <p>
                    Hilda Goldwag was born in Vienna in 1912. In 1939 she fled to Scotland to escape Nazi persecution. Hilda remained in Glasgow for the rest of her life, celebrating the everyday life of her adopted city through her colourful and powerfully direct paintings.
                        <br><br>
                        Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_0uw6a2ca" alt="External link to video" title="Link to video">Original</a> 
                        or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_45a0nz8u" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                    </p>
                    <p class="film-themes-p"> 
                        <strong>Themes:</strong><br>
                        <a href="./culture">Jewish Culture</a> || 
                        <a href="./antisemitism">Antisemitism</a> || 
                        <a href="./nazigermany">Jewish Life in Nazi Germany</a> || 
                        <a href="./holocaust">War and Holocaust</a> || 
                        <a href="./history">History of Jews in Scotland</a> || 
                        <a href="./arts">Jewish Art and Artists</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
