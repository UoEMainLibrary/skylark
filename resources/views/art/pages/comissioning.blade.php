@extends('layouts.art')

@section('title', 'Commissioning - University of Edinburgh Art Collection')

@section('content')
<section class="commissioning">
    <div class="container-fluid text">
        <h2>Commissioning</h2>
        <p class="paragraph-part">
            Commissioning is a practice that involves the engaging of an artist in the production of a new work of art.
            Historically this included paying artists to create statues, religious iconography or portraits of family
            members, but in the present day it covers an ever-expanding range of materials, processes and possibilities.<br><br>
            The University Art Collection manages both permanent and temporary commissions for University buildings and
            as part of research, and the University Commissioning Guidelines can be viewed <a href="{{ asset('collections/art/images/University_of_Edinburgh_Commissioning_Guidelines_V2_Single_Page_2024.pdf') }}">here</a>, with
            physical copies available on <a href="#contact">request</a>.
        </p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/JAMIE_CREWE.jpg') }}" class="img-fluid" alt="Artwork: 'Identity Deception' - Jamie Crewe, 2020-2022">
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Jamie Crewe</h3>
                    <p class="date">Identity Deception 2020-2022</p>
                    <p class="desc-text">
                        Glasgow-based artist Jamie Crewe is working alongside the Art Collection and Dr Chloë Kennedy in
                        the School of Law on a two-year research project exploring the concepts of criminalisation of
                        identity deceptions, and specifically instances of intimate deception.<br><br>
                        The resulting moving image work produced by Crewe will join the collection for use in display,
                        research and teaching.<br>
                        <a href="https://www.law.ed.ac.uk/news-events/news/identity-deception-project-commissions-artist-jamie-crewe">More detail on the project can be viewed here</a>
                    </p></div>
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Shona Macnaughton</h3>
                    <p class="date">Here to Deliver 2019-2021</p>
                    <p class="desc-text">Here to Deliver was a live cycle of performances by artist Shona
                        Macnaughton, produced over October and November of 2020. Footage and audio from the performances
                        will become a new moving image work, set to join the Contemporary Art Research strand of the Art
                        Collection in 2021.<br><br>
                        Responding to research undertaken on artists' engagement with the 'gig' and 'platform'
                        economies, the artwork explores the conditions of artistic labour, when actioned through gig
                        economy structures.<br>
                        <a href="https://www.shonamacnaughton.com/here-to-deliver/">More detail on the project can be viewed here</a>
                    </p></div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/SHONA.jpg') }}" class="img-fluid" alt="Image from the performance 'Here to Deliver' - Shona Macnaughton, 2019-2021">
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/MANUAL_LABOURS.jpg') }}" class="img-fluid" alt="The Global Staffroom podcast logo">
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Manual Labours</h3>
                    <p class="date">The Global Staffroom 2020 -2021</p>
                    <p class="desc-text">
                        <a href="https://www.manuallabours.co.uk/">Manual Labours</a> (ML) is a research project exploring physical and emotional relationships to work, initiated by Jenny Richards and Sophie Hope. During the first lockdown period they hosted the live podcast series The Global Staffroom. Each of the 14 episodes consists of conversations and interviews with people about what it feels like to care, be cared for, and not be able to care at work.<br><br>
                        The Art Collection was able to support the production of The Global Staffroom by providing funds to pay speakers, and to bring together the research and thinking undertaken into a manual which will be used in teaching in 2021.<br>
                        <a href="https://www.manuallabours.co.uk/todo/the-global-staffroom/">More detail on the project can be viewed here</a>
                    </p></div>
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Nathan Coley</h3>
                    <p class="date">The Basic Material is Not the Word but the Letter 2018</p>
                    <p class="desc-text">To mark the 50th anniversary of the Main Library at George Square, artist
                        Nathan Coley was commissioned to make a new work for the building.<br><br>
                        Best known for his illuminated text works, Coley sourced the phrase which both composes and
                        names the work from the University's archive.<br>
                        <a href="https://media.ed.ac.uk/media/0_tmmkjuz4">More detail on the project can be viewed here</a> and the record in the collection is <a href="{{ url('/art/record/102714') }}">here</a>.
                    </p></div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~75984~214492/full/full/0/default.jpg" class="img-fluid" alt="Image of the artwork: 'The Basic Material is Not the Word but the Letter' - Nathan Coley, 2018">
            </div>
        </div>
    </div>
</section>
@endsection
