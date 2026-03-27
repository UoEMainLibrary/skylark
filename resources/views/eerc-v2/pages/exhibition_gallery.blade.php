@extends('layouts.eerc-v2')

@section('title', 'Exhibition Gallery - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3 space-y-10">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Exhibition Gallery</h1>

        {{-- Thumbnail navigation: flex + wrap + justify-center → row1 [X][X][X], row2 centred [X][X] with same tile width (gap-4 = 1rem) --}}
        <div class="mt-6 flex w-full flex-wrap justify-center gap-4">
            <a href="#animal-encounters" class="group mx-auto block w-full min-w-0 max-w-md overflow-hidden rounded-lg shadow-sm sm:mx-0 sm:w-[calc((100%-2rem)/3)] sm:max-w-none">
                <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('collections/eerc/images/animal_encounters_resp.png') }}" alt="Animal Encounters" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <p class="px-3 py-2 text-sm font-medium text-gray-700 group-hover:text-resp-teal-600">Animal Encounters</p>
            </a>
            <a href="#musselburgh-mills" class="group mx-auto block w-full min-w-0 max-w-md overflow-hidden rounded-lg shadow-sm sm:mx-0 sm:w-[calc((100%-2rem)/3)] sm:max-w-none">
                <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('collections/eerc/images/MILLS-revised-720.png') }}" alt="Musselburgh Mills" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <p class="px-3 py-2 text-sm font-medium text-gray-700 group-hover:text-resp-teal-600">&ldquo;A right industrial wee town!&rdquo;</p>
            </a>
            <a href="#haddington-voices" class="group mx-auto block w-full min-w-0 max-w-md overflow-hidden rounded-lg shadow-sm sm:mx-0 sm:w-[calc((100%-2rem)/3)] sm:max-w-none">
                <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('collections/eerc/images/v2/exhibition-haddington-voices-thumb.jpg') }}" alt="Haddington Voices" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <p class="px-3 py-2 text-sm font-medium text-gray-700 group-hover:text-resp-teal-600">Haddington Voices</p>
            </a>
            <a href="#charlie-horne" class="group mx-auto block w-full min-w-0 max-w-md overflow-hidden rounded-lg shadow-sm sm:mx-0 sm:w-[calc((100%-2rem)/3)] sm:max-w-none">
                <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('collections/eerc/images/v2/exhibition-charlie-horne-thumb.jpg') }}" alt="Charlie Horne" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <p class="px-3 py-2 text-sm font-medium text-gray-700 group-hover:text-resp-teal-600">Charlie Horne</p>
            </a>
            <a href="#days-work" class="group mx-auto block w-full min-w-0 max-w-md overflow-hidden rounded-lg shadow-sm sm:mx-0 sm:w-[calc((100%-2rem)/3)] sm:max-w-none">
                <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('collections/eerc/images/v2/am-cover.jpg') }}" alt="All in a Day's Work cover" class="h-full w-full object-cover object-top transition-transform duration-300 group-hover:scale-105">
                </div>
                <p class="px-3 py-2 text-sm font-medium text-gray-700 group-hover:text-resp-teal-600">All in A Day&rsquo;s Work</p>
            </a>
        </div>

        {{-- Animal Encounters --}}
        <article id="animal-encounters" class="scroll-mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900">&ldquo;Animal Encounters in the RESP Archive&rdquo;</h2>
                <p class="mt-1 text-sm text-gray-500">Exploring animal-human relationships across the Regional Ethnology of Scotland Project</p>
                <div class="mt-4">
                    <img src="{{ asset('collections/eerc/images/animal_encounters_resp.png') }}" alt="Animal Encounters exhibition" class="w-full rounded-md">
                </div>
                <p class="mt-4 text-gray-700">To explore RESP's online exhibition <em>Animal Encounters in the RESP Archive</em> please click on the link below. The exhibition, curated and illustrated by Rebekah Day, reveals the varied and complex relationships that can exist between people and animals. Through carefully selected audio recordings, images, and videos the exhibition highlights how connections between humans and animals have shifted in recent decades: reflecting wider culture and environmental concerns present in Scottish society today.</p>
                <a href="https://exhibitions.ed.ac.uk/exhibitions/animal-encounters" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-resp-teal-600 hover:underline">
                    Visit the exhibition
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                </a>
            </div>
        </article>

        {{-- Musselburgh Mills --}}
        <article id="musselburgh-mills" class="scroll-mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900">&ldquo;This was a right industrial wee town!&rdquo;</h2>
                <p class="mt-1 text-sm text-gray-500">A film about life and work in the Musselburgh Mills</p>
                <div class="mt-4 text-gray-700 space-y-3">
                    <p>The 'Honest Toun' is a place that, to some extent, sits on its own. Part of Midlothian until its governance transferred to East Lothian in 1975. The size of Musselburgh's population and the scale and range of its economy has, for long, reflected its historic status as a burgh. Industry having been a key aspect of that large and diverse economy. Beginning in the nineteenth century through to the late twentieth century, three large industrial endeavours were based in the town: Stuarts Net Mill; Bruntons Wire Mill and Inveresk Paper Mill.</p>
                    <p>This film tells the story of these mills through the words of those who worked and lived in the town and beyond. In partnership with the John Gray Centre and Musselburgh Museum, the EERC interviewed a number of folk about their experiences in the mills. This film provides an introduction into these very different workplaces which were such a significant part of the Town's life for well over 100 years.</p>
                </div>
                <div class="mt-4">
                    <video controls width="100%" preload="auto" title="MILLS-revised" poster="{{ asset('collections/eerc/images/MILLS-revised-720.png') }}" class="rounded-md">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/56448/MILLS-revised-720.mp4') }}">
                        Sorry, your browser doesn't support embedded videos.
                    </video>
                </div>
                <p class="mt-3 text-sm text-gray-500">Editor: Colin Gateley &middot; Music by: Enid Forsyth &middot; Moving images: Courtesy of Moving Image Archive, National Library of Scotland</p>
            </div>
        </article>

        {{-- Haddington Voices (new) --}}
        <article id="haddington-voices" class="scroll-mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="p-6">
                <span class="inline-flex items-center rounded-full bg-resp-teal-100 px-3 py-0.5 text-xs font-medium text-resp-teal-800">New</span>
                <h2 class="mt-2 text-xl font-bold text-gray-900">Haddington Voices (2024)</h2>
                <p class="mt-1 text-sm text-gray-500">Film &middot; 57 minutes</p>
                <p class="mt-4 text-gray-700">Drawing on material collected as part of the RESP East Lothian study; in a series of themed segments covering work, leisure, wartime and the townscape, this film explores different aspects of life in Haddington through the voices of some of the interviewees.</p>
                <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                    Video embed will be added when the film file is provided.
                </div>
                <p class="mt-3 text-sm text-gray-500">Created by Colin Gateley and Mark Mulhern. Images from John Gray Centre, East Lothian Council. Music by Edith Forsyth.</p>
            </div>
        </article>

        {{-- Charlie Horne (new) --}}
        <article id="charlie-horne" class="scroll-mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="p-6">
                <span class="inline-flex items-center rounded-full bg-resp-teal-100 px-3 py-0.5 text-xs font-medium text-resp-teal-800">New</span>
                <h2 class="mt-2 text-xl font-bold text-gray-900">Charlie Horne: The Past is Still With Us (2019)</h2>
                <p class="mt-1 text-sm text-gray-500">Film &middot; 19 minutes</p>
                <p class="mt-4 text-gray-700">This short film explores the life of Charlie Horne — fisherman, D-Day veteran, dancer and centenarian — through the recordings he made with volunteer RESP fieldworker, Martine Robertson.</p>
                <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                    Video embed will be added when the film file is provided.
                </div>
                <p class="mt-3 text-sm text-gray-500">Film created by Martine Robertson and Colin Gateley. Music by Edith Forsyth.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ url('/eerc/record/190109/archival_object') }}" class="inline-flex items-center gap-1 text-sm font-medium text-resp-teal-600 hover:underline">
                        View interviewee page &rarr;
                    </a>
                    <a href="https://www.johngraycentre.org/about/archaeology/archaeology-events/east-lothian-archaeology-heritage-fortnight/archaeology-fortnight-2025-events/golden-days-the-life-of-charlie-horne/" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm font-medium text-resp-teal-600 hover:underline">
                        John Gray Centre event page
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                </div>
            </div>
        </article>

        {{-- All in a Day's Work (new) --}}
        <article id="days-work" class="scroll-mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="p-6">
                <span class="inline-flex items-center rounded-full bg-resp-teal-100 px-3 py-0.5 text-xs font-medium text-resp-teal-800">New</span>
                <h2 class="mt-2 text-xl font-bold text-gray-900">All in A Day&rsquo;s Work: Recollections from Haddington Active &amp; Sporting Memories Group (2025)</h2>
                <p class="mt-1 text-sm text-gray-500">Publication &middot; Katie Shepherd and Ailsa Dixon</p>
                <p class="mt-4 text-gray-700">In 2025 two RESP student interns interviewed members of the Haddington Active &amp; Sporting Memories group which meets at the John Gray Centre in Haddington. Facilitated by group leaders Graham Cross and Ruth Fyfe, the students worked on this publication over a number of months.</p>
                <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                    PDF download will be available when the digital copy is provided.
                </div>
            </div>
        </article>

    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var baseTitle = 'Exhibition Gallery - RESP Archive';
    var charlieTitle = 'Charlie Horne: The Past is Still With Us – Exhibition Gallery - RESP Archive';

    function syncTitleFromHash() {
        document.title = window.location.hash === '#charlie-horne' ? charlieTitle : baseTitle;
    }

    document.addEventListener('DOMContentLoaded', syncTitleFromHash);
    window.addEventListener('hashchange', syncTitleFromHash);
})();
</script>
@endpush
