@extends('layouts.bodylanguage')

@section('title', 'Contact - Body Language')

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

        <h2>Contact Details</h2>
        <p>If you would like to arrange to consult the collections, or wish advice or information, the most appropriate contacts are listed below.</p>

        <p>For enquiries relating to the archives of Dunfermline College of Physical Education, Dunfermline College of Physical Education Old Students&rsquo; Association, and the archives of Scottish Gymnastics:</p>
        <p class="contact-details">
            <strong>University of Edinburgh Centre for Research Collections</strong><br />
            University of Edinburgh,<br />
            Main Library,<br />
            30 George Square,<br />
            Edinburgh,<br />
            EH8 9LJ<br />
            Phone: <a class="phone para-link" href="tel:+441316508379">+44 (0)131 650 8379</a><br />
            Fax: <a class="phone para-link" href="tel:+441316502922">+44 (0)131 650 2922</a><br />
            Email: <a class="email para-link" href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a><br />
            Web: <a class="para-link" href="https://www.ed.ac.uk/information-services/library-museum-gallery/cultural-heritage-collections/crc/about" target="_blank" rel="noopener">https://www.ed.ac.uk/information-services/library-museum-gallery/cultural-heritage-collections/crc/about<span class="sr-only"> (Opens in a new tab)</span></a>
        </p>

        <p>For enquiries relating to the archives of Margaret Morris and Margaret Morris Movement International, please contact Culture Perth and Kinross: Museums.</p>

        <div class="big-divider"></div>
    </div>
</div>
@endsection
