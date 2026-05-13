{{-- Mirrors skylight-local/theme/stcecilia/views/search_facets.php verbatim
     (Bootstrap 3 panel-group accordion) but consumes Skylark's facet shape
     (each $facet has a flat 'terms' array with an 'active' flag). --}}
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs" id="side_facet">
    <h3 title="Use sidebar to refine your search results">Refine Results</h3>

    @if(isset($facets) && count($facets) > 0)
        @foreach($facets as $index => $facet)
            @php
                $activeTerms = [];
                $inactiveTerms = [];
                $numterms = 0;

                foreach (($facet['terms'] ?? []) as $term) {
                    if (!empty($term['active'])) {
                        $activeTerms[] = $term;
                    } else {
                        $inactiveTerms[] = $term;
                    }
                    $numterms++;
                }
            @endphp

            <div class="panel-group" id="accordion{{ $index }}">
                <div class="panel panel-facets">
                    <div class="panel-heading">
                        <span class="facet_title">
                            <a data-toggle="collapse" data-parent="#accordion" href="?query=h#collapse{{ $index }}" title="Collapse {{ $facet['name'] }} sidebar">
                                {{ $facet['name'] }}<i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>

                    <div id="collapse{{ $index }}" class="panel-collapse collapse in">
                        <div class="panel-body" id="{{ $index }}_container">
                            @if(preg_match('/Date/', $base_search) && $facet['name'] === 'Date')
                                @php
                                    $facetPattern = preg_quote($facet['name'], '#');
                                    $fremove = preg_replace('#/' . $facetPattern . '.*\]#', '', $base_search);
                                    $fremove = preg_replace('#/' . $facetPattern . '.*%5D#', '', $fremove);
                                @endphp
                                Clear {{ $facet['name'] }} filters
                                <a class="deselect" href="{{ $fremove }}"></a>
                                <br>
                            @endif

                            @foreach($activeTerms as $term)
                                @php
                                    $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                                    $encodedFacet = rawurlencode($facet['name']);
                                    $encodedTerm = urlencode($normalizedName);
                                    $pattern = '#/' . $encodedFacet . ':%22' . preg_quote($encodedTerm, '#') . '%22#';
                                    $removeUrl = preg_replace($pattern, '', $base_search);
                                    $removeUrl = rtrim($removeUrl, '/');
                                @endphp
                                {{ $term['display_name'] }}
                                <a class="deselect" href="{{ $removeUrl }}" title="Remove {{ $term['display_name'] }} filter"><i class="fa fa-close" aria-hidden="true"></i>&nbsp; <span>{{ $term['count'] }}</span></a><br><br>
                            @endforeach

                            @foreach($inactiveTerms as $term)
                                @php
                                    $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                                    $encodedTerm = urlencode($normalizedName);
                                    $addUrl = $base_search . '/' . $facet['name'] . ':"' . $encodedTerm . '"' . $base_parameters;
                                @endphp
                                <a href='{{ $addUrl }}' title="View instruments relating to ' {{ $term['display_name'] }}'"> {{ $term['display_name'] }}                                <span>{{ $term['count'] }}</span></a>
                                <br><br>
                            @endforeach

                            @foreach(($facet['queries'] ?? []) as $term)
                                @php
                                    $encodedFacet = rawurlencode($facet['name']);
                                    $removeUrl = preg_replace('#/' . $encodedFacet . '.*\]#', '', $base_search);
                                    $removeUrl = preg_replace('#/' . $encodedFacet . '.*%5D#', '', $removeUrl);
                                    $queryUrl = $removeUrl . '/' . $facet['name'] . ':' . $term['name'];
                                    if (isset($operator)) {
                                        $queryUrl .= '?operator=' . $operator;
                                    }
                                @endphp
                                @if($term['count'] > 0)
                                    <a class="deselect" href="{{ $queryUrl }}">{{ $term['display_name'] }}
                                        <span>{{ $term['count'] }}</span></a><br><br>
                                @endif
                            @endforeach

                            @if(empty($facet['terms']) && empty($facet['queries']))
                                No matches<br><br>
                            @else
                                @if($numterms == config('skylight.facet_limit'))
                                    <a href="{{ url('/stcecilias/browse/' . $facet['name']) }}">More ...</a><br><br>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>{{-- end of side_facet --}}
