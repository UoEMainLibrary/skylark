@extends('layouts.app')

@section('title', 'Collections As Data - University of Edinburgh Collections')

@section('content')
<div class="tab-list">
    <div class="container">
        <h1 class="bantext">Collections As Data</h1>
        <div>
            <h4 class="wrap">
                We are making full collections available as downloadable datasets. These can then be used as the basis of digital scholarship research, for text mining, data carpentry, and beyond. The content is available in zip format for download, and information around API calls to access them that way will be published here in due course.
            </h4>
            <h4 class="wrap-bold">NB: please login to EASE before attempting your download. You can do this by opening <a href="https://collectionsmanager.is.ed.ac.uk" target="_blank">Collections Manager<span class="sr-only"> (opens in a new tab)</span></a>.</h4>
            <br/>
        </div>
        <div>
            <h2>Scottish Statistical Accounts</h2>
            <br/>
            <img src="{{ asset('theme/clds/images/statacc.png') }}" class="zipimage">
            <br/>
            <br/>
            <h4 class="wrap">The Scottish Statistical Accounts zip contains all the pages from the OSA (Old Statistical Account) and the NSA (New Statistical Account) to be found at the website <a href="https://stataccscot.edina.ac.uk/static/statacc/dist/home" target="_blank" title="Scottish Statistical Accounts">https://stataccscot.edina.ac.uk<span class="sr-only"> (opens in a new tab)</span></a>.</h4>
            <br/>
            <h3>
                <a href="https://collectionsmanager.is.ed.ac.uk/bitstream/handle/10683/119269/statacc_pages.zip?sequence=1&isAllowed=y" target="_blank">Direct Download<span class="sr-only"> (opens in a new tab)</span></a> &nbsp;&bull;&nbsp;<a href="https://collectionsmanager.is.ed.ac.uk/handle/10683/119269" target="_blank">DSpace Record<span class="sr-only"> (opens in a new tab)</span></a>
            </h3>
            <br/>
        </div>

        <div>
            <h2>Digitised PhD Theses Collection</h2>
            <br/>
            <img src="{{ asset('theme/clds/images/theses.png') }}" class="zipimage">
            <br/>
            <br/>
            <h4 class="wrap">The Digitised PhD Theses zip contains all the theses in the <a href="https://era.ed.ac.uk" target="_blank" title="ERA">Edinburgh Research Archive<span class="sr-only"> (opens in a new tab)</span></a>, dating back to the 17th century. 60% of these were created by the <a href="http://libraryblogs.is.ed.ac.uk/phddigitisation/" target="_blank" title="PhD Digitisation Project">PhD digitisation project<span class="sr-only"> (opens in a new tab)</span></a> of 2018. More information at the <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/collections/theses" title="CRC theses pages" target="_blank">CRC webpages<span class="sr-only"> (opens in a new tab)</span></a>.</h4>
            <br/>
            <h3>
                <a href="https://collectionsmanager.is.ed.ac.uk/bitstream/handle/10683/119277/theses.zip?sequence=1&isAllowed=y" target="_blank" title="Download Digitised Theses zip">Direct Download<span class="sr-only"> (opens in a new tab)</span></a> &nbsp;&bull;&nbsp;<a href="https://collectionsmanager.is.ed.ac.uk/handle/10683/119277" target="_blank" title="Digitised Theses DSpace Record">DSpace Record<span class="sr-only"> (opens in a new tab)</span></a>
            </h3>
            <br/>
        </div>
        <div>
            <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img class="ccby" src="https://images.is.ed.ac.uk/graphics/by-front.jpg" alt="Creative Commons License"/></a>
            <br/>
        </div>
    </div>
</div>
@endsection
