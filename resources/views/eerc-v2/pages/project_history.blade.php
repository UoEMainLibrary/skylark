@extends('layouts.eerc-v2')

@section('title', 'Project History - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Project History</h1>

        <div class="mt-6 prose prose-lg max-w-none">

            <div class="not-prose float-right ml-6 mb-4 hidden w-56 sm:block lg:w-72">
                <img src="{{ asset('collections/eerc/images/v2/project-history-scotland-map.png') }}" alt="Interactive map of Scotland showing interview locations" class="w-full rounded-lg shadow-sm">
            </div>

            <p>The Regional Ethnology of Scotland Archive Project grew out of an earlier initiative, The Regional Ethnology of Scotland Project (RESP), which had been active since 2011. The RESP trained over 250 local volunteer fieldworkers who then went on to make recordings in their own area and with whoever they chose. And the RESP, in turn, was a progression of the work of the EERC (European Ethnological Research Centre, established 1989), which was established and funded by the Scotland Inheritance Fund and had been producing books with a focus on ethnological research.</p>

            <p>Ethnology, in its widest definition the study of culture, is centred on the assertion that personal testimony can enlighten and enrich our understanding of a particular time and place and lead us to a better understanding of our shared cultural lives. And people are at the heart of this discipline, as both practitioners and participants. As the founder of the EERC, Professor Sandy Fenton, asserted:</p>

            <blockquote>
                <p>&ldquo;[Ethnology] is a subject that relates to each and every one of us and there is no one who cannot be a practitioner. It is one in which personal roots, the home and environment within which the researcher is brought up, become part of the research apparatus of national identity.&rdquo;</p>
            </blockquote>

            <p>This quote is at the very heart of the work of the RESP where local partnerships and volunteers have been central to the success of our work: both in terms of how much the Project has been able to achieve, and in the authenticity and relevance of the resulting archive of material.</p>

            <div class="not-prose float-right ml-6 mb-4 hidden w-72 sm:block">
                <img src="{{ asset('collections/eerc/images/v2/alt-montage-crop.jpg') }}" alt="Montage of RESP volunteers and community fieldwork" class="w-full rounded-lg shadow-sm">
            </div>

            <p>To date, around 280 volunteer fieldworkers and 585 volunteer interviewees, who range in age from 8 to 102, have contributed over 1,000 recordings (more than 700 hours of spoken word testimony) as well as many hundreds of images and supporting documents.</p>

            <p>The work of the EERC and the RESP has been entirely funded by the Scotland Inheritance Fund and now, through this website, is preserved and made available on an open access basis under the ongoing care of the Centre for Research Collections at the University of Edinburgh.</p>

            <p>You can <a href="{{ asset('collections/eerc/documents/background-to-the-resp-26-3-26.docx') }}" class="font-medium text-resp-teal-600 hover:underline" download>read more about the EERC, RESP and the Archive Project<span class="sr-only"> (Word document download)</span></a> here.</p>

            <div class="clear-both"></div>
        </div>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-8">
            <img src="{{ asset('collections/eerc/images/v2/uoe-logo.png') }}" alt="The University of Edinburgh" class="h-16 w-auto">
            <div class="rounded-lg bg-[#4a7fa5] px-5 py-4">
                <img src="{{ asset('collections/eerc/images/v2/eerc-logo-white.png') }}" alt="The European Ethnological Research Centre" class="h-14 w-auto">
            </div>
            <img src="{{ asset('collections/eerc/images/v2/resp_circular_logo.png') }}" alt="RESP Archive Project" class="h-16 w-16 shrink-0 rounded-full">
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
