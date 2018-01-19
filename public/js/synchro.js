$(".selectAdd").click(function(event){
    event.preventDefault();
    if ($(".selectAdd").text() == "Uncheck All")
    {
        $("input[name='addCheck[]']").each(function(){
            $(this).prop('checked', false);
        })
        $(".selectAdd").html("Check All");
    }
    else
    {
        $("input[name='addCheck[]']").each(function(){
            $(this).prop('checked', true);
        })
        $(".selectAdd").html("Uncheck All");
    }
})

$(".selectDelete").click(function(event){
    event.preventDefault();
    if ($(".selectDelete").text() == "Uncheck All")
    {
        $("input[name='addCheck[]']").each(function(){
            $(this).prop('checked', false);
        })
        $(".selectDelete").html("Check All");
    }
    else
    {
        $("input[name='addCheck[]']").each(function(){
            $(this).prop('checked', true);
        })
        $(".selectDelete").html("Uncheck All");
    }
})