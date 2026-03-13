@php
    $nodeId = 'node_' . md5($node['record_uri'] ?? $node['title'] ?? rand());
    $title = $node['title'] ?? 'Untitled';
    if (strpos($title, ',') !== false) {
        $title = substr($title, 0, strpos($title, ','));
    }
    $units = explode('/', $node['record_uri'] ?? '');
    $numericId = end($units);
    $componentId = $node['component_id'] ?? '';
    $componentParts = explode('/', $componentId);
    $displayId = (strpos($title, 'Interviews of') !== false && count($componentParts) >= 2)
        ? $componentParts[count($componentParts)-2] . '/' . end($componentParts)
        : end($componentParts);
    $hasChildren = !empty($node['has_children']) && !empty($node['children']);
    $indentClass = match(true) {
        $depth === 0 => 'text-base font-semibold',
        $depth === 1 => 'text-sm',
        default => 'text-sm text-gray-600',
    };
@endphp

<li class="py-1" style="padding-left: {{ $depth * 1.25 }}rem;">
    <div class="flex items-center gap-2 rounded px-2 py-1 hover:bg-gray-50">
        @if($hasChildren)
            <button type="button"
                    onclick="this.querySelector('span').textContent = this.querySelector('span').textContent === '+' ? '−' : '+'; this.closest('li').querySelector('.children-list').classList.toggle('hidden');"
                    class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-500 transition-colors hover:bg-resp-teal-50 hover:border-resp-teal-300 hover:text-resp-teal-600"
                    aria-label="Expand {{ $title }}">
                <span class="text-sm leading-none">+</span>
            </button>
        @else
            <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center">
                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
            </span>
        @endif

        <a href="{{ url('/eerc/record/' . $numericId . '/archival_object') }}"
           class="{{ $indentClass }} text-gray-800 hover:text-resp-teal-600 hover:underline">
            {{ $title }}
            @if($displayId)
                <span class="text-xs text-gray-400">({{ $displayId }})</span>
            @endif
        </a>
    </div>

    @if($hasChildren)
        <ul class="children-list hidden">
            @foreach($node['children'] as $child)
                @include('eerc-v2.partials.tree-node', ['node' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>
