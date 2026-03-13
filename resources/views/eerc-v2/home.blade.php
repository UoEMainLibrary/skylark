@extends('layouts.eerc-v2')

@section('title', 'RESP Archive Project')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    {{-- Main content --}}
    <div class="lg:col-span-3 space-y-8">
        {{-- Photo grid --}}
        <div id="photo-grid" class="grid grid-cols-3 gap-1 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 overflow-hidden rounded-lg">
            {{-- Populated by JavaScript --}}
        </div>

        {{-- Introduction --}}
        <div class="prose prose-lg max-w-none">
            <p>The Regional Ethnology of Scotland Archive Project, funded by the Scotland Inheritance Trust, was established in 2017 to catalogue, preserve and share a collection of oral history recordings made by local volunteers under the guidance of the RESP. The Archive Project is dedicated to preserving and sharing the voices of those who have participated in the Study and this website provides an accessible way to engage with the collected interviews. The recordings presented here come primarily from Dumfries &amp; Galloway and East Lothian and the Western Isles, Tayside, Edinburgh, the Scottish Borders, Argyll, and West Lothian.</p>

            <p>By collecting biographical interviews with hundreds of people, their life stories, traditions, and local knowledge have created a living archive that tells us about change and continuity across Scotland, from the Victorian era to the present day. This approach reflects the RESP belief in the value of individual testimony to inform and enrich our understanding of our shared cultural lives.</p>

            <p>Through this website you can explore our entire archive, which extends to hundreds of recordings, find out more about the Project, have a look round our exhibition space and, for our younger audience, have fun learning about oral history and our archive through a series of guided worksheets on our Kids Only page.</p>

            <p>This website strives to make our recordings as accessible as possible and so each interview is available to listen to in full and presented alongside a summary and full transcription. In this way we aim to make our content open and accessible for research, teaching, and community engagement.</p>
        </div>

        {{-- Featured images from the brief --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            <img src="{{ asset('collections/eerc/images/v2/06-EL39_01_FWpage.jpg') }}" alt="Fieldwork in East Lothian" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/11-EL6-3-4-6.jpg') }}" alt="Interview photograph" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/12- DG29-1-4-21_logan ploughing with clydesdales.jpg') }}" alt="Ploughing with Clydesdales" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm hidden sm:block">
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

        var start = Math.floor(Math.random() * (all.length - 18));
        var photos = all.slice(start, start + 18);
        var grid = document.getElementById('photo-grid');

        photos.forEach(function(photo) {
            var link = document.createElement('a');
            link.href = '{{ url('/eerc/record') }}/' + photo.id;
            link.title = photo.title;
            link.className = 'block aspect-square overflow-hidden';

            var img = document.createElement('img');
            img.src = '{{ asset('collections/eerc/images/thumbs_processed') }}/' + photo.url;
            img.alt = photo.title;
            img.className = 'h-full w-full object-cover transition-transform duration-300 hover:scale-110';
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
