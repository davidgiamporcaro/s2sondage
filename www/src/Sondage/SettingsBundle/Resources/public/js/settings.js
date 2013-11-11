function DeleteSlideshowPicture(id) {
    var obj = {id:id}
    $.ajax({
        url: "slideshowparameters/removepicture",
        type: "POST",
        data:obj,
        dataType: "html",
        success: function( result ){
            // Load the content in to the page.
            $("#slideshow-pictures-list").empty();
            $("#slideshow-pictures-list").append( result );
        }
    });
}