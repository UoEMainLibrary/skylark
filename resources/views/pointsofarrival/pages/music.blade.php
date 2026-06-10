@extends('layouts.pointsofarrival')

@section('title', 'Music | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Music as a Global Language</h1>   
            <div class="theme-cont">
                <p class="theme-info">
                    Music is sometimes described as the one language shared by all humans. Even though many cultures have no single word for ‘music’, every group of people around the 
                    world takes part in activities that we could call ‘music-making’. For many of us, major life-events (weddings, births, deaths) would be unthinkable without music, 
                    and music is often an important part of everyday life. Across Scotland, and especially in the Hebridean Islands, women used to sing waulking songs to help keep 
                    together while softening cloth. Tribes such as the Suyá of Brazil, the Venda of South Africa and the Kaluli of Papua New Guinea use specific songs and singing styles 
                    to accompany almost all aspects of their daily work and recreation. Around the world, sailors sang sea shanties to keep in time while pulling up sails, and nowadays 
                    shops, restaurants and bars use music to draw customers in and create a particular atmosphere.
                    <br><br>
                    Music crosses borders, connects people around the world, and is a powerful and inclusive way to experience different cultures. For those of us that grow up in cities, 
                    music is often one of the first points of contact with different groups, nationalities and ethnicities. Music is also a way to bond together locally. Immigrants to a 
                    city can feel a sense of community through singing, playing, and dancing to the music of where they have come from. This music may form part of larger cultural or 
                    ritual events (such as religious festivals or annual celebrations), or it may simply remind them of home.
                    <br><br>
                    Music, however, can also lead to an increased perception of ‘difference’. In the 1950s and 60s, the calypso and ska music that Afro-Caribbean immigrants brought to 
                    the UK elicited both positive and negative reactions. Some saw it as an exciting and new sound, others as a threat. The same was true of African American hip-hop in 
                    the 1980s. Nevertheless, young people from different backgrounds often find common ground through music. Musical styles such as Bhangra and Grime developed as a result 
                    of the mixing of different cultures. And in a similar way, people from different parts of the world can find joy and meaning in music that comes from the other side of 
                    the globe.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
