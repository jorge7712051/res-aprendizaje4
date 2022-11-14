var assignLearningResultTable;

document.addEventListener('DOMContentLoaded', function(){
    assignLearningResultTable = $('#assignQuizTable').DataTable({
        "aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/ManagementQuiz/getQuizResult",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"quizName"},
            {"data":"active"},
            {"data":"acciones"}
          
        ],
        dom: 'lBfrtip',
        buttons: [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-warning"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10
    });

    var dataFormAddAssignQuiz = document.querySelector("#formAddQuizResult");
    var dataFormEditQuiz = document.querySelector("#formUpdateQuizResult");

    dataFormAddAssignQuiz.onsubmit = function(e){
        e.preventDefault();
        var active = document.querySelector("#active").value;
        var quizName = document.querySelector("#quizName").value;
        
        if(quizName == ""){
            swal("Advertencia", "Todos los campos son oblicatorios", "error");
            return false;
        }
        postPutExecution('ManagementQuiz/postQuiz', dataFormAddAssignQuiz, '#addQuizModal', formAddQuizResult);
    }

    dataFormEditQuiz.onsubmit = function(e){
        e.preventDefault();
        var intCode = document.querySelector("#idQuizId").value;
        var quizName = document.querySelector("#editQuizName").value;
     
        if(intCode == "" || quizName == ""){
            swal("Advertencia", "Todos los campos son oblicatorios", "error");
            return false;
        }
        postPutExecution('ManagementQuiz/putQuiz/' + intCode, dataFormEditQuiz, '#updateQuizModal', formUpdateQuizResult);
    }
});

function addQuizModal(){
    $('#addQuizModal').modal('show');
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
                    swal("Encuesta egresados", objData.msg, "success");
                    assignLearningResultTable.ajax.reload();
                } else {
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

function deleteAssignLearningResult(deleteButton){
    let code = deleteButton.getAttribute('alr');
    swal({
        title: "Eliminar asignación de resultado de aprendizaje",
        text: "¿Realmente quiere eliminar la asignación?",
        icon: "warning",
        buttons: {
            cancel: "¡No, cancelar!",
            confirm: "¡Si, eliminar!",
          },
        closeOnconfirm: false
    }).then(result => {
        if(result){
            deleteExecution('EditAssignLearningResult/deleteAssignLearningResult/'+ code);
        } else {
            swal("Cancelado", "El resultado de aprendizaje esta ha salvo", "error");
        }
        
    });
}



function searchSelect(selector){
    let selectBoxElement = document.querySelector(selector);
    dselect(selectBoxElement, {
        search: true
    });
}

function noBack(){
    history.go(1);
}