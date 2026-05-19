@extends('layouts.physics')

@section('title', 'School of Physics and Astronomy Image Archive')

@section('content')

    <div class="record">
        <p>
            This collection is intended primarily for University use. Images are provided free for non-commercial purposes
            to University of Edinburgh staff and students. You will be asked to register before downloading images:
            to ensure access, use your University email address.
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
