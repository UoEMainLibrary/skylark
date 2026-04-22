@if(isset($facets) && count($facets) > 0)
    @foreach($facets as $index => $facet)
        @php
            $active_terms = [];
            $inactive_terms = [];
            $numterms = 0;

            foreach (($facet['terms'] ?? []) as $term) {
                if (!empty($term['active'])) {
                    $active_terms[] = $term;
                } else {
                    $inactive_terms[] = $term;
                }
                $numterms++;
            }
        @endphp

        <h4>
            <a data-toggle="collapse" href="#collapse{{ $index }}">
                {{ $facet['name'] }}
            </a>
        </h4>

        {{-- Date facet clear link --}}
        @if(preg_match('/Date/', $base_search) && $facet['name'] === 'Date')
            @php
                $fremove = preg_replace('#/' . preg_quote($facet['name'], '#') . '.*\]#', '', $base_search);
                $fremove = preg_replace('#/' . preg_quote($facet['name'], '#') . '.*%5D#', '', $fremove);
            @endphp

            <ul class="selected">
                <li>
                    Clear {{ $facet['name'] }} filters
                    <a class="deselect" href="{{ $fremove }}" title="{{ $facet['name'] }}">Remove</a>
                </li>
            </ul>
        @endif

        {{-- Active filters --}}
        @if(count($active_terms) > 0)
            <ul class="selected">
                @foreach($active_terms as $term)
                    @php
                        $encodedFacet = rawurlencode($facet['name']);
                        $encodedTerm = urlencode($term['name']);
                        $pattern = '#/' . $encodedFacet . ':%22' . preg_quote($encodedTerm, '#') . '%22#';
                        $removeUrl = preg_replace($pattern, '', $base_search);
                        $removeUrl = rtrim($removeUrl, '/');
                    @endphp
                    <li>
                        {{ $term['display_name'] }} ({{ $term['count'] }})
                        <a class="deselect" href="{{ $removeUrl }}{{ $base_parameters }}" title="Remove {{ $term['display_name'] }}">
                            Remove
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Inactive filters and queries --}}
        <div id="collapse{{ $index }}" class="collapse in">
            <ul>
                @forelse($inactive_terms as $term)
                    @php
                        $encodedTerm = urlencode($term['name']);
                        $addUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedTerm . '%22' . $base_parameters;
                    @endphp
                    <li>
                        <a href="{{ $addUrl }}" title="{{ $facet['name'] }}">
                            {{ $term['display_name'] }} ({{ $term['count'] }})
                        </a>
                    </li>
                @empty
                    @if(empty($facet['queries']) && count($active_terms) === 0)
                        <li>No matches</li>
                    @endif
                @endforelse

                {{-- Query facets --}}
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
                        <li>
                            <a href="{{ $queryUrl }}" title="{{ $term['display_name'] }}">
                                {{ $term['display_name'] }} ({{ $term['count'] }})
                            </a>
                        </li>
                    @endif
                @endforeach

                {{-- More link --}}
                @if($numterms == config('skylight.facet_limit'))
                    <li>
                        <a href="./browse/{{ $facet['name'] }}" title="More ...">More ...</a>
                    </li>
                @endif
            </ul>
        </div>
    @endforeach
@endif
