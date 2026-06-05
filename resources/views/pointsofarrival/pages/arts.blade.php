@extends('layouts.pointsofarrival')

@section('title', 'Arts | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Arts and Artists</h1>
            <div class="theme-cont">
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/arts.png">
                    <p class="theme-credits">
                        Josef Herman, Refugees (1941). Ben Uri Collection (c) Josef Herman Estate
                    <p>
                </div>
                <p  class="theme-info">
                    The Second Commandment against the creation of graven images or likenesses has largely been interpreted in Judaism as a prohibition on idols or ‘false’ objects of 
                    worship, rather than an outright ban on figurative art. From antiquity onwards, <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> interiors 
                    have often been decorated with images of animals, flora, or more abstract patterns and designs (although very rarely human figures). However, religious iconography 
                    has not played the kind of role in Judaism in the way that it has in Christianity, and until recent centuries much Jewish artistic creativity was directed towards 
                    the decoration of ritual objects and manuscripts, often to high levels of detail and craftsmanship.
                    <br><br>
                    Jews have frequently appeared as artistic subjects. The famous Dutch painter Rembrandt, who lived in the Jewish quarter of Amsterdam, created powerful images of 
                    Moses and other biblical figures, as well as finely-observed portraits of his Jewish contemporaries. Conversely, antisemitic stereotypes of Jews holding coins or 
                    the notorious ‘Wandering Jew’ can be found throughout European art history. From the 19th century onwards, however, Jewish artists began to express themselves more 
                    directly and to use visual art to represent and question their own Jewish identities – often articulating a tension between Judaism and the wider social world. 
                    Marc Chagall (1887-1985) is famous for his evocative and magical scenes of Jews and Jewish life, but in 1918 he also founded a tuition-free, modernist art academy, 
                    known as the People’s Art School, in his home city of Vitebsk (in present-day Belarus). In 1980s Britain, the American Jewish artist RB Kitaj produced a ‘Diasporist 
                    Manifesto’, declaring that ‘The Diasporist lives and paints in two societies at once.’
                    <br><br>
                </p> 
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/arts2.png">
                    <p class="theme-credits">
                        Garnethill Boys Hostel, 1939. Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p class="theme-info">
                    Scotland was home to several important Jewish like artists who were welcomed by the artistic community and influenced Scottish art. Sculptor Benno Schotz (RSO), 
                    for example, came to Glasgow from Estonia in 1912 and was Head of Sculpture and Ceramic at the Glasgow School of Art. There were also a number of influential 
                    painters who came as refugees to escape Nazi persecution in the 1930-40s. Alongside Hilda Goldwag, the painter Josef Herman, who fled his native Poland in 1938, 
                    lived and worked in Glasgow from 1940 to 1943. Several of his paintings – such as Refugees and Memory of a <abbr data-title="Pogrom: Mob violence against Jewish people, 
                    homes, and property. Usually the term refers more specifically to the anti-Jewish riots in the former Russian empire in the 19th and 20th centuries.">Pogrom</abbr> 
                    – directly address the uneasy and frightening 
                    experience of persecution and forced migration. Holocaust survivor Marianne Grant (1921-2007) also lived Glasgow, creating powerful paintings of her time as a 
                    prisoner in <abbr data-title="Auschwitz:  German name for the Polish town Oświęcim in southern Poland and the name of the largest complex of concentration camps 
                    built nearby during the Holocaust.">Auschwitz</abbr>-Birkenau and Bergen-Belsen. These paintings were reproduced in a 2002 book, entitled <i>I knew I was painting for my life.</i> Other significant 
                    Scottish Jewish artists active in Glasgow included Hannah Frank, Yankl Adler, and Paul Zuntersteinor.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
