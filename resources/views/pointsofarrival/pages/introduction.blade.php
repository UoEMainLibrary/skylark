@extends('layouts.pointsofarrival')

@section('title', 'Introduction | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar -->
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->
    
    <div id="poa-intro">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">

            <h1 class="poa-page-title">Introduction</h4>
            <div class="intro-cont">
                <p class="intro-info">
                    <em>Points of Arrival</em> is a series of five short films about Jewish migration to Scotland in the 19<sup>th</sup> and 20<sup>th</sup> centuries. 
                    Each film tells the story of one person – in their own words and also through a contemporary narrator who shares a connection.
                </p>
                <p class="intro-info">
                    To supplement these films, we have designed this site to offer a series of digital resources to students and teachers. 
                    How to use this site below gives some suggestions about getting the most from these resources. <!--Alternatively, 
                    click on any of the images to the right to get started.  COMMENTED OUT AWAITING CONTENT--> 
                </p>
            </div>
            <br>
            <h1 class="poa-page-title">How To</h4>
            <div class="intro-cont">
                <ul class="parent-ul">
                    <li>First of all, watch the <a href="./films"><strong>films!</strong></a> Or at least one or two of them.
                        <ul class="child-ul">
                            <li>You can view all the films in one go <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_5h16vc0r" target="_blank" rel="noopener"><strong>here</strong></a>&nbsp; (about 18 mins total).</li>
                            <li>To see the full blurb for each film and its list of <a href="./themes"><strong>themes</strong></a> click on the individual films image on the <a href="./films"><strong>films page.</strong></a></li>
                            <li>Or choose to watch one film at a time by clicking one of the options to the right of the image on the <a href="./films"><strong>films page.</strong></a></li>
                        </ul>
                    </li>
                    <li>With each film, you will find a series of one-page <a href="./themes"><strong>themes</strong></a>. These themes will give you background information about the details, themes and questions that the film raises.
                        <ul class="child-ul">
                            <li>The <a href="./themes"><strong>themes</strong></a> are a chance for you to delve deeper into these fascinating and moving stories and to think about how they may connect with issues facing us today.</li>
                        </ul>
                    </li>
                    <li>At the bottom of the menu on the left, you will also find a <a href="./resources" rel="noopener"><strong>resources page</strong></a>. This page links you to suggested online resources to expand on your own discoveries. These will be particularly helpful for students wishing to put together their own presentations or projects.</li>
                </ul>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="spacer"></div>
        <div class="clearfix"></div>
    </div>
</div>

@endsection
