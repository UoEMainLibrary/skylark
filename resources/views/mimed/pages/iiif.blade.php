@extends('layouts.mimed-information')

@section('title', 'IIIF - Musical Instrument Collection')
@section('page-heading', 'International Image Interoperability Framework')

@section('information')
<a class="mimed-information-logo" href="https://iiif.io/"><img src="{{ asset('collections/mimed/images/iiiflogo.png') }}" width="50" height="50" alt="IIIF"></a>
            <p>
                The University of Edinburgh has adopted <a href="https://iiif.io" title="IIIF site" target="_blank">IIIF</a>
                as our standard for image interoperability and workflow. This has a number of advantages for us, including:
            </p>
            <ul>
                <li>High resolution image zooming in our collections item pages.</li>
                <li>The ability to share out our content using URLs (manifests).</li>
                <li>The ability to pull in other IIIF-compliant institutions' content using URLs (manifests).</li>
                <li>On-the-fly tweaking of images without the need to physically access the original.</li>
                <li>A culture of access to images through URLs, precluding the need to store images, thus saving storage space.</li>
            </ul>

            <h2>Using the images</h2><a class="mimed-information-logo" href="https://images.is.ed.ac.uk/"><img src="{{ asset('collections/mimed/images/LUNAIIIF.png') }}" width="50" height="50" alt="LUNA IIIF"></a>
            <p>
                This collection makes use of IIIF. On the record page, you will notice we have embedded high resolution zooming, using Mirador, with OpenSeadragon for images without a manifest.
                This has been made possible by our high-resolution image platform, LUNA (<a href="https://images.is.ed.ac.uk">https://images.is.ed.ac.uk</a>), becoming IIIF-compliant.

                If you are familiar with the IIIF viewers <a href="https://projectmirador.org/" title="Project Mirador Site" target="_blank">Mirador (opens in a new tab)</a>
                and <a href="https://universalviewer.io/" title="Universal Viewer Project site" target="_blank">Universal Viewer (opens in a new tab)</a>,
                use the IIIF logo beneath the image viewer to open the manifest or copy its link. The Mirador and Universal Viewer logos open the image in those viewers.
            </p>
            <p>
                Further information on IIIF available at <a href="https://iiif.io" title="IIIF site" target="_blank">iiif.io</a>.
            </p>
@endsection
