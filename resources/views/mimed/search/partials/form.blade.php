<form class="mimed-search-form" action="{{ route('mimed.search.redirect') }}" method="post" role="search">
    @csrf
    <label for="q">Search the catalogue</label>
    <div class="mimed-search-control">
        <input type="search" name="q" id="q" value="{{ isset($searchbox_query) ? urldecode($searchbox_query) : '' }}" placeholder="e.g. harpsichord">
        <button type="submit" name="submit_search" value="Search">Search <span aria-hidden="true">→</span></button>
    </div>
    <div class="mimed-search-links">
        <a href="{{ route('mimed.search.index', ['query' => '*:*']) }}">Browse all instruments</a>
        <a href="{{ route('mimed.advanced') }}">Advanced search</a>
    </div>
</form>
