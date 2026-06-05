@extends('layouts.pointsofarrival')

@section('title', 'Welfare | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Welfare</h1>   
            <div class="theme-cont">
                <div class="theme-img-cont">
                    <img class="theme-still theme-top" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/welfare.png">
                    <p class="theme-credits">
                        Female Friendly Society. Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p class="theme-info">
                    Throughout the world, <abbr data-title="Synagogue: Jewish place of worship.">synagogues</abbr> have often been owned by their local Jewish community. Communities themselves 
                    raise funds to build a synagogue, and wealthier members 
                    often donate items such as <abbr data-title="Torah: Hebrew Bible, consisting of the first five books of Moses. In synagogue, 
                    a different portion of the Torah is read aloud each Sabbath, usually from a handwritten Torah scroll.">Torah</abbr> scrolls. Synagogue congregations organise khevrot 
                    (societies) in order to provide services to their community such as ritual bathing 
                    and burial – both of which have specific processes according to traditional Jewish law (halakhah).
                    <br><br>
                    More generally, the act of philanthropy (tzedakah) is considered an important mitzvah (good deed). This means that a Jewish community will often provide welfare for 
                    its members, especially those in greater need, as well as for other Jews around the world, particularly in times of trouble. Historically, this has also led to the 
                    formation of charitable bodies, many of which survive to this day. In 1843, a group of German Jewish immigrants in New York founded an organisation to help alleviate 
                    the poverty and difficult living conditions in the Lower East Side, where a large number of Jews continued to settle until 1924. They aimed in particular to provide 
                    help to the sick and the elderly, and to offer assistance to widows and orphans. The organisation eventually became a worldwide network of Jewish mutual aid called 
                    B’nai Brith (Children of the Covenant). There are still a number of B’nai Brith Lodges in the UK, who work to promote Jewish charities, to support Jewish communities, 
                    and to combat religious intolerance.
                    <br><br>
                    As Jews began to settle in Glasgow in larger numbers in the second half of the 19th century, several societies formed in order to offer financial assistance to those 
                    who were struggling or even destitute. The Glasgow <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                    books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                    (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> Philanthropic Society, first mentioned in 1858, offered medical provision before the arrival of the welfare 
                    state. This society later became the Glasgow Jewish Board of Guardians, and is nowadays known as Jewish Care Scotland. It has its own purpose-build community centre, 
                    from which it runs a number of social clubs and services, as well as supporting the care in the community of more vulnerable groups.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
