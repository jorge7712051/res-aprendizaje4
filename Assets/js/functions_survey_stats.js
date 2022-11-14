var dataSurveyStat

document.addEventListener('DOMContentLoaded', function(){
    var dataFormSurveyStats = document.querySelector("#formSurveyStats");
    getSelectSurvey("LearningResult/getLearningResultSelect", "#listLearningResultSurvey", 0);

    dataFormSurveyStats.onsubmit = function(e){
        e.preventDefault();
        var intLearningResult = document.querySelector("#listLearningResultSurvey").value;
        window.location.href= base_url+'SurveyStats/SurveyStats/'+intLearningResult;
    }
});

function getSelectSurvey(url, selector, code){
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

function searchSelect(selector){
    let selectBoxElement = document.querySelector(selector);
    dselect(selectBoxElement, {
        search: true
    });
}