$(document).ready(function () {
    $("#totalItemsFound").insertAfter('#searchHeader');
    var searched = $('#Custom_tags').val();
    if (searched !== '') {
        $('#putFor').text("for");
        $('#searchedValue').text(searched);
    }
    checkInstitutionsCollections();
    setImageClick();

});


function checkInstitutionsCollections(){
    $('#Custom_institutions input').off('click').on('click', function () {
        var checkedInstitutions = [];
        $('#Custom_institutions input').each(function (i, item) {
            if( this.checked == true) {
                checkedInstitutions.push($(this).attr("value"));
            }
        });

        var instId = parseInt($(this).attr( 'value'),10) ;
        var colToInst = $.parseJSON($('#collectionToInstitution').text());
        var collectionsToBeUnSelectable = [];
        var collectionsToBeSelectable = [];
        var distinctCollectionsToBeUnSelectable = [];
        var i = 0;
        $.each(checkedInstitutions, function(key, value) {
            $.each(colToInst, function(i, item) {
                if(parseInt(item['institution_id'],10) !== parseInt(value,10)) {
                    collectionsToBeUnSelectable.push(item['id']);
                }
                if(parseInt(item['institution_id'],10) === parseInt(value,10)) {
                    collectionsToBeSelectable.push(item['id']);
                }
            });
        });

        $.grep(collectionsToBeUnSelectable, function(el) {
            if ($.inArray(el, collectionsToBeSelectable) == -1) distinctCollectionsToBeUnSelectable.push(el);
            i++;
        });

        $.each(distinctCollectionsToBeUnSelectable, function(i, item) {
            $("#Custom_collections [value = " + item + "]").attr("checked", false);
            $("#Custom_collections [value = " + item + "]").attr("disabled", true);
        });
        $.each(collectionsToBeSelectable, function(i, item) {
            $("#Custom_collections [value = " + item + "]").attr("disabled", false);
        });
        if(collectionsToBeSelectable.length === 0) {
            $('#Custom_collections input').each(function (i, item) {
                $(this).attr("disabled", false);
            });
        }
    });
}


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
                var thumbnails = $('.thumbnails');
                var imagesWithoutSource = 0;
                $.each(thumbnails, function( index, value ) {
                    if($(value).attr('src') == '')
                    {
                        $(value).css('visibility' , 'hidden');
                        $(value).remove();
                        imagesWithoutSource++
                    }

                });
                console.log("imagesWithoutSource: ",imagesWithoutSource);
                if(imagesWithoutSource == 8 ) $('.otherMediaInterests').remove();
            });





        });


        function add_delete () {
            $("#media_full_description").find(".delete").unbind('click').click(function () {
                $(this).closest('.media_full_description').remove();
                $(".arrow:visible").hide();
            });
        }
    });



}