@extends('layouts.eerc')

@section('title', 'Kids Activity Zone - EERC')

@push('styles')
<style>
    .sidebar-nav {
        display: none;
        margin: 0;
        padding: 0;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: none;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    .kids-paragraph {
        font-family: wfont_000751_dde043c9cc214f9bbc15a2e74a9d960b, wf_dde043c9cc214f9bbc15a2e74, orig_montserrat_regular;
        font-size:20px;
        display:inline;
    }
</style>
@endpush

@section('content')
<div class="col-md-12" style="margin-top: 20px;">
    <div style="overflow-x:auto;">
        <br>
        <table>
            <tr>
                <td>
                    <br>
                    <img src="{{ asset('collections/eerc/images/stars.gif') }}" style="width: 90%">
                </td>
                <td>
                    <h1 class="itemtitle" style="text-align: center; font-family:'Comic Sans MS';font-size:3em;color:#0066FF;background-color:#CCFFFF;padding:em;">Kids Activity Zone</h1>
                    <br>
                    <p class="kids-paragraph">
                        The activity sheets on this page are a great way to learn more about the recordings made by the RESP.
                        There are lots of fun questions to answer and some creative tasks to do. Chose any of the themes below
                        and then click on the PDF link to get started. If you like the worksheets there are some ideas
                        that might help you to explore the archive further and even suggestions for how to carry out your
                        own Oral History Project.
                    </p>
                </td>
                <td>
                    <br>
                    <img src="{{ asset('collections/eerc/images/stars.gif') }}" style="width: 90%">
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <p class="kids-paragraph">
            <strong><em style="font-size: 20px">Click on the boxes below to open each worksheet and play the clips alongside when it tells you in the worksheet...</em></strong>
        </p>
        <br/>
        <br/>
        <table>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: red; font-weight: bold;">FARMING</p> <p class="kids-paragraph">Find out about Irene Brown and her memories of working on a farm.</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Farming.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Farming compilation">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: blue; font-weight: bold;">SCHOOL DINNERS</p> <p class="kids-paragraph"> What was Ian's favourite school dinner?</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/School dinners.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="School dinners">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/School%20dinners_EL21-1-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: green; font-weight: bold;">TRAVEL AND TRANSPORT</p> <p class="kids-paragraph"> Listen to Grace talking about meeting the first man to land on the moon.</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Travel and Transport.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Travel and Transport">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Travel%20and%20Transport_DG17-1-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: #de00d7; font-weight: bold;">SWEETS</p> <p class="kids-paragraph"> Listen to Betty and Suzanne Watson chatting about their memories of sweet shops. </p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Sweets.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Sweets">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Sweets_EL20-2-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: #079692; font-weight: bold;">TOYS</p> <p class="kids-paragraph"> Find out which star wars character came to visit Cyril and Dorothy Wise.</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Toys.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Toys">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Toys_DG14-8-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: #758c0f; font-weight: bold;">SHOPPING</p> <p class="kids-paragraph">Marion Sunderland talks about shopping.See how much shopping habits have changed.</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Shopping.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Shopping">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/shopping_DG4-19-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle"><p class="kids-paragraph" style="color: #00678d; font-weight: bold;">PLAYGROUND GAMES</p> <p class="kids-paragraph">Listen to Sophie and Derry, aged 8, talking about their favourite playground games.</p></td>
                <td style="vertical-align: middle">
                    <a href="{{ asset('collections/eerc/images/kids_only_pdfs/Playground Games.pdf') }}" target="_blank">
                        <img src="{{ asset('collections/eerc/images/pdf_icon.png') }}" style="width: 60px">
                    </a>
                </td>
                <td style="vertical-align: middle">
                    <audio controls width="300" preload="metadata" title="Playground games">
                        <source src="{{ \App\Helpers\BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/Playground%20games_DG31-3-1-1.mp3') }}">
                        Sorry, your browser doesn't support embedded audio.
                    </audio>
                </td>
            </tr>
        </table>

        <br>
        <br>
        <table>
            <tr>
                <td>
                    <img src="{{ asset('collections/eerc/images/kids_only_1.png') }}" style="width: 90%">
                </td>
                <td style="vertical-align: middle">
                    <p class="kids-paragraph" style="vertical-align: middle">
                        Kalli Hunter and Hannah Green were 8 years old when they were interviewed by Flora Burns in 2014. Click on the link below to hear them telling Flora all about
                        their school day at St Ninians's school in Dumfries. <br>
                        <br>
                        <a href='{{ url('/eerc/record/165204/archival_object') }}' style='font-size:20px'>{{ url('/eerc/record/165204/archival_object') }}</a><br>
                    </p>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td><img src="{{ asset('collections/eerc/images/stars.gif') }}" style="width: 23%"></td>
                <td style="text-align: right"><img src="{{ asset('collections/eerc/images/stars.gif') }}" style="width: 23%"></td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
</div>
@endsection
