@extends('layouts.pointsofarrival')

@section('title', 'Synagoguemusic | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Synagogue Music</h1>   
            <div class="theme-cont">
                <p class="theme-info">
                    Music is a central part of <a href="./religion">Jewish worship</a>. Many prayers are sung together by the whole congregation in <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr>, and some Jewish families sing 
                    prayers and songs around the table at a Friday night <abbr data-title="Sabbath/Shabbat: Jewish day of rest, beginning on Friday at sundown and 
                    lasting until Saturday evening. Many Jews attend synagogue on the morning of the Sabbath, and refrain from most forms of work.">Sabbath</abbr> meal. Jewish holidays and festivals often have particular songs associated with them, such as dayenu at a 
                    <abbr data-title="Passover (also Pesach in Hebrew): Jewish festival of biblical origin celebrated in the spring to 
                    commemorate the liberation of the Jews from slavery in Ancient Egypt. The festival lasts eight days and begins with a meal called the seder, in which the story of 
                    the exodus is told with special foods and songs. During Passover Jews do not eat chametz, foods made of flour that has undergone fermentation. See also chametz; 
                    seder">Passover</abbr> <abbr data-title="Seder: Traditional meal on the first night of the eight-day festival of Passover. During the seder, 
                    he story of the Jews’ exodus from Egypt is recited with songs and a number of ritual foods are eaten.">Seder</abbr> and Avinu Malkeinu on the Day of Atonement. Most of these prayers and songs are in <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                    books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                    (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr>.
                    <br><br>
                    <abbr data-title="Synagogue: Jewish place of worship.">Synagogue</abbr> singing is often lead by a prayer leader. This may be a rabbi, or it may be a <em>cantor</em> – normally a trained musician and singer who is also well-versed in Jewish 
                    liturgy (like <a href="./hirshow">Isaac Hirshow</a>). Many synagogues also have choirs, often trained by the cantor. In Reform and Liberal synagogues, the choir is mixed; 
                    in most Orthodox congregations it consists only of men.
                    <br><br>
                    At synagogue every Saturday morning, a different portion of the Jewish <abbr data-title="Torah: Hebrew Bible, consisting of the first five books of Moses. In synagogue, 
                    a different portion of the Torah is read aloud each Sabbath, usually from a handwritten Torah scroll."><em>Torah</em></abbr> (bible) is chanted aloud by the prayer leader. Over the course of a year 
                    (in some congregations three years), then entire Torah is chanted. This system of chanting is known as <em>cantillation</em>, and it uses small symbols written above the Hebrew 
                    letters in a Torah scroll. Jews around the world use different cantillation melodies, known as <em>nusakh</em>. The Eastern European <abbr data-title="Ashkenazi (pl. Ashkenazim; Hebrew). From Hebrew word for ‘Germany’. The term refers to Jews whose origins 
                    and traditions can be traced to the communities that settled in Western Germany Northern France in the middle ages and then later to Eastern Europe 
                    (Poland-Lithuania commonwealth). Their spoken language was predominantly Yiddish. See also Yiddish">Ashkenazi</abbr> <em>nusakh</em> that Isaac Hirshow was 
                    trained in has a very dramatic, decorative sound, and requires great virtuosity from the cantor. The best-known Eastern European cantors like Gershon Sirota (1874-1943) 
                    and Yossele Rosenblatt (1882-1933) were as famous as opera stars in their day.
                    <br><br>
                    Synagogue music performs a very particular function, but it has also been a source of inspiration for many musicians outside the synagogue. The German composer Max Bruch, 
                    the French composer Maurice Ravel, and the Russian composer Dimitri Shostakovich have all used Jewish themes and motifs in their work, even though none of them was Jewish.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
