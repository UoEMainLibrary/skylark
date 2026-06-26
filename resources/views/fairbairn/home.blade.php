@extends('layouts.fairbairn')

@section('title', 'W. Ronald D. Fairbairn')

@section('content')
<div class="record">
    <div class="content byEditor">
        <h1>W. Ronald D. Fairbairn (1889-1964)</h1>

        <p>
            William Ronald Dodds Fairbairn (1889-1964) was a leading psychoanalyst whose pioneering work helped children
            suffering from trauma in the early 20th century. His personal library including works by Freud and Jung is held
            by Edinburgh University Library. His papers, diaries and correspondence are in the National Library of Scotland.
            This project, funded by the Wellcome Trust, has seen these collections fully catalogued and conserved.
        </p>
        <div id="fairbairn-image"></div><br />
        <p><a href="{{ $collectionUrl('record/20528/archival_object') }}" title="Photographic prints of W. Ronald D. Fairbairn">Photographic prints of W. Ronald D. Fairbairn.</a></p>
    </div>
</div>
@endsection
