var assignLearningResultTable;

document.addEventListener('DOMContentLoaded', function () {


    var dataFormRegister = document.querySelector("#formRegister");
    var dataFormReset = document.querySelector("#formResetPassword");


    dataFormRegister.onsubmit = function (e) {
        e.preventDefault();
        var userEmail = document.querySelector("#userEmail").value;
        var password = document.querySelector("#userPassword").value;
        var userPassword2 = document.querySelector("#userPassword2").value;

        if (password != userPassword2) {
            swal("Advertencia", "Las contraseñas no coinciden", "error");
            return false;
        }

        if (userEmail == "" || password == "" || userPassword2 == "") {
            swal("Advertencia", "Todos los campos son oblicatorios", "error");
            return false;
        }
        postPutExecution('ResolveQuiz/createUser', dataFormRegister, '#addQuizModal', formRegister);
    }

    dataFormReset.onsubmit = function (e) {
        e.preventDefault();
        var resetEmail = document.querySelector("#resetEmail").value;


        if (resetEmail == "") {
            swal("Advertencia", "Todos los campos son oblicatorios", "error");
            return false;
        }
        postPutExecution('ResolveQuiz/resetPassword', dataFormReset, '#resetPasswordModal', formResetPassword);
    }


});

function addQuizModal() {
    $('#registerModal').modal('show');
}

function addResetModal() {
    $('#resetPasswordModal').modal('show');
}

function postPutExecution(url, dataFormALR, modalName, formModal) {
    document.querySelector('#btnRegister').disabled = true;
    document.querySelector('#btnReset').disabled = true;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + url;
    let formData = new FormData(dataFormALR);

    request.open('POST', ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                $(modalName).modal("hide");
                formModal.reset();
                document.querySelector('#btnRegister').disabled = false;
                document.querySelector('#btnReset').disabled = false;
                swal(objData.title, objData.msg, "success");
                assignLearningResultTable.ajax.reload();
            } else {
                document.querySelector('#btnRegister').disabled = false;
                document.querySelector('#btnReset').disabled = false;
                swal("Error", objData.msg, "error");
            }
        }
    }
}


$('#formLoginQuiz').submit(function (event) {

    event.preventDefault();
    var email = $('#email').val();

    grecaptcha.ready(function () {
        grecaptcha.execute('6LfITyAjAAAAAIhE6Leitd7I_jwQ3H6Q-GCf4S9l', { action: 'login_quiz' }).then(function (token) {
            $('#formLoginQuiz').prepend('<input type="hidden" name="token" value="' + token + '">');
            $('#formLoginQuiz').prepend('<input type="hidden" name="action" value="login_quiz">');
            $('#formLoginQuiz').unbind('submit').submit();
        });;
    });
});

$('#formResetPass').submit(function (event) {

    event.preventDefault();

    var password = document.querySelector("#newpassword").value;
    var userPassword2 = document.querySelector("#repetpassword").value;

    if (password != userPassword2) {
        swal("Advertencia", "Las contraseñas no coinciden", "error");
        return false;
    }

    if (password == "" || userPassword2 == "") {
        swal("Advertencia", "Todos los campos son oblicatorios", "error");
        return false;
    }

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const product = urlParams.get('token')

    grecaptcha.ready(function () {
        grecaptcha.execute('6LfITyAjAAAAAIhE6Leitd7I_jwQ3H6Q-GCf4S9l', { action: 'reset_pass' }).then(function (token) {
            $('#formResetPass').prepend('<input type="hidden" name="token" value="' + token + '">');
            $('#formResetPass').prepend('<input type="hidden" name="action" value="reset_pass">');
            $('#formResetPass').prepend('<input type="hidden" name="data" value="' + product + '">');
            $('#formResetPass').unbind('submit').submit();
        });;
    });
});

function noBack() {
    history.go(1);
}