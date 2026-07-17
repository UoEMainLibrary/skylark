@extends('layouts.bodylanguage')

@section('title', 'People - Body Language')

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

        <h1>People</h1>
        <p>These are the individuals whose papers feature as part of the project.</p>

        <div id="tile-block">
            <div id="tile-1" class="people-tile"><p class="people-name">Clare Button</p><p class="people-title">Project Archivist</p></div>
            <div id="tile-2" class="people-tile"><p class="people-name">Elaine MacGillivray</p><p class="people-title">Project Archivist</p></div>
            <div id="tile-3" class="people-tile"><p class="people-name">Emily Hick</p><p class="people-title">Project Conservator</p></div>
            <div id="tile-4" class="people-tile"><p class="people-name">Rachel Hosker</p><p class="people-title">Archives Manager and Deputy Head of Special Collections, University of Edinburgh</p></div>
            <div id="tile-5" class="people-tile"><p class="people-name">Grant Buttars</p><p class="people-title">University of Edinburgh Archivist, Archives and Technical Systems</p></div>
            <div id="tile-6" class="people-tile"><p class="people-name">Kirsty MacNab</p><p class="people-title">University of Edinburgh Exhibitions Officer</p></div>
            <div id="tile-7" class="people-tile"><p class="people-name">Wendy Timmons</p><p class="people-title">Programme Director: MSc Dance Science and Education, Moray House School of Education and Sport, University of Edinburgh</p></div>
            <div id="tile-8" class="people-tile"><p class="people-name">Prof. John Ravenscroft</p><p class="people-title">Chair of Childhood Visual Impairment, Moray House School of Education and Sport, University of Edinburgh</p></div>
            <div id="tile-9" class="people-tile"><p class="people-name">Dr. Matthew L McDowell</p><p class="people-title">Lecturer in Sport Policy, Management, and International Development, Moray House School of Education and Sport, University of Edinburgh</p></div>
            <div id="tile-10" class="people-tile"><p class="people-name">Tiffany Boyle</p></div>
            <div id="tile-11" class="people-tile"><p class="people-name">Gillian Findlay</p><p class="people-title">Head of Museums and Galleries, Culture Perth and Kinross</p></div>
            <div id="tile-12" class="people-tile"><p class="people-name">Rhona Rodger</p><p class="people-title">Senior Officer, Collection Management, Culture Perth and Kinross</p></div>
            <div id="tile-16" class="people-tile"><p class="people-name">Amy Fairley</p><p class="people-title">Collections Officer, Culture Perth and Kinross</p></div>
        </div>

        <div class="big-divider"></div>
    </div>
</div>
@endsection
