@extends('layouts.iog')

@section('title', 'Scottish Government Yearbooks')

@section('content')
<div class="content">
    <div class="content byEditor">
        @php
            $subjects = [
                ['label' => 'Gender', 'image' => '0012110c.jpg', 'value' => 'gender'],
                ['label' => 'Media', 'image' => '1037285312_ec5c88a059_z.jpg', 'value' => 'media'],
                ['label' => 'Health', 'image' => '0041847c.jpg', 'value' => 'health service'],
                ['label' => 'Devolution', 'image' => '2504698578_1d17ed6e41_z.jpg', 'value' => 'devolution'],
                ['label' => 'Islands', 'image' => '0028004c.jpg', 'value' => 'islands'],
                ['label' => 'Local Government', 'image' => 'ol00044.jpg', 'value' => 'local government'],
                ['label' => 'Religion', 'image' => '0002488c.jpg', 'value' => 'religion'],
                ['label' => 'Elections', 'image' => '3598534263_aaba5a75c0_z.jpg', 'value' => 'elections'],
                ['label' => 'Scottish Office', 'image' => '4917919154_74e84a09a1_z.jpg', 'value' => 'scottish office'],
            ];
        @endphp

        <p><h6>Welcome to the digital archive of the Scottish Government Yearbooks, published by the University of Edinburgh's
            'Unit for the Study of Government in Scotland' between 1976 and 1992.</h6></p>

        <div class="jgrid-wrapper">
            <div class="jgrid">
                @foreach($subjects as $subject)
                    @php
                        $lower = urlencode($subject['value']);
                        $orig = urlencode($subject['label']);
                        $href = $collectionUrl('search/*:*/Subject:%22'.$lower.'+%7C%7C%7C+'.$orig.'%22');
                    @endphp
                    <a href="{{ $href }}">
                        <img alt="{{ $subject['label'] }}" title="{{ $subject['label'] }}" src="{{ asset('collections/iog/images/carousel/'.$subject['image']) }}">
                        <div class="carousel-caption caption-iog">
                            {{ $subject['label'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <p><h6>This archive was constructed by the Unit's successor, the Institute of Governance. Please feel
            free to browse using the links above, or by using the search function.</h6></p>
        <p>
            <h6>
            The Scottish Government Yearbook was succeeded in 1992 by the quarterly journal <a href="http://www.euppublishing.com/loi/scot" target="_blank" rel="noopener noreferrer" title="Scottish Affairs">Scottish Affairs<span class="visually-hidden"> (opens in a new tab)</span></a>.
            It has continued the same editorial principles as the Yearbook, and maintained the same commitment to providing
            a forum for well-informed public discussion. Further information on the development of the Yearbook and Scottish Affairs
            is available <a href="{{ $collectionUrl('history') }}">here</a>.
            </h6>
        </p>
    </div>
</div>
@endsection
