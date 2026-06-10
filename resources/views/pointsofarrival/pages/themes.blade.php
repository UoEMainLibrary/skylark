@extends('layouts.pointsofarrival')

@section('title', 'Themes | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar --> 
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->
    
    <div id="poa-themes">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">

            <h1 class="poa-page-title">Themes</h4>

            <div class="themes-cont">
                <!--<h2>Adnan Shamdin</h2>
                <p>
                    <a href="./adnan" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>-->
                <h2>Antisemitism</h2>
                <p>
                    In simple terms, <abbr data-title="Antisemitism: Prejudiced beliefs, unfair treatment, persecution and/or hatred of Jewish people; incl. attacking or desecrating 
                    Jewish institutions or symbols.">antisemitism</abbr> is hatred of Jews. Like all racisms it picks on a characteristic (here, being Jewish) that is an unchangeable part of a person, 
                    and fills this characteristic with nasty ideas. Antisemitism is something that is brought to the Jewish people from the outside and to which Jews are asked to react.
                    <br>
                    <a href="./antisemitism" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Family</h2>
                <p>
                    One of the most difficult things that child refugees face was their dislocation from home and family. Children like Dorrith and Henry had to make the journey 
                    from their homes in Europe to their new life in Britain in groups led by young adult volunteers. Children as young as two years old travelled without their 
                    parents and were collected in Harwich and London by people they didn’t know and who spoke a language they didn’t understand.
                    <br>
                    <a href="./family" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>The Gorbals</h2>
                <p>
                    The Gorbals is an area on the south side of Glasgow, the first official part of the city south of the River Clyde. Coal mining was an early Gorbals industry, 
                    and in the 1790s it became a fashionable spot for those wanting to move out of the old city centre, with elegant suburban houses built along its broad streets.
                    <br>
                    <a href="./gorbals" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>The Great Migration</h2>
                <p>
                    The late nineteenth and early twentieth century saw the mass migration of many people from Eastern Europe towards ‘the West’. Included among them were close to 
                    2 million Jews who moved from the <abbr data-title="Pale of Settlement: Geographic area in the western part of the 
                    Russian Empire (1791-1917) in which Jews were permitted to live and travel. Unless issued special permits, Jews were forbidden to reside beyond outside these areas 
                    and in urban centres.">Pale of Settlement</abbr> towards North America, western Europe, the United Kingdom, and other parts of the English-speaking 
                    (Anglophone) world.
                    <br>
                    <a href="./greatmigration" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>History of Jews in Scotland</h2>
                <p>
                    Records of Jews in Scotland date back at least to the 17th century. Julius Conradus Otto, a Christian convert who later reverted to Judaism, became the first chair 
                    of <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                    books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                    (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> and Oriental Languages at Edinburgh University in 1642. Herman Lyon’s 1795 mausoleum on Calton Hill is thought to be the first Jewish gravesite in Edinburgh.
                    <br>
                    <a href="./history" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <p> 
                </p>
                <h2>Jewish Art and Artists</h2>
                <p>   
                    Religious iconography has not played the kind of role in Judaism in the way that it has in Christianity, and until recent centuries much Jewish artistic creativity 
                    was directed towards the decoration of ritual objects and manuscripts, often to high levels of detail and craftsmanship.     
                    <br>
                    <a href="./arts" rel="noopener"><i class="fa fa-eye"></i> Read More</a>            
                </p>
                <h2>Jewish Culture</h2>
                <p>
                    Not all Jews find it meaningful to engage with Jewish religious beliefs and practices. For many Jews their interest in maintaining a connection with their Jewish 
                    identity is expressed by an engagement with other Jewish cultural expressions, such as Jewish history, literature, music and politics.
                    <br>
                    <a href="./culture" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Jewish Food</h2>
                <p>
                <abbr data-title="Kosher (Hebrew): Label attached to food that is permitted 
                    to eat under Jewish dietary laws. See also Kashrut">Kosher</abbr> food is governed by the laws of <abbr data-title="Kashrut (Hebrew) Complex set of 
                    Jewish dietary laws that are biblical in origin. Main characteristics are to regulate the kinds of meat permitted (notably exclusion of shellfish and pork products), 
                    how meat and poultry are slaughtered, the prohibition of the consumption of blood, and separation of meat from dairy foods. Food that follows these regulations is 
                    deemed kosher. See also kosher">kashrut</abbr>, which have their basis in the <abbr data-title="Torah: Hebrew Bible, consisting of the first five books of Moses. In synagogue, 
                a different portion of the Torah is read aloud each Sabbath, usually from a handwritten Torah scroll.">Torah</abbr> and have been interpreted over the centuries by religious authorities so that 
                    they can be followed by Jews throughout the world. These laws determine which foods may be eaten, how they should be prepared, and what they can be eaten with.
                    <br>
                    <a href="./food" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Jewish Life in Eastern Europe</h2>
                <p>
                    Eastern European Jews are known as <abbr data-title="Ashkenazi (pl. Ashkenazim; Hebrew). From Hebrew word for ‘Germany’. The term refers to Jews whose origins 
                    and traditions can be traced to the communities that settled in Western Germany Northern France in the middle ages and then later to Eastern Europe 
                    (Poland-Lithuania commonwealth). Their spoken language was predominantly Yiddish. See also Yiddish">Ashkenazi</abbr> Jews. Jews began to settle in Poland, Russia and other parts of Eastern Europe from around the 15th century. Many moved 
                    there from countries further West, looking for better opportunities and sometimes escaping persecution.
                    <br>
                    <a href="./easterneurope" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Jewish Languages</h2>
                <p>
                    For the majority of Jewish history, Jews have not had a land of their own. This means that Jewish languages have often been shared across many countries, connecting 
                    diasporic groups through sacred texts, in poetry and song, and more recently with books, newspapers and broadcasting.
                    <br>
                    <a href="./languages" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Jewish Life in Nazi Germany</h2>
                <p>
                    After the Nazi party came into government in 1933 life for Jews in Germany changed. In 1934 and 1935 laws were introduced which excluded Jews from participating in 
                    social and professional life.
                    <br>
                    <a href="./nazigermany" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Jewish Religion</h2>
                <p>
                    A person is a Jew if they have Jewish parents. A Jew may choose to express their Jewishness by following the religion of Judaism. However, a person’s ‘Jewish status’ 
                    does not depend on them holding particular beliefs or following particular practices.
                    <br>
                    <a href="./religion" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Kindertransport</h2>
                <p>
                    After the state organised terror on 9-10 November 1938 (also known as ‘Kristallnacht’, the night of broken glass), the British government gave in to pressure from 
                    British citizens to allow children to take refuge in the United Kingdom as long as families and refugee organisations paid for their maintenance (food, clothes, 
                    education, housing and so on).
                    <br>
                    <a href="./kindertransport" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Music as a Global Language</a></h2>
                <p>
                    Music is sometimes described as the one language shared by all humans. Even though many cultures have no single word for ‘music’, every group of people around the 
                    world takes part in activities that we could call ‘music-making’.
                    <br>
                    <a href="./music" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Synagogue Music</h2>
                <p>
                    Music is a central part of Jewish worship. Many prayers are sung together by the whole congregation in <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr>, and some Jewish families sing prayers and songs around 
                    the table at a Friday night <abbr data-title="Sabbath/Shabbat: Jewish day of rest, beginning on Friday at sundown and 
                    lasting until Saturday evening. Many Jews attend synagogue on the morning of the Sabbath, and refrain from most forms of work.">Sabbath</abbr> meal.
                    <br>
                    <a href="./synagoguemusic" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>War and Holocaust</h2>
                <p>
                    World War II had consequences for Germany’s antisemitic policies. The Nazis were motivated by a fascist ideology which divided people up into nations and placed nations 
                    into a hierarchy.
                    <br>
                    <a href="./holocaust" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
                <h2>Welfare</h2>
                <p>
                    Throughout the world, synagogues have often been owned by their local Jewish community. Communities themselves raise funds to build a synagogue, and wealthier members 
                    often donate items such as Torah scrolls. Synagogue congregations organise khevrot (societies) in order to provide services to their community such as ritual bathing 
                    and burial – both of which have specific processes according to traditional Jewish law (halakhah).
                    <br>
                    <a href="./welfare" rel="noopener"><i class="fa fa-eye"></i> Read More</a>
                </p>
            </div>



        </div>
        <div class="clearfix"></div>
        <div class="spacer"></div>
        <div class="clearfix"></div>
    </div>
</div>

@endsection
