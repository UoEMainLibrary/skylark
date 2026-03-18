@if(isset($facets) && count($facets) > 0)
    @foreach($facets as $index => $facet)
        <h4>
            <a data-toggle="collapse" href="#collapse{{ $index }}">{{ $facet['name'] }}</a>
        </h4>

        {{-- Active filters --}}
        @foreach($facet['active_terms'] as $term)
            @php
                $encodedTerm = urlencode($term['name']);
                $pattern = '/' . rawurlencode($facet['name']) . $delimiter . '%22' . $encodedTerm . '%22';
                $removeUrl = str_replace($pattern, '', $base_search);
                $removeUrl = rtrim($removeUrl, '/');
            @endphp
            <ul class="selected">
                <li>
                    {{ $term['display_name'] }}
                    <a class="deselect" href="{{ $removeUrl }}{{ $base_parameters }}">Remove</a>
                </li>
            </ul>
        @endforeach

        {{-- Inactive filters --}}
        <div id="collapse{{ $index }}" class="collapse in">
            <ul>
                @if(count($facet['inactive_terms']) === 0 && count($facet['active_terms']) === 0)
                    <li>No matches</li>
                @else
                    @foreach($facet['inactive_terms'] as $term)
                        @php
                            $encodedTerm = urlencode($term['name']);
                            $addUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedTerm . '%22';
                        @endphp
                        <li>
                            <a href="{{ $addUrl }}{{ $base_parameters }}">
                                {{ $term['display_name'] }} ({{ $term['count'] }})
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    @endforeach
@endif
