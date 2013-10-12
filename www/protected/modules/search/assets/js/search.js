$( document ).ready(function() {
    $("#advancedSearch").hide();
    $('#advancedButton').off('click').on('click', function () {
        //alert('we are here');

        $("#advancedSearch").toggle('slow');

        $(':submit').off('clicl').on('click', function () {
            var srchFieldValue = $('#Custom_tags').val();
            if(srchFieldValue !== ""){
                $('#searchedValue').innerHTML = " for " + srchFieldValue;
            }
        })

    });
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

            $('<div id="media_full_description"></div>').insertAfter(last_in_row).slideDown("show", function () {
                    $("#template-description").tmpl($.parseJSON(element.find('.json').text())).appendTo($("#media_full_description")).after(function () {

                    });
                });
        });
    });
}