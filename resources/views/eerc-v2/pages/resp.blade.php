@extends('layouts.eerc-v2')

@section('title', 'About the Project - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">About the Project</h1>

        <div class="mt-6 prose prose-lg max-w-none">

            {{-- Interviewee portrait floated right beside opening paragraph --}}
            <div class="not-prose float-right ml-6 mb-4 hidden w-48 sm:block">
                <img src="{{ asset('collections/eerc/images/v2/DG38-5-4-1.jpg') }}" alt="RESP interviewee at home" class="rounded-lg shadow-sm">
            </div>

            <p>The RESP Archive Project was established in 2018 in collaboration with the Centre for Research Collections at the University of Edinburgh. Originally conceived as a cataloguing project to ensure the ongoing digital security of this collection and improve the discoverability of the audio recordings created by the RESP the remit was soon expanded to include the creation of this website.</p>

            <p>A central ethos of the RESP was to make the recordings fully accessible and freely available, both now and for future generations, whether for research, as a teaching resource or wider community use — particularly within the communities where the recordings were made. This website aims to fulfil this remit by ensuring full access to the audio recordings, photographs, and transcripts for each interviewee, presented on dedicated interviewee pages. Additional pages have been included to enhance engagement and include: an Exhibition Gallery, which showcases creative outputs from the Project; a Kids Only page of resources designed to encourage children to learn more about oral history; and an interactive map to help with place-based research.</p>

            <div class="clear-both"></div>

            <p>Over the course of the Project, the RESP has gathered fieldwork from Dumfries &amp; Galloway and East Lothian and, to a smaller extent, the Western Isles, Tayside, Edinburgh, the Scottish Borders, Argyll and West Lothian. The Collection covers all aspects of our cultural lives: from birth customs to working practices, foodways to transport, landscape to law &amp; order, shops to gardens and fashion to schooldays. Including the donated recordings, the timespan when the recordings were made covers over 50 years, from the 1970s to the 2020s, and with Interviewees ranging in age from 7 to 102, the first-person accounts shared here take us from the present day back to the Victorian era, in over 1,000 recordings and more than 700 hours of audio.</p>

            <div class="clear-both"></div>

            {{-- Man in garden, floated right --}}
            <div class="not-prose float-right ml-6 mb-4 hidden w-56 sm:block">
                <img src="{{ asset('collections/eerc/images/v2/EL39-2-4-1.jpg') }}" alt="RESP interviewee in his garden" class="rounded-lg shadow-sm">
            </div>

            <p>The result is a Collection which is broad in timespan, geography and subject matter and offers enormous potential for dedicated and comparative research either within the Collection itself, or in providing comparative material for studies more broadly.</p>

            <div class="clear-both"></div>
        </div>

        <div class="mt-8 mx-auto w-[75%] max-w-full">
            <img src="{{ asset('collections/eerc/images/v2/montage.jpg') }}" alt="Montage of RESP interviewees and community events" class="h-auto w-full rounded-lg shadow-sm">
        </div>

        {{-- Team card --}}
        <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Project Team</h2>
            <ul class="mt-3 space-y-2 text-gray-700">
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-resp-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                    <span><strong>Lesley Bryson</strong>, RESP Project Archivist</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-resp-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                    <span><strong>Caroline Milligan</strong>, RESP Archives Assistant and Research Officer</span>
                </li>
            </ul>
        </div>

        {{-- Note about fieldwork --}}
        <div class="mt-6 rounded-lg border-l-4 border-resp-teal-400 bg-resp-teal-50 p-4">
            <p class="text-sm text-resp-teal-800">Our focus now is on using our available resources to process our recordings so that the entire collection can be available on the website. For this reason, we are not involved in any active fieldwork at this time.</p>
        </div>

        {{-- Contact & management footer --}}
        <div class="mt-8 rounded-lg bg-gray-100 p-6 text-sm text-gray-600">
            <p>The RESP Archive is managed and maintained as a University of Edinburgh Collection.</p>
            <p class="mt-2">Enquiries regarding the RESP Archive should be directed in the first instance to: <a href="mailto:HeritageCollections@ed.ac.uk" class="font-medium text-resp-teal-600 hover:underline">HeritageCollections@ed.ac.uk</a> — Please address your enquiry to &lsquo;RESP Archive&rsquo;.</p>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-3">
            <img src="{{ asset('collections/eerc/images/v2/DG42-3-4-1.jpg') }}" alt="RESP interviewee" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/DG11-2-4-5.jpg') }}" alt="Volunteers reviewing archive photographs and documents" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/EL40-7-4-1.jpg') }}" alt="Interviewee at a community event" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
