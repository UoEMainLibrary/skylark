<nav aria-label="{{ $navigationLabel }}" class="sch-nav">
    @foreach($navigation->whereNull('navigation_parent_id') as $item)
        @if($item->slug !== 'home')
            @php
                $itemUrl = $item->slug === 'whats-on' ? route('stcecilias.museum.events') : route('stcecilias.museum.page', ['slug' => $item->slug]);
                $children = $navigation->where('navigation_parent_id', $item->id);
            @endphp
            <div class="sch-nav-item">
                <a href="{{ $itemUrl }}" @if($page->slug === $item->slug) aria-current="page" @endif>{{ $item->navigation_label ?: $item->title }}</a>
                @if($children->isNotEmpty())
                    <details class="sch-submenu">
                        <summary aria-label="More in {{ $item->navigation_label ?: $item->title }}"><span aria-hidden="true">⌄</span></summary>
                        <ul>
                            @foreach($children as $child)
                                <li><a href="{{ route('stcecilias.museum.page', ['slug' => $child->slug]) }}" @if($page->slug === $child->slug) aria-current="page" @endif>{{ $child->navigation_label ?: $child->title }}</a></li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </div>
        @endif
    @endforeach
    <a class="sch-explore" href="{{ $collectionSearchUrl }}">Explore the collection ↗</a>
</nav>
