/**
 * Created by antonio.giordano on 15.01.2018.
 */

function edit() {

    $("#view").addClass("hidden");
    $("#edit").addClass("hidden");
    $("#save").removeClass("hidden");


}

function cancel() {
    $("#view").removeClass("hidden");
    $("#edit").removeClass("hidden");
    $("#save").addClass("hidden");
}