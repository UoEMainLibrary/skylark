@extends('layouts.pointsofarrival')

@section('title', 'Culture | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar -->
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->
    
    <div id="poa-theme">

        <div class="back-link">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"> </span><a href="./themes">Back to Themes List</a>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">
            <h1 class="poa-page-title ind-film-title">Jewish Culture</h1>
            <p class="theme-info">
                Not all Jews find it meaningful to engage with Jewish religious beliefs and practices. For many Jews their interest in maintaining a connection with their Jewish 
                identity is expressed by an engagement with other Jewish cultural expressions, such as Jewish history, literature, music and politics.
                <br><br>
                In pre-World War II Europe there were many Jewish cultural organisations and political parties that sought Jewish self-expression in majority non-Jewish societies, 
                and that produced music, art and literature that reflected on Jewish experiences in history. Many of the artistic and literary works contained references to Jewish 
                religion and Jewish cultural traditions. Often these works discussed what Jewishness meant in a fast-changing social, political world which became better connected 
                through increasing opportunities to travel and to communicate.
            </p>
        </div>
    </div>
</div>
@endsection
