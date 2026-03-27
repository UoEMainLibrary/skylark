{{-- Skylight search_facets.php equivalent --}}
@php
    $facetLimit = config('skylight.facet_limit', 10);
@endphp
@if(! empty($facets))
    @foreach($facets as $facet)
        @php
            $inactive_terms = $facet['inactive_terms'] ?? [];
            $active_terms = $facet['active_terms'] ?? [];
            $facet_queries = $facet['queries'] ?? [];
        @endphp

        <h4><a href="{{ $collectionUrl('browse/'.$facet['name']) }}" title="{{ $facet['name'] }}">{{ $facet['name'] }}</a></h4>

        @if(preg_match('/Date/', $base_search) && $facet['name'] === 'Date')
            @php
                $fpattern = '#\/'.$facet['name'].'.*\]#';
                $fremove = preg_replace($fpattern, '', $base_search, -1);
                $fpattern = '#\/'.$facet['name'].'.*\%5D#';
                $fremove = preg_replace($fpattern, '', $fremove, -1);
            @endphp
            <ul class="selected">
                <li>
                    Clear {{ $facet['name'] }} filters <a class="deselect" href="{{ $fremove }}" title="{{ $facet['name'] }}"></a>
                </li>
            </ul>
        @endif

        @php
            $numterms = count($inactive_terms) + count($active_terms);
        @endphp

        @if(count($active_terms) > 0)
            <ul class="selected">
                @foreach($active_terms as $term)
                    @php
                        $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                        $encodedTerm = urlencode($normalizedName);
                        $pattern = '#\/'.rawurlencode($facet['name']).$delimiter.'%22'.preg_quote($encodedTerm, '#').'%22#';
                        $remove = preg_replace($pattern, '', $base_search, -1);
                    @endphp
                    <li>{{ $term['display_name'] }} ({{ $term['count'] }}) <a class="deselect" href="{{ $remove }}" title="Remove {{ $term['display_name'] }}"></a></li>
                @endforeach
            </ul>
        @endif

        <ul>
            @foreach($inactive_terms as $term)
                @php
                    $normalizedName = str_replace(["\r\n|||\r\n", "\n|||\n"], ' ||| ', $term['name']);
                    $encodedTerm = urlencode($normalizedName);
                @endphp
                <li>
                    <a href="{{ $base_search }}/{{ $facet['name'] }}:{{ '%22'.$encodedTerm.'%22' }}{{ $base_parameters }}" title="{{ $facet['name'] }}">{{ $term['display_name'] }} ({{ $term['count'] }})
                    </a>
                </li>
            @endforeach

            @foreach($facet_queries as $term)
                @php
                    $pattern = '#\/'.rawurlencode($facet['name']).'.*\]#';
                    $remove = preg_replace($pattern, '', $base_search, -1);
                    $pattern = '#\/'.rawurlencode($facet['name']).'.*\%5D#';
                    $remove = preg_replace($pattern, '', $remove, -1);
                @endphp
                @if(($term['count'] ?? 0) > 0)
                    <li>
                        <a class="deselect" href="{{ $remove }}/{{ $facet['name'] }}:{{ $term['name'] }}{{ isset($operator) ? '?operator='.$operator : '' }}" title="Remove {{ $term['display_name'] }}">{{ $term['display_name'] }} ({{ $term['count'] }})
                        </a>
                    </li>
                @endif
            @endforeach

            @if(empty($inactive_terms) && empty($active_terms) && empty($facet_queries))
                <li>No matches</li>
            @elseif($numterms >= $facetLimit)
                <li><a href="{{ $collectionUrl('browse/'.$facet['name']) }}" title="More ...">More ...</a></li>
            @endif
        </ul>
    @endforeach
@endif
