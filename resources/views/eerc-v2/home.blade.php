@extends('layouts.eerc-v2')

@section('title', 'Home - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    {{-- Main content --}}
    <div class="lg:col-span-3">
        {{-- Relative to full intro row so top offset is predictable; text column stacked above watermark --}}
        <div class="relative gap-6 sm:grid sm:grid-cols-[280px_1fr] lg:grid-cols-[300px_1fr]">
            {{-- Watermark: 200px below top of this block (below main padding, aligned with start of photo/text row). Centred on text column from sm+. --}}
            <div
                class="pointer-events-none absolute left-1/2 z-0 -translate-x-1/2 overflow-hidden opacity-[0.06] sm:left-[calc(280px+1.5rem+(100%-280px-1.5rem)/2)] lg:left-[calc(300px+1.5rem+(100%-300px-1.5rem)/2)]"
                style="top: 200px;"
                aria-hidden="true">
                <img src="{{ asset('collections/eerc/images/v2/resp_circular_logo.png') }}" alt="" class="w-96 max-w-none">
            </div>

            {{-- Photo montage (left column, masonry) --}}
            <div id="photo-grid" class="relative z-10 hidden columns-2 gap-1 self-start overflow-hidden rounded-lg sm:block">
                {{-- Populated by JavaScript --}}
            </div>

            {{-- Text content (right of photos) --}}
            <div class="relative z-10 min-w-0">
                <div class="prose prose-lg max-w-none">
                    {!! $respHomeBodyHtml !!}
                </div>

                <div class="not-prose mt-8 flex justify-center">
                    <img src="{{ asset('collections/eerc/images/v2/resp_circular_logo.png') }}" alt="EERC / RESP Logo" class="h-40 w-40 shrink-0 rounded-full shadow-sm sm:h-48 sm:w-48">
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        var all = @json(json_decode(file_get_contents(resource_path('data/eerc_photos.json')), true));
        if (!all || !all.length) return;

        var shuffled = all.slice().sort(function() { return 0.5 - Math.random(); });
        var photos = shuffled.slice(0, 16);
        var grid = document.getElementById('photo-grid');
        grid.classList.remove('hidden');

        photos.forEach(function(photo) {
            var link = document.createElement('a');
            link.href = '{{ url('/eerc/record') }}/' + photo.id;
            link.title = photo.title;
            link.className = 'mb-1 block overflow-hidden break-inside-avoid rounded';

            var img = document.createElement('img');
            img.src = '{{ asset('collections/eerc/images/thumbs_processed') }}/' + photo.url;
            img.alt = photo.title;
            img.className = 'w-full transition-transform duration-300 hover:scale-105';
            img.loading = 'lazy';

            link.appendChild(img);
            grid.appendChild(link);
        });
    } catch (e) {
        console.error('Error loading photos:', e);
    }
});
</script>
@endpush
@endsection
