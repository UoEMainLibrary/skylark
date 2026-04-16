/**
 * Created by Kristiyan Tsvetanov on 16/03/2017.
 * Contact me: kristiyan.c@gmail.com
 */
(function($){
    var i = Math.floor((Math.random() * 7)),
        hovered = false,
        images = ["https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~2~2~73051~164085/full/!1024,1024/0/default.jpg",
                  "https://apps.utu.fi/media/kuvat/Coimbra/Kalm-kirja-3.jpg",
                  "https://gwdu64.gwdg.de/images/forster/overview/189_Prodr_Nr_255_b_1.jpg",
                  "https://apps.utu.fi/media/kuvat/Coimbra/old-bug-boxes-33.jpg",
                  "http://www.unimus.no/felles/bilder/web_hent_bilde.php?id=12136228&type=jpeg",
                  "https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~51583~103971/full/!1024,1024/0/default.jpg",
                  "https://apps.utu.fi/media/kuvat/Coimbra/old-bug-boxes-33.jpg"];

    $('.parallax').css('background-image', 'url(' + images[i] + ')');
    $('.main-categories li:nth-child(' + (i) + ')').addClass('active');

    // Changes the focused category every n seconds
    window.setInterval(function () {
        if(!hovered) {
            $('.main-categories li').removeClass('active');
            $('.main-categories li:nth-child(' + (i + 1) + ')').addClass('active');
            $('.parallax').fadeTo('slow', 0.7, function () {
                $('.parallax').css('background-image', 'url(' + images[i] + ')');
            }).delay(10).fadeTo(10, 1);
        }
        i == 6 ? i = 0 : i++;
        hovered = false;

    }, 10000);

    // If a category is hovered
    $(".main-categories li").mouseover(function () {
        $('.main-categories li').removeClass('active');
        $(this).addClass('active');
        i = $('.main-categories li').index($(this));
        $('.parallax').fadeTo('slow', 0.7, function(){
            $('.parallax').css('background-image', 'url(' + images[i] + ')');
        }).fadeTo(10, 1);
        hovered = true;
    });
})(jQuery);
