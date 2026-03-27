@extends('layouts.openbooks')

@section('title', 'Open Books')

@section('content')
<div class="content">
    <p>This collection is compiled from readers’ orders for scans, principally in black and white and some in colour. They highlight the range of resources at The University of Edinburgh’s Centre for Research Collections, from Herschel’s music manuscripts, to ‘An Essay on the Character and Cerebral Development of Robert Burns,’ to Charles Lyell’s handwritten notes.</p>

    <div id="burns">
        <img src="{{ asset('collections/openbooks/images/rhino.jpg') }}" alt="" />
    </div>
    <p>
        The images that have been created by the University's Cultural Heritage Digitisation Service are freely accessible to all, and most of the material is supplied under a
        <a href="http://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer">Creative Commons CC BY License (opens in a new tab)</a>
        (<a href="http://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer">http://creativecommons.org/licenses/by/4.0/ (opens in a new tab)</a>),
        meaning you can share and adapt for any purpose as long as attribution is given to the University of Edinburgh. Specific licence information is available on each item’s coversheet.
    </p>
</div>
@endsection
