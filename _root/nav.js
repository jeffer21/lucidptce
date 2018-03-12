/**
 * Created by AlanJoseph on 3/9/2018.
 */
$(document).ready(function(){
    var scrollTop = 0;
    $(window).scroll(function(){
        scrollTop = $(window).scrollTop();
        $('.counter').html(scrollTop);

        if (scrollTop >= 150) {
            $('#global-nav').addClass('scrolled-nav');
        } else if (scrollTop < 150) {
            $('#global-nav').removeClass('scrolled-nav');

        }

    });

});