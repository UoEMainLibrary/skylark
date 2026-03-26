@extends('layouts.eerc-v2')

@section('title', 'Creative Engagement and Research - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Creative Engagement and Research</h1>

        <div class="mt-6 prose prose-lg max-w-none [&_ul]:marker:text-gray-500">

            <p>The RESP archive contains over 1,000 recordings which touch on every aspect of our shared cultural lives and which can inform and enrich our understanding of life across time and place, from the Victorian era to the present day. The RESP collection can be used in many ways, across both individual and group endeavours, in the community, or to provide research data for academic study. Below we&rsquo;ve provided a few ideas to give you inspiration:</p>

            <h2>Suggestions for research, PhD or dissertation topics</h2>

            <p>The RESP Archive collection can provide ample source material for studies focused on a varied number of subjects as either the sole source of research data or to present alongside your own research material, including:</p>

            {{-- Do not wrap lists in not-prose: Typography strips bullets for the whole subtree. Images only → not-prose. --}}
            <div class="my-6 space-y-6">
                <div class="grid grid-cols-1 gap-x-10 gap-y-4 sm:grid-cols-2">
                    <ul class="mb-0">
                        <li>Childhood and school life</li>
                        <li>Working life</li>
                        <li>The experience of women</li>
                        <li>The changing physical landscape, both rural and urban</li>
                        <li>Changing agricultural life</li>
                        <li>Language and locality</li>
                    </ul>
                    <ul class="mb-0">
                        <li>Sport and Play</li>
                        <li>Housing and transportation</li>
                        <li>Home life</li>
                        <li>Customs and Beliefs</li>
                        <li>The experience of War</li>
                    </ul>
                </div>
                <div class="not-prose grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-6">
                    <div class="flex h-[300px] items-center justify-center">
                        <img src="{{ asset('collections/eerc/images/v2/creative/image1.jpeg') }}" alt="Historical photograph of a woman carrying a basket" class="max-h-full max-w-full rounded-lg object-contain shadow-sm">
                    </div>
                    <div class="flex h-[300px] items-center justify-center">
                        <img src="{{ asset('collections/eerc/images/v2/creative/image2.jpeg') }}" alt="Historical photograph of a group of working men" class="max-h-full max-w-full rounded-lg object-contain shadow-sm">
                    </div>
                </div>
            </div>

            <h2>Creative Output</h2>

            <p>There are many ways in which you can use the RESP resources in your own creative endeavours, for instance you could:</p>

            <ul>
                <li>Write or commission a poem or piece of music or art inspired by RESP interviews and stories.</li>
                <li>Host a Storytelling session with stories and wider conversation inspired by the collections.</li>
                <li>Create a Soundscape. Collaborate with music or sound students to create audio pieces inspired by the descriptions taken from within our recordings.</li>
                <li>Create a mini exhibition highlighting some of the lives and stories documented from within our collections.</li>
            </ul>

            <div class="not-prose my-8 flex justify-center">
                <img src="{{ asset('collections/eerc/images/v2/creative/image4.png') }}" alt="Animal Encounters in the RESP Archive exhibition poster" class="max-w-md rounded-lg shadow-sm">
            </div>

            <h2>Community Based</h2>

            <p>Perhaps you work in the community as a professional or volunteer. There are lots of ways you can use our resources to enhance your community work, such as:</p>

            <div class="my-6 flex flex-col gap-6 sm:flex-row sm:items-start">
                <ul class="mb-0 min-w-0 sm:flex-1">
                    <li>Creating your own shared memories project inspired by the collections.</li>
                    <li>Hosting your own pop-up recording sessions inspired by RESP at your local library or museum.</li>
                    <li>Using the resources on our <a href="{{ url('/eerc/exhibition_gallery') }}">Exhibitions Page</a>, host an event to promote community engagement, perhaps within a care home setting or with a local carers support group.</li>
                    <li>Using the resources in our <a href="{{ url('/eerc/kids_only') }}">Kids Zone</a> when working with children to promote cross-generational work, encourage learning and skills development.</li>
                </ul>
                <div class="not-prose mx-auto shrink-0 sm:mx-0 sm:w-40">
                    <img src="{{ asset('collections/eerc/images/v2/creative/image5.jpeg') }}" alt="Community sporting memories session" class="rounded-lg shadow-sm">
                </div>
            </div>

            <div class="not-prose my-6 flex justify-center">
                <img src="{{ asset('collections/eerc/images/v2/creative/group-sporting-memories.jpg') }}" alt="Haddington Active and Sporting Memories Group" class="mx-auto h-auto max-w-[419px] rounded-lg shadow-sm">
            </div>

            <h2>Schools and Education</h2>

            <p>Perhaps you&rsquo;re a teacher or educator. The RESP Archive collection offers loads of potential to learn more about history in an engaging and innovative way. This can be as simple as listening to interview extracts in class, to something much more ambitious, such as creating an oral history project as part of your lesson plan. Here are a couple of ideas to get you started:</p>

            <ul>
                <li><strong>Schools Resource Pack.</strong> Develop curriculum led material for primary and secondary schools exploring lives and customs in Scotland.</li>
                <li><strong>Organise your own Oral History project</strong> within your class or school. This could be to commemorate a specific event or timeline for your school or organisation.</li>
            </ul>

            <div class="not-prose mt-8 flex justify-center">
                <img src="{{ asset('collections/eerc/images/v2/creative/image7.jpeg') }}" alt="School children participating in RESP activities" class="max-w-[25.2rem] rounded-lg shadow-sm">
            </div>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
