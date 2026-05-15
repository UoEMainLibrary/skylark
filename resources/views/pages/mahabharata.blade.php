@extends('layouts.app')

@section('title', 'Mahabharata Scroll - University of Edinburgh Collections')

@section('content')
<div class="tab-list">
    <div class="container">
        <h1>Mahabharata Scroll</h1>
        <div align="left">
            <p>The Edinburgh University&rsquo;s 1795 copy of the Mahābhārata is now available online. One of the Iconic items in our Collection, this beautiful scroll is one of the longest poems ever written and contains a staggering 200,000 verses spread along 72 meters of richly decorated silk backed paper.</p>
            <p>
                More information about the work involved in making the scroll available can be found on the
                <a href="https://libraryblogs.is.ed.ac.uk/diu/2018/06/22/a-stitch-in-time-mahabharata-delivered-online/" title="Cultural Heritage Digitisation Service blog" target="_blank">Cultural Heritage Digitisation Service blog <span class="sr-only">(opens in a new tab)</span></a>.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <iframe src="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=https://librarylabs.ed.ac.uk/iiif/manifest/mahabharataFinal.json" width="100%" height="800" allowfullscreen="true"></iframe>
</div>
@endsection
