@extends('layouts.jlss')

@section('title', 'Feedback - Jewish Lives Scottish Spaces')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">

    <div class="content byEditor">

        <div class="feedback_form">

            <div id="about-image">
                <img src="{{ asset('collections/jlss/images/sjac-temp.jpg') }}" alt="Garnethill Synagogue" class="img-responsive">
            </div>
            <br>
            <br>

            <h1>Feedback</h1>
            <div class="content-divider-inline"><p>divider</p></div>
            <div class="about-para">
                <p>Please contact us with your suggestions or questions at <a href="http://jewishmigrationtoscotland.is.ed.ac.uk/index.php/project-team/"
                    alt="link to JLSS team contact details" title="Click to view the JLSS team contact details on their own website">Jewish Lives, Scottish Spaces</a>.</p>
            </div>

            <p>
                Alternatively if you have any questions about SJAC, please contact: <a href="mailto:info@sjac.org.uk" alt="email link to contact SJAC" title="Click to contact SJAC via email">info@sjac.org.uk</a>
                or visit their <a href="https://www.sjac.org.uk/" alt="link to SJAC website" title="Click to visit SJAC website">website.</a>
            </p>
        </div>
    </div>
</div>
@endsection
