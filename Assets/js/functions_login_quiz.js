var assignLearningResultTable;

document.addEventListener('DOMContentLoaded', function(){


    var dataFormRegister = document.querySelector("#formRegister");
    var dataFormLogin = document.querySelector("#formRegister");
   

    dataFormRegister.onsubmit = function(e){
        e.preventDefault();
        var userEmail = document.querySelector("#userEmail").value;
        var password = document.querySelector("#userPassword").value;
        var userPassword2 = document.querySelector("#userPassword2").value;

        if (password != userPassword2 ) {
            swal("Advertencia", "Las contraseñas no coinciden", "error");
            return false;
        }
       
        if(userEmail == "" || password=="" || userPassword2=="" ){
            swal("Advertencia", "Todos los campos son oblicatorios", "error");
            return false;
        }
        postPutExecution('ResolveQuiz/createUser', dataFormRegister, '#addQuizModal', formRegister);
    }

   

  
});

function addQuizModal(){
    $('#registerModal').modal('show');
}

function editQuizModal(button){
    let idAssignLearningResult = button.getAttribute('alr');
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'ManagementQuiz/getQuizById/' + idAssignLearningResult;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
               
                if(objData.msg.active==true){
                    document.getElementById("editActive").checked = true;
                }else{
                    document.getElementById("editActive").checked = false;
                }
                document.querySelector("#editQuizName").value = objData.msg.quizName;
                document.querySelector("#idQuizId").value = objData.msg.id;
               
                
              
            } else {
                swal("Error", objData.msg, "error");
            }
        } 
    }

    $('#updateQuizModal').modal('show');
}

function postPutExecution(url, dataFormALR, modalName, formModal){
    document.querySelector('#btnRegister').disabled = true;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+url;
    let formData = new FormData(dataFormALR);

    request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    $(modalName).modal("hide");
                    formModal.reset();
                    document.querySelector('#btnRegister').disabled = false;
                    swal("Usuario Creado", objData.msg, "success");
                    assignLearningResultTable.ajax.reload();
                } else {
                    document.querySelector('#btnRegister').disabled = false;
                    swal("Error", objData.msg, "error");
                }
            }
        }
}

function deleteExecution(url){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+url;
    request.open('POST', ajaxUrl, true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    swal("¡Eliminado!", objData.msg, "success");
                    assignLearningResultTable.ajax.reload();
                } else {
                    swal("Cancelado", objData.msg, "error");
                }
            }
        }
}

$('#formLoginQuiz').submit(function(event) {
    
    event.preventDefault();
    var email = $('#email').val();

    grecaptcha.ready(function() {
        grecaptcha.execute('6LfITyAjAAAAAIhE6Leitd7I_jwQ3H6Q-GCf4S9l', {action: 'login_quiz'}).then(function(token) {
            $('#formLoginQuiz').prepend('<input type="hidden" name="token" value="' + token + '">');
            $('#formLoginQuiz').prepend('<input type="hidden" name="action" value="login_quiz">');
            $('#formLoginQuiz').unbind('submit').submit();
        });;
    });
});

function noBack(){
    history.go(1);
}