$(document).ready(function () {
    let answer = new Array();
    let required = new Array();
    $(".formQuiz").bind('submit', function (e) {
        e.preventDefault();
        let url = $(this).data("url")

        let i = 0, j = 0;
        $('.formQuiz  input, .formQuiz  select, .formQuiz  textarea').each(function (key, value) {
            if ($(this).attr('type') == "checkbox" && $(this).prop("checked")) {

                answer[i] = [$(this).attr('id'), $(this).val()];
                i++;
            }
            else if ($(this).attr('type') == "radio" && $(this).prop("checked")) {

                answer[i] = [$(this).attr('id'), $(this).val()];
                i++;
            }

            else if ($(this).val() != "" && $(this).attr('type') != "checkbox" && $(this).attr('type') != "radio") {

                answer[i] = [$(this).attr('id'), $(this).val()];
                i++;
            }


            if ($(this).attr('data-required') == "true") {

                required[j] = [$(this).attr('id')];
                j++;
            }
        });

        var isValid = FormIsValid();

        if (isValid) {
            jQuery.ajax({
                type: "POST",
                url: base_url    + "ResolveQuiz/saveQuiz/",
                dataType: "html",
                data: { "response": answer },
                success: function (result) {
                    location.reload();

                },                
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error", "Existio un error y las respuatas no fueron guardadas: "+thrownError, "error");
                }

            });
        }
        else {
            alert("Tiene campos obligatorios sin llenar");
        }
        e.preventDefault();
        return false;


    });

    function FormIsValid() {
        response = false;
        validate = true
        //console.log(required);
        required.forEach(element => {

            for (var arrayIndex in answer) {
                //console.log(answer[arrayIndex][0]);

                if (answer[arrayIndex][0] == element) {
                    //console.log("id: "+answer[arrayIndex][0]+" elemto: "+element)
                    response = true;
                    break;

                }
            }
            if (response) {
                response = false;
            }
            else {
                //console.log(element);
                validate = false;


            }
        });
        return validate;

    }

});

function noBack() {
    history.go(1);
}