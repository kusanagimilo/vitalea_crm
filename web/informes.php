<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';?>
<script type="text/javascript">
	$(document).ready(function() {

        $('select').select2();
	      Highcharts.chart('container', {

    title: {
        text: 'Solar Employment Growth by Sector, 2010-2016'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
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
            pointStart: 2010
        }
    },

    series: [{
        name: 'Installation',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: 'Manufacturing',
        data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
    }, {
        name: 'Sales & Distribution',
        data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
    }, {
        name: 'Project Development',
        data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
    }, {
        name: 'Other',
        data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
    }],

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

          var chart = Highcharts.chart('container_dos', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Highcharts responsive chart'
    },

    subtitle: {
        text: 'Resize the frame or click buttons to change appearance'
    },

    legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
    },

    xAxis: {
        categories: ['Apples', 'Oranges', 'Bananas'],
        labels: {
            x: -10
        }
    },

    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Amount'
        }
    },

    series: [{
        name: 'Christmas Eve',
        data: [1, 4, 3]
    }, {
        name: 'Christmas Day before dinner',
        data: [6, 4, 2]
    }, {
        name: 'Christmas Day after dinner',
        data: [8, 4, 3]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                },
                yAxis: {
                    labels: {
                        align: 'left',
                        x: 0,
                        y: -5
                    },
                    title: {
                        text: null
                    }
                },
                subtitle: {
                    text: null
                },
                credits: {
                    enabled: false
                }
            }
        }]
    }
});

//* Pie*//


Highcharts.chart('container_principal', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in January, 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'Internet Explorer',
            y: 11.84
        }, {
            name: 'Firefox',
            y: 10.85
        }, {
            name: 'Edge',
            y: 4.67
        }, {
            name: 'Safari',
            y: 4.18
        }, {
            name: 'Sogou Explorer',
            y: 1.64
        }, {
            name: 'Opera',
            y: 1.6
        }, {
            name: 'QQ',
            y: 1.2
        }, {
            name: 'Other',
            y: 2.61
        }]
    }]
});

Highcharts.chart('container_tres', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Historic World Population by Region'
    },
    subtitle: {
        text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    },
    xAxis: {
        categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Year 1800',
        data: [107, 31, 635, 203, 2]
    }, {
        name: 'Year 1900',
        data: [133, 156, 947, 408, 6]
    }, {
        name: 'Year 2000',
        data: [814, 841, 3714, 727, 31]
    }, {
        name: 'Year 2016',
        data: [1216, 1001, 4436, 738, 40]
    }]
});

var chart = Highcharts.chart('container_cuatro', {

    title: {
        text: 'Chart.update'
    },

    subtitle: {
        text: 'Plain'
    },

    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
        showInLegend: false
    }]

});


$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});

		 
});

</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<style type="text/css">
    #container ,#container_tres {
    height: 300px;width: 50%;
    float: left;
    padding: 20px;
    background-color: #F6F8FA;
}

 #container_dos,#container_cuatro {
    height: 300px;
    width: 50%;
    float: right;
    padding: 20px;
    background-color: #F6F8FA;
}
  #container_principal{
    /* F6F8FA*/
    background-color: #F6F8FA;
     padding: 20px;
  }
</style>
<body style="background-color: #F6F8FA">
	
	
	
    <nav class="navbar navbar-default">
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<ol class="breadcrumb">
	<li><a  href="#" onclick="history.back()" class="nounderline"  title="Volver atras"><img src="images/atras.png"></a></li>
	<li><a href="#" onclick="history.back()" title="Inicio" style=" color: #337ab7;
    text-decoration: none; font-family: 'Open Sans', sans-serif; font-size:15px;
    line-height: 30px;">Inicio</a></li>
	<li class="active" style="font-family: 'Open Sans', sans-serif; font-size:15px;">Seguimiento</li>
	</ol></div>   
	
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
          <img src="images/graficos.png">
      </a>
    </div>
    <ul class="nav navbar-nav">
       <li><a href="reportes/reportes.php"><img src="images/icon_report.png" style="height:24px; width:24px;"><b>Reportes digiturno</b></a></li>
      <li><a href="tablas_informe.php"><img src="images/tablas.png" style="height:24px; width:24px;"><b>Tablas</b></a></li>
      <li><a href="reportes/reportes_cotizaciones.php"><img src="images/cotizacion.png"><b>Cotizaciones</b></a></li>
      <li><a href="#"> <img src="images/seguimiento_chart.png"><b>Seguimientos </b></a></li>
      <li><a href="#"><img src="images/venta_chart.png"> <b>Ventas</b></a></li>
    </ul>
  </div>
</nav>

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   

                    <div class="row pad-top" style="background-color: white;">
                      
                       
                            <div id="examenes" style="padding: 20px;">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 20px;">
                                    <label>Filtros de busqueda</label>
                                    <br>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <label> <img src="images/agregar-usuario.png"> Seleccione usuario(s)</label>
                                        <select class="mdb-select md-form colorful-select dropdown-primary" multiple searchable="Search here.." style="width: 100%">
                                            <?php 
                                                for ($i=1000; $i < 1020 ; $i++) { ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php }?>
                                        </select>
                                    
                                    
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label> <img src="images/fecha.png"> Fecha Inicial</label>
                                            <input name="fecha_inicial" type="date" class="form-control" placeholder="Fecha Inicial">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label> <img src="images/fecha.png"> Seleccione Fecha Final</label>
                                            <input name="fecha_final" type="date" class="form-control" placeholder="Fecha Final">
                                        </div>

                                    </div>
                                </div>

                                <div id="container_principal"></div> 

                            	<div id="container"></div>  

                                <div id="container_dos"></div>

                                <div id="container_tres"></div>
                                <div id="container_cuatro"></div>

                                   

                            	

                            </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>                     





<?php require_once '../include/footer.php'; ?>

</body>

</html>