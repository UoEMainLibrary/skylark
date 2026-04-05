@extends('layouts.guardbook')

@section('title', 'University of Edinburgh Guardbook')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12 index-content">

    <p class="float-right">
       <a class="btn btn-default" href="{{url('/collections/guardbook/about"')}}">View all volumes</a>
    </p>
    <div class="clearfix"></div>
    <img src="{{ asset('collections/guardbook/images/0028709c.jpg')}}" alt="Guardbook example" class="img-responsive pull-right" />
    <p>
    <div class="clearfix"></div>
    <br />
    <p>The Guardbook was the University Library's last catalogue on paper, before computerisation. It was closed to new
        additions and amendments in 1985, and the electronic catalogue now replaces it for all General Collections material.
        It remains a useful source of information for Rare Books, as retrospective conversion of the Guardbook's contents
        was not completed for the older collections. Please bear in mind that many shelf locations have been changed
        since 1985, so this catalogue should always be used in conjunction with the current electronic catalogue.
        Recataloguing of our rare books collections onto the online system is ongoing.
    </p>
    <p>The Guardbook is a valuable historical document, showing the state of the library collection at a single point in
        history, and is of value for research into the history of the collections. The original was typed onto loose
        sheets, punched with four holes, and held in binders of a proprietary design. The entries were arranged in a
        single sequence using only the left-hand page of each opening. Additions were made to  it by removing the sheets
        from the binder and typing new entries in the appropriate place. If there was no space on the page, additions
        were made on a narrower sheet, bound to face it.  Eventually, the whole sheet would be re-typed.  Originally the
        library maintained two copies of this catalogue: one for public use and a master copy held in the Cataloguing
        Department. The copy digitised here is the public copy. The Cataloguing Department copy is now held by the University Archives.
    </p>
    <p>The Guardbook is the last in a sequence of catalogues in very similar format which go back to the seventeenth
        century, which are now held in the University Archives. The earliest were handwritten in bound volumes. The first
        in a looseleaf format seems to date from about 1920; only parts of this survive. The Guardbook digitised here was started in the late 1950s."
    </p>
    <div class="clearfix"></div>
    <img src="{{ asset('collections/guardbook/images/CC-BY_icon.png')}}" alt="CC-BY attribution license" class="img-responsive" />
    <p>
        The PDFs are supplied under a Creative Commons CC-BY License: you may share and adapt for any purpose as long as attribution is given to the University of Edinburgh. Further information is available at <a href="http://creativecommons.org/licenses/by/4.0/" target="_blank">http://creativecommons.org/licenses/by/4.0/ (opens in a new tab)</a>

    </p>
</div>

<div class="col-sidebar">
{{--<pre>{{ var_export($facets, true) }}</pre>--}}
    @include('guardbook.search.partials.facets')
</div>
@endsection
