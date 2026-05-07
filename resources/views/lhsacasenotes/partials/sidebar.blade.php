{{-- Subject + Person browse facets, mirroring the legacy CodeIgniter sidebar.
     `subjectFacet` and `personFacet` are injected into every layout render
     by App\View\Composers\LhsacasenotesSidebarComposer. --}}
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav">
        @if(!empty($subjectFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <a href="{{ url('/lhsacasenotes/search/*:*') }}">Subject</a>
                </li>
                @foreach($subjectFacet['terms'] as $term)
                    <li class="list-group-item">
                        <span class="badge">{{ $term['count'] }}</span>
                        <a href='{{ url('/lhsacasenotes/search/*:*/Subject:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if(!empty($personFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <a href="{{ url('/lhsacasenotes/search/*:*') }}">Person</a>
                </li>
                @foreach($personFacet['terms'] as $term)
                    <li class="list-group-item">
                        <span class="badge">{{ $term['count'] }}</span>
                        <a href='{{ url('/lhsacasenotes/search/*:*/Person:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
