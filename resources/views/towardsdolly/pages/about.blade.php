@extends('layouts.towardsdolly')

@section('title', 'About - Towards Dolly')

@section('content')
<div class="content">
    <div class="content byEditor">
        <p>Since 2012, the Wellcome Trust has funded a number of projects relating to animal genetics collections held at the University of Edinburgh's Centre for Research Collections. &lsquo;Towards Dolly: Edinburgh, Roslin and the Birth of Modern Genetics&rsquo; and &lsquo;The Making of Dolly: Science, Politics and Ethics&rsquo; have catalogued, preserved and made available archival, printed and visual collections relating to animal genetics in Edinburgh, from nineteenth century zoology to the birth of Dolly the sheep in 1996, and beyond to present day cutting-edge research. Working on the project were Rare Book Cataloguer Kristy Davis and Project Archivist Clare Button.</p>

        <p>In all, 23 collections have been catalogued and preserved, with key items receiving conservation treatment. These collections include rare books, scientific papers, the archives of institutions such as Roslin Institute and the papers of pioneering scientists including Charlotte Auerbach, C.H. Waddington and Sir Ian Wilmut. Nine oral history recordings were also carried out with leading contemporary geneticists.</p>

        <p>Between October 2014 and May 2015, the project &lsquo;Science on a Plate: the natural sciences through glass slides, 1870-1930&rsquo; digitised nearly 3,500 historic glass slides which were catalogued as part of &lsquo;Towards Dolly&rsquo;. Depicting different animal breeds and scenes and people from around the world, this rich visual resource is now available to <a href="https://images.is.ed.ac.uk/luna/servlet/UoEgal~6~6" target="_blank" rel="noopener">view online</a>.</p>

        <p>These projects were generously funded by the Wellcome Trust&rsquo;s <a href="http://www.wellcome.ac.uk/Funding/Humanities-and-social-science/Funding-schemes/Research-resources-awards/index.htm" target="_blank" rel="noopener">Research Resources scheme</a>. Watch the Project Archivist, Clare Button, talking about the collections in the Wellcome Trust&rsquo;s film about the scheme.</p>

        <video controls width="100%" preload="metadata" title="Introduction to Towards Dolly by Clare Button, Project Archivist">
            <source src="{{ asset('collections/towardsdolly/videos/Towards_Dolly_Wellcome_Trust_showreel.mp4') }}" type="video/mp4">
            Sorry, your browser doesn't support embedded videos.
        </video>

        <p style="margin-top: 1.5rem;">From July to October 2015, the University of Edinburgh Main Library Exhibition Gallery hosted the <a href="https://exhibitions.ed.ac.uk/towardsdolly" target="_blank" rel="noopener">exhibition</a> &lsquo;Towards Dolly: a century of animal genetics in Edinburgh.&rsquo; This was curated by Project Archivist Clare Button and featured an array of archival, printed and visual collections, as well as Dolly the sheep herself, on loan courtesy of National Museums Scotland. Watch the Library and University Collections Digital Imaging Unit&rsquo;s timelapse video of Dolly being installed in the exhibition gallery here:</p>

        <video controls width="100%" preload="metadata" title="Towards Dolly Exhibition being installed, video by University of Edinburgh Digital Imaging Unit">
            <source src="{{ asset('collections/towardsdolly/videos/0051021v-001.mp4') }}" type="video/mp4">
            Sorry, your browser doesn't support embedded videos.
        </video>

        <h1>Project report</h1>
        <p>Download the full project report <a href="https://collections.ed.ac.uk/videos/Towards%20Dolly%20complete%20final%20report.pdf" target="_blank" rel="noopener">here</a> (9.3mb)</p>

        <h1>Contact Details</h1>
        <p>For further information please contact:</p>
        <p><strong>Centre for Research Collections</strong><br>
            University of Edinburgh,<br>
            Main Library,<br>
            30 George Square,<br>
            Edinburgh,<br>
            EH8 9LJ<br>
            Email: <a class="email" href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a><br>
        </p>
    </div>
</div>
@endsection
