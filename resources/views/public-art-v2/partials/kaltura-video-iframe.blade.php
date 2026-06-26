{{--
    Public Kaltura / Media Hopper embed for Art on Campus.

    Each Media Hopper entry has its own widget id (see public_art_videos in
    config/collections/public-art.php). Using another entry's widget returns
    "No source video was found" even when the video plays on media.ed.ac.uk.
--}}
@php
    $widgetParam = $widgetParam ?? 'widget_id';
    $uiConfId = $uiConfId ?? '40887822';
    $embedSrc = 'https://cdnapisec.kaltura.com/p/2010292/sp/201029200/embedIframeJs/uiconf_id/'.$uiConfId.'/partner_id/2010292?iframeembed=true&playerId=kaltura_player&entry_id='.$entryId;

    if ($useFlashvars ?? false) {
        $embedSrc .= '&flashvars[streamerType]=auto&flashvars[localizationCode]=en&flashvars[sideBarContainer.plugin]=true&flashvars[sideBarContainer.position]=left&flashvars[sideBarContainer.clickToClose]=true&flashvars[chapters.plugin]=true&flashvars[chapters.layout]=vertical&flashvars[chapters.thumbnailRotator]=false&flashvars[streamSelector.plugin]=true&flashvars[EmbedPlayer.SpinnerTarget]=videoHolder&flashvars[dualScreen.plugin]=true&flashvars[Kaltura.addCrossoriginToIframe]=true&'.$widgetParam.'='.$widgetId;
    } else {
        $embedSrc .= '&'.$widgetParam.'='.$widgetId;
    }
@endphp
<iframe src="{{ $embedSrc }}"
        title="{{ $title }}"
        allow="autoplay *; fullscreen *; encrypted-media *"
        loading="lazy"
        frameborder="0"
        class="h-full w-full"></iframe>
