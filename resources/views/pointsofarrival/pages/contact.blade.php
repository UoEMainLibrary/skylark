@extends('layouts.pointsofarrival')

@section('title', 'Contact | Points Of Arrival')

@section('content')
<div class="container-fluid">

    <!-- Include custom sidebar -->
    @include('pointsofarrival.partials.poa_sidebar') 
    <!-- Include custom sidebar -->
    
    <div id="poa-theme">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 byEditor">
            <h1 class="poa-page-title contact-title">Contact Details</h1>
            <p class="theme-info">
                Jewish Lives, Scottish Spaces project team and contact details<br/>
                <a href="jewishmigrationtoscotland.is.ed.ac.uk">jewishmigrationtoscotland.is.ed.ac.uk</a>
                <br/><br/>
            </p>
            <p class="theme-info">
                Dr Hannah Holtschneider (University of Edinburgh)<br/>
                <a href="mailto:h.holtschneider@ed.ac.uk">h.holtschneider@ed.ac.uk</a>
                <br/><br/>
            </p>
            <p class="theme-info">
                Dr Mia Spiro (University of Glasgow)<br/>
                <a href="mailto:mia.spiro@glasgow.ac.uk">mia.spiro@glasgow.ac.uk</a>
                <br/><br/>
            </p>
            <p class="theme-info">
                Dr Phil Alexander (University of Edinburgh)<br/>
                <a href="mailto:phil.alexander@ed.ac.uk">phil.alexander@ed.ac.uk</a>
                <br/><br/>
            </p>
        </div>
    </div>
</div>
@endsection
