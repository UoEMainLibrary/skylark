<div class="col-md-3 col-sm-3 hidden-xs">
    @if(isset($facets))
        <div class="sidebar-nav">
            @foreach($facets as $facet)
                @php
                    $inactive_terms = [];
                    $active_terms = [];
                    $numterms = 0;
                @endphp

                <ul class="list-group">
                    <li class="list-group-item active">
                        <a href="./search/*?sort_by=dc.title_sort+asc">
                            {{ $facet['name'] }}
                        </a>
                    </li>

                    @if(preg_match('/Date/', $base_search) && $facet['name'] === 'Date')
                        @php
                            $fremove = preg_replace('#/' . $facet['name'] . '.*\]#', '', $base_search, -1);
                            $fremove = preg_replace('#/' . $facet['name'] . '.*\%5D#', '', $fremove, -1);
                        @endphp

                        <li class="list-group-item">
                            Clear {{ $facet['name'] }} filters
                            <a class="deselect" href="{{ $fremove }}"></a>
                        </li>
                    @endif

                    @foreach($facet['terms'] as $term)
                        @php
                            if ($term['active']) {
                                $active_terms[] = $term;
                            } else {
                                $inactive_terms[] = $term;
                            }
                            $numterms++;
                        @endphp
                    @endforeach

                    @if(sizeof($active_terms) > 0)
                        @foreach($active_terms as $term)
                            @php
                                $pattern = '#/' . rawurlencode($facet['name']) . ':%22' . preg_quote($term['name'], '#') . '%22#';
                                $remove = preg_replace($pattern, '', $base_search, -1);
                            @endphp
                            <li class="list-group-item">
                                <span class="badge">{{ $term['count'] }}</span>
                                {{ $term['display_name'] }}
                                <a class="deselect" href="{{ $remove }}">
                                    <i class="fa fa-close"></i>&nbsp;
                                </a>
                            </li>
                        @endforeach
                    @endif

                    @foreach($inactive_terms as $term)
                        <li class="list-group-item">
                            <span class="badge">{{ $term['count'] }}</span>
                            <a href="{{ $base_search }}/{{ $facet['name'] }}:%22{{ $term['name'] }}%22{{ $base_parameters }}">
                                {{ $term['display_name'] }}
                            </a>
                        </li>
                    @endforeach

                    @foreach($facet['queries'] as $term)
                        @php
                            $remove = preg_replace('#/' . rawurlencode($facet['name']) . '.*\]#', '', $base_search, -1);
                            $remove = preg_replace('#/' . rawurlencode($facet['name']) . '.*\%5D#', '', $remove, -1);
                        @endphp

                        @if($term['count'] > 0)
                            <li class="list-group-item">
                                <span class="badge">{{ $term['count'] }}</span>
                                <a class="deselect" href="{{ $remove }}/{{ $facet['name'] }}:{{ $term['name'] }}@if(isset($operator))?operator={{ $operator }}@endif">
                                    {{ $term['display_name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    @if(empty($facet['terms']) && empty($facet['queries']))
                        <li class="list-group-item">No matches</li>
                    @else
                        @if($numterms == config('skylight.results_per_page'))
                            <li class="list-group-item">
                                <a href="./browse/{{ $facet['name'] }}">More ...</a>
                            </li>
                        @endif
                    @endif
                </ul>
            @endforeach
        </div>
    @endif
</div>
