/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* fixed scroll */
/* http://stackoverflow.com/questions/15850271/how-to-make-div-fixed-after-you-scroll-to-that-div */
$(window).scroll(function () {
//                var currentScroll = $(window).scrollTop();
    if ($(window).scrollTop() >= fixmeTop) {
        $('.item-list').css({
            position: 'fixed',
            top: '120px',
            left: '0'
        });
        $('.item-list-2').css({display: 'block'});
    } else {
        $('.item-list').css({
            position: 'static'
        });
        $('.item-list-2').css({display: 'none'});

    }
});