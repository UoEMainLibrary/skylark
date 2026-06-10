@extends('layouts.pointsofarrival')

@section('title', 'Lindey | Points Of Arrival')

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

            <h1 class="poa-page-title ind-film-title">Annie Lindey</h4>
            <div class="film-cont">
                <div class="ifilm-img-cont">
                    <img class="ivideo-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/lindey.jpg">
                    <p class="film-credits">Narrated by Annie’s granddaughter Carole Cowen, film by Chris Leslie.<p>
                </div>
                <div class="ifilm-text-cont" id="lindey-text">
                    <p>
                        This is the story of Annie Lindey, who moved to Edinburgh from Russia in the late 19th century. Annie was a tireless worker for her community and an early advocate 
                        of mutual support and social welfare for women.
                        <br><br>
                        Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_0uw6a2ca" alt="External link to video" title="Link to video">Original</a> 
                        or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_45a0nz8u" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                    </p>
                    <p class="film-themes-p">
                        <strong>Themes:</strong><br>
                        <a href="./easterneurope">Jewish Life in Eastern Europe</a> || 
                        <a href="./greatmigration">The Great Migration</a> || 
                        <a href="./history">History of Jews in Scotland</a> || 
                        <a href="./languages">Jewish Languages</a> || 
                        <a href="./welfare">Welfare</a> || 
                        <a href="./religion">Jewish Religion</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
