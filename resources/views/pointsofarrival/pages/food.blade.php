@extends('layouts.pointsofarrival')

@section('title', 'Food | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Food</h1>
            <p class="theme-info">
                Henry Wuga and his wife Ingrid worked for many years as <abbr data-title="Kosher (Hebrew): Label attached to food that is permitted 
                to eat under Jewish dietary laws. See also Kashrut">kosher</abbr> caterers. Kosher food is governed by the laws of 
                <abbr data-title="Kashrut (Hebrew) Complex set of Jewish dietary laws that are biblical in origin. Main characteristics are to regulate 
                the kinds of meat permitted (notably exclusion of shellfish and pork products), how meat and poultry are slaughtered, the prohibition of 
                the consumption of blood, and separation of meat from dairy foods. Food that follows these regulations is deemed kosher. See also kosher">
                kashrut</abbr>, which have their basis in the <abbr data-title="Torah: Hebrew Bible, consisting of the first five books of Moses. In synagogue, 
                a different portion of the Torah is read aloud each Sabbath, usually from a handwritten Torah scroll.">Torah</abbr> and 
                have been interpreted over the centuries by religious authorities so that they can be followed by Jews throughout the world. These laws determine which foods may 
                be eaten, how they should be prepared, and what they can be eaten with. For example, dishes containing milk and dishes containing meat may not be eaten together, 
                and the consumption of certain animals (such as pigs) and shellfish is forbidden. In order to keep a kosher kitchen, many Jews have two or three different sets of 
                utensils. Packaged food in supermarkets will often be marked with a special symbol, and certain shops display certificates, so that those who follow kashrut can be 
                sure that they are not buying <abbr data-title="Treyf: (also treif; Yiddish) Term for food that is forbidden under Jew dietary laws. See also kosher">treyf</abbr> 
                (non-kosher) food.
                <br><br>
                Like all aspects of Jewish culture, Jewish food is often influenced by the part of the world in which it developed. <abbr data-title="Sephardi (Hebrew for Spain): 
                Jews of Spanish or Portuguese origin and traditions.">Sephardi</abbr> cuisine, with its roots in Spain, Southern Europe, and the Middle East, often includes the 
                aromatic spices, dried fruits and grains that are characteristic of those regions. By contrast, the food of Eastern European <abbr data-title="Ashkenazi: (pl. Ashkenazim; Hebrew). 
                From Hebrew word for ‘Germany’. The term refers to Jews whose origins and traditions can be traced to the communities that settled in Western Germany Northern France in 
                the middle ages and then later to Eastern Europe (Poland-Lithuania commonwealth). Their spoken language was predominantly Yiddish. See also Yiddish">Ashkenazi</abbr> 
                Jews is known for its borsht, pickles, gefilte fish, dumplings, black bread and other dishes adapted from German and later Russian 
                and Polish cuisine. Reflecting more recent migration patterns, Israeli food incorporates many dishes and ingredients from North African and Middle Eastern Arab 
                cuisines, such as <abbr data-title="Falafel: Fried chickpea croquettes, popular in Israel and Middle East.">falafel</abbr>, <abbr data-title="Couscous:  A popular North African eastern dish made from very small balls of durum wheat and served with a slow roasted chickpea stew. Often eaten on Sabbath day in Sephardic homes.  
                See also Sephardi">couscous</abbr> and pastries.
                <br><br>
                Many Jewish holidays are linked with particular foods, sometimes through scripture and sometimes through tradition. Plaited <abbr data-title="Challah: (pl. challot; Hebrew) Braided egg bread 
                traditionally eaten on the Sabbath and other Jewish holidays.">challah</abbr> bread is often eaten on a Friday night <abbr data-title="Sabbath/Shabbat: Jewish day of rest, 
                beginning on Friday at sundown and lasting until Saturday evening. Many Jews attend synagogue on the morning of the Sabbath, and refrain from most forms of work.">Sabbath</abbr> 
                meal, with a slow-cooked <abbr data-title="Cholent (also chulent, tsholent; Yiddish). A slow-cooked stew, traditionally prepared for Sabbath and eaten on Saturday lunch in 
                Ashkenazi homes.">cholent</abbr> stew on Saturday – this can be cooked before sundown on Friday, thus making sure that the Sabbath prohibition against lighting a fire (cooking) 
                is not broken. At <abbr data-title="Passover (also Pesach in Hebrew): Jewish festival of biblical origin celebrated in the spring to commemorate the liberation of the 
                Jews from slavery in Ancient Egypt. The festival lasts eight days and begins with a meal called the seder, in which the story of the exodus is told with special foods and songs. 
                During Passover Jews do not eat chametz, foods made of flour that has undergone fermentation. See also chametz; seder">Passover</abbr>, unleavened matzoh bread (pronounced motsah) 
                reminds Jews of their hurried escape from bondage. The Passover seder plate also holds six other foods that symbolise the Jews’ exodus from Egypt, including bitter herbs that stand 
                for the bitter experience of slavery, and <abbr data-title="Haroset: (also charoset; Hebrew) A dark coloured paste made of nuts, apples and sweet wine eaten at the Passover seder to 
                commemorate the bricks and mortar the Hebrew slaves made in ancient Egypt. See also Passover; seder">haroset</abbr> – a sticky paste of nuts, fruit, and sweet wine – to represent the 
                building mortar used by Hebrew slaves. Observant Jews will fast on <abbr data-title="Yom Kippur (Hebrew): Day of Atonement. The holiest day of the Jewish calendar, Yom Kippur is marked 
                by introspection and penitence. Many Jews will fast and spend most of the day in synagogue.">Yom Kippur</abbr>, the Day of Atonement, and at New Year (<abbr data-title="Rosh Hashanah (‘start of the year’; Hebrew): 
                One of the major Jewish festivals in the autumn that begins the period of the High Holidays. Rosh Hashanah celebrates the ‘birthday of the world’ and begins a period of introspection and 
                repentance. which concludes the fast day of Yom Kippur. See also Yom Kippur">Rosh Hashanah</abbr>) apples are dipped in honey to wish for a sweet year to come.
            </p>
        </div>
    </div>
</div>
@endsection
