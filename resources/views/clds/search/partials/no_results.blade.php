<div class="alert alert-warning">
    <h3>No results found</h3>
    
    @if(isset($suggestions) && count($suggestions) > 0)
        <p><strong>Did you mean:</strong></p>
        <ul>
            @foreach($suggestions as $suggestion)
                <li>
                    <a href="{{ url('/search/' . urlencode($suggestion)) }}">{{ $suggestion }}</a>
                </li>
            @endforeach
        </ul>
    @endif
    
    <p><strong>Search tips:</strong></p>
    <ul>
        <li>Check your spelling</li>
        <li>Try different keywords</li>
        <li>Try more general keywords</li>
        @if(isset($active_filters) && count($active_filters) > 0)
            <li>Try removing some filters</li>
        @endif
    </ul>
    
    @if(isset($active_filters) && count($active_filters) > 0)
        <p>
            <a href="{{ url('/search/' . $query) }}" class="btn btn-primary">
                Clear all filters and search again
            </a>
        </p>
    @endif
</div>
