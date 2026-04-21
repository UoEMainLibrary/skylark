/**
 * Created by Kristiyan on 28/02/2017.
 * kristiyan.c@gmail.com
 */

var id;

// Starts the script unsless the screen is small and some images might be higher than the viewport
if($(window).height()>767){
    $(window).on('DOMContentLoaded load resize scroll', handler);
}

function handler(){
    $('.row.record').each(function () {
        id = $(this).attr('class').split(/\s+/)[0];
        if(!isElementInViewport($(this)) && !map_mode){
            $(this).removeClass("visible").addClass("invisible");
            markers[id].setOpacity(0);
        }
        else{
            $(this).removeClass("invisible").addClass("visible");
            markers[id].setOpacity(1);
        }
    });
    if($('.row.record').length>0) centerMap();
}

function isElementInViewport (el) {

    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }

    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
    );
}