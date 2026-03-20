@extends('layouts.art')

@section('title', 'University of Edinburgh Art Collection')

@section('content')
<section class="introduction">
    <div class="container-fluid">
        <a class="w-100" href="{{ url('/art/record/112492') }}"><img class="d-block w-100"
                src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~76079~393273/1651,2210,7000,3500/1000,500/0/default.jpg"
                alt="Whittle"></a>
    </div>
</section>
<div class="background-banner">
    <div class="container-fluid text">
        <h2>About</h2>
        <p class="paragraph-part">
            The University of Edinburgh has been engaged with the practices of commissioning, purchasing and displaying
            the work of artists for nearly 350 years. The early stages of this collecting were closely linked with
            galvanising the institution's identity and status as a place of learning and inspiration, through the
            commissioning and collecting of portraits and busts of Professors and key alumni.<br><br>
            The present day Art Collection is comprised of two institutional collections – the University of Edinburgh
            Fine Art Collection and the Edinburgh College of Art Collection. Now amounting to nearly 8,000 artworks
            spanning two millennia, the collection is divided into twelve named sub-collections which can be viewed <a
                href="{{ url('/art/search/*:*/Collection') }}">here</a>.
            <br><br>
            Alongside <a href="{{ url('/art/comissioning') }}">commissioning</a> new work, displaying the collection across campus, and
            lending to external venues, greater emphasis is now placed on the acquisition and use of artworks in the
            support and development of research and teaching.
            <br><br>
            In addition to searching the collection via these pages, The University of Edinburgh Art Collection also has
            two discrete areas on <a href="https://www.artuk.org/about/about">Art UK</a>; one for the <a
                href="https://artuk.org/visit/venues/university-of-edinburgh-5095">University's Fine Art Collection</a>
            and one for <a
                href="https://artuk.org/visit/venues/edinburgh-college-of-art-university-of-edinburgh-7553">Edinburgh
                College of Art</a>.
        </p>
    </div>
</div>
@endsection
