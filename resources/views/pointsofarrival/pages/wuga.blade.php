@extends('layouts.pointsofarrival')

@section('title', 'Wuga | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Henry Wuga</h4>
            <div class="film-cont">
                <div class="ifilm-img-cont">
                    <img class="ivideo-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/wuga.jpg">
                    <p class="film-credits">Film by Chris Leslie.<p>
                </div>
                <div class="ifilm-text-cont" id="wuga-text">
                    <p>
                        Henry Wuga arrived in Glasgow from Nuremberg as a teenage refugee. On leaving school, he began a successful career as a caterer and raised a family with his wife 
                        Ingrid. Henry often spoke about his experiences of being a refugee and the ongoing dangers of persecution. Now in his 90's he is still an outspoken advocate of 
                        tolerance, acceptance and mutual understanding.
                        <br><br>
                        Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_0uw6a2ca" alt="External link to video" title="Link to video">Original</a> 
                        or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_45a0nz8u" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                    </p>
                    <p class="film-themes-p">
                        <strong>Themes:</strong><br>
                        <a href="./antisemitism">Antisemitism</a> || 
                        <a href="./nazigermany">Jewish Life in Nazi Germany</a> || 
                        <a href="./kindertransport">Kindertransport</a> || 
                        <a href="./holocaust">War and Holocaust</a> || 
                        <a href="./welfare">Welfare</a> || 
                        <a href="./food">Jewish Food</a> || 
                        <a href="./history">History of Jews in Scotland</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
