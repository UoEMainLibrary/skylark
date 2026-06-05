@extends('layouts.pointsofarrival')

@section('title', 'Films | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar -->
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->

    <div id="poa-films">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">

            <h1 class="poa-page-title">Points of Arrival Films</h4>
            <ul class="films-list">
                <li>
                    <h2>Full Compilation</h2>
                    <div class="film-info">
                        <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_1tunnl0j" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/full.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            Five stories of Jewish migration to Scotland in the 19th and 20th centuries, told by contemporary narrators.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_1tunnl0j" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_5h16vc0r" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Trailer</h2>
                    <div class="film-info"> 
                        <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_wivoswb5" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/full.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            Trailer for a series of 5 short films made by the Jewish Lives/Scottish Spaces team.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_wivoswb5" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_t544hg2r" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Hilda Goldwag</h2>
                    <div class="film-info">
                        <a href="./goldwag" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/goldwag.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            Hilda Goldwag was born in Vienna in 1912. In 1939 she fled to Scotland to escape Nazi persecution.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_0uw6a2ca" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_45a0nz8u" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Isaac Hirshow</h2>
                    <div class="film-info">
                        <a href="./hirshow" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/hirshow.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            <abbr data-title="Synagogue: Jewish place of worship.">Synagogue</abbr> cantor Isaac Hirshow was born to a poor family in Russia in 1883. In 1922, 
                            he and his family emigrated to Glasgow and Isaac began work in the Gorbals.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_lb5tqgvj" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_rrblnqr5" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Annie Lindey</h2>
                    <div class="film-info">
                        <a href="./lindey" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/lindey.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            This is the story of Annie Lindey, who moved to Edinburgh from Russia in the late 19th century.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_7amxtxuy" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_eyfaajhf" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions. 
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Dorrith Sim</h2>
                    <div class="film-info">
                        <a href="./sim" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/sim.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            Dorrith Sim was one of the thousands of Jewish children who arrived in the UK in 1939 on what became known as the <abbr data-title="Kindertransport: (German for 
                            ‘children’s transport’) Rescue of c.10,000 unaccompanied Jewish children from Germany and Nazi-occupied Europe to Britain 1938-1939. The last transport was 1940 
                            when the start of World War II made further rescue impossible.">Kindertransport</abbr>.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_hk75k72k" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_oz3g2szj" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
                <li>
                    <h2>Henry Wuga</h2>
                    <div class="film-info">
                        <a href="./wuga" alt="External link to video" title="Link to video">
                            <div class="film-img-cont">
                                <img class="video-still" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/wuga.jpg">
                                <img class="eye-overlay" src="{{ asset('collections/pointsofarrival/') }}/images/video-stills/eye-icon.png">
                            </div>
                        </a>
                        <p>
                            Henry Wuga arrived in Glasgow from Nuremberg as a teenage refugee. On leaving school, 
                            he began a successful career as a caterer and raised a family with his wife Ingrid.
                            <br><br>
                            Available in <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_gtrcwk4o" alt="External link to video" title="Link to video">Original</a> 
                            or <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_y8449rsh" alt="External link to subtitled video" title="Link to subtitled video">Subtitled</a> versions.
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="spacer"></div>
        <div class="clearfix"></div>
    </div>
</div>
@endsection
