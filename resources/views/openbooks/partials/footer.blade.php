<footer>
    <div class="footer-links">
        <div class="site-links">
            <a href="{{ $collectionUrl() }}">Open Books</a>
            <a href="{{ $collectionUrl('about') }}">About this Collection</a>
            <a href="{{ $collectionUrl('feedback') }}" class="last">Feedback</a>
        </div>
        <div class="social-links">
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/crc.edinburgh" class="facebook-icon" target="_blank" title="CRC on Facebook" rel="noopener noreferrer"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
                <li><a href="https://twitter.com/CRC_EdUni" class="twitter-icon" target="_blank" title="CRC on Twitter" rel="noopener noreferrer"><span class="visually-hidden"> (opens in a new tab)</span></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-disclaimer">
        <div class="footer-logo">
            <a href="https://www.ed.ac.uk/schools-departments/information-services/about/organisation/library-and-collections" target="_blank" rel="noopener noreferrer" class="luclogo" title="Library &amp; University Collections Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
        </div>
        <div class="footer-policies">
            <p>This collection is part of <a href="{{ url('/') }}" title="University Collections Home">University Collections</a>.</p>
            <p><a href="https://www.ed.ac.uk/about/website/privacy" title="Privacy and Cookies Link" target="_blank" rel="noopener noreferrer">Privacy &amp; Cookies (opens in a new tab)</a>
                &nbsp;&nbsp;<a href="https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/using-the-collections/digitisation/image-licensing/takedown-policy" target="_blank" rel="noopener noreferrer" title="Takedown Policy Link">Takedown Policy (opens in a new tab)</a>
                &nbsp;&nbsp;<a href="{{ $collectionUrl('licensing') }}" title="Licensing and Copyright Link">Licensing &amp; Copyright</a>
                &nbsp;&nbsp;<a href="{{ $collectionUrl('accessibility') }}" title="Website Accessibility Link" target="_blank" rel="noopener noreferrer">Accessibility (opens in a new tab)</a></p>
            <p>Unless explicitly stated otherwise, all material is copyright &copy; {{ date('Y') }} <a href="https://www.ed.ac.uk" title="University of Edinburgh Home" target="_blank" rel="noopener noreferrer">University of Edinburgh (opens in a new tab)</a>.</p>
        </div>
        <div class="is-logo">
            <a href="https://www.ed.ac.uk/information-services" target="_blank" rel="noopener noreferrer" class="islogo" title="University of Edinburgh Information Services Home"><span class="visually-hidden"> (opens in a new tab)</span></a>
        </div>
    </div>
</footer>
