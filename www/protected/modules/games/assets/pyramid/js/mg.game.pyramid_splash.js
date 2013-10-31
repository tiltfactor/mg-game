$(window).resize(function() {
    onResize ();
});
$( document ).ready(function() {
    onResize();
    $("#footer").hide();
    $(".hover_btn").hover(
        function () {
            var img_obj = $(this).find('img:eq(0)'),
                src = img_obj.attr('src'),
                new_src = src.replace("_off","_on");

            img_obj.attr('src', new_src);
        }, function() {
            var img_obj = $(this).find('img:eq(0)'),
                src = img_obj.attr('src'),
                new_src = src.replace("_on","_off");

            img_obj.attr('src', new_src);
        }
    );

    $(".hover_btn").click(function (e) {
        var that = $(this),
            img_obj = that.find('img:eq(0)'),
            src = img_obj.attr('src');
        e.preventDefault();

/*        if(MG_PYRAMID.isLogged == 'false' && $("body").hasClass("touch_device")) {
            $().toastmessage("showToast", {
                text:'You must be logged in to play.',
                position:"tops-center",
                type:"notice",
                background:"white",
                color:"black",
                stayTime:MG_GAME_PYRAMID.toastStayTime,
                addClass:MG_GAME_PYRAMID.toastBackgroundClass
            });
            img_obj.attr('src', src.replace("_on","_off"));
        } else {
            window.location.href = that.prop('href');
        }
*/
        window.location.href = that.prop('href');
    });
});

$( window ).load(function() {
// Run code
    onResize();
});

function onResize () {
    $("#splash_home .middle_height").css("max-height", $(window).height() / 3);
    $("#splash_logo").centerVertival();
    var height_top = $(window).height() - $(".splash_logo").outerHeight() - $("#header").outerHeight() - $("img.middle_height").height();
    if (height_top < 10) height_top = 10;
    $("#main_screen .top").css('height', height_top + 'px');
    $("nav .mm-inner").css('width', $(window).width());
}