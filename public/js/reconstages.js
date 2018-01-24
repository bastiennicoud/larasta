//------------------------------------------------------------
// Nicolas Henry
// SI-T1a
// reconstages.js
//------------------------------------------------------------

$(document).ready(function(){
    $("#check").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });


 });