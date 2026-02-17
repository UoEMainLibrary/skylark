@if(isset($facets) && count($facets) > 0)
    @foreach($facets as $index => $facet)
        <div class="panel-group" id="accordion{{ $index }}">
            <div class="panel panel-facets">
                <div class="panel-heading">
                    <span class="facet_title">
                        <a data-toggle="collapse" data-parent="#accordion{{ $index }}" href="#collapse{{ $index }}">
                            {{ $facet['name'] }} <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                    </span>
                </div>

                <div id="collapse{{ $index }}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        @if(count($facet['terms']) === 0)
                            <p>No matches</p>
                        @else
                            {{-- Active filters (with remove button) --}}
                            @foreach($facet['active_terms'] as $term)
                                @php
                                    // Build URL to remove this filter
                                    $pattern = '/' . rawurlencode($facet['name']) . $delimiter . '"' . $term['name'] . '"';
                                    $removeUrl = str_replace($pattern, '', $base_search);
                                    $removeUrl = rtrim($removeUrl, '/');
                                @endphp
                                <div class="facet-term active-term">
                                    {{ $term['display_name'] }}
                                    <a class="deselect" href="{{ $removeUrl }}{{ $base_parameters }}">
                                        <i class="fa fa-close"></i> <span>({{ $term['count'] }})</span>
                                    </a>
                                </div>
                            @endforeach

                            {{-- Inactive filters (clickable to add) --}}
                            @foreach($facet['inactive_terms'] as $term)
                                @php
                                    // Build URL to add this filter
                                    $addUrl = $base_search . '/' . $facet['name'] . ':"' . $term['name'] . '"';
                                @endphp
                                <div class="facet-term">
                                    <a href="{{ $addUrl }}{{ $base_parameters }}">
                                        {{ $term['display_name'] }} <span>({{ $term['count'] }})</span>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
