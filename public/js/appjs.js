$(document).ready(function () {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    $(".willvanish").fadeTo(2000, 500).slideUp(500, function(){
        $(".willvanish").slideUp(500);
    });
});