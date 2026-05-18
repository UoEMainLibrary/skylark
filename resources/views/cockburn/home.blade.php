@extends('layouts.cockburn')

@section('title', 'Geology- Cockburn Collection- Home')

@section('content')

    <div class="content">
        <p>
            The Cockburn Museum at King's Buildings holds a very extensive collection of geological specimens and historical objects which reflect Edinburgh's prominent position in geological sciences since the time of James Hutton (1726-1797) and its continuing activity today. The stored collections reflect the whole spectrum of Earth Science materials - minerals, rocks, fossils - as well as maps and photographs and archives of activity by famous Earth scientists dating back as far as the late eighteenth century.
        </p><p>
            The collections have been housed at the Grant Institute since its opening in 1932 and were largely catalogued and arranged during the early years of the Institute by Dr. A. M. Cockburn. The considerable care, dedication and effort undertaken by Dr Cockburn on a voluntary basis automatically led his colleagues to adopt his name for the museum following his death in 1959. Since 1960, Helen Nisbet and Peder Aspen have been curators of the Cockburn Museum and have played a major part in extending the teaching and research collections in association with the huge expansion in both undergraduate and graduate students in geology in the second half of the twentieth century.
        </p><p>
            The original purpose of the museum dates back to 1873 when Professor Archibald Geikie, the holder of the first Chair of Geology at Edinburgh University, founded "a museum for the teaching of geology"; with the straightforward objective of having collections of minerals, rocks and fossils for the instruction of students. Geikie's example has been followed by many geological staff in the university and the teaching collections have been continually added to. At the same time the existence of the museum over many years has led to major donations of special and rare specimens (particularly minerals), which provide extremely valuable reference material for research investigations as well as some beautiful specimens for display.
        </p>
    </div>

    @if(! empty($docs))
        @php
            $titleField = str_replace('.', '', config('skylight.field_mappings.Title', ''));
            $authorField = str_replace('.', '', config('skylight.field_mappings.Author', ''));
            $recentCount = count($docs);
        @endphp

        <h3>Recently added items</h3>
        <ul class="listing">
            @foreach($docs as $index => $doc)
                @php
                    $recentTitle = 'Untitled';
                    if (! empty($doc[$titleField])) {
                        $titleValue = $doc[$titleField];
                        $recentTitle = is_array($titleValue) ? ($titleValue[0] ?? 'Untitled') : $titleValue;
                    }

                    $recentId = null;
                    if (isset($doc['id'])) {
                        $recentId = is_array($doc['id']) ? ($doc['id'][0] ?? null) : $doc['id'];
                    } elseif (isset($doc['handle'])) {
                        $handle = is_array($doc['handle']) ? ($doc['handle'][0] ?? '') : $doc['handle'];
                        $recentId = preg_replace('/^.*\//', '', (string) $handle);
                    }

                    $liClass = '';
                    if ($index === 0) {
                        $liClass = ' class="first"';
                    } elseif ($index === $recentCount - 1) {
                        $liClass = ' class="last"';
                    }
                @endphp

                <li{!! $liClass !!}>
                    @if($recentId)
                        <h3><a href="./record/{{ $recentId }}">{{ $recentTitle }}</a></h3>
                    @else
                        <h3>{{ $recentTitle }}</h3>
                    @endif

                    <div class="tags">
                        @if($authorField && ! empty($doc[$authorField]))
                            @foreach($doc[$authorField] as $authorIndex => $author)
                                @php
                                    $authorFilter = str_replace(' ', '+', $author);
                                    $authorFilter = str_replace(',', '%2C', $authorFilter);
                                @endphp
                                <a href='./search/*/Author:"{{ $authorFilter }}"'>{{ $author }}</a>@if($authorIndex < count($doc[$authorField]) - 1) @endif
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
