@extends('layouts.eerc-v2')

@section('title', 'Contact - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Contact</h1>

        <div class="mt-6 prose prose-lg max-w-none">
            <p>Enquiries regarding the RESP Archive should be directed in the first instance to: <a href="mailto:HeritageCollections@ed.ac.uk">HeritageCollections@ed.ac.uk</a>. Please address your enquiry to &lsquo;<em>RESP Archive</em>&rsquo;.</p>
        </div>

        <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Privacy Statement</h2>
            <div class="mt-4 space-y-3 text-sm text-gray-600">
                <p><strong>Information about you: how we use it and with whom we share it.</strong></p>
                <p>The information you provide will be used only for purposes of your enquiry. We will not share your personal information with any third party or use it for any other purpose. We are using information about you because it is necessary to contact you regarding your enquiry. By providing your personal data when submitting an enquiry to us, consent for your personal data to be used in this way is implied.</p>
                <p>We will hold the personal data you provided us for 6 years. We do not use profiling or automated decision-making processes.</p>
                <p>Our takedown statement can be viewed on the &lsquo;<a href="{{ url('/eerc/using') }}" class="text-resp-teal-600 hover:underline">Searching and Using the Collection</a>&rsquo; page.</p>
            </div>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
