@extends('layouts.public-art-v2')

@section('title', 'Paolozzi Mosaic Project | Art on Campus')

@section('description', 'The University of Edinburgh\'s Paolozzi Mosaic Project: the story of how fragments of Eduardo Paolozzi\'s Tottenham Court Road station mosaics came to Edinburgh.')

@section('content')
<article class="mx-auto max-w-3xl">
    <p class="text-sm font-medium uppercase tracking-[0.25em] text-pa-ink-600">University Art Collection</p>
    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Paolozzi Mosaic Project</h1>

    {{-- Optional informational video block (no "Information video" heading per client) --}}
    <div class="mt-8 aspect-video w-full overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
        <iframe src="https://player.vimeo.com/video/170003917?title=0&amp;byline=0&amp;portrait=0&amp;texttrack=en"
                title="Video about the Paolozzi Mosaic Project (Vimeo)"
                allow="autoplay; fullscreen; picture-in-picture; encrypted-media"
                loading="lazy"
                frameborder="0"
                class="h-full w-full"></iframe>
    </div>
    <p class="mt-2 text-sm text-pa-ink-700">
        Captions are available within the video player. Use the
        @include('public-art-v2.partials.external-link', [
            'href' => 'https://vimeo.com/170003917',
            'label' => 'full-page version on Vimeo',
            'class' => 'text-pa-accent',
        ])
        to access player controls and any available transcript.
    </p>

    <div class="prose prose-lg mt-10 max-w-none text-pa-ink-700">
        <h2>Background</h2>
        <p>
            In 1979 Scottish artist Eduardo Paolozzi (1924&ndash;2005) was commissioned by London Regional Transport to
            create a public artwork for Tottenham Court Road Tube Station (TCR). Covering over 950 square metres in
            mosaics, Paolozzi designed an artwork in images of everyday life, references to visual culture, and the
            locality and nearby attractions like the British Museum.
        </p>
        <p>
            This commission included archways over the escalators going down and back up from the main entrance hall.
            In total there were six archways within two structures, with four separate designs &mdash; one on each side
            of the two structures. Images on the first and second archway were modelled on watch straps, a nod to the
            commuters checking the time as they rushed for a train. The third and fourth designs were inspired by an
            Egyptian panel in the nearby British Museum.
        </p>

        <h2>Restoration plans</h2>
        <p>
            In 2011 Transport for London (TfL) announced plans for a Crossrail station and other redevelopments at TCR.
            While restoration plans were developed for the mosaics on the platforms and in the rotunda area, the arches
            were to be removed from the station as part of the expansion of the entrance hall.
        </p>
        <p>
            Agreeing with contractors and structural engineers that the arches could not be retained in the new station,
            the Paolozzi Foundation accepted that they were to be dismantled and removed. Despite this decision the
            public and media protested against the removal of the arches and, led by the heritage organisation 20th
            Century Society, campaigned for them to be saved. Nonetheless, the arches were removed from the station in
            January 2015.
        </p>
        <p>
            With pressure from the public and 20th Century Society, TfL agreed to make plans to store fragments that
            were deemed saveable and to find them a new home.
        </p>

        <h2>Mosaic fragments</h2>
        <p>
            In February 2015 TfL made contact with the University of Edinburgh to see whether the fragments could form
            part of the University&rsquo;s Art Collection, and in June were officially announced as the institution
            that would be gifted the remainder of the mosaic fragments.
        </p>
        <p>
            The University&rsquo;s Art Collection is an appropriate home. Paolozzi was from Leith and his professional
            history began in the north at Edinburgh College of Art (ECA). He returned later in his career as a visiting
            professor, giving lectures to ECA students. He continued to have a strong connection with Edinburgh that
            carries on today through his art. At the University, Paolozzi is the most represented artist in the art
            collection.
        </p>
        <p>
            In October 2015 over 600 fragments arrived in Edinburgh and were unpacked in ECA&rsquo;s Sculpture Court.
            Over five days staff and students carried out some basic conservation, cataloguing and rehousing of each
            fragment.
        </p>

        <h2>A Scottish Art Conundrum</h2>
        <p>
            Although it was highly likely that not all the material had survived the removal, it was not clear how much
            was actually lost. This uncertainty determined the University&rsquo;s next steps for management of the
            fragments, and over the next three months each fragment was photographed.
        </p>
        <p>
            As well as providing a digital record, this work allowed for collaborations with the School of Informatics.
            Led by the Chair in Computer Vision, Professor Bob Fisher, and PhD student Alex Davis, this collaboration
            set out to digitally map each fragment against the original designs using the MATLAB programme. Each
            photograph was scanned into the image-recognition software and a matched location was generated.
        </p>
        <p>
            This provided vital knowledge regarding fragment location but also complicated plans for their redisplay
            with the discovery that only 33% of the arches survived the removal from the station. Fisher and
            Davis&rsquo; data and images estimated that the material gifted to the University amounts to 12% of the
            colour-tile area of the artwork.
        </p>

        <h2>Exploring the aftermath</h2>
        <p>
            The data produced by Informatics raised many questions. Faced with a partial artwork, do you attempt to
            reconstruct it in its original form? Or do you keep the arches in their fragmented form? If so, how do you
            redisplay them?
        </p>
        <p>
            Deciding what to do with the material was an exciting, challenging project for the art collection team, the
            wider University and the city. In August 2016 a Public Art Officer was hired to oversee the future of the
            project. Over ten months they carried out research, ran events, developed and managed a series of
            consultations to determine the potential use(s) for the mosaics.
        </p>
        <p>
            Consultations included a number of handling sessions and a dedicated symposium in February 2017 organised by
            the University, as well as talks at national and international events including the Vandalism and Art
            Conference in June 2017 and the British Association for Modern Mosaics (BAMM) Annual Forum in September 2017.
            At each event attendees were invited to discuss the project and make suggestions for use of the fragments.
        </p>
        <p>
            As well as forming part of the external, public consultancy around the project, this also enabled a sense of
            ownership in the wider community for a public artwork that had come from London.
        </p>

        <h2>Next stages</h2>
        <p>
            Following this period of research, consultation and reflection, two critical points emerged. Firstly, the
            suggestion that the mosaics should be redisplayed as a public artwork and, secondly, they should not be
            remade in their entirety. Their original context in the public realm and the story of what had happened to
            them were a key part of their identity.
        </p>
        <p>
            Two options were identified for their future form and use. Firstly, the fragments could be redisplayed in
            the form of the archway or as part of an entrance. In this way, the link to the functional, historical
            intention of the original artwork would be retained. The suggestion of achieving this by creating a
            &lsquo;ghost arch&rsquo; was raised consistently. The arches would be redrawn and the fragments placed in
            their location; areas of loss would be visible and outlined with the redrawn design, allowing for a
            sympathetic, conservation-based approach to the fragments&rsquo; redisplay.
        </p>

        <h2>A ghost arch?</h2>
        <p>
            However, as well as losing more than half of the arches, there were other losses to consider. Many who knew
            and worked with Paolozzi closely felt that creating a ghost arch would be inappropriate and would overlook
            the spirit of his work. At its core his artworks explored what he referred to as &lsquo;the metamorphosis
            of rubbish&rsquo; and played with ideas of recycling, reconfiguration, accumulation, and collage of
            material.
        </p>
        <p>
            The opportunity to engage with these ideas seemed ripe with the mosaic fragments. Moreover, it was important
            to remember that the artwork had never been located in Edinburgh. The recreation of a work that had never
            existed in the city could risk becoming a tragic monument that failed to celebrate the artist or the
            artwork &mdash; only focusing on the story of its removal from the London tube station and subsequent loss.
        </p>
        <p>
            In order to both celebrate Paolozzi, his work and tell the arches&rsquo; story, a secondary suggestion was
            that the fragments could be recreated into something new. A competition process could be organised to
            obtain artists&rsquo; proposals for a new work, which could then be displayed on campus as part of the art
            collection. This could allow for a contemporary yet loyal solution given the level of damage, the loss of
            original context and relocation to Edinburgh.
        </p>
        <p>
            Though neither the &lsquo;Ghost Arch&rsquo; nor the repurposing of the fragments into a new work have been
            realised, the mosaics remain a regular feature in teaching across the University, enabling speculative
            conversations about ethics, copyright, artists&rsquo; rights, and art in the public realm.
        </p>
    </div>
</article>
@endsection
