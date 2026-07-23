@php
    $siteTitle = config('skylight.fullname', 'Special Collections');
@endphp
<footer class="footer bg-primary">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs">
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="centered text-center">
                <ul class="nav nav-pills">
                    <li><a href="{{ url('/speccoll') }}" title="{{ $siteTitle }} Home"><i class="fa fa-home fa-lg" aria-hidden="true">&nbsp;</i><span class="sr-only">{{ $siteTitle }} Home</span></a></li>
                    <li><a href="{{ url('/speccoll/about') }}" title="About {{ $siteTitle }}"><i class="fa fa-info fa-lg" aria-hidden="true">&nbsp;</i><span class="sr-only">About {{ $siteTitle }}</span></a></li>
                    <li><a href="https://www.facebook.com/crc.edinburgh" target="_blank" rel="noopener noreferrer" title="CRC on Facebook"><i class="fa fa-facebook fa-lg" aria-hidden="true">&nbsp;</i><span class="sr-only">CRC on Facebook (opens in a new tab)</span></a></li>
                    <li><a href="https://twitter.com/CRC_EdUni" target="_blank" rel="noopener noreferrer" title="CRC on Twitter"><i class="fa fa-twitter fa-lg" aria-hidden="true">&nbsp;</i><span class="sr-only">CRC on Twitter (opens in a new tab)</span></a></li>
                    <li><a href="{{ url('/speccoll/feedback') }}" title="Provide feedback"><i class="fa fa-envelope fa-lg" aria-hidden="true">&nbsp;</i><span class="sr-only">Provide feedback</span></a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-3 hidden-sm hidden-xs">
            <a class="navbar-brand navbar-left" href="https://www.ed.ac.uk" title="The University of Edinburgh Homepage Link" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('collections/speccoll/images/UoETransparentWhite.png') }}" class="img-responsive uoe_logo" alt="University of Edinburgh link" />
                <span class="sr-only"> (opens in a new tab)</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 hidden-xs hidden-lg hidden-md">
            <ul>
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener noreferrer">Privacy &amp; Cookies</a></li>
                <li><a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener noreferrer" title="Takedown Policy Link">Takedown Policy</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 hidden-xs hidden-lg hidden-md ">
            <ul>
                <li><a href="{{ url('/speccoll/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener noreferrer">Accessibility</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 hidden-lg hidden-md hidden-sm">
            <ul class="small">
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener noreferrer">Privacy &amp; Cookies</a></li>
                <li><a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener noreferrer" title="Takedown Policy Link">Takedown Policy</a></li>
            </ul>
        </div>
        <div class="col-xs-6 hidden-lg hidden-md hidden-sm">
            <ul class="small">
                <li><a href="{{ url('/speccoll/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener noreferrer">Accessibility</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="centered text-center hidden-sm hidden-xs">
            <ul class="list-inline">
                <li><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener noreferrer">Privacy &amp; Cookies</a></li>
                <li><a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener noreferrer" title="Takedown Policy Link">Takedown Policy</a></li>
                <li><a href="{{ url('/speccoll/licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a></li>
                <li><a href="https://www.ed.ac.uk/about/website/accessibility" title="Website Accessibility Link" target="_blank" rel="noopener noreferrer">Accessibility</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 hidden-xs text-center">
            <span><a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener noreferrer" title="Library &amp; University Collections Home">Library and University Collections</a> is a division of <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener noreferrer" class="islogo" title="University of Edinburgh Information Services Home">Information Services</a>.</span><br />
            <span>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener noreferrer">University of Edinburgh</a>.</span><br />
        </div>
        <div class="col-xs-12 hidden-lg hidden-md hidden-sm text-center">
            <span class="small"><a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener noreferrer" title="Library &amp; University Collections Home">Library and University Collections</a> is a division of
                <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener noreferrer" class="islogo" title="University of Edinburgh Information Services Home">Information Services</a>.</span><br />
            <span class="small">Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener noreferrer">University of Edinburgh</a>.</span><br />
        </div>
    </div>

    <div class="spacer"></div>
</footer>
