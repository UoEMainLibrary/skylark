@extends('layouts.alumni')

@section('title', 'University of Edinburgh Historical Alumni')

@section('content')
<div class="col-main">
 <div class="record">
    <div class="content byEditor">
        <h1>University of Edinburgh: Historical Alumni Collection</h1>
        <p>Our records of students date back to the very first class which graduated in 1587.  However they do not cover every student who ever attended the University.  Because formal matriculation and graduation did not become mandatory until the nineteenth century, many do not appear in the records.</p>

        <p>This resource is drawn from earlier databases of students and is not yet a comprehensive list of all students in our records.  For details of coverage and sources from which this has been drawn, please use the link below.</p>

        <h2>Specific datasets</h2>
        <h3>University of Edinburgh</h3>
        <ul>
            <li>
                <a href="{{ url('alumni/rosner') }}">Students of Medicine, 1762-1826</a>
            </li>
            <li>
                <a href="{{ url('alumni/medsample') }}">Students of Medicine (sample of 205), 1833-1846</a>
            </li>
            <li>
                <a href="{{ url('alumni/extraac') }}">Extra Academical students, 1887-1922</a>
            </li>
            <li>
                <a href="{{ url('alumni/firstmat') }}">First Matriculations, 1890-1899</a>
            </li>
            <li>
                <a href="{{ url('alumni/women') }}">Awards to Women students, 1876-1894</a>
            </li>
            <li>
                <a href="{{ url('alumni/femalegrad') }}">Female Medical Graduates, 1896-1900</a>
            </li>
            <li>
                <a href="http://archives.lib.ed.ac.uk/alumni/ld.php" target = "_blank">Browse the full first Laureation &amp; Degrees Album (1587-1809) by year</a>
            </li>
        </ul>

        <h3>Royal Dick Veterinary College</h3>
        <ul>
            <li>
                <a href="{{ url('alumni//earlyvet') }}">Early Veterinary Graduates, 1825-1865</a>
            </li>
            <li>
                <a href="{{ url('alumni//vetgrad') }}">Graduates in Veterinary Medicine, 1911-1955</a>
            </li>
        </ul>

        <h3>New College</h3>
        <ul>
            <li>
                <a href="{{ url('alumni//newcoll') }}">Students at New College, 1843-1943</a>
            </li>
        </ul>

        <h3>Other</h3>
        <ul>
            <li>
                <a href="{{ url('alumni//ww1roll') }}">University of Edinburgh: Roll of Honour, WW1</a>
            </li>
        </ul><!--
        <h3>Coming Soon</h3>
        <ul>
            <li>
               University of Edinburgh: Roll of Honour, WW2
            </li>
        </ul>
-->
        <h3>Data held elsewhere</h3>
        <ul>
            <li>
                <a href="https://www.uega.co.uk/archive" target="_blank">University of Edinburgh: Roll of Honour, WW2 (opens in a new tab)</a>
            </li>
            <li><a href="http://www.scripts.sasg.ed.ac.uk/registry/Graduations/Honorary_Graduates.cfm" target="_blank">Honorary Graduates (opens in a new tab)</a></li>
        </ul>

        <div class="clearfix"></div>

    </div>
</div>
</div>

<div class="col-sidebar">
{{--<pre>{{ var_export($facets, true) }}</pre>--}}
    @include('alumni.search.partials.facets')
</div>
@endsection
