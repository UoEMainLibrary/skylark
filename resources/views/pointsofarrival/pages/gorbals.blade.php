@extends('layouts.pointsofarrival')

@section('title', 'Gorbals | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">The Gorbals</h1>
            <div class="theme-cont">
                <div class="theme-img-cont">
                    <img class="theme-still theme-top" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/gorbals.png">
                    <p class="theme-credits">
                        1901 map of Glasgow. Reproduced with the permission of the National Library of Scotland
                    <p>
                </div> 
                <p class="theme-info">
                    The Gorbals is an area on the south side of Glasgow, the first official part of the city south of the River Clyde. Coal mining was an early Gorbals industry, 
                    and in the 1790s it became a fashionable spot for those wanting to move out of the old city centre, with elegant suburban houses built along its broad streets.
                    <br><br>
                    From the middle of the 19th century onwards, the Gorbals saw the arrival of large numbers of immigrant groups. These included Highland Gaels, Italians, Irish, 
                    Lithuanians and Jews, often living in subdivided tenement flats or even single rooms. Many of these immigrants would have found themselves in close proximity to 
                    different languages, foods, songs, and religious traditions – some of which would have been new to them. Immigrants maintained ties through societies, unions and 
                    social events, but many also mixed more freely with other nationalities and ethnicities.
                    <br><br>
                    From approximately 1880 until after World War II, the Gorbals was the centre of Jewish life in Glasgow. The city’s largest <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> 
                    was built on South Portland Street in 1901, and in the 1930s the Glasgow Jewish Institute was founded next door. The Jewish Institute hosted sports clubs, youth groups, dances, concerts and 
                    other social events. It had its own theatre, and the Jewish Institute Players – under their leader Avrom Greenbaum – won many amateur dramatic awards. From the 
                    1940s onwards, increasing numbers of Jews moved out of the Gorbals and further south to areas such as Giffnock, which is now home to the majority of Glasgow’s 
                    Jewish population.
                    <br><br>
                    The Gorbals in the first half of the 20th century was a very deprived area, with the dubious distinction of Europe’s largest slum. In the 1960s and 1970s, 
                    the area’s tenement housing was pulled down and replaced with some of Glasgow’s first high-rise flats. These, however, did not prove a good idea, and they too 
                    have now been demolished.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
