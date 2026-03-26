/**
 * Created by Kristiyan Tsvetanov on 23/03/2017.
 * Contact me: kristiyan.c@gmail.com
 */
(function($){

    OpenSeadragon({
        id: "openseadragon",
        prefixUrl: "../theme/coimbra/images/buttons/",
        toolbar: "toolbarDiv",
        zoomInButton: "zoom-in",
        zoomOutButton: "zoom-out",
        homeButton: "home",
        showNavigator: true,
        mouseNavEnabled: true,

        tileSources: [{
            "@context": "http://iiif.io/api/image/2/context.json",
            "@id": imageURL,
            "height": imageHeight,
            "width": imageWidth,
            "profile": ["http://iiif.io/api/image/2/level2.json",
                {
                    "formats": ["jpg"]
                }
            ],
            "protocol": "http://iiif.io/api/image",
            "tiles": [{
                "scaleFactors": [1, 2, 8, 16, 32],
                "width": "750",
                "height": "750"
            }],
            "tileSize": 750
        }]
    });

})(jQuery);


