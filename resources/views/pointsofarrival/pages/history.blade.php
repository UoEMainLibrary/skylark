@extends('layouts.pointsofarrival')

@section('title', 'History | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">The History of Jews in Scotland</h1>            
            <div class="theme-cont">
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/scotland.png">
                    <p class="theme-credits">
                        Glasgow Jewish linen merchant. Courtesy of the Scottish Jewish Archives Centre
                    <p>
                </div>
                <p  class="theme-info txt-rt">
                    Records of Jews in Scotland date back at least to the 17th century. Julius Conradus Otto, a Christian convert who later reverted to Judaism, became the first chair of 
                    <abbr data-title="Hebrew: Ancient language of the Jews originating in land of Canaan in which the Torah and other holy 
                    books and prayers are written. Hebrew was revived and modernised under Jewish nationalism in the 19th century. Modern Hebrew, 
                    (Ivrit) is the official language of the State of Israel. See also Torah">Hebrew</abbr> and Oriental Languages at Edinburgh University in 1642. Herman Lyon’s 1795 mausoleum on Calton Hill is thought to be the first Jewish gravesite in Edinburgh.
                    <br><br>
                    The Edinburgh Hebrew Congregation was founded in 1817. The majority of Edinburgh’s Jews lived in the southside and worshipped at <abbr data-title="Synagogue: Jewish place of worship.">synagogues</abbr> in Park Place and later 
                    Graham Street, while a smaller hall in Richmond Court catered to newer immigrants. For a time, the rubber workers in Dalry, to the west of the centre, had their own 
                    blekhene (‘tin roof’) <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr>. In 1932, the different groups of Edinburgh Jews were brought together, largely through the efforts of Rabbi Salis Daiches, within 
                    the newly-built Salisbury Road >synagogue, which remains the only fixed site of Jewish worship in the city.
                    <br><br>
                    Glasgow, Scotland’s largest city, has also always been home to the greatest number of the country’s Jews. The Glasgow Hebrew</abbr> Congregation was formed in 1823, 
                    and over the next fifty years a number of small synagogues opened around Glasgow’s city centre. In 1875, an imposing hilltop site was purchased on the corner of 
                    Garnet and Hill Streets, followed by the construction and consecration—in 1879—of an equally impressive “Moorish” style synagogue. Garnethill Synagogue continues 
                    to host a small and welcoming congregation, as well as being home to the Scottish Jewish Archives Centre. The majority of Glasgow’s Jewish population now live to 
                    the southwest of the city, which has been home to several synagogues since the middle of the twentieth century.
                    <br><br>
                    Other Jewish community centres established themselves in Scotland at the turn of the century. In Dundee, German Jewish merchants established a community in 1874, 
                    and in 1893 the Aberdeen Hebrew Congregation was founded. Other smaller communities also grew in Inverness, Dunfermline, Ayr, Falkirk, and Greenock.
                    <br><br>
                </p>
                <div class="theme-img-cont-right" id="theme-img-offset">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/scotland2.png">
                    <p class="theme-credits">
                    Rev Gershon Spilg and the Falkirk Cheyder. Courtesy of the Scottish Jewish Archives Centre.
                    <p>
                </div> 
                <p class="theme-info  txt-rt">
                    Although the numbers of Jews in Scotland was small (numbering c. 1,600 in 1881), from 1880 onwards, Scotland’s population of began to receive a significant number 
                    of Jewish immigrants from Eastern Europe. Many came with the large waves of late nineteenth-century East-West Jewish migration, escaping economic hardship and 
                    persecution in Russia, Poland and Rumania to seek out better lives in the West. These Eastern European arrivals signalled a new phase in the country’s Jewish life. 
                    Whereas the relatively small number of urban-based Jews in Scotland had already established themselves economically and were integrated into society (, many of 
                    the post-1880 Jews were poorer and less quick to assimilate. They spoke <abbr data-title="Yiddish: Language predominantly spoken by European Ashkenazi Jews, a mixture 
                    of medieval German, Hebrew, Aramaic and Slavic languages.">Yiddish</abbr>, or the short-lived Scots-Yiddish dialect. They were often more radical in their 
                    politics, or more orthodox in their observance. Some simply passed through Scotland on their way to America, but ended up staying – working as shopkeepers, tradesmen, 
                    tailors, furniture-makers, or sometimes travelling salesmen (known as trebblers). In Glasgow, the vast majority lived south of the river Clyde, in the Gorbals, one of 
                    the worst slums in Europe, later often moving out to suburbs such as Giffnock and Newton Mearns. In Edinburgh, most took up residence on the city’s Southside, many also 
                    in slum tenements.
                    <br><br>
                    Scotland’s Jewish population has always been smaller than that of English cities like London, Manchester, Leeds and Liverpool, but by the 1930s its population had 
                    risen from under 6,000 in 1900 to 20,000. Glasgow and Edinburgh became hubs of Jewish religious, intellectual, and cultural life. The 1930s-1940s also child and 
                    adult refugees from Nazi Germany and other countries under German occupation came to Scotland to seek refuge. A significant number of these refugees, such as the 
                    composer Hans Gal, artist Hilda Goldwag, and the neurologist Ernst Levin, made significant contributions to Scottish social and cultural life. In recent decades, 
                    emigration and assimilation have reduced this figure to around 6,000, still largely concentrated in Glasgow and Edinburgh.
                </p>
                <p class="theme-info">
                    <br><br>
                    You can explore Scotland’s Jewish history further with the online exhibition The Jewish Experience in Scotland, and through educational programmes offered by the 
                    Scottish Jewish Archives Centre. The Centre’s archive is open to visitors and a preview of the wealth of materials held can be accessed in the <strong><a href="https://www.sjac.org.uk/" 
                    target="_blank">Scottish Jewish Archives Centre’s Digital Collection.</a></strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
