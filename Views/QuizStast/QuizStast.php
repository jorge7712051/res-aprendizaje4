<?php pageHeader($data);?>
    <div class="row justify-content-center" id="general-title">
        <div class="col-11">
            <h3><?= $data['page_title'];?></h3>
            <p>Para el análisis cuantitativo solo se tendrán presente las preguntas cerradas, para poder definir un conjunto especifico de datos.
            </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11">
        

            <div class="row" id="charts">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="answers"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php footer($data);?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/funnel3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>




<script>
      Highcharts.setOptions({
        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.color(color).brighten(-0.3).get('rgb')] 
                ]
            };
        })
    });
    // Create the chart
    Highcharts.chart('answers', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: '<?php echo $data["quiz_name"]  ?>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total conteo de respuesta'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
           
            pointFormat: '<span style="color:{point.color}">{point.ans}</span>: <b>{point.y}</b> de '+  <?php echo $data["quiz_total"] ?>+' encuestado(s)<br/>'
        },

        series: [
            {
                name: "Resultados de aprendizaje",
                colorByPoint: true,
                data: [
                    <?php foreach($data['quiz_result'] as $value){
                        echo "{name:'".$value['question']."',y:".$value['total'].", ans:'".$value['answer']."', drilldown: '".$value['id']."'},";
                    } ?>
                ]
            }
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [
                    <?php foreach($data['response'] as $value){
                        echo "{name:'".$value['id']."',id:'".$value['id']."', data:[";
                          foreach($data['response'] as $value2){
                            if ($value['id']== $value2['id']) {
                                echo "['".$value2['answer']."',".$value2['total']."],";
                            }
                           
                          }
                           
                        
                        echo "]},";
                                          
                    } ?>
            ]
        }
    
    });
</script>
<script>
  // Create the chart total response 
  Highcharts.chart('date-response', {
    chart: {
        type: 'spline',
        events: {
      load: function() {
        var series = this.series;
        
        for (let i = 0; i < series.length; i++) {
        	let newData = []
          for (let j = 0; j < series[i].data.length; j++) {
            newData.push({x: new Date(series[i].data[j].name).getTime(), y: series[i].data[j].y});
          }
          this.series[i].update({
            data: newData
          }, false);
        }
        this.redraw();
      }
    }
  
    },
   
   
    xAxis: {
    type: 'datetime',
    dateTimeLabelFormats: { // don't display the dummy year
      day: '%e. %b',
      hour: '%H:%M',
      year: '%Y',
      millisecond: 'millisecond'
    },
    labels: {
      format: '{value:%Y-%m-%d}'
    },
    title: {
      text: 'Date'
    }
  },

        series: [
            {
                
                data: [
                    <?php foreach($data['date_response'] as $value){
                        echo "['2022-11-27',2],['2022-11-28',3]";
                    } ?>
                ]
            }
        ]
    
    });



</script>

   