@extends('layouts.app')

@section('title', 'Fabienne Hess: Zebras, Blanks and Blobs, Windows - University of Edinburgh Collections')

@section('content')
<div class="tab-list">
    <div class="container">
        <h1>Fabienne Hess : Zebras, Blanks and Blobs, Windows (2017)</h1>
        <div align="left">
            <p>The University of Edinburgh has amassed one of most important collections anywhere in the world. Beginning with the bequest of 276 volumes to the library in 1580, our collection contains objects as old as the solar system through to contemporary works of art. Millions of objects are spread over 45 different sites; 280 named collections cared for by around 40 curators, archivists and conservators. Finding ways to articulate the vastness of this collection is what inspired the Swiss artist Fabienne Hess.
            </p>
            <p>In her 2015 exhibition at the University's Talbot Rice Gallery, Hess brought together over 25,000 collection images and reproduced them on a vast silk fabric. This gave the collection an immediate and tangible scale whilst highlighting the diversity of individual objects. Hess went on to develop the project with a publication in 2017, titled Zebras, Blanks and Blobs. This introduced 13 'image families' derived from the same digital images, this time accentuating visual connections between otherwise disparate groups of objects. The families include; Red Dots, Fragiles, Triangles, Stripes and Pointers. Hess has selected a group of images from these families for this installation, specially commissioned for Argyle House.
            </p>
            <p>
                Hess' classifications are first and foremost visual; accentuated by the quality of the images produced by our Digital Imaging Unit. The visual comparisons also encourage a deeper engagement with the overall collection, what it represents and how it is used. Objects that have never been seen in parallel are thrust together, giving a truly unique overview.
            </p>
            <p>
                <a href="http://www.fabiennehess.com" target="_blank">www.fabiennehess.com <span class="sr-only">(opens in a new tab)</span></a>
            </p>
            <p>
                Library Digital Development have used <a href="https://iiif.io" title="International Image Interoperability Framework" target="_blank">IIIF <span class="sr-only">(opens in a new tab)</span></a>
                image and presentation APIs to make Fabienne's selected images available in a digestible format.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <iframe src="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=https://librarylabs.ed.ac.uk/iiif/manifest/RoomCollection.json" width="100%" height="800" allowfullscreen="true"></iframe>
</div>
@endsection
