<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav related-items">
        <ul class="list-group">
            <li class="list-group-item active">Related Items</li>

            @if(count($related_items) > 0)
                @foreach($related_items as $doc)
                    <li class="list-group-item">
                        <a class="related-record" href="./record/{{ $doc['id'] }}">
                            {{ $doc[$title_field][0] ?? 'Untitled' }}
                        </a>
                    </li>
                @endforeach
            @else
                <li class="list-group-item">None.</li>
            @endif
        </ul>
    </div>
</div>
