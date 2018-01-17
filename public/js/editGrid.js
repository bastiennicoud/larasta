/**
 * Created by Julien.RICHOZ on 16.01.2018.
 */
$(document).ready(function() {
;
    //Show Button OK and hide button Edit
    $('.btn-detail').click(function(){  //add $el if you remplace with commented line

        //console.log($(this));
        $(this).addClass("hidden")
        $(this).next().removeClass("hidden")
        $(this).prev().show()
        $(this).prevAll().eq(2).hide()

        //console.log($el)
        //var el = $el.target.value;
        //  $("#" + el).show()
        // $("#" + el).prev().hide()
        // $(this).addClass("hidden")
        // $(this).next().removeClass("hidden")
        // console.log($(this));
    });

    //Save Data, hide button OK and show button Edit
    $('.btn-success').click(function(){   //add $el if you remplace with commented line//add $el if you remplace with commented line
        var newValue = $(this).prevAll().eq(1)["0"].value
        var field =$(this).prevAll().eq(3)["0"].title
        var id=$(this)["0"].value;

        console.log("id = "+id+"\nfield = "+field+"\nNewValue = "+newValue)

        $(this).addClass("hidden")
        $(this).prev().removeClass("hidden")
        $(this).prevAll().eq(3).show()
        $(this).prevAll().eq(1).hide()
        switch(field){
            case 'criteriaName':
                //editCriteria(field, id, newValue)
            break;

            case 'criteriaDetails':

            break;

            case 'sectionName':

            break;

        }


        //console.log($el)
        //var el = $el.target.value;
        //var newValue = $("#" + el)["0"].value;
        //$("#" + el).hide()
        //$("#" + el).prev().show()
        //$(this).addClass("hidden")
        //$(this).prev().removeClass("hidden")

        //Save new entity with ajax?
    });


    $('.btn-success').click(function(){
    });


})