@extends('layouts.towardsdolly')

@section('title', 'Towards Dolly')

@section('content')
<div class="record">
    <div class="content byEditor">
        <h1>Towards Dolly: Edinburgh, Roslin and the Birth of Modern Genetics</h1>

        <p>
            &lsquo;Towards Dolly&rsquo; and related projects have catalogued, preserved and made available 22 archival and printed
            collections relating to Edinburgh&rsquo;s extraordinary contributions to animal genetics over the past century.
            Read more about the projects <a href="{{ url('/towardsdolly/about') }}" title="About the Project list">here</a>.
        </p>
        <div>
            <div title="J.C Ewart with Burchell's zebra c.1900" id="zebra-image"></div>
            <div title="Dolly the Sheep photograph courtesy The 'Roslin Institute and R(D)SVS, University of Edinburgh" id="dolly-image"></div>
            <p class="image-label">J.C Ewart with Burchell&rsquo;s zebra c.1900</p>
            <p class="image-label">Dolly the Sheep photograph courtesy The &lsquo;Roslin Institute and R(D)SVS, University of Edinburgh</p>
        </div>

        <div class="clearfix"></div>
        <p class="quote"><q>Spanning as they do from before the rediscovery of Mendel's work to the birth of Dolly and stem cell
            research, these papers form a collection unrivalled in the history and development of Genetics.</q>
        </p>
        <p class="float-right">Professor Grahame Bulfield, Emeritus Professor of Genetics at the University of Edinburgh
            and former director of Roslin Institute</p>
    </div>
    <div class="clearfix"></div>
</div>
@endsection
