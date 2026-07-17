@extends('layouts.bodylanguage')

@section('title', 'Feedback - Body Language')

@section('content')
<div class="feedback_form">
    <h1>Feedback</h1>
    <p>Please contact us with your suggestions or questions at <a class="para-link" href="mailto:{{ config('skylight.adminemail') }}">{{ config('skylight.adminemail') }}</a>.</p>

    <h3>Privacy Statement</h3>
    <p>Information about you: how we use it and with whom we share it.</p>
    <p>
        The information you provide will only be used for purposes of your enquiry. We will not share your personal information
        with third parties or use it for any other purpose.
    </p>
    <p>
        If you have any questions, please contact
        <a class="para-link" href="mailto:{{ config('skylight.adminemail') }}">{{ config('skylight.adminemail') }}</a>.
    </p>
    <p>
        <a class="para-link" href="https://www.ed.ac.uk/about/website/privacy" target="_blank" rel="noopener">University of Edinburgh privacy statement</a>
    </p>
</div>
@endsection
