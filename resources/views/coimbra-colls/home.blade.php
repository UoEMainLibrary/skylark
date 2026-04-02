@extends('layouts.coimbra-colls')

@section('title', 'Coimbra Collections')

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
        <div class="parallax img7 inactive"></div>
        <div class="parallax img8 inactive"></div>
        <div class="parallax img9 inactive"></div>
        <div class="parallax img10 inactive"></div>
        <div class="parallax img11 inactive"></div>
        <div class="parallax img12 inactive"></div>



        <div class="main-categories row" id="content">
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22anthropology+%7C%7C%7C+Anthropology%22'>Anthropology</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22antiquities+%7C%7C%7C+Antiquities%22'><div class="border-top"></div>Antiquities</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22art+%7C%7C%7C+Art%22'><div class="border-top"></div>Art</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22early+printed+books+%7C%7C%7C+Early+printed+books%22'><div class="border-top"></div>Early books</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22language+and+languages+%7C%7C%7C+Language+and+languages%22'><div class="border-top"></div>Language</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22manuscripts+%7C%7C%7C+Manuscripts%22'><div class="border-top"></div>Manuscripts</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22medicine+%7C%7C%7C+Medicine%22'><div class="border-top"></div>Medicine</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22musical+instruments+%7C%7C%7C+Musical+Instruments%22'><div class="border-top"></div>Music</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22natural+history+%7C%7C%7C+Natural+history%22'><div class="border-top"></div>Natural history</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22politics+and+government+%7C%7C%7C+Politics+and+government%22'><div class="border-top"></div>Politics</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22social+history+%7C%7C%7C+Social+History%22'><div class="border-top"></div>Social History</a>
            <a class="col-xs-6 col-md-2" href='/coimbra-colls/search/*:*/Category:%22science+%7C%7C%7C+Science%22'><div class="border-top"></div>Science</a>
            <a class="col-xs-12 col-md-12 border-b" href='./search/*:*/Category:%22technology+%7C%7C%7C+Technology%22'><div class="border-top"></div>Technology</a>
        </div>
    </div>
@endsection
