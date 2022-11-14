<?php pageHeader($data);?>
    <div class="row justify-content-center" id="general-title">
        <div class="col-11">
            <h3><?= $data['page_title'];?></h3>
            <p>Las graficas que encontrará a continuación fueron construidas a partir de una encuesta realizada por la coordinación del proyecto
                curricular de Tecnología en Sistematización de Datos e Ingeniería en Telemática a sus estudiantes. En ella los estudiantes respondieron
                que tan capaces se sentian de entregar un determinado resultado de aprendizaje. Los resultados de apredizaje que fueron sujetos de la evaluación
                son aquellos que los docentes del proyecto curricular reportaron.
                <br><br>
                En el menú desplegable puede seleccionar el resultado de aprendizaje para evidenciar la información relacionada a él.
            </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="row" id="charts">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <form id="formSurveyStats" name="formSurveyStats">
                            
                        <div class="row">
                            <div class="col-10">
                                <label for="listLearningResultSurvey" class="col-form-label">Resultado de aprendizaje</label>
                                <select class="form-select" id="listLearningResultSurvey" name="listLearningResultSurvey"></select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-warning">Seleccionar</button>
                            </div>
                        </div>
                        </form>
                        <br><br>
                            <div id="survey"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php footer($data);?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
Highcharts.chart('survey', {

    title: {
        text: 'Comportamiento de Resultado de Aprendizaje vs Duración en la Tecnología<br><?= $data['chart_title'] ?>'
    },

    subtitle: {
        text: 'Fuente: Sistema de Información Chibchacum'
    },

    yAxis: {
        title: {
            text: 'Número de Estudiantes con este resultado de Aprendizaje'
        }
    },

    xAxis: {
        categories: ['Muy Malo', 'Mas o menos', 'Algo', 'Bien', 'Excelente'],
        accessibility: {
            description: 'Months of the year'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
        }
    },

    series: [{
        name: 'Semestre inicial',
        data: 
            [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 0)
                        echo $value['students'].",";
                    } ?>]
    }, {
        name: 'Un Semestre',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 1)
                        echo $value['students'].",";
                    } ?>]
    }, {
        name: 'Dos semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 2)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Tres semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 3)
                        echo $value['students'].",";
                    } ?>]
    }, {
        name: 'Cuatro semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 4)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Cinco semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 5)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Seis semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 6)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Siete semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 7)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Ocho semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 8)
                        echo $value['students'].",";
                    } ?>]
    }
    , {
        name: 'Nueve semestres',
        data: [<?php 
                    foreach($data['survey'] as $value){
                        if($value['semester'] == 9)
                        echo $value['students'].",";
                    } ?>]
    }
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>