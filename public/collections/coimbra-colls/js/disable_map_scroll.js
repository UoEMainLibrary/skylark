/**
 * Created by Kristiyan Tsvetanov on 09/03/2017.
 * Contact me: kristiyan.c@gmail.com
 *
 * This script prevents users from scrolling(zooming) on maps accidentally
 * It sets the scrolling to false as default and toggles it when clicked on map
 */

function enableScrollingWithMouseWheel() {
    map.setOptions({ scrollwheel: true });
}

function disableScrollingWithMouseWheel() {
    map.setOptions({ scrollwheel: false });
}

if($('#map')[0]) {
    $('body').on('mousedown', function (event) {
        var clickedInsideMap = $(event.target).parents('#map').length > 0;

        if (!clickedInsideMap) {
            disableScrollingWithMouseWheel();
        }
    });
}