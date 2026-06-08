@extends('layouts.pointsofarrival')

@section('title', 'Holocaust | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">The Holocaust</h1>            
            <div class="theme-cont"> 
                <p class="theme-info">
                    World War II started in Europe on 1 September 1939 when Germany attacked Poland. Because Britain was an ally of Poland, Britain declared war on Germany a few days later. 
                    Germany waged an aggressive war to extend its territory and seek to rule as many different places as possible. Germany first defeated Poland and then expanded westwards 
                    by annexing the Netherlands and attacking France. Soon, the entire European continent was at war, with Russia the USA joining in 1941 to help their Allies. Germany was 
                    defeated in 1945. Its territory was reduced to the borders we see today, and until 1990 Germany was divided into East and West Germany.
                    <br><br>
                    The war also had consequences for Germany’s antisemitic policies. The Nazis were motivated by a fascist ideology which divided people up into nations and placed nations 
                    into a hierarchy. So-called <abbr data-title="Aryan A term created in the 19th century to refer to Indo-European languages and the people who spoke them. In Nazi race ideology, 
                    ‘Aryan’ came to mean people of pure Nordic or Germanic descent, in contrast to ‘non-Aryans’ such as Jews, Roma (Gypsies), Africans, as well as Slavs and so-called ‘Asiatics’ 
                    (peoples of Soviet Central Asia and Muslims of the Caucasus region).">‘Aryans’</abbr> were deemed to be superior to other peoples. At the bottom of this hierarchy were Jews. The Nazis used antisemitic ideas and claimed 
                    that Jews were “at war” with other peoples and were wanting to destroy other nations and rule over them. Such conspiracy theories have no basis in reality, but they 
                    provide a convenient way of scapegoating, that is blaming everything that is wrong in a society (poverty and so on) on an invisible network of powers, rather than actually 
                    addressing the problems within a state. Styling Germans as ‘Aryans’ and Jews as ‘vermin’ that sought to destroy ‘Aryans’, Nazi ideology was built on the idea that the 
                    Jewish people, and other peoples and individuals at odds with their vision of society (Romani people, LGBT+ persons, the disabled, and so on), had to be destroyed. 
                    Since coming to power in 1933, the Nazis had passed many laws which effectively removed Jews from German society, creating a group of people who were no longer wanted in 
                    Germany. The Jewish population of Germany was small, c.500,000 people among a nation of c.67,000,000. At first the Nazis pushed Jews to emigrate and made Jews pay for their 
                    own removal from society by forcing them to sell off assets such as property and businesses to ‘Aryan’ Germans at very cheap prices. 
                    <br><br>
                    However, with hardly any states in the world willing to accept refugees and with the closing of borders at the beginning of the war, the Jews still remaining in Germany 
                    were effectively trapped. At the same time, Germany’s territorial expansion East and West brought many more Jews under Nazi jurisdiction. From 1939, German action against 
                    Jews, in particular in the newly gained territories, became physically brutal. The c.3,000,000 Jews on Polish territory were moved into ghettos, used as slave labour, 
                    and effectively exploited and starved to death. From summer 1941 murder by machine guns committed by special murder squads began as German forces moved East in their attack 
                    on the Soviet Union. ‘Industrial’ murder through gas chambers began in late 1941 in specially designed camps, the most notorious of which was <abbr data-title="Auschwitz:  
                    German name for the Polish town Oświęcim in southern Poland and the name of the largest complex of concentration camps built nearby during the Holocaust.">Auschwitz</abbr>
                    -Birkenau. Murder by gas continued until the end of 1944. At the end of the war in Europe in spring 1945 the majority of Europe’s Jewish population had been murdered. The number 
                    of Jews who were murdered is estimated to be around 6,000,000.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
