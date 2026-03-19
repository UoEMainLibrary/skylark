@extends('layouts.mimed')

@section('title', 'Musical Instrument Museums Edinburgh')

@section('content')
<div class="col-main">
    <div class="content">
        <div class="content byEditor">
            <p>St Cecilia's Hall is home to the collections of early keyboard and plucked strings, part of Edinburgh University Collection of Historic Musical Instruments, which ranks among the world's most important collections of musical heritage. The sister collection is currently on display and in store at the Reid Concert Hall Museum of Instruments. As part of the Redevelopment Project the two collections will be brought together as one, creating a single visitor destination at St Cecilia's Hall. It has official Recognised Collection of National Significance to Scotland status.</p>

            <div class="gallery">
                <a href="./record/16327"><img src="{{ asset('collections/mimed/images/carousel/triple-manual-harpsichord.jpg') }}" alt="Triple Manual Harpsichord" title="Triple Manual Harpsichord"></a>
                <a href="./record/15630"><img src="{{ asset('collections/mimed/images/carousel/bombardon.jpg') }}" alt="Bombardon" title="Bombardon"></a>
                <a href="./record/16782"><img src="{{ asset('collections/mimed/images/carousel/kettle-drum.jpg') }}" alt="Kettle Drum" title="Kettle Drum"></a>
                <a href="./record/14715"><img src="{{ asset('collections/mimed/images/carousel/viola-damore.jpg') }}" alt="Viola D'Amore" title="Viola D'Amore"></a>
                <a href="./record/17041"><img src="{{ asset('collections/mimed/images/carousel/tam-tam.jpg') }}" alt="Tam-Tam" title="Tam-Tam"></a>
                <a href="./record/15288"><img src="{{ asset('collections/mimed/images/carousel/upright-pianoforte.jpg') }}" alt="Upright Pianoforte" title="Upright Pianoforte"></a>
                <a href="./record/17987"><img src="{{ asset('collections/mimed/images/carousel/shawm.jpg') }}" alt="Shawm" title="Shawm"></a>
                <a href="./record/16820"><img src="{{ asset('collections/mimed/images/carousel/panpipes.jpg') }}" alt="Panpipes" title="Panpipes"></a>
                <a href="./record/17120"><img src="{{ asset('collections/mimed/images/carousel/sousaphone.jpg') }}" alt="Sousaphone" title="Sousaphone"></a>
                <a href="./record/14923"><img src="{{ asset('collections/mimed/images/carousel/banjo.jpg') }}" alt="Banjo" title="Banjo"></a>
                <a href="./record/15548"><img src="{{ asset('collections/mimed/images/carousel/clarinet.jpg') }}" alt="Clarinet" title="Clarinet"></a>
                <a href="./record/16671"><img src="{{ asset('collections/mimed/images/carousel/bow-harp.jpg') }}" alt="Bow Harp" title="Bow Harp"></a>
                <a href="./record/15002"><img src="{{ asset('collections/mimed/images/carousel/bassoon.jpg') }}" alt="Bassoon" title="Bassoon"></a>
                <a href="./record/16112"><img src="{{ asset('collections/mimed/images/carousel/double-belled-euphonium.jpg') }}" alt="Double-Belled Euphonium" title="Double-Belled Euphonium"></a>
                <a href="./record/16089"><img src="{{ asset('collections/mimed/images/carousel/guitar.jpg') }}" alt="Guitar" title="Guitar"></a>
                <a href="./record/17775"><img src="{{ asset('collections/mimed/images/carousel/stock-and-horn.jpg') }}" alt="Stock and Horn" title="Stock and Horn"></a>
                <a href="./record/14592"><img src="{{ asset('collections/mimed/images/carousel/xylophone.jpg') }}" alt="Xylophone" title="Xylophone"></a>
                <div class="cover"></div>
            </div>

            <p>The emphasis of the Collection is on instruments that are no longer in regular current use and the collecting policy is to acquire instruments when they fall out of use rather than to collect instruments by contemporary makers. The Collection thus covers the period from the 16th century (the earliest from which examples are available for acquisition) to the 20th century (the most recent from which instruments can be regarded as historic).</p>
            <p>Many of the instruments are still playable and through an established concert programme and as a regular venue during the Edinburgh International Festival, the Concert Room provides a contemporaneous setting for performances, within which the audience can be seen as the interface between the University and the public. For instance, St Cecilia's Hall is the only place in the world where it is possible to hear 18th century music in an 18th century concert hall played on 18th century instruments.</p>
            <p>The instruments are supplemented by an archive of original materials, working papers and a sound archive. The Collection as a whole attracts researchers from far and wide and is an extensively cited resource in international scholarship. Instruments are lent to prestigious exhibitions at home and internationally.</p>
        </div>
    </div>
</div>
<div class="col-sidebar">
    @include('mimed.search.partials.facets')
</div>
@endsection
