@extends('layouts.physics')

@section('title', 'School of Physics and Astronomy Image Archive - About')

@section('content')
<div class="content byEditor">
    <h1>About this Collection</h1>

    <p>
        The School of Physics and Astronomy Image Archive (SOPA) gathers photographs, posters, event documentation
        and other images that record the work, people and history of the
        <a href="http://www.ph.ed.ac.uk" target="_blank">School of Physics and Astronomy</a>
        at the University of Edinburgh.
    </p>

    <p>
        Images are provided free for non-commercial purposes to University of Edinburgh staff and students. You will
        be asked to register before downloading images. To ensure access, please use your University email address.
    </p>

    <p>
        For enquiries about the collection or to request access to a higher-resolution copy of any image, please
        <a href="{{ url('/physics/feedback') }}">contact us</a>.
    </p>
</div>
@endsection
