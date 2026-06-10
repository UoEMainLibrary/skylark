@extends('layouts.pointsofarrival')

@section('title', 'Family | Points Of Arrival')

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
            <h1 class="poa-page-title ind-film-title">Family</h1>
            <div class="theme-cont"> 
                <div class="theme-img-cont">
                    <img class="theme-still theme-top" src="{{ asset('collections/pointsofarrival/') }}/images/theme-images/family.png">
                    <p class="theme-credits">
                        Garnethill Boys Hostel, 1939. Courtesy of the Scottish Jewish Archives Centre.
                    <p>
                </div>
                <p class="theme-info">
                    One of the most difficult things that child refugees face was their dislocation from home and family. Children like <a href="./sim">Dorrith</a> and <a href="./wuga">Henry</a> 
                    had to make the journey from their homes in Europe to their new life in Britain in groups led by young adult volunteers. Children as young as two years old travelled without 
                    their parents and were collected in Harwich and London by people they didn’t know and who spoke a language they didn’t understand. The <abbr data-title="Kindertransport: (German for 
                    ‘children’s transport’) Rescue of c.10,000 unaccompanied Jewish children from Germany and Nazi-occupied Europe to Britain 1938-1939. The last transport was 1940 
                    when the start of World War II made further rescue impossible.">Kindertransport</abbr> was organised very quickly, 
                    transporting children from Germany, Austria and Czechoslovakia to Britain from December 1938 to September 1939. Most often children had to leave quickly, with little 
                    opportunity to learn English before they left Europe. 
                    <br><br>
                    Many parents and children hoped they would be together again soon, but the beginning of <a href="./holocaust">World War II</a> in September 1939 made it impossible for 
                    most parents to come to Britain. 
                    <br><br>
                    While the Kindertransport saved the lives of 10,000 children, it did not save their parents. Most children did never see their birth families again, because all were 
                    murdered in the <a href="./holocaust">Holocaust.</a>
                    <br><br>
                    In Britain, the children had to learn English and live in different families as foster children. Some children, like Dorrith and Henry, were lucky because they were 
                    fostered by families who loved them and looked after them in the same way as their own children. Others were not so lucky and found that the families they were 
                    staying with had very little interest in them. Some, particularly older children and teenagers, were not housed with families but made to work as servants or placed 
                    in hostels. Siblings were often split up to live with different families. Moreover, some children recalled the humiliation of being ‘passed over’ as British families 
                    were allowed to browse through the lined-up children to choose a child they wanted to look after, often picking those who looked cute and were very young.
                    <br><br>
                    Not all Jewish children were fostered by Jewish families, and even when they were there were, differences in British and German Jewish life could sometimes cause 
                    tension and conflict between family and child. Even when the religious background of the foster home and child matched, children had to learn about British culture, 
                    and often unlearn their culture from home. Children like Dorrith, who were fostered by Christian families, sometimes went on to choose to become Christian themselves 
                    in later life.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
