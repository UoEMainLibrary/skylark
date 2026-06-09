<footer>
    <div class="footer-links">
        <div class="site-links">
            <div class="footer-logo">
                <a href="https://www.ed.ac.uk" target="_blank" rel="noopener noreferrer" class="uoelogo" title="University of Edinburgh Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
            </div>
            <div class="footer-policies">
                <a href="{{ $collectionUrl() }}" title="{{ config('skylight.fullname') }} Home" class="border">Home</a>
                <a href="{{ $collectionUrl('about') }}" title="About this site" class="border">About</a>
                <a href="{{ $collectionUrl('takedown') }}" title="Takedown Policy Link">Takedown Policy</a><br>
                <a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener noreferrer" class="border">Privacy &amp; Cookies<span class="visually-hidden"> (opens in a new tab)</span></a>
                <a href="{{ $collectionUrl('licensing') }}" title="Licensing and Copyright Link" class="border">Licensing &amp; Copyright</a>
                <a href="{{ $collectionUrl('accessibility') }}" title="Website Accessibility Link" target="_blank" rel="noopener noreferrer">Accessibility<span class="visually-hidden"> (opens in a new tab)</span></a>
                <a href="http://collections.ed.ac.uk" title="University Collections Home" target="_blank" rel="noopener noreferrer" class="border">University Collections<span class="visually-hidden"> (opens in a new tab)</span></a>
                <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" title="Library and University Collections Home" target="_blank" rel="noopener noreferrer">Library &amp; University Collections<span class="visually-hidden"> (opens in a new tab)</span></a><br>
            </div>
            <div class="iog-logo">
                <a href="http://www.institute-of-governance.org" target="_blank" rel="noopener noreferrer" class="ioglogo" title="Institute of Governance Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
            </div>
            <div class="clearfix"></div>
            <div class="copyright-policies">
                Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener noreferrer" class="last">University of Edinburgh<span class="visually-hidden"> (opens in a new tab)</span></a>
            </div>
        </div>
    </div>
</footer>
