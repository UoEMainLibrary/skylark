<div class="pull-right">
    <form method="get" action="{{ $base_search }}" class="form-inline">
        @if(request()->has('num_results'))
            <input type="hidden" name="num_results" value="{{ request('num_results') }}">
        @endif
        
        <div class="form-group">
            <label for="sort_by">Sort by:</label>
            <select name="sort_by" id="sort_by" class="form-control input-sm" onchange="this.form.submit()">
                @foreach($sort_options as $label => $field)
                    @php
                        $sortValue = $field . ' desc';
                        if ($label === 'Title') {
                            $sortAsc = $field . ' asc';
                            $sortDesc = $field . ' desc';
                        }
                    @endphp
                    
                    @if($label === 'Title')
                        <option value="{{ $field }} asc" {{ $sort_by === $field . ' asc' ? 'selected' : '' }}>
                            Title (A-Z)
                        </option>
                        <option value="{{ $field }} desc" {{ $sort_by === $field . ' desc' ? 'selected' : '' }}>
                            Title (Z-A)
                        </option>
                    @elseif($label === 'Relevancy')
                        <option value="{{ $field }} desc" {{ $sort_by === $field . ' desc' || str_starts_with($sort_by, 'score') ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @else
                        <option value="{{ $field }} desc" {{ $sort_by === $field . ' desc' ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </form>
</div>
