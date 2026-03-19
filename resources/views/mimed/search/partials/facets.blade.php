@if(isset($facets))
    @foreach($facets as $facet)
        @php
            $inactiveTerms = [];
            $activeTerms = [];
            $numterms = 0;
        @endphp

        <h4><a href="{{ url('/mimed/browse/' . $facet['name']) }}" title="{{ $facet['name'] }}">{{ $facet['name'] }}</a></h4>

        @foreach($facet['terms'] as $term)
            @php
                if ($term['active']) {
                    $activeTerms[] = $term;
                } else {
                    $inactiveTerms[] = $term;
                }
                $numterms++;
            @endphp
        @endforeach

        @if(count($activeTerms) > 0)
            <ul class="selected">
                @foreach($activeTerms as $term)
                    @php
                        $normalizedName = str_replace(["\n|||\n", "\r\n|||\r\n"], ' ||| ', $term['name']);
                        $encodedTerm = rawurlencode($normalizedName);
                        $segment = '/' . rawurlencode($facet['name'] . ':"' . $normalizedName . '"');
                        $remove = str_replace($segment, '', $base_search);
                    @endphp
                    <li>{{ $term['display_name'] }} ({{ $term['count'] }}) <a class="deselect" href="{{ $remove }}" title="Remove {{ $term['display_name'] }}"></a></li>
                @endforeach
            </ul>
        @endif

        <ul>
            @foreach($inactiveTerms as $term)
                @php $encodedTerm = urlencode(str_replace(["\n|||\n", "\r\n|||\r\n"], ' ||| ', $term['name'])); @endphp
                <li>
                    <a href="{{ $base_search }}/{{ $facet['name'] }}:%22{{ $encodedTerm }}%22{{ $base_parameters ?? '' }}" title="{{ $facet['name'] }}">{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                </li>
            @endforeach

            @if(isset($facet['queries']))
                @foreach($facet['queries'] as $term)
                    @if($term['count'] > 0)
                        @php
                            $pattern = '/' . preg_quote('/' . rawurlencode($facet['name']), '/') . '.*\]/';
                            $remove = preg_replace($pattern, '', $base_search, 1);
                            $pattern2 = '/' . preg_quote('/' . rawurlencode($facet['name']), '/') . '.*%5D/';
                            $remove = preg_replace($pattern2, '', $remove, 1);
                        @endphp
                        <li>
                            <a class="deselect" href="{{ $remove }}/{{ $facet['name'] }}:{{ $term['name'] }}" title="Remove {{ $term['display_name'] }}">{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                        </li>
                    @endif
                @endforeach
            @endif

            @if(empty($facet['terms']) && empty($facet['queries'] ?? []))
                <li>No matches</li>
            @elseif($numterms == config('skylight.facet_limit'))
                <li><a href="{{ url('/mimed/browse/' . $facet['name']) }}" title="More ...">More ...</a></li>
            @endif
        </ul>
    @endforeach
@endif
