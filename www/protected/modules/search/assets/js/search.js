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