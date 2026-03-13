@extends('layouts.eerc-v2')

@section('title', 'Accessibility - RESP Archive')

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Accessibility</h1>

        <div class="mt-6 prose prose-lg max-w-none">
            <p>The RESP Archive Project is committed to making its website accessible to as wide an audience as possible. We strive to comply with current accessibility standards and aim to meet WCAG 2.1 Level AA.</p>

            <h2>What we are doing</h2>
            <ul>
                <li>Using semantic HTML for proper document structure</li>
                <li>Providing alt text for images</li>
                <li>Ensuring keyboard navigation is supported throughout the site</li>
                <li>Maintaining adequate colour contrast ratios</li>
                <li>Providing captions and transcripts for audio content where possible</li>
            </ul>

            <h2>Known issues</h2>
            <p>We are aware that some older content may not fully meet current accessibility standards. We are working to address these issues as resources allow.</p>

            <h2>Feedback</h2>
            <p>If you experience any accessibility barriers while using this website, please <a href="{{ url('/eerc/contact') }}">contact us</a>. We welcome your feedback and will do our best to address any issues promptly.</p>

            <p>For the University of Edinburgh&rsquo;s full accessibility statement, please visit <a href="https://www.ed.ac.uk/about/website/accessibility" target="_blank" rel="noopener">the University accessibility page</a>.</p>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>
@endsection
