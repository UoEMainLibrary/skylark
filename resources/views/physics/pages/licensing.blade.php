@extends('layouts.physics')

@section('title', 'School of Physics and Astronomy Image Archive - Licensing')

@section('content')
<div class="content">
    <div class="content byEditor">
        <h1>Licensing &amp; Copyright</h1>

        <p>
            Images in the School of Physics and Astronomy Image Archive are made available free of charge for
            non-commercial use by staff and students of the University of Edinburgh, subject to the
            <a href="{{ url('/physics/takedown') }}">takedown policy</a>.
        </p>

        <p>
            Where attribution is given, please credit "School of Physics and Astronomy, The University of Edinburgh".
            For commercial reuse or for a higher-resolution copy of an image, please
            <a href="{{ url('/physics/feedback') }}">contact us</a>.
        </p>

        <p>
            Unless explicitly stated otherwise, all material is copyright &copy; <?php echo date('Y'); ?>
            <a href="https://www.ed.ac.uk" target="_blank">The University of Edinburgh</a>.
        </p>
    </div>
</div>
@endsection
