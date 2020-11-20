$(document).ready(function() {

    /** Disable Links Starting With #s **/
    $('a[href*="#"]').click(function(e) {
        e.preventDefault();
    });

    /** Toggle Active Class **/
    $('a.nav-link').click(function() {
        $('a.nav-link').removeClass('active');
        $(this).toggleClass('active');
    });

    /** Smooth Scroll To Top **/
    $('#scroll').click(function() {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 700);
        return false;
    });

});
