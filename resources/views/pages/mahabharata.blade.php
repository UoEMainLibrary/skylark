@extends('layouts.app')

@section('title', 'Mahabharata Scroll - University of Edinburgh Collections')

@section('content')
<div class="tab-list">
    <div class="container">
        <h1>Mahabharata Scroll</h1>
        <div align="left">
            <p>The Edinburgh University's 1795 copy of the Mahābhārata is now available online. This beautiful scroll is one of the longest poems
                ever written, containing a staggering 200,000 verses spread along 72 meters of richly decorated silk backed paper. As one of the Iconic
                items in our Collection.
            </p>
        </div>
        <h2>Digitisation of the Mahabharata Scroll</h2>
        <div align="left">
            <p>Before the scroll could be digitised, Conservator Emily Hick had to stabilise the scroll edges which the wooden housing was causing
                to fray and snag. We had a plate made to insert under the scroll to provide a flat area for Emily to work on, which could also be used
                during photography.
            </p>
            <p>
                Following conservation the photography required a certain amount of problem solving when planning the studio set up. The scroll is
                elaborately decorated in gold and has dense, tiny text. The fine text was so small that it is difficult to read and had to be
                photographed at circa 2x magnification to enable readability. Despite the housing and roller arrangement, as the scroll was wound on
                there was a certain amount of lateral movement, around 1cm side to side. Furthermore, while the extensive gold is part of
                what makes this item so special, photographically it adds further layers of complexity. Gold illuminations can be hard to light-
                light from the side and it barely looks like gold, light from above and risk vast areas of specular burn out. Also, the ripple
                movement from the roller arrangment would cause the gold to reflect light at different angles, complicating the next stage of the
                project: stitching the images back together. Due to the fragility of the surface and critical light positioning we were not able to use
                glass to steady the surface, instead opting for 'snakes' –strings of weights used in the Special Collections Reading Room.
            </p>
            <p>
                Calibration was done to ensure the lighting was even and neutral. A large overlap of images was made during photography to aid stitching.
                Undertaking a stitching job of this scale presented a significant project for the DIU: even assuming I could successfully stitch
                together the full scroll, it would make for an unimaginable file size and how would we deliver this in a useful format online? In recent
                years there has been some development in the automation of image stitching with improved algorithms of software such as Adobe and PTGui.
                However, the dense text, the variations in the gold rendering and the ripple movement of the scroll all conspired against successful
                automation. Stitching together manually took just under 3 months of work so the completion of the scroll was a moment of celebration
                in the DIU!
            </p>
            <p>
                You can hear more about this project from Dr Naomi Appleton, Senior Lecturer in Asian Religions and Conservator Emily Hick,
                in this <a href="https://youtu.be/spYehaknO_A" title="video" target="_blank">video <span class="sr-only">(opens in a new tab)</span></a>.
            </p>
            <p>
                The scroll has been made available to view online using <a href="https://iiif.io" title="International Image Interoperability Framework" target="_blank">IIIF <span class="sr-only">(opens in a new tab)</span></a>
                image and presentation APIs, that stitch the images together in realtime to enable you to scroll up and down. There is more information about the digitisation in a
                <a href="http://libraryblogs.is.ed.ac.uk/diu/2018/06/22/a-stitch-in-time-mahabharata-delivered-online/" title="Digitisation Blog post" target="_blank">blog post <span class="sr-only">(opens in a new tab)</span></a>.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <iframe src="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=https://librarylabs.ed.ac.uk/iiif/manifest/mahabharataFinal.json" width="100%" height="800" allowfullscreen="true"></iframe>
</div>
@endsection
