function DeleteSurvey(id) {
    var obj = {id:id}
    $.ajax({
        url: "remove",
        type: "POST",
        data:obj,
        dataType: "html",
        success: function( result ){
            // Load the content in to the page.
            $("#survey-list").empty();
            $("#survey-list").append( result );
        }
    });
}