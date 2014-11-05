$(document).ready(function() {
    var ww = document.body.clientWidth;
    $(".nav li a").each(function() {
        if ($(this).next().length > 0) {
            $(this).addClass("parent");
        }
        ;
    });


    $(".toggleMenu").click(function(e) {
        e.preventDefault();
        $(this).toggleClass("active");
        $(".nav").toggle();
    });
    adjustMenu();
});

$(window).bind('resize orientationchange', function() {
    ww = document.body.clientWidth;
    adjustMenu();
});

var adjustMenu = function() {
    $(".toggleMenu").css("display", "none");
    $(".nav").show();

    $(".nav li").removeClass("hover");
    $(".nav li a").unbind('click');

    $(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
        // must be attached to li so that mouseleave is not triggered when hover over submenu
        $(this).toggleClass('hover');
    });
    $(".nav li ul li ul li ul li").removeClass("hover");
    $(".nav li ul li ul li ul li a").unbind('click');
    $(".nav li ul li ul li ul li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
        // must be attached to li so that mouseleave is not triggered when hover over submenu
        $(this).toggleClass('hover');
    });
};