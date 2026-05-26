<div class="col-sidebar">
    <h4><a href="{{ url('/towardsdolly/browse/Subject') }}">Subject</a></h4>

    <ul>
        @foreach(($subjectFacet['terms'] ?? []) as $subject)
            <li>
                <a href='{{ url('/towardsdolly/search/*:*/Subject:"' . ($subject['name'] ?? '') . '"') }}'>
                    {{ $subject['display_name'] ?? '' }} ({{ $subject['count'] ?? 0 }})
                </a>
            </li>
        @endforeach
        @if(count($subjectFacet['terms'] ?? []) > 0)
            <li><a href="{{ url('/towardsdolly/browse/Subject') }}">More ...</a></li>
        @endif
    </ul>

    <h4><a href="{{ url('/towardsdolly/browse/Person') }}">Person</a></h4>

    <ul>
        @foreach(($personFacet['terms'] ?? []) as $person)
            <li>
                <a href='{{ url('/towardsdolly/search/*:*/Person:"' . ($person['name'] ?? '') . '"') }}'>
                    {{ $person['display_name'] ?? '' }} ({{ $person['count'] ?? 0 }})
                </a>
            </li>
        @endforeach
        @if(count($personFacet['terms'] ?? []) > 0)
            <li><a href="{{ url('/towardsdolly/browse/Person') }}">More ...</a></li>
        @endif
    </ul>
</div>
