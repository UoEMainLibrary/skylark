@extends('layouts.pointsofarrival')

@section('title', 'Antisemitism | Points Of Arrival')

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

            <h1 class="poa-page-title ind-film-title">Antisemitism</h1>

            <p class="theme-info">
                In simple terms, antisemitism is hatred of Jews. Like all racisms it picks on a characteristic (here, being Jewish) that is an unchangeable part of a person, and fills 
                this characteristic with nasty ideas. Antisemitism is something that is brought to the Jewish people from the outside and to which Jews are asked to react.
                <br><br>
                Antisemitism can be expressed in stereotypes which exaggerate something that is true for some Jews and suggest that it applies to all Jews. 
                This produces always a negative image that becomes a target for hatred: for example, the observation that there are some Jews who are rich becomes the stereotype: ‘all Jews are rich’. 
                Other expressions of antisemitism have no links to anything that can be observed in reality. These are the results of fantasies which are used to blame Jews for things 
                that are wrong in society and that cannot be explained in simple, observable terms: for example, the deaths of many people by the plague in the Middle Ages was blamed 
                on Jews who were said to have poisoned wells; the vast differences between rich and poor and challenging economic times such as the financial crash of 2008 are blamed 
                on Jews who are said to ‘control’ the economy. Antisemitism, like all forms of racism, is based on myths, prejudice and bias and is both unjust and harmful to people 
                of Jewish heritage.
            </p>
        </div>
    </div>
</div>
@endsection
