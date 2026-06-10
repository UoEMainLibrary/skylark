@extends('layouts.pointsofarrival')

@section('title', 'Languages | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Languages</h1>            
            <div class="theme-cont">
                <div class="theme-img-cont">
                    <img class="theme-still theme-top" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/languages.png">
                    <p class="theme-credits">
                        Hebrew primer, published in 1931 by H M Langman, Glasgow. Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p class="theme-info">
                    For the majority of Jewish history, Jews have not had a land of their own. This means that Jewish languages have often been shared across many countries, connecting 
                    diasporic groups through sacred texts, in poetry and song, and more recently with books, newspapers and broadcasting.
                    <br><br>
                    The first language that Jews spoke was <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                    books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, a different portion of the Torah 
                    is read aloud each Sabbath, usually from a handwritten Torah scroll.">Torah</abbr>) and other holy books. With the destruction of the First Temple in Jerusalem 
                    in 587 BCE, the Jewish people went into exile in Babylon and <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the 
                    Torah and other holy books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                    (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> lost its centrality as a spoken language. 
                    It was revived into Modern Hebrew and adoption by Jews in Palestine and later the <abbr data-title="State of Israel: Location of the modern-day nation-state of Israel, 
                    founded in 1948.">State of Israel</abbr> in the twentieth century.
                    <br><br>
                    After the destruction of the Second Temple in Jerusalem in 70 CE, the majority of Jews lived outside of the <abbr data-title="Land of Israel Name for the geographic location of the ancient homeland promised 
                    to the Jewish people in the narratives of the Hebrew Bible; not to be confused with the modern State of Israel. See also State of Israel">Land of Israel</abbr> (a statistic that remains true to this day), 
                    and their patterns of migration were reflected in their language. In the first few centuries CE, the most important Jewish language was <abbr data-title="Aramaic: Language spoken in Syria and much of Middle East 
                    from the 6th century (BCE); it replaced Hebrew as the main language spoken by Jews for a few hundred years. Although it is now considered a dead language, 
                    numerous Jewish books and prayers continue to be read and recited in Aramaic.">Aramaic</abbr>, which was spoken widely throughout the Middle and Near East. 
                    The massive books of law and commentary, the Talmud, were written in Aramaic, and a number of prayers in the Jewish prayer book are 
                    still recited in Aramaic. The traditional Jewish wedding certificate (ketuba) is still written and read in Aramaic today.
                    <br><br>
                    As Jews settled further into Europe they developed a number of languages, often incorporating elements from the wider society around them. Many of these are now no 
                    longer in use, but the two that survive are <abbr data-title="Yiddish: Language predominantly spoken by European Ashkenazi Jews, a mixture of medieval German, Hebrew, Aramaic and Slavic languages.">Yiddish</abbr> and Judesmo (also known as <abbr data-title="Ladino: (also Judeo-Spanish) Synthesis of Old Spanish, Arabic and Hebrew, it was the language predominantly spoken by Sephardi Jews in Spain and the countries 
                    in which they settled after Jews were expelled from Spain in 1492.">Ladino</abbr>). Judesmo has its roots in medieval Spanish, reflecting the vibrant Jewish 
                    culture in Spain and Portugal prior to expulsion in 1492. Although the number of Judesmo speakers is now in the thousands, an increasing number of musicians are 
                    rediscovering its rich musical heritage.
                    <br><br>
                    Yiddish was widely spoken before the war by millions of Jews in Poland, Russia, Central Europe, North and South America, and the UK. <abbr data-title="Yiddish: Language predominantly 
                    spoken by European Ashkenazi Jews, a mixture of medieval German, Hebrew, Aramaic and Slavic languages.">Yiddish</abbr> shares many similarities 
                    with early German (Middle High German), but also incorporates elements of Hebrew, Aramaic, Italian and French, English, and Slavic languages – all places where Jews 
                    have settled over the past 1000 years. In the 19th and early 20th centuries a flourishing Yiddish publishing industry connected Jews across Europe, the Americas and 
                    Australia. Although there are now far fewer native Yiddish speakers, Yiddish it is still spoken within Chasidic (ultra-orthodox) communities in the US, Europe, and 
                    Israel. There is also a growing transnational Yiddish music scene – from folk to rock to rap music. Many Yiddish words have found their way into general English usage, 
                    such as chutzpah (cheekiness), schlep (carry), and schmooze (chat).
                    <br><br>
                    When the Zionist movement and desire for a Jewish homeland grew in the early twentieth century, so too did the effort to reinstate Hebrew as the ‘official’ Jewish 
                    language. At the time, very few people actually spoke this language and it was still rooted in antiquity and mostly used for prayer and learning holy books. 
                    The man credited with the creation of modern Hebrew is the Lithuanian-born Eliezer Ben-Yehuda (1858-1922). Hebrew is the first language of most Israelis, 
                    and is also spoken and understood by many Jews outside of Israel. However, the most common language shared by Jews across the world today is English.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
