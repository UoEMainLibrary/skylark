@extends('layouts.pointsofarrival')

@section('title', 'Nazigermany | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Jewish Life in Nazi Germany</h1>   
            <div class="theme-cont">
                <p class="theme-info">
                    After the Nazi party came into government in 1933 life for Jews in Germany changed. In 1934 and 1935 laws were introduced which excluded Jews from participating in 
                    social and professional life: Jews could only go grocery shopping at particular times of the day, Jews could no longer work as civil servants, Jewish doctors could 
                    only treat Jewish patients, Jewish children had to go to a Jewish school, Jews could only marry Jews, couples where one partner was Jewish and the other not were 
                    asked to divorce (few did), Jews were forced to sell their shops or factories to non-Jews, Jews were forced to leave their homes and live in flats and houses with 
                    other Jews. Slowly, there was less and less contact between Jews and non-Jews. Jews were excluded from society and discriminated against in every area of life. 
                    <br><br>
                    Many Jews tried to leave Germany and begin a new life in a different country. Being able to do so depended on having a visa (permission to enter) for another country, 
                    and gaining such permission required evidence of enough money to leave the country and set up home elsewhere, or a relative or friend in the new country to write a 
                    guarantee (affidavit) that they would look after the emigrants. Countries such as the United Kingdom offered working visas, that is it allowed Jews from Germany to 
                    enter Britain to work in particular occupations. Many women applied to become domestic servants in British homes as that was a way to gain permission to come to the 
                    UK and it guaranteed an income. Many Jews did not have enough money and connections to leave Germany. 
                    <br><br>
                    The situation became even more stressful for Jews in November 1938 when the government organised terrorist attacks on the homes and businesses of Jews and on Jewish 
                    religious buildings such as <abbr data-title="Synagogue: Jewish place of worship.">synagogues</abbr> (the state organised terror on 9-10 November 1938 is also known as 
                    ‘Kristallnacht’, the night of broken glass). Many buildings and homes were destroyed, c.1,000 Jews were killed in violence by paramilitary organisations, and c.3,000 
                    Jews were arrested and imprisoned.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
