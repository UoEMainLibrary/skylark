@extends('layouts.pointsofarrival')

@section('title', 'Sim | Points Of Arrival')

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

            <h1 class="poa-page-title ind-film-title">Dorrith Sim</h4>
            <div class="film-cont">
                <div class="ifilm-img-cont">
                    <img class="ivideo-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/sim.jpg">
                    <p class="film-credits">Narrated by Noa Wilkes, film by Chris Leslie.<p>
                </div>
                <div class="ifilm-text-cont" id="sim-text">
                    <p>
                        Dorrith Sim was one of the thousands of Jewish children who arrived in the UK in 1939 on what became known as the <abbr data-title="Kindertransport: (German for 
                        ‘children’s transport’) Rescue of c.10,000 unaccompanied Jewish children from Germany and Nazi-occupied Europe to Britain 1938-1939. The last transport was 1940 
                        when the start of World War II made further rescue impossible.">Kindertransport.</abbr> Travelling alone and speaking 
                        little English, she was taken in by an Edinburgh family. After the war, Dorrith chose to remain in Edinburgh. She wrote a book about her experiences and became 
                        an ambassador and spokesperson for her fellow refugees.
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
                        <a href="./family">Family</a> || 
                        <a href="./history">History of Jews in Scotland</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
