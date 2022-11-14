var assignLearningResultTable;

document.addEventListener('DOMContentLoaded', function(){
    $("#dominio").hide();
    assignLearningResultTable = $('#assignQuestionTable').DataTable({
        "aProcessing":true,
		"aServerSide":true,
        "ordering": true,
        "order": [[ 6, 'desc' ]],
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/ManagementQuestion/getQuestionResult",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"question"},
            {"data":"type"},
            {"data":"required"},
            {"data":"icon"},
            {"data":"domain", "className": "uniqueClassName" },
            {"data":"quizName"},
            {"data":"acciones"}
          
        ],
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 3
            }
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

    var dataFormAddQuestion= document.querySelector("#formAddQuestionResult");
    var dataFormEditQuestion = document.querySelector("#formUpdateQuestionResult");

    dataFormAddQuestion.onsubmit = function(e){
        e.preventDefault();
        var listQuiz = document.querySelector("#listQuiz").value;
        var questionName = document.querySelector("#questionName").value;
        var type = document.querySelector("#type").value;
       
        
        if(listQuiz == "" || questionName=="" || type=="" ){
            swal("Advertencia", "Existen campos vacios", "error");
            return false;
        }

        if (type=="checkbox" || type=="select" || type=="radio") {
            var domain = document.querySelector("#domain").value;
            if(domain == "" ){
                swal("Advertencia", "El campo dominio esta vacio", "error");
                return false;
            }
        }
        postPutExecution('ManagementQuestion/postQuestion', dataFormAddQuestion, '#addQuestionModal', formAddQuestionResult);
    }

    dataFormEditQuestion.onsubmit = function(e){
        e.preventDefault();
        var intCode = document.querySelector("#idQuestionId").value;
        var listQuiz = document.querySelector("#editListQuiz").value;
        var questionName = document.querySelector("#editQuestionName").value;
        var type = document.querySelector("#editType").value;
       
       
        
        if(listQuiz == "" || questionName=="" || type=="" ){
            swal("Advertencia", "Existen campos vacios", "error");
            return false;
        }
        

        if (type=="checkbox" || type=="select" || type=="radio") {
            var domain = document.querySelector("#editDomain").value;
            
            if(domain == "" ){
                swal("Advertencia", "El campo dominio esta vacio", "error");
                return false;
            }
        }
         postPutExecution('ManagementQuestion/putQuestion/' + intCode, dataFormEditQuestion, '#UpdateQuestionModal', formUpdateQuestionResult);
    }
});

function addQuestionModal(){
    getSelect("ManagementQuiz/getQuizSelect", "#listQuiz", 0);
    
    $('#addQuestionModal').modal('show');
}

function editQuestionModal(button){
    $("#editDominio").hide();
    let idAssignLearningResult = button.getAttribute('alr');
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'ManagementQuestion/getQuestionById/' + idAssignLearningResult;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                getSelect("ManagementQuiz/getQuizSelect", "#editListQuiz", objData.msg.idQuiz);
                document.querySelector("#idQuestionId").value = objData.msg.id;
                document.querySelector("#editIcon").value = objData.msg.icon;
                document.querySelector("#editQuestionName").value = objData.msg.question;
                document.querySelector("#editType").value = objData.msg.type;
                if (objData.msg.domain != undefined) {
                    document.querySelector("#editDomain").value = objData.msg.domain;
                    $("#editDominio").show();
                  }
                if(objData.msg.required==true){
                    document.getElementById("editRequired").checked = true;
                }else{
                    document.getElementById("editRequired").checked = false;
                }
               
                
            } else {
                swal("Error", objData.msg, "error");
            }
        } 
    }

    $('#UpdateQuestionModal').modal('show');
}

function getSelect(url, selector, code){
    let ajaxUrl = base_url+url;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector(selector).innerHTML = request.responseText;
            if(code != 0){
                document.querySelector(selector).value = code;
            }
            searchSelect(selector);
        }
    }
}

function showDomain(){
    let type= document.querySelector("#type").value;
    if(type=="checkbox" || type=="select" || type=="radio"){
        $("#dominio").show();
    }
    else{
        $("#dominio").hide();
    }
}

function showEditDomain(){
    let type= document.querySelector("#editType").value;
    if(type=="checkbox" || type=="select" || type=="radio"){
        $("#editDominio").show();
    }
    else{
        $("#editDominio").hide();
    }
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

function deleteQuestion(deleteButton){
    let code = deleteButton.getAttribute('lr');
    swal({
        title: "Eliminar pregunta",
        text: "¿Realmente quiere eliminar esta pregunta?",
        icon: "warning",
        buttons: {
            cancel: "¡No, cancelar!",
            confirm: "¡Si, eliminar!",
          },
        closeOnconfirm: false
    }).then(result => {
        if(result){
            deleteExecution('ManagementQuestion/deleteQuestion/'+ code);
        } else {
            swal("Cancelado", "La pregunta no se borro", "error");
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