@if(isset($facets) && count($facets) > 0)
    @foreach($facets as $facet)
        @php
            $inactiveTerms = [];
            $activeTerms = [];

            foreach ($facet['terms'] ?? [] as $term) {
                if ($term['active'] ?? false) {
                    $activeTerms[] = $term;
                } else {
                    $inactiveTerms[] = $term;
                }
            }

            $numterms = count($facet['terms'] ?? []);
        @endphp

        <h4><a href="{{ $collectionUrl('browse/'.$facet['name']) }}">{{ $facet['name'] }}</a></h4>

        @if(count($activeTerms) > 0)
            <ul class="selected">
                @foreach($activeTerms as $term)
                    @php
                        $encodedFacet = rawurlencode($facet['name']);
                        $encodedTerm = urlencode($term['name']);
                        $pattern = '#/' . $encodedFacet . ':%22' . preg_quote($encodedTerm, '#') . '%22#';
                        $removeUrl = preg_replace($pattern, '', $base_search ?? url(request()->path()));
                        $removeUrl = rtrim($removeUrl, '/');
                    @endphp
                    <li>{{ $term['display_name'] }} ({{ $term['count'] }})
                        <a class="deselect" href='{{ $removeUrl }}{{ $base_parameters ?? '' }}'><i class="fa fa-close"></i>&nbsp;</a>
                    </li>
                @endforeach
            </ul>
        @endif

        <ul>
            @foreach($inactiveTerms as $term)
                @php
                    $encodedTerm = urlencode($term['name']);
                    $addUrl = ($base_search ?? url(request()->path())) . '/' . $facet['name'] . ':%22' . $encodedTerm . '%22' . ($base_parameters ?? '');
                @endphp
                <li>
                    <a href='{{ $addUrl }}'>{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                </li>
            @endforeach

            @foreach($facet['queries'] ?? [] as $term)
                @if(($term['count'] ?? 0) > 0)
                    <li>
                        <a href='{{ $base_search ?? url(request()->path()) }}/{{ $facet['name'] }}:{{ $term['name'] }}{{ $base_parameters ?? '' }}'>{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                    </li>
                @endif
            @endforeach

            @if(empty($facet['terms']) && empty($facet['queries']))
                <li>No matches</li>
            @elseif($numterms >= config('skylight.results_per_page', 10))
                <li><a href="{{ $collectionUrl('browse/'.$facet['name']) }}">More ...</a></li>
            @endif
        </ul>
    @endforeach
@endif
