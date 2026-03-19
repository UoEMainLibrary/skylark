@extends('layouts.art')

@section('title', 'IIIF - University of Edinburgh Art Collection')

@section('content')
<div class="content container">
    <div class="content byEditor">
        <h1>International Image Interoperability Framework (IIIF)</h1>
        <p>The International Image Interoperability Framework (IIIF) is a set of open standards for delivering high-quality, attributed
            digital objects online at scale. It's also an international community developing and implementing the IIIF APIs.
            IIIF is backed by a consortium of leading cultural institutions.</p>
        <p>For more information about the International Image Interoperability Framework, visit <a href="https://iiif.io" target="_blank">https://iiif.io</a></p>
        <p>
            Records in this catalogue may have a <span style="white-space:nowrap;"><img src="{{ asset('collections/art/images/iiif-logo.png') }}" alt="IIIF Logo" width="20" /> IIIF icon</span> in their sidebar,
            which can be dragged to a IIIF-compatible image viewer to open the image there. IIIF-compatible
            image viewers are available at the following locations:
        </p>
        <p>
            <a href="https://projectmirador.org/" target="_blank">Mirador</a><br>
            <a href="https://universalviewer.io/" target="_blank">Universal Viewer</a>
        </p>
    </div>
</div>
@endsection
