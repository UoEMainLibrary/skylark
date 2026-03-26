<div class="search-facets">
@if(isset($facets) && count($facets) > 0)
    @foreach($facets as $facet)
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('/art/browse/' . $facet['name']) }}" title="{{ $facet['name'] }}">{{ $facet['name'] }}</a>
            </li>
        </ul>

        @if(count($facet['active_terms']) > 0)
            <ul class="selected">
                @foreach($facet['active_terms'] as $term)
                    @php
                        $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                        $encodedTerm = urlencode($normalizedName);
                        $pattern = '/' . rawurlencode($facet['name']) . $delimiter . '%22' . $encodedTerm . '%22';
                        $removeUrl = str_replace($pattern, '', $base_search);
                        $removeUrl = rtrim($removeUrl, '/');
                    @endphp
                    <li>{{ $term['display_name'] }} ({{ $term['count'] }}) <a class="deselect" href="{{ $removeUrl }}{{ $base_parameters }}" title="Remove {{ $term['display_name'] }}"></a></li>
                @endforeach
            </ul>
        @endif

        <ul>
            @if(count($facet['inactive_terms']) === 0 && count($facet['active_terms']) === 0)
                <li>No matches</li>
            @else
                @foreach($facet['inactive_terms'] as $term)
                    @php
                        $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                        $encodedTerm = urlencode($normalizedName);
                        $addUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedTerm . '%22';
                    @endphp
                    <li>
                        <a href="{{ $addUrl }}{{ $base_parameters }}" title="{{ $facet['name'] }}">{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                    </li>
                @endforeach
            @endif
        </ul>
    @endforeach
@endif
</div>
