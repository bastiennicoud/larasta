/**
 * Created by antonio.giordano on 10.01.2018.
 */

function editMode() {
f = $("#insert")
    f.removeClass("hidden");
    $("#edit").addClass("hidden");
}

function endModif(){
    $("entreprises").submit();
}