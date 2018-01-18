$(document).ready(function(){
    $("#check").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });


    var $checkboxes = $('input[type="checkbox"]');

    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $('#count-checked-checkboxes').text(countCheckedCheckboxes);

        
        
    });

    $("td input").click(function(event){
        tutu = $(this).attr("id")
        a =[];

            a.push(tutu);
            console.log(a);
            alert(tutu);
    });

 });