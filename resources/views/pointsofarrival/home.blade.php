@extends('layouts.pointsofarrival')

@section('title', 'Points Of Arrival')

@section('body_class', 'home')

@section('content')
<div class="container-fluid">
    @include('pointsofarrival.partials.poa_sidebar')

    <div id="poa_banner">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <p class="index-para indx-p-top">
                <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_5h16vc0r" title="External link to Points of Arrival video playlist" target="_blank" rel="noopener">Points of Arrival</a>
                is a series of five short films about Jewish migration to Scotland in the 19th and 20th centuries.
                Each film tells the story of one person – in their own words and also through a contemporary narrator who shares a connection.
            </p>
            <br>
            <p class="index-para">
                The films are part of the work of the AHRC-funded project <a href="http://jewishmigrationtoscotland.is.ed.ac.uk"><strong>Jewish Lives, Scottish Spaces: Jewish Migration to Scotland, 1880-1950</strong></a>,
                and they were produced by documentary film-maker Chris Leslie, whose artistry, imagination and respect for his subject brings alive each of these five histories.
            </p>
        </div>
        <div id="galleries" class="grid">
            <div class="grid-sizer"></div>
            <a href="./introduction">
                <div class="landing-background">
                    <div id="galleryethst" class="film-info landing-grid"></div>
                    <div class="gallery-title">
                        <h2 class="grid-item-title">How To</h2>
                        <h2 class="grid-item-title-shadow">How To</h2>
                    </div>
                </div>
            </a>
            <a href="./films">
                <div class="landing-background">
                    <div id="gallerykb" class="film-info landing-grid"></div>
                    <div class="gallery-title">
                        <h2 class="grid-item-title">Films</h2>
                        <h2 class="grid-item-title-shadow">Films</h2>
                    </div>
                </div>
            </a>
            <a href="./themes">
                <div class="landing-background">
                    <div id="gallerywespe" class="film-info landing-grid"></div>
                    <div class="gallery-title">
                        <h2 class="grid-item-title">Themes</h2>
                        <h2 class="grid-item-title-shadow">Themes</h2>
                    </div>
                </div>
            </a>
            <a href="./resources">
                <div class="landing-background">
                    <div id="galleryethpe" class="film-info landing-grid"></div>
                    <div class="gallery-title">
                        <h2 class="grid-item-title" id="title-ofset">Resources</h2>
                        <h2 class="grid-item-title-shadow" id="title-ofset-shadow">Resources</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="spacer"></div>
    <div class="clearfix"></div>
</div>
@endsection
