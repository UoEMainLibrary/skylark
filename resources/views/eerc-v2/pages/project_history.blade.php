@extends('layouts.eerc-v2')

@section('title', 'Project History - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Project History</h1>

        <div class="mt-6 prose prose-lg max-w-none">
            <p>The Regional Ethnology of Scotland Archive Project grew out of an earlier initiative, The Regional Ethnology of Scotland Project (RESP), which has been active since 2011. And the RESP, in turn, was a progression of the work of the EERC (European Ethnological Research Centre, established [DATE TBC]), which was established and funded by the Scotland Inheritance Fund and had been producing books with a focus on ethnological research since [DATE TBC].</p>

            <p>Ethnology, in its widest definition the study of culture, is centred on the assertion that personal testimony can enlighten and enrich our understanding of a particular time and place and lead us to a better understanding of our shared cultural lives. And people are at the heart of this discipline, as both practitioners and participants. As the founder of the EERC, Professor Sandy Fenton, asserted:</p>

            <blockquote>
                <p>&ldquo;[Ethnology] is a subject that relates to each and every one of us and there is no one who cannot be a practitioner. It is one in which personal roots, the home and environment within which the researcher is brought up, become part of the research apparatus of national identity.&rdquo;</p>
            </blockquote>

            <p>This quote is at the very heart of the work of both the RESP and RESP Archive Project where local partnerships and volunteers have been central to the success of our work: both in terms of how much the Project has been able to achieve and, in the authenticity, and relevance of the resulting archive of material.</p>

            <p>To date, around 280 volunteer fieldworkers and 585 volunteer interviewees, who range in age from 8 to 102, have contributed over 1,000 recordings (more than 700 hours of spoken word testimony) as well as many hundreds of images and supporting documents.</p>

            <p>The work of the EERC, RESP and the RESP Archive Project has been entirely funded by the Scotland Inheritance Fund and now, through this website, is preserved and made available on an open access basis under the ongoing care of the Centre for Research Collections at the University of Edinburgh.</p>

            <p>You can read more about the EERC, RESP and the RESP Archive Project here [LINK TO DOCUMENT — URL TBC]</p>
        </div>

        {{-- Photo gallery --}}
        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
            <img src="{{ asset('collections/eerc/images/v2/09-EL40-7-4-2.jpg') }}" alt="Interview photograph" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/13 -ES5-1-4-5.JPG') }}" alt="Archive photograph" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm">
            <img src="{{ asset('collections/eerc/images/v2/08-EL40-6-4-2.jpg') }}" alt="Community engagement" class="aspect-4/3 w-full rounded-lg object-cover shadow-sm hidden sm:block">
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
