@extends('layouts.pointsofarrival')

@section('title', 'Kindertransport | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Kindertransport</h1>            
            <div class="theme-cont">
                <div class="theme-img-cont-right">
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/kindertransport.png">
                    <p class="theme-credits">
                        Kindertransport children. Courtesy of the Association of Jewish Refugees.
                    <p>
                </div>
                <p class="theme-info">
                    After the state organised terror on 9-10 November 1938 (also known as ‘Kristallnacht’, the night of broken glass), the British government gave in to pressure from 
                    British citizens to allow children to take refuge in the United Kingdom as long as families and refugee organisations paid for their maintenance (food, clothes, 
                    education, housing and so on). This project is known as the Kindertransport (children’s transport) and it allowed c.10,000 children from Germany, Austria, and the 
                    Czech Republic and Poland to come to Britain without their parents. The children stayed here until after the war and many remained in Britain and eventually became 
                    British. Only very few children were reunited with their parents after the war. Most parents had been murdered by the Nazis.
                    <br><br>
                </p>
                <div class="theme-img-cont-right"> 
                    <img class="theme-still" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/kindertransport2.png">
                    <p class="theme-credits">
                        Kinderstransportee Henry Wuga’s landing card. Courtesy of Henry Wuga.
                    <p>
                </div>
                <p class="theme-info">
                    In 1990 Dorrith Sim founded the Scottish Association of Reunion of Kinder (SAROK), and helped many people who had come to Scotland as child refugees to meet and share 
                    their stories. For many who then were often grandparents themselves it was very helpful to be able to get together and talk with others who had experienced similar 
                    things in their childhood. It was a place to reconnect with memories and to share stories with people who could understand them.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
