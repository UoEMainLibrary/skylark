@extends('layouts.stcecilias')

@section('title', "Feedback — St Cecilia's Hall")

@section('body_class', 'feedback')

@section('content')
    @php
        $emailAddress = config('skylight.adminemail', 'HeritageCollections@ed.ac.uk');
    @endphp

    <div class="container-fluid">
        <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2"></div>

        <div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
            <div class="feedback_form">
                <h2>Feedback</h2>

                <p>Please contact us with your suggestions or questions at <a href="mailto:{{ $emailAddress }}">{{ $emailAddress }}</a>. You can also send us a request to consult the records from which these data sets are drawn or to order copies for your own use.</p>

                <h3>Privacy Statement</h3>
                <p>Information about you: how we use it and with whom we share it.</p>
                <p>The information you provide in this form will be used only for purposes of your enquiry. We will not share your personal information with any third party or use it for any other purpose. We are using information about you because it is necessary to contact you regarding your enquiry. By providing your personal data when submitting an enquiry to us, consent for your personal data to be used in this way is implied.</p>
                <p>For digitisation orders, your personal data is necessary for the performance of our contract to provide you with services that charge a fee.</p>
                <p>We will hold the personal data you provided us for 6 years. We do not use profiling or automated decision-making processes.</p>
                <p>If you have any questions, please contact: <a href="mailto:{{ $emailAddress }}">{{ $emailAddress }}</a></p>
                <p><a href="https://www.ed.ac.uk/records-management/notice" target="_blank" rel="noopener">University privacy statement (opens in a new tab)</a></p>
            </div>
        </div>

        <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2"></div>
    </div>
@endsection
