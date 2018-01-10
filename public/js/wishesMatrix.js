//------------------------------------------------------------
// Benjamin Delacombaz
// version 0.3
// WishesMatrixController
// Created 18.12.2017
// Last edit 09.01.2017 by Benjamin Delacombaz
//------------------------------------------------------------

$(document).ready(function(){
    // When the table is load add item already clicked in a array
    /*$('#WishesMatrixTable').load(function(){
        var items=[]
    });*/

    $('.clickableCase').click(function(){
        var items=[];
        var col = $(this).parent().children().index($(this)) + 1;
        $('tr td:nth-child(' + col + ')').each( function(){
            //add item to array
            items.push( $(this).text().replace(/\s/g, '') );       
         });
        
         if($(this).text().replace(/\s/g, '') != "")
         {
             console.log("Je ne suis pas vide")
             console.log("+++" + $(this).text() + "+++");
            recalculateRank(col, $(this).text().replace(/\s/g, ''));
            $(this).text("");
         }else
         {
             console.log("Je suis vide")
            // Else if for limit 3 choices
            if(jQuery.inArray("1",items) == -1)
            {
                $(this).text(1)
            }else if(jQuery.inArray("2",items) == -1)
            {
                $(this).text(2)
            }else if(jQuery.inArray("3",items) == -1)
            {
                $(this).text(3)
            }
         }

    });

    // Recalculate rank
    function recalculateRank(col, nbRemove)
    {
        // Do that for each row in col
        $('tr td:nth-child(' + col + ')').each( function(){
            //add item to array
            if($(this).text().replace(/\s/g, '') != "")
            {
                switch(nbRemove)
                {
                    case "1":
                    // Change 2 to 1 and 3 to 2
                        if($(this).text().replace(/\s/g, '') == "2")
                        {
                            $(this).text("1");
                        }
                        if($(this).text().replace(/\s/g, '') == "3")
                        {
                            $(this).text("2"); 
                        }
                        break;
                    case "2":
                        // Change 3 to 2
                        if($(this).text().replace(/\s/g, '') == "3")
                        {
                            $(this).text("2"); 
                        }
                        break;
                    default:
                        // Do nothing
                }
            }     
         });
    }
 });