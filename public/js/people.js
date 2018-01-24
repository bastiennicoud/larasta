// Davide Carboni
// Functions for people page

//////////////////////////////////////////////////////////////////////////////////////////
///////// On load
//////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){

    // Submit the form when filters changed
    $("#people_form").on("change", "input:checkbox", function(){
        $("#people_form").submit();
    });

    // Submit the form when the name changed
    $("#people_inputName").blur(function(){
        $("#people_form").submit();
    });

    // Remove selected input field from the form
    $('#contact-modify').on("click", ".btn-danger", function () {
        event.preventDefault();
        $(this).parent().parent().remove();
    });

    // Add a new field from the form in the selected container
    $('#contact-modify').on("click", ".btn-success", function () {
        var Value = $(this).attr("id");

        // Find the correct value to put in the placeholder attribute
        if (Value.includes("mail")) {
            placeValue = "example@domaine.ch";
            placeTitle = "Mail";
        }
        else {
            placeValue = "numero téléphone suisse";
            placeTitle = "Tel:";
        }

        // Append a new rew a the end of the section
        $('#' + Value + 'Content' ).append('' +
            '<div class="row modal-row">\n' +
            '<div class="col-lg-2 col-md-2">'+ placeTitle+'</div>\n' +
            '<div class="col-lg-9 col-md-9"><input type="text" class="form-control toValidate"  name = "' + Value + '[]" value="" placeholder="' + placeValue +'" /></div>\n' +
            '<div class="col-lg-1 col-md-1"><button type="button" class="btn btn-success glyphicon glyphicon-plus" disabled="disabled" id="' + Value + '"></button></div>\n' +
            '</div>' +
            '');

        // Change Button Type
        $(this).removeClass('btn-success').addClass('btn-danger');
        $(this).removeClass('glyphicon-plus').addClass('glyphicon-minus');
    });

    // Check the field for mails and phones number in keyup event
    $('#contact-modify').on("keyup", ".toValidate", function () {
       checkfiled(this);
    });

    // Check the field for mails and phones number in change event
    $('#contact-modify').on("change", ".toValidate", function () {
        checkfiled(this);
    });

    // Check All fields for mails and phones number in keyup event
    $('#contact-modify').on("change", ".toValidate", function () {
        checkfileds();
    });

    // Check All fields for mails and phones number in change event
    $('#contact-modify').on("keyup", ".toValidate", function () {
        checkfileds();
    });

    // Check All fields for mails and phones number in change event
    $('#contact-modify').on("load", ".toValidate", function () {
        checkfileds();
    });

    // Check the first control in the form
    checkfileds();
});

//////////////////////////////////////////////////////////////////////////////////////////
///////// Functions
//////////////////////////////////////////////////////////////////////////////////////////

/**
 * Validate mail expression
 *
 * @param email
 * @returns {boolean}
 */
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/**
 * Validate phone number Swiss expression
 *
 * @param phone
 * @returns {boolean}
 */
function validatePhone(phone) {
    var re = /^(0041|041|\+41|\+\+41|41)?(0|\(0\))?([1-9]\d{1})(\d{3})(\d{2})(\d{2})$/;
    return re.test(phone);
}

/**
 * Check the value in the field that math the regEX
 *
 * @param attr
 * @param value
 * @returns {*}
 */
function verifyAllFiledValue(attr, value)
{
    if (attr.includes("mail"))
        res = validateEmail(value) || (value == "");
    else
        res = validatePhone(value) || (value == "");

    return res;
}

/**
 * Check if the value is valable to enable the button
 *
 * @param elm
 * @returns {boolean}
 */
function checkfiled(elm)
{
    var attrValue = $(elm).attr("name");
    var value = $(elm).val();

    // Find the correct value to put in the placeholder
    if (attrValue.includes("mail"))
        res = validateEmail(value);
    else
        res = validatePhone(value);

    // Enabled the button status in the selected field
    if (res) {
        // If the field have a button disable is not necessary to be disabled so return
        if (!$(elm).parent().parent().children('div').children('button').attr("class").includes("btn-danger"))
            $(elm).parent().parent().children('div').children('button').removeAttr("disabled");
        // If the field is valide fill change the text color in black
        $(elm).parent().parent().children('div').children('input').css("color", "black");
        return true;
    }
     else {
        // If the field have a button disable is not necessary to be disabled so return
        if (!$(elm).parent().parent().children('div').children('button').attr("class").includes("btn-danger"))
            $(elm).parent().parent().children('div').children('button').attr('disabled','disabled');
        // If the field is not valide fill change the text color in red
        $(elm).parent().parent().children('div').children('input').css("color", "red");
        return false;
    }
}

/**
 * Verify all fields and enabled the button to submit the form
 */
function checkfileds()
{
    var res = [];

    // Check if all filds has valide and store true or false for each elements in to res array
    $( ".toValidate" ).each(function() {

        value = $(this ).val();
        attr = $(this).attr("name");
        res.push(verifyAllFiledValue(attr, value));
        checkfiled(this);
    });

    // Check if res array contiens one fild that is not valide(false)
    if (res.indexOf(false) == -1)
    {
        $("#addNewPeople").removeAttr("disabled");
    }
    else
    {
        $("#addNewPeople").attr('disabled','disabled');
    }


}