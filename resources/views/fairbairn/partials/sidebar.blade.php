{{-- Subject + Agent browse facets for non-search pages. --}}
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

    @if(!empty($agentFacet['terms']))
        <h4><a href="{{ $collectionUrl('browse/Agent') }}">Agent</a></h4>
        <ul>
            @foreach($agentFacet['terms'] as $term)
                @php
                    $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                @endphp
                <li>
                    <a href='{{ $collectionUrl('search/*:*/Agent:"' . $encodedTerm . '"') }}'>
                        {{ $term['display_name'] }} ({{ $term['count'] }})
                    </a>
                </li>
            @endforeach
            <li><a href="{{ $collectionUrl('browse/Agent') }}">More ...</a></li>
        </ul>
    @endif
</div>
