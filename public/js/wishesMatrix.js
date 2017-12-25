$(document).ready(function(){
    $('.clickableCase').click(function(){
        var items=[];
        var col = $(this).parent().children().index($(this)) + 1;
        $('tr td:nth-child(' + col + ')').each( function(){
            //add item to array
            items.push( $(this).text() );       
         });
        
         if($(this).text() != "")
         {
            $(this).text("");
         }else
         {
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
 });