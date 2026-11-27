@if(!empty($facets))
    <div class="mimed-facets">
        @foreach($facets as $facet)
            <details @if(!empty($facet['active_terms'])) open @endif>
                <summary>{{ $facet['name'] }}</summary>
                <ul>
                    @foreach($facet['active_terms'] as $term)
                        @php
                            $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                            $encodedTerm = urlencode($normalizedName);
                            $pattern = '/' . rawurlencode($facet['name']) . $delimiter . '%22' . $encodedTerm . '%22';
                            $removeUrl = rtrim(str_replace($pattern, '', $base_search), '/');
                        @endphp
                        <li class="mimed-active-filter">
                            {{ $term['display_name'] }}
                            <a href="{{ $removeUrl }}{{ $base_parameters }}" aria-label="Remove {{ $term['display_name'] }} filter">Remove</a>
                        </li>
                    @endforeach

                    @foreach($facet['inactive_terms'] as $term)
                        @php
                            $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                            $encodedTerm = urlencode($normalizedName);
                            $addUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedTerm . '%22';
                        @endphp
                        <li><a href="{{ $addUrl }}{{ $base_parameters }}">{{ $term['display_name'] }} <span>({{ $term['count'] }})</span></a></li>
                    @endforeach

                    @if(empty($facet['inactive_terms']) && empty($facet['active_terms']))
                        <li>No matches</li>
                    @endif
                </ul>
            </details>
        @endforeach
    </div>
@endif
