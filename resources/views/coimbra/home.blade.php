@extends('layouts.coimbra')

@section('title', 'Coimbra Virtual Exhibition')

@section('content')
<div class="content">
    <!-- todo replace two with sass or less -->
<div>
    <div class="parallax img0 inactive"></div>
    <div class="parallax img1 inactive"></div>
    <div class="parallax img2 inactive"></div>
    <div class="parallax img3 inactive"></div>
    <div class="parallax img4 inactive"></div>
    <div class="parallax img5 inactive"></div>
    <div class="parallax img6 inactive"></div>

    <div class="main-categories">
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22voyage+%7C%7C%7C+Voyage%22'><div class="border-top"></div>Voyage</a>
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22discovery+%7C%7C%7C+Discovery%22'><div class="border-top"></div>Discovery</a>
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22faith+%7C%7C%7C+Faith%22'><div class="border-top"></div>Faith</a>
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22the+arts+%7C%7C%7C+The+Arts%22'><div class="border-top"></div>The Arts</a>
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22natural+science+%7C%7C%7C+Natural+Science%22'><div class="border-top"></div>Natural Sciences</a>
        <a class="col-xs-6 col-md-4" href='/coimbra/search/*:*/Category:%22war+%26+peace+%7C%7C%7C+War+%26+Peace%22'><div class="border-top"></div>War & Peace</a>
        <a class="col-xs-12 col-md-12 border-b" href='/coimbra/search/*:*/Category:%22the+wunderkammer+%7C%7C%7C+The+Wunderkammer%22'><div class="border-top"></div>The Wunderkammer</a>
    </div>
</div>
@endsection
