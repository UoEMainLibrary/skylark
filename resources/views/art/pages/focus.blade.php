@extends('layouts.art')

@section('title', 'In Focus - University of Edinburgh Art Collection')

@section('content')
<section class="in-focus">
    <div class="container-fluid text">
        <h2>In focus</h2>
        <p class="paragraph-part">
            The Art Collection is predominantly composed of artworks in fairly traditional materials, such as oil paint,
            marble, and bronze. Divergence from this, and the active collecting of contemporary work, has been a more
            recent endeavour; triggered by the merger of the University with Edinburgh College of Art in 2012.<br><br>
            As with many UK collections brought together in recent centuries, representation in the Art Collection is
            skewed towards white, western European artists, with estimates that they account for over 90% of the
            holdings. Approximately 33% of the individuals represented in the collection are women, meaning the majority
            of artists are men.<br><br>
            This section provides a short introduction to some of the key areas of the Art Collection holdings, both in
            terms of historical significance and future development. It is by no means exhaustive, so for further
            information please use the search function, or <a href="#contact">contact us</a>.
        </p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <img src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~76101~393272/full/full/0/default.jpg" class="img-fluid" alt="Secreting Myths (jade) - Alberta Whittle">
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Contemporary Art Research Collection (CARC)</h3>
                    <p class="desc-text">Established in 2015 in partnership with academics in the History of Art
                        department, the CARC takes globalisation as its central theme, setting a specific focus on
                        women's experience and the contribution of <a href="https://www.fabric.eca.ed.ac.uk/about/">feminist thought</a>.
                    </p>
                    <p class="artists">Artists acquired to date include: <br>
                        <a href="{{ url('/art/search/alberta+whittle') }}">Alberta Whittle</a>,
                        <a href="{{ url('/art/search/Shona+Macnaughton') }}">Shona Macnaughton</a>,
                        <a href="{{ url('/art/search/Kate+Davis') }}">Kate Davis</a>,
                        <a href="{{ url('/art/search/Melanie+Gilligan') }}">Melanie Gilligan</a>,
                        <a href="{{ url('/art/search/Petra+Bauer') }}">Petra Bauer</a>, and
                        <a href="http://www.manuallabours.co.uk/todo/the-global-staffroom/">Manual Labours</a></p></div>
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Portraits</h3>
                    <p class="desc-text">The portraits in the Art Collection represent historical figures connected with the
                        University, with some rare recent examples.<br> <br>
                        The holdings are second only in scope and quality in Scotland to the Scottish National Portrait
                        Gallery. The Raeburn Room at Old College is dedicated to the seven works by
                        <a href="{{ url('/art/search/*:*/Artist:%22sir+henry+raeburn+%7C%7C%7C+Sir+Henry+Raeburn%22') }}">Sir Henry Raeburn</a> held in the collection. Of particular note are the portraits of Robert
                        Trotter of The Bush and Castlelaw by
                        <a href="{{ url('/art/search/*:*/Artist:%22david+martin+%7C%7C%7C+David+Martin%22') }}">David Martin</a>, and the work depicting
                        <a href="{{ url('/art/record/530') }}?highlight=john+knox">John Knox</a>, said to
                        be the first representation of his image.
                    </p></div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~5132~100011/full/full/0/default.jpg" class="img-fluid" alt="Portrait of William Robertson (1721–1793) - Henry Raeburn (1756–1823)">
            </div>
            <div class="col-lg-6">
                <img src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~73315~164174/full/full/0/default.jpg" class="img-fluid" alt="The University of Edinburgh Art Collection Poster">
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>ECA Collection</h3>
                    <p class="desc-text">
                        The Edinburgh College of Art (ECA) Collection is comprised of a diverse range of subjects and
                        genres, including painting, sculpture, film, animation, textiles and jewellery. The largest of
                        the collections is Drawing & Painting, which contains approximately 2,000 items, primarily
                        ex-student work.<br><br>
                        Although work was collected from 1914/1915 onwards, the majority of the items remaining in the
                        collection were produced in the second half of the 20th century. This includes a number of
                        significant formative works by artists such as
                        <a href="{{ url('/art/search/*:*/Artist:%22john+bellany+%7C%7C%7C+John+Bellany%22') }}">John Bellany</a>,
                        <a href="{{ url('/art/search/*:*/Artist:%22elizabeth+blackadder+%7C%7C%7C+Elizabeth+Blackadder%22') }}">Elizabeth Blackadder</a>,
                        <a href="{{ url('/art/search/*:*/Artist:%22john+houston+%7C%7C%7C+John+Houston%22') }}">John Houston</a> and
                        <a href="{{ url('/art/search/*:*/Artist:%22anne+redpath+%7C%7C%7C+Anne+Redpath%22') }}">Anne Redpath</a>.<br><br>
                        Student work continues to be acquired, and you can read more about our annual ECA Degree Show
                        Purchase Prize <a href="https://artsandculture.google.com/story/mQVR1auYykVafQ">here</a>.
                    </p></div>
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>South Asian Artworks In The Collections</h3>
                    <p class="desc-text">A project initiated in 2023, in collaboration with Dr Yashaswini Chandra at Edinburgh
                        College of Art, has sought to make visible significant examples of artworks produced in South Asia between
                        the 17th and 19th centuries C.E. that are catalogued within the Manuscripts of the Islamicate World and South
                        Asia (MIWSA) Collection. These works and more information on the project can be found <a href="https://archives.collections.ed.ac.uk/subjects/30128">here</a>.
                        <br><br>
                        Other works within the Art Collection connected to South Asia include ancient <a href="{{ url('/art/search/gandharan') }}">Gandharan sculptures</a>
                        from the Peshawar Valley and the contemporary installation work of British-Pakistani artist <a href="{{ url('/art/record/122466') }}?highlight=AMMNA+SHEIKH">Ammna Sheikh</a>.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/PhotoLaurenceWinram_2.jpg') }}" class="img-fluid" alt="Image of the book Diwan; Collected Poetical Works, f.90v">
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/ECA_CAST.jpg') }}" class="img-fluid" alt="Sculpture court arches from the Edinburgh Cast Collection at the Edinburgh College of Art.">
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>ECA Cast Collection</h3>
                    <p class="desc-text">The Cast Collection is comprised of 265 plaster casts of Antique, Renaissance,
                        and Gothic statues, bas reliefs, and architectural passages held at the ECA and the University
                        of Edinburgh. The plaster casts at ECA are displayed in an A-listed building, including a
                        beautiful neo-Classical sculpture court specifically designed to house the casts of the
                        Parthenon frieze – works donated directly by Lord Elgin especially for the education of artists
                        in Scotland.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="centered-text">
                    <h3>Moving Image And Performance</h3>
                    <p class="desc-text">Development of the range of media represented in the collection is a key area
                        of work, with a major part of this a collaborative project with the
                        <a href="https://www.nationalgalleries.org/">National Galleries of Scotland</a>. Funded via an
                        Art Fund <a href="https://www.artfund.org/supporting-museums/programmes/new-collecting-awards">New Collecting Award Grant</a>, the two institutions will be jointly acquiring performance
                        artworks for use in both teaching, research and display.<br><br>
                        The Art Collection has also been investing in adding to its modest, but important, selection of
                        moving image works by both international artists as well as students and alumni connected to
                        ECA. Staff and students at the University can view all of the works via
                        <a href="https://media.ed.ac.uk/channel/Moving%2BImage%2BWorks/96102512">Mediahopper</a>.
                    </p></div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('collections/art/images/MOVING_IMAGE.jpg') }}" class="img-fluid" alt="An image from the 2017 Market Gallery, Glasgow 'Bodybuilding' exhibition: 'Progressive' - Shona Macnaughton">
            </div>
        </div>
    </div>
</section>
@endsection
