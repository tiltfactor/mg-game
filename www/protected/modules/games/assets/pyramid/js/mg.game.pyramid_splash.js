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
                new_src = src.replace("_off","_on");

            img_obj.attr('src', new_src);
        }
    );

    $(".hover_btn").click(function (e) {
        var that = $(this);
        e.preventDefault();
        that.find('img:eq(0)').hide();
        that.find('img:eq(1)').closest('span').show();
        window.location.href = that.prop('href');
    });
});
$(window).resize(function() {
    onResize ();
});
function onResize () {
    $("#splash_home .middle_height").css("max-height", $(window).height() / 3);
    $("#splash_logo").centerVertival();
}