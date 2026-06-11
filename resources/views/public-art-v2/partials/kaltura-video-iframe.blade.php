{{--
    Public Kaltura / Media Hopper embed for Art on Campus.

    Uses wid=1_65sjprmo (not widget_id=0_j4c8cidb) — the latter returns
    "No source video was found" for anonymous visitors. Same pattern as the
    home-page Ideas spotlight embed.
--}}
<iframe src="https://cdnapisec.kaltura.com/p/2010292/sp/201029200/embedIframeJs/uiconf_id/32599141/partner_id/2010292?iframeembed=true&playerId=kaltura_player&entry_id={{ $entryId }}&flashvars[streamerType]=auto&flashvars[localizationCode]=en&flashvars[sideBarContainer.plugin]=true&flashvars[sideBarContainer.position]=left&flashvars[sideBarContainer.clickToClose]=true&flashvars[chapters.plugin]=true&flashvars[chapters.layout]=vertical&flashvars[chapters.thumbnailRotator]=false&flashvars[streamSelector.plugin]=true&flashvars[EmbedPlayer.SpinnerTarget]=videoHolder&flashvars[dualScreen.plugin]=true&flashvars[Kaltura.addCrossoriginToIframe]=true&wid=1_65sjprmo"
        title="{{ $title }}"
        allow="autoplay *; fullscreen *; encrypted-media *"
        loading="lazy"
        frameborder="0"
        class="h-full w-full"></iframe>
