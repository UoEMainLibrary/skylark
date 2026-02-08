<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="skip-links">
            <a class="screen-reader-text" href="{{ url()->current() }}#content">Skip to content</a>
        </div>
        <div class="navbar-header">
            <div id="collection-title">
                <a href="https://www.ed.ac.uk" class="navbar-brand logo" title="The University of Edinburgh Home" target="_blank">
                    <img src="{{ asset('images/UoELogo.gif') }}" alt="The University of Edinburgh Logo"/> 
                    <span class="sr-only">(opens in a new tab)</span> 
                </a>
                <div id="navbar-word">
                    <a href="{{ url('/') }}" class="collectionslogo" title="University of Edinburgh Collections Home"></a>
                </div>
                <div id="navbar-smallword">
                    <a href="{{ url('/') }}" class="collectionswordsmall" title="University of Edinburgh Collections Home">Collections</a>
                </div>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav" id="navbar-middle">
                <li><a href="{{ url('/') }}" title="University of Edinburgh Collections Home">Home</a></li>
                <li><a href="https://collections.ed.ac.uk/about" target="_blank" title="About Edinburgh University Collections">About <span class="sr-only">(opens in a new tab)</span></a></li>
                <li><a href="https://collections.ed.ac.uk/feedback/" target="_blank" title="Provide feedback">Feedback <span class="sr-only">(opens in a new tab)</span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right hidden-xs" id="navbar-right">
                <li><a href="https://www.facebook.com/crc.edinburgh" target="_blank" title="CRC Facebook Page" data-toggle="tooltip" data-trigger="focus"><i id="social-fb" class="fa fa-facebook-square fa-3x social" aria-hidden="true"></i> <span class="sr-only">(opens in a new tab)</span></a></li>
                <li><a href="https://twitter.com/CRC_EdUni" target="_blank" title="CRC Twitter Feed" data-toggle="tooltip" data-trigger="focus"><i id="social-tw" class="fa fa-twitter-square fa-3x social" aria-hidden="true"></i> <span class="sr-only">(opens in a new tab)</span></a></li>
                <li><a href="https://www.flickr.com/photos/crcedinburgh" target="_blank" title="CRC Flickr Page" data-toggle="tooltip" data-trigger="focus"><i id="social-fr" class="fa fa-flickr fa-3x social" aria-hidden="true"></i> <span class="sr-only">(opens in a new tab)</span></a></li>
                <li><a href="http://libraryblogs.is.ed.ac.uk/" target="_blank" title="University of Edinburgh Library Blogs" data-toggle="tooltip" data-trigger="focus"><i id="social-wp" class="fa fa-wordpress fa-3x social" aria-hidden="true"></i> <span class="sr-only">(opens in a new tab)</span></a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="content" class="tab-heading">
    <div class="container">
        <ul class="cldmenu" >
            <li class="current" ><a href="https://collections.ed.ac.uk/search/*/Type:%22archives+%7C%7C%7C+Archives%22/Header:%22archives%22?sort_by=cld.weighting_sort+desc,dc.title_sort+asc" data-hover="ARCHIVES" title="Archive and Manuscript Collections">Archives</a></li>
            <li><a href="https://collections.ed.ac.uk/search/*/Type:%22rare+books+%7C%7C%7C+Rare+Books%22/Header:%22rarebooks%22?sort_by=cld.weighting_sort+desc,dc.title_sort+asc" data-hover="RARE BOOKS" title="Rare Book Collections">Rare Books</a></li>
            <li><a href="https://collections.ed.ac.uk/search/*/Type:%22mimed+%7C%7C%7C+MIMEd%22/Header:%22mimed%22?sort_by=cld.weighting_sort+desc,dc.title_sort+asc" data-hover="MUSICAL INSTRUMENTS" title="Musical Instrument Collections">Musical Instruments</a></li>
            <li><a href="https://collections.ed.ac.uk/search/*/Type:%22art+%7C%7C%7C+Art%22/Header:%22art%22?sort_by=cld.weighting_sort+desc,dc.title_sort+asc" data-hover="ART" title="Art Collections">Art</a></li>
            <li><a href="https://collections.ed.ac.uk/search/*/Type:%22museums+%7C%7C%7C+Museums%22/Header:%22museums%22?sort_by=cld.weighting_sort+desc,dc.title_sort+asc" data-hover="MUSEUMS" title="Museums">Museums</a></li>
        </ul>
    </div>
</div>
