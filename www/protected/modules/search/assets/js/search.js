$( document ).ready(function() {
    setImageClick ();
});

function setImageClick () {
    $(".imageInside").each(function () {
        var element = $(this),
            position,
            y_coordinates,
            last_in_row,
            pos,
            el;

        element.unbind('click').click(function () {
            $("#media_full_description").remove();
            $(".arrow").hide();
            position = element.position();
            y_coordinates = position.top;
            last_in_row = element;

            $(".imageInside:gt('" + $(this).index() + "')").each(function () {
                el = $(this);
                pos = el.position();
                if (y_coordinates == pos.top) {
                    last_in_row = el;
                } else {
                    return false;
                }
            });

            $('<div id="media_full_description" class="media_full_description group"></div>').insertAfter(last_in_row).slideDown("show", function () {
                element.find(".arrow").show();
                var json = $.parseJSON(element.find('.json').text());
                if (json.result[0].mimeType === 'image') {
                    $("#template-image_description").tmpl(json.result[0]).appendTo($("#media_full_description")).after(function () {
                        add_delete ();
                    });
                } else if (json.result[0].mimeType === 'audio') {
                    $("#template-audio_description").tmpl(json.result[0]).appendTo($("#media_full_description")).after(function () {
                        add_delete ();
                    });
                } else if (json.result[0].mimeType === 'video') {
                    $("#template-video_description").tmpl(json.result[0]).appendTo($("#media_full_description")).after(function () {
                        add_delete ();
                    });
                }
            });
        });

        function add_delete () {
            $("#media_full_description").find(".delete").unbind('click').click(function () {
                $(this).closest('.media_full_description').remove();
                $(".arrow").is(":visible").hide();
            });
        }
    });
}