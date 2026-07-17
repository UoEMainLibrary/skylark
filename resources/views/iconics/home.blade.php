@extends('layouts.iconics')

@section('title', 'Library and University Collections - Iconics')

@section('content')

    <div class="record">
        <div class="content byEditor">
            <div class="tag-line">
                <h1>These iconic items are the most beautiful, important and unique treasures in the University's collections.
                    Some, like the Rashid al-Din manuscript, are known across the world. Others, like Clement Litill's charter
                    which founded the Library, are key to the story of our collections. Some choices may
                    <a href="{{ url('/iconics') }}">surprise</a> you!
                    &nbsp; &nbsp;<a href="{{ url('/iconics/search/*:*') }}">View All</a>
                </h1>
            </div>
        </div>
    </div>

    @if(! empty($randomItems))
        @php
            $titleField = str_replace('.', '', config('skylight.field_mappings.Title', ''));
            $bitstreamField = str_replace('.', '', config('skylight.field_mappings.Bitstream', ''));
            $thumbnailField = str_replace('.', '', config('skylight.field_mappings.Thumbnail', ''));
        @endphp

        <div class="randoms">
            <div class="container-random">
                @foreach($randomItems as $index => $doc)
                    @php
                        $extraClass = $index % 4 === 0 ? 'thumbnail-first' : '';

                        $randomTitle = 'Untitled';
                        if (! empty($doc[$titleField])) {
                            $titleValue = $doc[$titleField];
                            $randomTitle = is_array($titleValue) ? ($titleValue[0] ?? 'Untitled') : $titleValue;
                        }

                        $randomId = null;
                        if (isset($doc['id'])) {
                            $randomId = is_array($doc['id']) ? ($doc['id'][0] ?? null) : $doc['id'];
                        }

                        $thumbnailLink = '';

                        if ($bitstreamField && ! empty($doc[$bitstreamField])) {
                            $bitstreams = is_array($doc[$bitstreamField]) ? $doc[$bitstreamField] : [$doc[$bitstreamField]];
                            $bitstreamArray = [];
                            $minSeq = null;

                            foreach ($bitstreams as $bitstream) {
                                $segments = explode('##', $bitstream);
                                $filename = $segments[1] ?? '';
                                $seq = $segments[4] ?? null;

                                if ($seq !== null && (str_contains($filename, '.jpg') || str_contains($filename, '.JPG'))) {
                                    $bitstreamArray[$seq] = $bitstream;
                                    if ($minSeq === null || $seq < $minSeq) {
                                        $minSeq = $seq;
                                    }
                                }
                            }

                            if ($minSeq !== null && count($bitstreamArray) > 0) {
                                $bSegments = explode('##', $bitstreamArray[$minSeq]);
                                $bFilename = $bSegments[1] ?? '';
                                $bHandle = $bSegments[3] ?? '';
                                $bSeq = $bSegments[4] ?? '';
                                $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
                                $bUri = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;

                                $imageUri = $bUri;

                                if ($thumbnailField && isset($doc[$thumbnailField])) {
                                    foreach ($doc[$thumbnailField] as $thumbnail) {
                                        $tSegments = explode('##', $thumbnail);
                                        $tFilename = $tSegments[1] ?? '';
                                        if ($tFilename === $bFilename.'.jpg') {
                                            $tSeq = $tSegments[4] ?? '';
                                            $imageUri = './record/'.$bHandleId.'/'.$tSeq.'/'.$tFilename;
                                            break;
                                        }
                                    }
                                }

                                $thumbnailLink = '<div class="random-image">'
                                    .'<a class="random-image-link" href="./record/'.e($randomId).'" title="'.e($randomTitle).'">'
                                    .'<img src="'.e($imageUri).'" class="random-thumbnailimg" title="'.e($randomTitle).'" alt="'.e($randomTitle).'" />'
                                    .'</a></div>';
                            }
                        }
                    @endphp

                    <div class="thumbnail random-thumbnail {{ $extraClass }}">
                        <div class="random-title">
                            @if($randomId)
                                <a href="./record/{{ $randomId }}">{{ $randomTitle }}</a>
                            @else
                                {{ $randomTitle }}
                            @endif
                        </div>

                        {!! $thumbnailLink !!}
                    </div>
                @endforeach
            </div>

            <div>
                <p>
                    <a target="_blank" href="https://images.is.ed.ac.uk/luna/servlet/iiif/collection/g/376">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/International_Image_Interoperability_Framework_logo.png" class="iiiflogo" alt="IIIF logo" title="Right-click, Copy Link to get the full IIIF manifest for the collection." />
                        <span class="sr-only"> (Opens in a new tab)</span>
                    </a>
                    <a target="_blank" href="https://images.is.ed.ac.uk/luna/servlet/iiif/collection/g/376">
                        <img src="https://images.is.ed.ac.uk/luna/images/LUNAIIIF80.png" class="lunaiiif" alt="LUNA IIIF logo" title="Right-click, Copy Link to get the full IIIF manifest for the collection." />
                        <span class="sr-only"> (Opens in a new tab)</span>
                    </a>
                    This collection is IIIF-compliant. <a href="{{ url('/iconics/iiif') }}">See more</a>.
                </p>
            </div>

            <div class="clearfix"></div>
        </div>
    @endif

@endsection
