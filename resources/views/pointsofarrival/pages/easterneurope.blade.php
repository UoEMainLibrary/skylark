@extends('layouts.pointsofarrival')

@section('title', 'Easterneurope | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Life In Eastern Europe</h1>
            <div class="theme-cont"> 
                <div class="theme-img-cont">
                    <img class="theme-still theme-top" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/easterneurope.png">
                    <p class="theme-credits">Location of the Pale of Settlement.<p>
                </div>
                <p class="theme-info">
                    Eastern European Jews are known as <abbr data-title="Ashkenazi: (pl. Ashkenazim; Hebrew). From Hebrew word for ‘Germany’. The term refers to Jews whose origins 
                    and traditions can be traced to the communities that settled in Western Germany Northern France in the middle ages and then later to Eastern Europe 
                    (Poland-Lithuania commonwealth). Their spoken language was predominantly Yiddish. See also Yiddish">Ashkenazi</abbr> Jews. Jews began to settle in Poland, Russia and other parts of Eastern Europe from around the 15th century. 
                    Many moved there from countries further West, looking for better opportunities and sometimes escaping persecution. They worked as artisans, as merchants, 
                    as musicians, as innkeepers, and in many other trades. Some collected taxes and revenue for Polish landowners. Jews in Eastern Europe mostly spoke a language 
                    called Yiddish, which has its roots in German but also includes elements of Hebrew, <abbr data-title="Aramaic: Language spoken in Syria and much of Middle East 
                    from the 6th century (BCE); it replaced Hebrew as the main language spoken by Jews for a few hundred years. Although it is now considered a dead language, 
                    numerous Jewish books and prayers continue to be read and recited in Aramaic.">Aramaic</abbr>, and Slavic languages such as Russian and Polish.
                    <br><br>
                    In the late 18th century, the Russian Empire took over a large part of what had been the Polish-Lithuanian Commonwealth, including many areas where Jews lived. 
                    Partly as a result of this, in 1791 the Russian ruler Catherine the Great created what became known as the <abbr data-title="Pale of Settlement: Geographic area in 
                    the western part of the Russian Empire (1791-1917) in which Jews were permitted to live and travel. Unless issued special permits, Jews were forbidden to reside 
                    beyond outside these areas and in urban centres.">Pale of Settlement</abbr>. This was a large area of land that stretched from the Baltic States in the North to 
                    the Black Sea in the South, and it was here that most of Russia’s 5 million Jews were forced to live. They could travel within the Pale, but it was harder to move 
                    outside it, and only a very few Jews were allowed to live further East in cities like Moscow or St Petersburg.
                    <br><br>
                    Many Jews in the Pale of Settlement lived in small market towns known as <abbr data-title="Shtetl (‘little’ town; Yiddish): Term used for a small village or 
                    market town in Eastern Europe with a large Jewish population before the Second World War.">shtetls. They often lived close to the centre, and in some 
                    shtetls</abbr> nearly half the population was Jewish. Large numbers of Jews also lived in large Eastern European cities such as Warsaw, Krakow and Odessa. In many of these 
                    cities, Jewish life was concentrated in a particular area. Here, street signs would be in <abbr data-title="Yiddish: Language predominantly spoken by European Ashkenazi Jews, 
                    a mixture of medieval German, Hebrew, Aramaic and Slavic languages.">Yiddish</abbr>, there were numerous <abbr data-title="Synagogue: Jewish place of worship.">synagogues</abbr>, 
                    <abbr data-title="Kosher (Hebrew): Label attached to food that is permitted to eat under Jewish dietary laws. See also Kashrut">kosher</abbr> butchers and Yiddish
                    newspaper sellers, and Jewish businesses and organisations flourished.
                    <br><br>
                    A small number of Eastern European Jews became wealthy, but many remained poor. Many faced persecution and violent attacks known as <abbr data-title="Pogrom: Mob violence against Jewish people, 
                    homes, and property. Usually the term refers more specifically to the anti-Jewish riots in the former Russian empire in the 19th and 20th centuries.">pogroms</abbr>, and a large number were 
                    forcibly drafted into the Russian army for up to 25 years. As a result of these economic and social problems, between 1880 and 1914 large numbers of Jews emigrated 
                    from Poland, the Russian Empire, Lithuania and other Eastern European countries – to the UK, to Western Europe, to Australia and to South America, and most of all to 
                    the USA.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
