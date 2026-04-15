/**
 * Created by Kristiyan Tsvetanov on 24/02/2017.
 * email: kristiyan.c@gmail.com for any questions
 */

window.onload = function(){
    $('#loader').fadeOut(10);
    $('#loader').click(function(){ $('#loader').fadeOut(); });

    $('.cover-image-container').addClass("loaded");
    $('.record-info').addClass("showing");
};
