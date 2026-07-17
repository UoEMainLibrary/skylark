@extends('layouts.bodylanguage')

@section('title', 'Catalogue - Body Language')

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

        <h1 id="catalogue-anchor">Catalogue</h1>

        <p>
            This is the online portal to interrelated archive collections relating to movement, dance and physical education in Scotland 1890&ndash;1990,
            held by both the University of Edinburgh and Culture Perth and Kinross: Museums. The collections included here are the archives of Dunfermline
            College of Physical Education, Scottish Gymnastics and Margaret Morris Movement International.
        </p>
        <p>
            Search the collections by using the free text search box above, using a keyword of phrase. Alternatively, click on the links below to be directed
            to the fully searchable catalogues on the University of Edinburgh&rsquo;s Archives and Manuscripts Collections Catalogue.
        </p>
        <p>
            Some search results will include a digital image of the document. To view the actual document it is necessary to visit the relevant holding institution&rsquo;s
            reading rooms in person.
        </p>

        <h2 id="dunfermline-anchor" class="catelogue-title"><a class="list-link" href="https://archives.collections.ed.ac.uk/repositories/2/resources/85725">Dunfermline College of Physical Education Collection</a></h2>
        <h2 class="catelogue-title"><a class="list-link" href="https://archives.collections.ed.ac.uk/repositories/2/resources/86737">Dunfermline College of Physical Education Old Student&rsquo;s Association</a></h2>
        <h2 id="sctgymnastics-anchor" class="catelogue-title"><a class="list-link" href="https://archives.collections.ed.ac.uk/repositories/2/resources/86677">Scottish Gymnastics</a></h2>
        <h2 id="morris-anchor" class="catelogue-title"><a class="list-link" href="https://archives.collections.ed.ac.uk/repositories/2/resources/86712">Margaret Morris Movement International</a></h2>

        <div class="big-divider"></div>
        <div class="big-divider"></div>
    </div>
</div>
@endsection
