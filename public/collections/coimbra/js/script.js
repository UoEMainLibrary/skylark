/**
 * Created by Kristiyan Tsvetanov on 24/02/2017.
 * email: kristiyan.c@gmail.com for any questions
 */

window.addEventListener('load',
    function() {
        //Removes loader overlay
        $('#loader').delay(1000).fadeOut();
        $('#loader').click(function(){ $('#loader').fadeOut(); });
        $('.cover-image-container').addClass("loaded");
        $('.record-info').addClass("showing");
        // Setting body padding bottom dynamically because the footer has dynamic height
        $('body').css('padding-bottom', $('.footer').height());

        // Controlling sidebar if it reaches the footer
        if('.sidebar-nav')[0] // Checking if there is need for checking the sidebar position
        {
            $(window).scroll(function () {
                if (!map_mode && $(window).scrollTop() + $(window).height() + 80 >= $('.footer').offset().top) {
                    $(".sidebar-nav").css('position', 'absolute').css('top', $('.footer').offset().top - $('.sidebar-nav').height() - 150).css('width', '100%');
                }
                else {
                    $(".sidebar-nav").css('position', 'fixed').css('top', 50).css('width', 'inherit');
                }
            });
        }

        // If it is the home page, start the slideshow
        if($('.main-categories')[0]) {
            slideshow();
        }
}, false);
