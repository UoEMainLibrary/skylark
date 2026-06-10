@extends('layouts.pointsofarrival')

@section('title', 'Religion | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Religion</h1>   
            <div class="theme-cont" class="theme-info">
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/religion.png">
                    <p class="theme-credits">
                        Interior of Garnethill Synagogue, Glasgow. Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p class="theme-info">
                    A person is a Jew if they have Jewish parents. A Jew may choose to express their Jewishness by following the religion of Judaism. However, 
                    a person’s ‘Jewish status’ does not depend on them holding particular beliefs or following particular practices. A person may be identified 
                    as a Jew by others, and not feel that they would choose this identification themselves. Sometimes, non-Jews wish to identify people as Jewish 
                    for reasons that have nothing to do with a person’s self-understanding. Such motivation can be racist and 
                    <abbr data-title="Antisemitism: Prejudiced beliefs, unfair treatment, persecu¬tion and/or hatred of Jewish people; incl. attacking or desecrating 
                    Jewish institutions or symbols."><a href="./antisemitism/">antisemitic</a></abbr>. Sometimes, Jews are interested in identifying others as Jewish, 
                    whether or not such an identification is meaningful to them.
                    <br><br>
                    Ethnically, Jews divide into three major categories: <abbr data-title="Ashkenazi (pl. Ashkenazim; Hebrew). From Hebrew word for ‘Germany’. The term refers to Jews whose origins 
                    and traditions can be traced to the communities that settled in Western Germany Northern France in the middle ages and then later to Eastern Europe 
                    (Poland-Lithuania commonwealth). Their spoken language was predominantly Yiddish. See also Yiddish"><em>Ashkenazi</em></abbr> Jews whose cultures and rituals 
                    originate in northern Europe, <abbr data-title="Sephardi (Hebrew for Spain): Jews of Spanish or Portuguese origin and traditions."><em>Sephardi</em></abbr> 
                    Jews who trace their origins to the Iberian peninsular, and <em>Mizrachi</em> Jews who hail from the Arab world, North Africa and the Middle East. 
                    Beyond that there are Jews identifying with smaller ethnic groupings such as Italian Jews, Chinese Jews, Afro-Carribbean Jews and so on.
                    <br><br>
                    If Jews express their Jewishness by practising the religion of Judaism, the following elements are likely to be relevant to them:
                </p>

                <ul class="religion-list">
                    <li class="title-religion-li"><em>Shabbat</em> observance:
                        <ul class="inner-religion-list">
                            <li>Saturday is the ‘day of rest’ and Jews celebrate this by taking time off from work and spending it with their family and friends. 
                                The Jewish day begins at sunset and on Friday night is marked by the lighting of <em>shabbat</em> candles followed by a festive meal. 
                                On Saturday morning Jews may attend religious services in the <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> during which the <abbr data-title="Torah: Hebrew Bible, consisting of the first five books of Moses. In synagogue, 
                                a different portion of the Torah is read aloud each Sabbath, usually from a handwritten Torah scroll."><em>Torah</em></abbr> (the <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                                books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                                (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> Bible) is read. 
                                On Saturday evening shabbat is concluded by a ritual called <em>Havdalah</em> (separation) which formally separates the holy time of 
                                <em>shabbat</em> from the ordinary time of the working week.</li>
                        </ul>
                    </li>
                    <li class="title-religion-li">Jewish festivals such as <em>Rosh Hashanah</em> and <em>Passover</em>:
                        <ul class="inner-religion-list">
                            <li>
                                <abbr data-title="Rosh Hashanah (‘start of the year’; Hebrew) One of the major Jewish festivals in the autumn that begins the period of the High Holidays. Rosh Hashanah 
                                celebrates the ‘birthday of the world’ and begins a period of introspection and repentance. which concludes the fast day of Yom Kippur. 
                                See also Yom Kippur"><em>Rosh Hashanah</em></abbr>, the Jewish new year, is a festival taking place in September. It is celebrated by rituals in the home and the 
                                <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> all of which remind Jews of renewal and the opportunity to begin afresh. The festival is also known as ‘<em>yom hazikkaron</em>’ 
                                (remembrance day) and marks the beginning of 10 days of introspection during which Jews are called to review their personal conduct over the 
                                past year and apologise to anyone they have quarelled with or whom they have done wrong to.
                            </li>
                            <li>
                            <abbr data-title="Passover (also Pesach in Hebrew): Jewish festival of biblical origin celebrated in the spring to 
                                commemorate the liberation of the Jews from slavery in Ancient Egypt. The festival lasts eight days and begins with a meal called the seder, in which the story of 
                                the exodus is told with special foods and songs. During Passover Jews do not eat chametz, foods made of flour that has undergone fermentation. See also chametz; 
                                seder"><em>Passover</em></abbr> is a springtime festival which celebrates the founding of the Jewish people as a nation. Central to the Passover story is 
                                the biblical book of Exodus which tells the story of the Israelites being freed from slavery in Egypt and travelling through the desert to 
                                their new home in the <abbr data-title="Land of Israel Name for the geographic location of the ancient homeland promised 
                                to the Jewish people in the narratives of the Hebrew Bible; not to be confused with the modern State of Israel. See also State of Israel">land of Israel</abbr>. 
                                Rituals are mainly home-based and centre around the <abbr data-title="Seder: Traditional meal on the first night of the eight-day festival of Passover. During the seder, 
                                the story of the Jews’ exodus from Egypt is recited with songs and a number of ritual foods are eaten."><em>seder</em></abbr> meal during which the story of the 
                                Exodus is recalled by reading a book (the <em>Haggadah</em>, which means ‘story’), and eating symbolic foods.
                            </li>
                        </ul>
                    </li>
                    <li class="title-religion-li">Hebrew:
                        <ul class="inner-religion-list">
                            <li>
                                Is the language of the Hebrew Bible. The Hebrew Bible contains 24 books that tell Jews important stories about the origins of the Jewish people, 
                                that give guidance about right conduct, and that remember events and lessons in poetry and song. Many Jews will know some >Hebrew which helps in 
                                getting to know biblical stories and follow the <a href="./synagoguemusic">liturgy of the synagogue</a>.
                            </li>
                            <li>
                                Hebrew</abbr> and the closely related language of <abbr data-title="Aramaic: Language spoken in Syria and much of Middle East 
                                from the 6th century (BCE); it replaced Hebrew as the main language spoken by Jews for a few hundred years. Although it is now 
                                considered a dead language, numerous Jewish books and prayers continue to be read and recited in Aramaic.">Aramaic</abbr> are also important in 
                                understanding the Talmud, the largest compilation of commentaries on the Hebrew Bible and its early interpretations.
                            </li>
                            <li>
                                Hebrew has been important as a scholarly language of the Jewish people for thousands of years. In the nineteenth century Hebrew was 
                                ‘brought up to date’ and began to be taught as a Jewish language for everyday use. Today, almost half of the Jewish population of the world speaks 
                                Hebrew as a native language as it is one of the official languages of the <abbr data-title="State of Israel: Location of the modern-day nation-state of Israel, 
                                founded in 1948.">State of Israel</abbr>. See also: <a href="./languages/">Jewish languages</a>.
                            </li>
                        </ul>
                    </li>
                    <li class="title-religion-li">Synagogue attendance:
                        <ul class="inner-religion-list">
                            <li>
                                Religious Jews need the company of other Jews to carry out key Jewish rituals. For a service at which the Torah is read, for example, most Jews need 
                                the company of 10 Jews, often this means 10 male Jews.
                            </li>
                            <li>
                                Synagogues are important gathering places which fulfil not only a religious but also a social function. As Jews are mainly a minority population in 
                                larger societies where the majority of people is not Jewish, synagogues are gathering places for Jews often regardless whether all those gathering 
                                identify with the religion of Judaism.
                            </li>
                        </ul>
                    </li>
                    <li class="title-religion-li">Jewish religious education for for children:
                        <ul class="inner-religion-list">
                            <li>
                                Many Jewish children will attend a religion school also known as <em>cheder</em> (‘room’). There they will be taught basic Jewish history, Hebrew, 
                                and be introduced to the main themes of Jewish liturgy and Jewish festivals. Religious education completes at the age of 12-13 with a ritual called 
                                <em>bar</em> or <em>bat</em><em>mitzvah</em> (‘son/daughter of the commandments’) which marks the entry into a Jewish congregation as a full participant 
                                who can be called on to perform rituals and prayers for or on behalf of the entire community.
                            </li>
                        </ul>
                    </li>
                    <li class="title-religion-li"><em>Kashrut </em>(dietary laws):
                        <ul class="inner-religion-list">
                            <li>
                                Jews distinguish between a number of different categories of food which inform the way in which dishes are prepared and eaten. These dietary laws 
                                originate in the Hebrew Bible and are interpreted in different ways, including a complete rejection of their relevance. Basic distinctions are the 
                                following: food can be either <abbr data-title="Kosher (Hebrew): Label attached to food that is permitted 
                                to eat under Jewish dietary laws. See also Kashrut"><em>kosher</em></abbr> (that is, fit to be eaten by Jews) or <em>treif</em> (that is unfit to be eaten by Jews). 
                                Among kosher foods the main distinctions are foods that contain meat (<em>fleishig</em>), foods that contain milk products (<em>milchig</em>) 
                                and foods that are neutral (<em>parev</em>). Meat and milk may not be consumed together in the same meal. Neutral foods can be eaten with either a meat 
                                or a milk meal. These distinctions form the basis of <abbr data-title="Kashrut (Hebrew) Complex set of 
                                Jewish dietary laws that are biblical in origin. Main characteristics are to regulate the kinds of meat permitted (notably exclusion of shellfish and pork products), 
                                how meat and poultry are slaughtered, the prohibition of the consumption of blood, and separation of meat from dairy foods. Food that follows these regulations is 
                                deemed kosher. See also kosher"><em>kashrut</em></abbr> observance and are relevant across all Jewish religious movements.
                            </li>
                        </ul>
                    </li>
                </ul>

                <p class="theme-info">
                    There are many different ways to be Jewish. While all the above elements will be relevant to religious Jews, they may be expressed very differently 
                    in the various Jewish religious movements.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
