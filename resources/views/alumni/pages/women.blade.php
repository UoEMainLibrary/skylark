@extends('layouts.alumni')

@section('title', 'Awards to Women- University of Edinburgh Historical Alumni')

@section('content')
<div class="content">
    <div class="content byEditor about">
        <h1>Awards to Women students, 1876-1894</h1>
        <h2><a href='{{ \App\Support\CollectionUrl::url("search/*:*") }}/Collection:"awards+to+women+students%2C+1876-1894%7C%7C%7CAwards+to+Women+students%2C+1876-1894"'><i class="fa fa-search fa-lg">&nbsp;</i>View all items</a></h2>
        <p>Women were only allowed to graduate from the University following measures put in place following the Universities (Scotland) Act, 1889.  The first female undergraduates at Edinburgh were admitted in 1892 and eight graduated in 1893, all of them having previously studied at classes given by the Edinburgh Association for the University Education for Women. All classes were mixed except those for medical students. By 1914 a thousand women had degrees from Edinburgh University.</p>
        <p>Women were not totally excluded prior to this and this database represents those who managed to gain a Certificate in Arts in the lead-up to full admission being available.  Details are taken from an older index, based on details as published in the University Calendar, with the addition of notes.</p>
    </div>
</div>
@endsection
