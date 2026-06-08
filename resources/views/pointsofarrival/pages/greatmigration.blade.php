@extends('layouts.pointsofarrival')

@section('title', 'Greatmigration | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">The Great Migration</h1>
            <div class="theme-cont"> 
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/greatmigration.png">
                    <p class="theme-credits">
                        Warsaw <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                        books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                        (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> newspaper advertisement for Canadian Pacific Ocean Services. 
                        Sailing from Danzig (Gdansk), Antwerp, Liverpool, London, Glasgow and Southampton.
                    <p>
                </div>
                <p class="theme-info">
                    The late nineteenth and early twentieth century saw the mass migration of many people from Eastern Europe towards ‘the West’. Included among them were close to 2 
                    million Jews who moved from the Pale of Settlement towards North America, western Europe, the United Kingdom, and other parts of the English-speaking (Anglophone) 
                    world.
                    <br><br>
                </p>
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/greatmigration2.png">
                    <p class="theme-credits">
                        Sarah Jacobson Alien Registration Certificate (1916). Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p class="theme-info">
                    The Pale of Settlement was an area of the Russian Empire in which Jews had been permitted to settle in early modern times (the 15th and 16th centuries) following 
                    the movement of Jews from western and southern Europe towards the eastern Europe. This early modern migration was caused in part by antisemitic attacks and policies 
                    that drove Jews from western European countries and the expulsion of Jews from Christianised Spain in 1492. The Russian Empire allowed Jews to settle and form their 
                    own communities in relative safety. The safety was regularly disrupted by <abbr data-title="pogrom Mob violence against Jewish people, homes, and property. Usually 
                    the term refers more specifically to the anti-Jewish riots in the former Russian empire in the 19th and 20th centuries.">pogroms</abbr> (anti-Jewish riots), particularly 
                    during Christian religious festivals such as Easter. Easter celebrates the crucifixion and resurrection of Jesus Christ and the biblical stories in the New Testament 
                    lay part of the blame for Jesus’s death on the Jewish authorities of the time.  Although the Roman justice system was responsible for carrying out crucifixions, many 
                    Christians throughout the ages blamed Jews for the death of Jesus and used the opportunity to take their anger and other frustrations out on their Jewish neighbours. 
                    While Jews were able to prosper in the Pale of Settlement, their lives were also tightly controlled by the Russian authorities, marked by frequent violence, and, for 
                    many, great poverty. When Tsar Alexander II was assassinated in 1881 and the blame was again laid on Jews, many decided to leave their homes to seek safety and prosperity 
                    in the West. This movement of large numbers of Jews and others was made possible by the invention of rail travel and the steam boat which made long distance travel possible 
                    and affordable for many.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
