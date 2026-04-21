@extends('layouts.eerc-v2')

@section('title', 'Kids Activity Zone - RESP Archive')

@section('content')
<div class="mx-auto max-w-4xl">
    {{-- Header with stars --}}
    <div class="flex items-center justify-center gap-4">
        <img src="{{ asset('collections/eerc/images/stars.gif') }}" alt="" class="hidden w-24 sm:block" aria-hidden="true">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-blue-600">Kids Activity Zone</h1>
        </div>
        <img src="{{ asset('collections/eerc/images/stars.gif') }}" alt="" class="hidden w-24 sm:block" aria-hidden="true">
    </div>

    <p class="mt-4 text-center text-lg text-gray-600">The activity sheets on this page are a great way to learn more about the recordings made by the RESP. There are lots of fun questions to answer and some creative tasks to do. Choose any of the themes below and then click on the PDF link to get started. If you like the worksheets there are some ideas that might help you to explore the archive further and even suggestions for how to carry out your own Oral History Project.</p>

    <p class="mt-6 text-center font-semibold italic text-gray-700">Click on the boxes below to open each worksheet and play the clips alongside when it tells you in the worksheet...</p>

    {{-- Activity cards --}}
    <div class="mt-8 space-y-4">
        @php
            $activities = [
                ['title' => 'Farming', 'color' => 'red', 'bgColor' => 'bg-red-50 border-red-200', 'textColor' => 'text-red-700', 'description' => 'Find out about Irene Brown and her memories of working on a farm.', 'pdf' => 'Farming.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3'],
                ['title' => 'School Dinners', 'color' => 'blue', 'bgColor' => 'bg-blue-50 border-blue-200', 'textColor' => 'text-blue-700', 'description' => "What was Ian's favourite school dinner?", 'pdf' => 'School dinners.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/School%20dinners_EL21-1-1-1.mp3'],
                ['title' => 'Travel and Transport', 'color' => 'green', 'bgColor' => 'bg-green-50 border-green-200', 'textColor' => 'text-green-700', 'description' => 'Listen to Grace talking about meeting the first man to land on the moon.', 'pdf' => 'Travel and Transport.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Travel%20and%20Transport_DG17-1-1-1.mp3'],
                ['title' => 'Sweets', 'color' => 'fuchsia', 'bgColor' => 'bg-fuchsia-50 border-fuchsia-200', 'textColor' => 'text-fuchsia-700', 'description' => 'Listen to Betty and Suzanne Watson chatting about their memories of sweet shops.', 'pdf' => 'Sweets.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Sweets_EL20-2-1-1.mp3'],
                ['title' => 'Toys', 'color' => 'teal', 'bgColor' => 'bg-teal-50 border-teal-200', 'textColor' => 'text-teal-700', 'description' => 'Find out which star wars character came to visit Cyril and Dorothy Wise.', 'pdf' => 'Toys.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Toys_DG14-8-1-1.mp3'],
                ['title' => 'Shopping', 'color' => 'lime', 'bgColor' => 'bg-lime-50 border-lime-200', 'textColor' => 'text-lime-700', 'description' => 'Marion Sunderland talks about shopping. See how much shopping habits have changed.', 'pdf' => 'Shopping.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/shopping_DG4-19-1-1.mp3'],
                ['title' => 'Playground Games', 'color' => 'cyan', 'bgColor' => 'bg-cyan-50 border-cyan-200', 'textColor' => 'text-cyan-700', 'description' => 'Listen to Sophie and Derry, aged 8, talking about their favourite playground games.', 'pdf' => 'Playground Games.pdf', 'audio' => 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Playground%20games_DG31-3-1-1.mp3'],
            ];
        @endphp

        @foreach($activities as $activity)
        <div class="flex flex-col gap-4 rounded-lg border {{ $activity['bgColor'] }} p-4 sm:flex-row sm:items-center">
            <div class="sm:w-1/3">
                <h3 class="text-lg font-bold {{ $activity['textColor'] }}">{{ $activity['title'] }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ $activity['description'] }}</p>
            </div>
            <div class="flex items-center gap-4 sm:w-2/3">
                <a href="{{ asset('collections/eerc/images/kids_only_pdfs/' . $activity['pdf']) }}" target="_blank" rel="noopener" class="inline-flex shrink-0 items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zM10 8a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5A.75.75 0 0110 8z" clip-rule="evenodd"/></svg>
                    Worksheet
                </a>
                <audio controls preload="metadata" class="h-10 w-full" title="{{ $activity['title'] }}">
                    <source src="{{ $activity['audio'] }}">
                    Sorry, your browser doesn't support embedded audio.
                </audio>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Featured interview (4/8 split) --}}
    <div class="mt-10 grid grid-cols-1 gap-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:grid-cols-3">
        <div class="sm:col-span-1">
            <img src="{{ asset('collections/eerc/images/kids_only_1.png') }}" alt="Kalli and Hannah" class="w-full rounded-lg">
        </div>
        <div class="flex flex-col justify-center sm:col-span-2">
            <p class="text-lg text-gray-700">Kalli Hunter and Hannah Green were 8 years old when they were interviewed by Flora Burns in 2014. Click on the link below to hear them telling Flora all about their school day at St Ninian&rsquo;s school in Dumfries.</p>
            <a href="{{ url('/eerc/record/165204/archival_object') }}" class="mt-3 inline-block font-medium text-resp-teal-600 hover:underline">Listen to their interview &rarr;</a>
        </div>
    </div>

    {{-- Bottom stars --}}
    <div class="mt-8 flex items-center justify-between px-8">
        <img src="{{ asset('collections/eerc/images/stars.gif') }}" alt="" class="w-16" aria-hidden="true">
        <img src="{{ asset('collections/eerc/images/stars.gif') }}" alt="" class="w-16" aria-hidden="true">
    </div>
</div>
@endsection
