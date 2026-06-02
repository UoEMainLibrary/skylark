@extends('layouts.jlss')

@section('title', 'About - Jewish Lives Scottish Spaces')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">

    <div class="content byEditor">

        <div id="about-image">
            <img src="{{ asset('collections/jlss/images/sjac-temp.jpg') }}" alt="Garnethill Synagogue" class="img-responsive">
        </div>
        <br>
        <br>

        <h1> The Scottish Jewish Archives Centre</h1>
        <div class="content-divider-inline"><p>divider</p></div>

        <div class="about-para">
            <p> <a href="https://www.sjac.org.uk/" target="_blank" alt="link to the SJAC website" title="Click to visit the SJAC home page">Scottish Jewish Archives Centre</a>
                is dedicated to preserving Scotland's Jewish heritage. Since 1987 we have
                been collecting historic material relating to the experiences of Jewish people in Scotland over the past 200
                years. We document, preserve, exhibit and publish aspects of the collections and make the collections available
                for education, academic research, tourists and visitors of all kinds.  We welcome research enquiries and visitors
                and organise regular <a href="https://www.sjac.org.uk/news-events/" target="_blank" alt="link to the SJAC website" title="Click to visit the SJAC news and events page">Open Days</a> and events.
            </p>
        </div>

        <h1> Jewish Lives, Scottish Spaces</h1>
        <div class="content-divider-inline"><p>divider</p></div>

        <div class="about-para">
            <p><a href="http://gtr.rcuk.ac.uk/project/CBEEB0C2-2F73-4D86-B95A-04D906257602" target="_blank"
                alt="link to the JLSS blog page" title="Click to visit the JLSS blog">Jewish Lives, Scottish
                Spaces</a> was a research project funded by the <a href="http://www.ahrc.ac.uk/Pages/Home.aspx" target="_blank"
                alt="link to the HRC home page" title="Click to visit the Humanities Research Council home page">Arts
                and Humanities Research Council</a>. It was a joint project between the Universities of Edinburgh and Glasgow that ran
                from September 2015 until April 2018.
            </p>
            <p>As Jews in Scotland moved between and within, into and out of local and transnational spaces, the objects they saved, used
                and created reveal how Jews self-identified as they negotiated issues such as antisemitism, assimilation, cultural loss,
                memory and the Holocaust, nationalism and belonging. The materiality of such Scottish Jewish ‘memory objects’ testifies to
                the visibility of aspects of the past in the immediate environment of people’s new lives in Scotland. The location and placement
                of these items within a Scottish landscape offers a rich ground for the investigation of various processes of cultural transition
                and provides a link to the study of the city and Jewish space, thus making the best use of the available archival resources and
                material evidence.
            </p>
        </div>

        <h1> Our Collections </h1>
        <div class="content-divider-inline"><p>divider</p></div>

        <div class="about-para">
            <p>The Centre collects a wide range of material, and its large collection includes old <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> minute books and registers,
                membership lists, over 6,000 photographs, oral history recordings, annual reports of many communal organisations, a small
                library of books of Scottish Jewish interest, friendly society regalia, personal papers, war medals, ceremonial keys,
                newspapers, magazines, trophies, plaques, paintings and sculptures.
            </p>
        </div>

        <h1> Open To everyone </h1>
        <div class="content-divider-inline"><p>divider</p></div>

        <div class="about-para">
            <p> These collections are documented, preserved and exhibited for the benefit of the general public, and visitors including
                researchers, school pupils, students, postgraduates, journalists, television producers, tourists, family historians and others.
            </p>
        </div>

        <h1>Contact Details</h1>
        <div class="content-divider-inline"><p>divider</p></div>

        <div class="about-para">
            <p><strong>Scottish Jewish Archives Centre</strong><br>
                Garnethill Hebrew Congregation<br>
                129 Hill Street<br>
                Garnethill<br>
                Glasgow<br>
                G3 6UB<br>
                <strong>Tel:</strong> +44 (0)141 332 4911<br>
                <strong>Email:</strong> <a class="email" href="mailto:info@sjac.org.uk" alt="email link to SJAC" title="Click to email the SJAC team">info@sjac.org.uk</a><br/>
            </p>
        </div>

    </div>

</div>

<div class="col-sidebar">
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="header-search">
        <div id="collection-search">
            <form action="{{ \App\Support\CollectionUrl::url('search') }}" method="post" class="navbar-form">
                @csrf
                <div class="input-group search-box">
                    <input type="text" class="form-control" placeholder="Search" name="q" id="q">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="sidebar-nav">
        <ul class="list-group">
            <li class="list-group-item active">
                <a href="./browse/Collection" alt="sidae bar facet link" title="Click to view all Collections">Collection</a>
            </li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;theatre+%7C%7C%7C+Theatre&quot;">Theatre</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;serving+their+country+%7C%7C%7C+Serving+Their+Country&quot;">Serving Their Country</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;migration+%7C%7C%7C+Migration&quot;">Migration</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;refugee+period+%7C%7C%7C+Refugee+Period&quot;">Refugee Period</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;religious+life+%7C%7C%7C+Religious+life&quot;">Religious Life</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;art+%7C%7C%7C+Art&quot;">Art</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;soviet+jewry+%7C%7C%7C+Soviet+Jewry&quot;">Soviet Jewry</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;scottish+communities+%7C%7C%7C+Scottish+Communities&quot;">Scottish Communities</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;women+%7C%7C%7C+Women&quot;">Women</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;relations+with+wider+community+%7C%7C%7C+Relations+with+wider+community&quot;">Relations with the Wider Community</a></li>
        </ul>
    </div>
</div>
</div>
@endsection
