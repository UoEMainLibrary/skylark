{{-- Subject + Person browse facets for non-search pages. --}}
<div class="col-sidebar">
    @if(!empty($subjectFacet['terms']))
        <h4><a href="{{ $collectionUrl('browse/Subject') }}">Subject</a></h4>
        <ul>
            @foreach($subjectFacet['terms'] as $term)
                @php
                    $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                @endphp
                <li>
                    <a href='{{ $collectionUrl('search/*:*/Subject:"' . $encodedTerm . '"') }}'>
                        {{ $term['display_name'] }} ({{ $term['count'] }})
                    </a>
                </li>
            @endforeach
            <li><a href="{{ $collectionUrl('browse/Subject') }}">More ...</a></li>
        </ul>
    @endif

    @if(!empty($personFacet['terms']))
        <h4><a href="{{ $collectionUrl('browse/Person') }}">Person</a></h4>
        <ul>
            @foreach($personFacet['terms'] as $term)
                @php
                    $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                @endphp
                <li>
                    <a href='{{ $collectionUrl('search/*:*/Person:"' . $encodedTerm . '"') }}'>
                        {{ $term['display_name'] }} ({{ $term['count'] }})
                    </a>
                </li>
            @endforeach
            <li><a href="{{ $collectionUrl('browse/Person') }}">More ...</a></li>
        </ul>
    @endif
</div>
