@extends('layouts.art')

@section('title', 'About - University of Edinburgh Art Collection')

@section('content')
<div class="content container">
    <div class="content byEditor">
        <p>Our Art Collection supports the world-leading research and teaching that happens within the University.
            Comprised of an astonishing range of objects and ideas spanning two millennia and a multitude of artistic forms,
            the collection reflects not only the long and rich trajectory of the University, but also major national and international shifts in art history.
        </p>

        <p>A significant and celebrated component of our holdings is the Torrie collection, which features seventeenth-century Dutch and Italian work,
            with examples by <a href="{{ url('/art/search/Ruisdael') }}">Ruisdael</a>, <a href="{{ url('/art/search/ten%20Oever') }}">ten Oever</a>,
            <a href="{{ url('/art/search/Van%20der%20Meulen') }}">Van der Meulen</a>, <a href="{{ url('/art/search/Pynacker') }}">Pynacker</a>,
            <a href="{{ url('/art/search/Rosa') }}">Rosa</a> and <a href="{{ url('/art/search/van%20de%20Velde') }}">van de Velde</a>. The University also holds the second largest collection of
            portraits in Scotland, ranging from historic depictions of <a href="{{ url('/art/search/Napier') }}">John Napier</a> and <a href="{{ url('/art/search/John%20Knox') }}">John Knox</a>,
            to the more recent painting of Nobel Laureate <a href="{{ url('/art/search/Peter%20Higgs') }}">Peter Higgs</a> by
            Ken Currie. Other portrait artists represented include <a href="{{ url('/art/search/Henry%20Raeburn') }}">Sir Henry Raeburn</a>, <a href="{{ url('/art/search/Stanley%20Cursiter') }}">Stanley Cursiter</a>,
            <a href="{{ url('/art/search/George%20Reid') }}">Sir George Reid</a>, <a href="{{ url('/art/search/James%20Cowie') }}">James Cowie</a> and
            <a href="{{ url('/art/search/Victoria%20Crowe') }}">Victoria Crowe</a>.
        </p>

        <p>After the organisations merged in 2011, the Edinburgh College of Art (ECA) collection of prints, drawings, paintings and sculpture also became
            part of the wider University Art Collection. These works help tell the story of the artistic output of the College, with a particular strength being the
            early to mid-20th Century work by artists such as <a href="{{ url('/art/search/Peploe') }}">Samuel Peploe</a>, <a href="{{ url('/art/search/Bellany') }}">John Bellany</a>,
            <a href="{{ url('/art/search/Redpath') }}">Anne Redpath</a> and <a href="{{ url('/art/search/Blackadder') }}">Elizabeth Blackadder</a>.
        </p>

        <p>
            We continue to actively acquire works for the collection, with the most recent strand of development being the Contemporary Art Research Collection (CARC).
            Established in 2015 in partnership with academics in the History of Art department at ECA, the CARC takes globalisation as its central theme, setting a
            specific focus on women's experience and the contribution of feminist thought. Artists acquired to date include <a href="{{ url('/art/search/Whittle') }}">Alberta Whittle</a>,
            <a href="{{ url('/art/search/McNaughton') }}">Shona McNaughton</a>, <a href="{{ url('/art/search/Kate%20Davis') }}">Kate Davis</a>,
            <a href="{{ url('/art/search/Gilligan') }}">Melanie Gilligan</a> and <a href="{{ url('/art/search/Bauer') }}">Petra Bauer</a>.
        </p>

        <h1>Display, loan and access</h1>

        <p>A large portion of the Art Collection is on view throughout the University campus, and we actively lend to other venues where possible. Viewing works held in store,
            or enquiring about borrowing a work, can be arranged by contacting <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a></p>

        <h1>Online</h1>

        <p>Representing the University Art Collection online is an ongoing process. Images accompany records where there is an existing image file of sufficient quality, and
            images will be added to records as part of wider cataloguing efforts. If there is a particular work that is of interest that does not have an accompanying image, please contact us directly on the
            details below.</p>

        <h1>Contact Details</h1>
        <p>
            For further information about the University of Edinburgh Art Collections please contact:
        </p>
        <p>Art Collections Curator<br />
            University of Edinburgh,<br />
            Main Library,<br />
            30 George Square,<br />
            Edinburgh,<br />
            EH8 9LJ<br />
            <a class="email" href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a><br />
        </p>

        <p>Visit Centre for Research Collections <a href="https://www.ed.ac.uk/visit/museums-galleries/heritage-collections" title="Centre for Research Collections" target="_blank">webpage (opens in a new tab)</a>
            for further information about access.</p>

        <a href="https://twitter.com/UoEArtArchives" title="Art Collections on Twitter" target="_blank">Art Collections on Twitter (opens in a new tab)</a><br />

        <a href="https://artuk.org/visit/venues/university-of-edinburgh-5095" title="Art Collections on ArtUK" target="_blank">Art Collections on Art UK (opens in a new tab)</a>

    </div>
</div>
@endsection
