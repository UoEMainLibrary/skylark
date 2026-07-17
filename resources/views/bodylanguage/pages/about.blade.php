@extends('layouts.bodylanguage')

@section('title', 'About - Body Language')

@section('content')
<div class="content">
    <div class="content byEditor">

        <div id="collection-search" class="other-search">
            <form action="{{ $collectionUrl('redirect') }}" method="post">
                @csrf
                <fieldset class="search">
                    <input type="text" name="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" id="q" />
                    <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                </fieldset>
            </form>
        </div>

        <h1 id="project-anchor">About The Project</h1>
        <p>
            Between July 2017 and July 2020, the Wellcome Research Resource-funded project &lsquo;Body Language: movement, dance and physical education in Scotland,
            1890&ndash;1990&rsquo; has preserved, conserved, catalogued, made accessible and virtually united three archive collections held by the University of Edinburgh
            Centre for Research Collections and Culture Perth and Kinross: Museums. The collaborative project is supported by Moray House School of Education, Margaret
            Morris Movement International, and Scottish Gymnastics. The &lsquo;Body Language&rsquo; project features three interrelated archive collections: the archives of
            Dunfermline College of Physical Education, Scottish Gymnastics (both held at the University of Edinburgh), and the archives of Margaret Morris Movement
            International (held at the Fergusson Gallery in Perth). The project aims to unlock these invaluable collections for the benefit of academic scholars and the
            wider community, and aims to inspire and facilitate new and innovative interdisciplinary research in the medical humanities, social sciences and other fields.
        </p>
        <p>
            Scotland produced a particularly close-knit network of innovators and pioneers whose distinctive approaches to movement, dance, physical education and sport are
            exemplified by these collections. Spanning the 1890s to the 1990s, the collections highlight these important contributions from three perspectives; that of
            an individual (Margaret Morris), an educational institution (Dunfermline College of Physical Education), and an amateur sports organisation (Scottish Gymnastics).
        </p>
        <p>
            Margaret Morris (1891&ndash;1980) established her own system for dance training, Margaret Morris Movement, which focuses on breathing techniques, posture and strength
            training with co-ordinated movements. She also trained as a physiotherapist and demonstrated her technique to medical professionals. The archives also relate to the
            organisation Margaret Morris Movement International (MMMI), which works with mentally and physically disabled persons using Margaret Morris Movement systems and
            techniques.
        </p>
        <p>
            Dunfermline College of Physical Education (DCPE) (1905&ndash;1986) was one of the first training colleges for women students of physical education and had an important
            influence on developing the role of movement and the body in educational practice.
        </p>
        <p>
            Scottish Gymnastics (SG) (1890&ndash;present) was founded as a voluntary organisation representing a number of Scottish gymnastic and athletic clubs. Broadening its
            initial focus from military fitness to general health and wellbeing, it was significant for promoting and supporting gymnastics in Scotland and abroad.
        </p>

        <h4>Working on the project were:</h4>
        <ul class="about-list">
            <li><strong>Clare Button</strong>, Project Archivist</li>
            <li><strong>Elaine MacGillivray</strong>, Project Archivist</li>
            <li><strong>Emily Hick</strong>, Conservator</li>
        </ul>

        <h4>They were supported by:</h4>
        <ul class="about-list">
            <li><strong>Rachel Hosker</strong>, Archives Manager and Deputy Head of Special Collections, University of Edinburgh</li>
            <li><strong>Grant Buttars</strong>, University of Edinburgh Archivist, Archives and Technical Systems</li>
            <li><strong>Kirsty MacNab</strong>, University of Edinburgh Exhibitions Officer</li>
            <li><strong>Wendy Timmons</strong>, Programme Director: MSc Dance Science and Education, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Professor John Ravenscroft</strong>, Chair of Childhood Visual Impairment, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Dr Matthew L McDowell</strong>, Lecturer in Sport Policy, Management, and International Development, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Tiffany Boyle</strong></li>
            <li><strong>Gillian Findlay</strong>, Head of Museums and Galleries, Culture Perth and Kinross</li>
            <li><strong>Rhona Rodger</strong>, Senior Officer, Collection Management, Culture Perth and Kinross</li>
            <li><strong>Amy Fairley</strong>, Collections Officer, Culture Perth and Kinross</li>
            <li>Staff at both the Centre for Research Collections, University of Edinburgh and at Culture Perth and Kinross</li>
        </ul>

        <p>
            The project enlisted help from volunteers who helped on a wide range of tasks ranging from conservation to cataloguing.
        </p>
        <p>
            It is now possible to search across all three collections using our
            <a class="para-link" href="{{ $collectionUrl('catalogue') }}">online portal</a>.
        </p>
        <p>
            The project was generously funded by the Wellcome Trust&rsquo;s
            <a class="para-link" target="_blank" rel="noopener" href="https://wellcome.ac.uk/grant-funding/schemes/research-resources-awards-humanities-and-social-science">Research Resource Awards Scheme<span class="sr-only"> (Opens in a new tab)</span></a>.
        </p>

        <div id="collection-anchor"></div>
        <h1>About The Collection</h1>
        <p>
            Body Language: movement, dance and physical education in Scotland, 1890&ndash;1990 preserved, conserved, catalogued, made accessible and virtually united three
            archive collections held by the University of Edinburgh and Culture Perth and Kinross: Museums. The archive collections include the archives of Dunfermline College
            of Physical Education, and Scottish Gymnastics (University of Edinburgh), and the archives of Margaret Morris Movement International (Culture Perth and Kinross: Museums).
        </p>
    </div>
</div>
@endsection
