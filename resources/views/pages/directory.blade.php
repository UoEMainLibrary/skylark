@extends('layouts.app')

@section('title', 'Directory of Collections - University of Edinburgh Collections')

@section('content')
<div class="container">
    <div class="content byEditor">
        <h1>Directory of Collections</h1>
        <p>
            For the first time, the scale and variety of the collections held at the University of Edinburgh have been
            captured in a single, fully illustrated volume. The Directory of Collections at the University of Edinburgh
            presents a detailed and easily navigable guide to the main named heritage collections of the University,
            introduced by a section on its most iconic items.
        </p>
        <p>
            The University holds one of the world's greatest collections, which has been growing since its foundation in
            1582. It includes rare books, archives and manuscripts, art, historical musical instruments and a wide range
            of other museum objects from geological specimens to anatomical models - in total, some 60 kilometres of
            heritage material. They are curated by specialist staff across 45 different sites within the University and
            are used for teaching, research and by the wider public community.
        </p>
        <p>
            You can purchase hardback and paperback copies of the Directory of the Collections, published by Third
            Millennium, at the Centre for Research Collections and the University of Edinburgh Visitor Centre, as well as <a href="https://tmbooks.com/directory-of-collections-at-the-university-of-edinburgh.html" title="External link to Third Millenium Shop" target="_blank">online<span class="sr-only"> (opens in a new tab)</span></a>.
        </p>

        <p>Directory of Collections, Copyright &copy; The University of Edinburgh, 2016</p>

        <object data="{{ asset('theme/clds/pdfs/Directory_of_Collections_at_The_University_of_Edinburgh_redux2.pdf') }}" type="application/pdf" width="920" height="928">
            <p><span class="label">It appears you don't have a PDF plugin for this browser.</span>
                <a href="{{ asset('theme/clds/pdfs/Directory_of_Collections_at_The_University_of_Edinburgh_redux2.pdf') }}">Click</a> to download (15.7 MB).
            </p>
        </object>
    </div>
</div>
@endsection
