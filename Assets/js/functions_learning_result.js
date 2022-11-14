var totalPageGeneral;
function viewMore(button){
    let idLearningResult = button.getAttribute('lr');
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'LearningResult/getLearningResultById/' + idLearningResult;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector("#titleLRModal").innerHTML = objData.msg.descripcion;
                document.querySelector("#descriptionLRModal").innerHTML = objData.msg.detalle;
            } else {
                swal("Error", objData.msg, "error");
            }
        } 
    }
    $('#learningResultModal').modal('show');
}

$(searchData(""));
$("#bottomPagination").html(htmlPaginationCode());
$(document.querySelector("#btn-next").setAttribute("pageNumber", 1));
$(document.querySelector("#btn-prev").setAttribute("pageNumber", 1));
$(document.getElementById("0").className = "page-item active");

function searchData(query){
    $.ajax({
        url: " "+base_url+"LearningResult/SearchBar",
        type: 'POST',
        dataType: 'html',
        data: {query: query},
    })
    .done(function(response){
        $("#show-cards").html(response);
    })
    .fail(function(){
        console.log("Error searching data");
    })
}

$(document).on('keyup', '#inputSearch', function(){
    let value = $(this).val();
    if(value != ""){
        searchData(value);
        $("#bottomPagination").html("");
    } else {
        searchData("");
        $("#bottomPagination").html(htmlPaginationCode());
        $(document.getElementById("0").className = "page-item active");
        document.querySelector("#btn-next").setAttribute("pageNumber", 1);
    }
});

function changePage(button){
    let pageNumber = button.getAttribute('pageNumber');
    $.ajax({
        url: " "+base_url+"LearningResult/getLearningResult",
        type: 'POST',
        dataType: 'html',
        data: {pageNumber: pageNumber},
    })
    .done(function(response){
        $("#show-cards").html(response);
        paginationPrevious(pageNumber);
        paginationCurrent(pageNumber);
        paginationNext(pageNumber);         
    })
    .fail(function(){
        console.log("Error searching data");
    })
}

function paginationPrevious(pageNumber){
    if(pageNumber >= 1){ 
        document.querySelector("#btn-prev").setAttribute("pageNumber", parseInt(pageNumber)-1);
        document.getElementById("li-prev").className = "page-item";
    } else{
        document.querySelector("#btn-prev").setAttribute("pageNumber", "");
        document.getElementById("li-prev").className = "page-item disabled";
    }
}

function paginationCurrent(pageNumber){
    for(i = 0; i<=totalPageGeneral; i++){
        document.getElementById(i).className = "page-item";
    }
    document.getElementById(pageNumber).className = "page-item active";
}

function paginationNext(pageNumber){
    if((totalPageGeneral-1) >= pageNumber){ 
        document.querySelector("#btn-next").setAttribute("pageNumber", parseInt(pageNumber)+1);
        document.getElementById("li-next").className = "page-item";
    } else{
        document.querySelector("#btn-next").setAttribute("pageNumber", "");
        document.getElementById("li-next").className = "page-item disabled";
    }
}

function htmlPaginationCode(){
    text = '<ul class="pagination justify-content-end">'+
    '<li class="page-item disabled" id="li-prev">'+
        '<button id="btn-prev" class="page-link" onclick=changePage(this) pageNumber="">Anterior</button>'+
    '</li>';

    for(let i=1; i<=totalPageGeneral+1; i++){
        text += '<li class="page-item" id="'+(i-1)+'">'+
                    '<button class="page-link" id="btn-current" onclick=changePage(this) pageNumber="'+(i-1)+'">'+i+'</button>'+
                '</li>';
    }
    text += '<li class="page-item" id="li-next">'+
            '<button id="btn-next" class="page-link" onclick=changePage(this) pageNumber="">Siguiente</button>'+
            '</li>'+
        '</ul>';
    return text;
}