$(document).ready(function(){
    $("#people_form").on("change", "input:checkbox", function(){
        $("#people_form").submit();
    });
    $("#people_inputName").blur(function(){
        $("#people_form").submit();
    });
});

