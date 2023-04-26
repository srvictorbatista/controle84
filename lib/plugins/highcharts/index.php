<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Highcharts Examples</title>
        <style>
            * {
                font-family: sans-serif;
            }
            ul.nav > li > div {
                font-size: 1.5em;
                font-weight: bold;
                margin: 1em 0 0.3em 0;
            }
            ul.nav > li {
                list-style: none;
                display: black
            }
            div > ul > li {
                padding-bottom: 0.5em;
            }
            ul ul {
                list-style-type: initial;
                padding-left: 1.25em;
                font-size: 1.15em;
            }
            li a {
                text-decoration: none;
                color: #6065c8;
            }
            li a:hover {
                text-decoration: underline;
            }
        </style>


        <STYLE>
            .highcharts-figure,
            .highcharts-data-table table {
                width: 100%;
                min-width: 360px;
                max-width: 1850px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #ebebeb;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }

            #button-bar {
                min-width: 310px;
                max-width: 800px;
                margin: 0 auto;
            }

        </STYLE>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    </head>
    <body>



<figure class="highcharts-figure">
    <div id="container1"></div>
    <p class="highcharts-description">
        Gráfico de linha básico mostrando tendências em um conjunto de dados. 
        Este gráfico inclui o módulo de dados (<code>series-label</code>), que 
        adiciona um rótulo a cada linha para melhorar a legibilidade.
    </p>
</figure>



<div id="button-bar">
    <button id="small">Small</button>
    <button id="large">Large</button>
    <button id="auto">Auto</button>
</div>
















<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        This chart shows how data labels can be added to the data series. This
        can increase readability and comprehension for small datasets.
    </p>
</figure> 






<SCRIPT>
var chart = Highcharts.chart('container1', {

lang:{
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    loading: ['Atualizando o gráfico...aguarde'],
    contextButtonTitle: 'Exportar gráfico',
    decimalPoint: ',',
    thousandsSep: '.',
    downloadJPEG: 'Baixar imagem JPEG',
    downloadPDF: 'Baixar arquivo PDF',
    downloadPNG: 'Baixar imagem PNG',
    downloadSVG: 'Baixar vetor SVG',
    downloadCSV: 'Baixar arquivo CSV',
    downloadXLS: 'Baixar arquivo XLS',
    printChart: 'Imprimir gráfico',
    rangeSelectorFrom: 'De',
    rangeSelectorTo: 'Para',
    rangeSelectorZoom: 'Zoom',
    resetZoom: 'Limpar Zoom',
    resetZoomTitle: 'Voltar Zoom para nível 1:1',
    drillUpText: 'Voltar',
    exitFullscreen: 'Sair da tela cheia',
    viewFullscreen: 'Ver em tela cheia',
    viewData: 'Ver tabela',
    noData: 'Sem dados para visualizar',
    hideData: 'Esconder tabela'
},
credits:{enabled:false},
exporting:{enabled:false},



    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
        backgroundColor: {
            linearGradient: [0, 0, 0, 200],
            stops: [
                [0, '#2D343A'],
                [1, '#171B1E']
            ]
        },
    },



  subtitle: {
    text: '<span style="font-size:20px;font-weight:bold;color:#AAA;"> \
            Título Aqui \
            </span>',

    align: 'center',
  },

  yAxis: {
    title: {
      text: 'Fonte: <a href="#" target="_blank">CONTROLE84.com</a>'
    }
  },

  xAxis: {
    accessibility: {
      rangeDescription: 'Rótulo...'
    },
      categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  },

  legend: {
    enabled:false,
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    itemStyle: {
      font: '9pt Trebuchet MS, Verdana, sans-serif',
      color: '#999'
    },
    itemHoverStyle:{
      color: 'gray'
    }
  },

  plotOptions:{
    series: {
      label: {
        connectorAllowed: false
      },
      /*pointStart: 2023*/
      //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }
  },

  series: [{
    name: 'Valores Previstos R$',
    data: [43934.48, 48656, 65165, 81827, 112143, 142383, 171533, 165174, 155157, 161454, 154610]
  }, {
    name: 'Recebidos R$',
    data: [24916, 37941, 29742, 29851, 32490, 30282, 38121, 36885, 33726, 34243, 31050]
  }, {
    name: 'Sales & Distribution',
    data: [11744, 30000, 16005, 19771, 20185, 24377, 32147, 30912, 29243, 29213, 25663]
  }, {
    name: 'Operations & Maintenance',
    data: [null, null, null, null, null, null, null, null, 11164, 11218, 10077]
  }, {
    name: 'Other',
    data: [21908, 5548, 8105, 11248, 8989, 11816, 18274, 17300, 13053, 11906, 10073]
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
          verticalAlign: 'bottom',
        }
      }
    }],
  },

});

document.getElementById('small').addEventListener('click', function(){
    chart.setSize(400);
});

document.getElementById('large').addEventListener('click', function(){
    chart.setSize(900);
});

document.getElementById('auto').addEventListener('click', function(){
    chart.setSize(null);
});



///////////////////////////////////////////////////////////////////
// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
Highcharts.chart('container', {

lang:{
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    loading: ['Atualizando o gráfico...aguarde'],
    contextButtonTitle: 'Exportar gráfico',
    decimalPoint: ',',
    thousandsSep: '.',
    downloadJPEG: 'Baixar imagem JPEG',
    downloadPDF: 'Baixar arquivo PDF',
    downloadPNG: 'Baixar imagem PNG',
    downloadSVG: 'Baixar vetor SVG',
    downloadCSV: 'Baixar arquivo CSV',
    downloadXLS: 'Baixar arquivo XLS',
    printChart: 'Imprimir gráfico',
    rangeSelectorFrom: 'De',
    rangeSelectorTo: 'Para',
    rangeSelectorZoom: 'Zoom',
    resetZoom: 'Limpar Zoom',
    resetZoomTitle: 'Voltar Zoom para nível 1:1',
    drillUpText: 'Voltar',
    exitFullscreen: 'Sair da tela cheia',
    viewFullscreen: 'Ver em tela cheia',
    viewData: 'Ver tabela',
    noData: 'Sem dados para visualizar',
    hideData: 'Esconder tabela'
},
credits:{enabled:false},
exporting:{enabled:false},



    chart: {
        type: 'line',
        backgroundColor: {
            linearGradient: [0, 0, 0, 200],
            stops: [
                [0, '#2D343A'],
                [1, '#171B1E']
            ]
        },
    },

    title: {
        //text: 'Titulo aqui'

    },
    subtitle: {
        text: '<span style="font-size:20px;font-weight:bold;color:#AAA;"> \
            Título Aqui \
            </span>'
    },
    xAxis: {
        title: {
            text: 'Fonte: <a href="#" target="_blank">CONTROLE84.com</a> 2',
        },
        categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    },
    yAxis: {
        title: {
            text: 'Fonte: <a href="#" target="_blank">CONTROLE84.com</a>',
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true,
            },
            enableMouseTracking: true,
        },
    },
    series: [{
        name: 'Previsto',
        color: '#058DC7',
        data: [16.00, 18.2, 23.1, 27.9, 32.2, 36.4, 39.8, 38.4, 35.5, 29.2, 22.0, 17.8,               null]
    }, {
        name: 'Recebido',
        color: '#50B432',
        data: [2.9, 3.6, 0.6, 4.8, 10.2, 14.5, 17.6, 16.5, 12.0, 6.5, 2.0, 0.9,                      null]
    }]
});
///////////////////////////////////////////////////////////////////
</SCRIPT>





































    <h1>Highcharts Examples</h1>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sidebar d-md-block"><ul class="nav nav-sidebar">
    <li>
        <div class="" tabindex="0"><span>Line charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./line-basic/index.html">Basic line</a></li><li><a href="examples/./line-ajax/index.html">Ajax loaded data clickable points</a></li><li><a href="examples/./line-boost/index.html">Line chart with 500k points</a></li><li><a href="examples/./line-log-axis/index.html">Logarithmic axis</a></li><li><a href="examples/./spline-inverted/index.html">Spline with inverted axes</a></li><li><a href="examples/./spline-plot-bands/index.html">Spline with plot bands</a></li><li><a href="examples/./spline-symbols/index.html">Spline with symbols</a></li><li><a href="examples/./spline-irregular-time/index.html">Time data with irregular intervals</a></li><li><a href="examples/./line-time-series/index.html">Time series zoomable</a></li><li><a href="examples/./annotations/index.html">With annotations</a></li><li><a href="examples/./line-labels/index.html">With data labels</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Area charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./area-basic/index.html">Basic area</a></li><li><a href="examples/./arearange/index.html">Area range</a></li><li><a href="examples/./arearange-line/index.html">Area range and line</a></li><li><a href="examples/./area-missing/index.html">Area with missing points</a></li><li><a href="examples/./area-negative/index.html">Area with negative values</a></li><li><a href="examples/./areaspline/index.html">Area-spline</a></li><li><a href="examples/./area-inverted/index.html">Inverted axes</a></li><li><a href="examples/./area-stacked-percent/index.html">Percentage area</a></li><li><a href="examples/./sparkline/index.html">Sparkline charts</a></li><li><a href="examples/./area-stacked/index.html">Stacked area</a></li><li><a href="examples/./streamgraph/index.html">Streamgraph</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Column and bar charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./bar-race/index.html">Bar race</a></li><li><a href="examples/./column-basic/index.html">Basic column</a></li><li><a href="examples/./bar-basic/index.html">Basic bar</a></li><li><a href="examples/./bar-negative-stack/index.html">Bar with negative stack</a></li><li><a href="examples/./column-comparison/index.html">Column comparison</a></li><li><a href="examples/./columnrange/index.html">Column range</a></li><li><a href="examples/./column-drilldown/index.html">Column with drilldown</a></li><li><a href="examples/./column-negative/index.html">Column with negative values</a></li><li><a href="examples/./column-rotated-labels/index.html">Column with rotated labels</a></li><li><a href="examples/./column-parsed/index.html">Data defined in a HTML table</a></li><li><a href="examples/./column-placement/index.html">Fixed placement columns</a></li><li><a href="examples/./column-stacked-and-grouped/index.html">Stacked and grouped column</a></li><li><a href="examples/./bar-stacked/index.html">Stacked bar</a></li><li><a href="examples/./column-stacked/index.html">Stacked column</a></li><li><a href="examples/./column-stacked-percent/index.html">Stacked percentage column</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Pie charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./pie-basic/index.html">Pie chart</a></li><li><a href="examples/./pie-donut/index.html">Donut chart</a></li><li><a href="examples/./pie-drilldown/index.html">Pie with drilldown</a></li><li><a href="examples/./pie-gradient/index.html">Pie with gradient fill</a></li><li><a href="examples/./pie-legend/index.html">Pie with legend</a></li><li><a href="examples/./pie-monochrome/index.html">Pie with monochrome fill</a></li><li><a href="examples/./pie-semi-circle/index.html">Semi circle donut</a></li><li><a href="examples/./variable-radius-pie/index.html">Variable radius pie</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Scatter and bubble charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./scatter-jitter/index.html">Scatter plot with jitter</a></li><li><a href="examples/./bubble/index.html">Bubble chart</a></li><li><a href="examples/./scatter/index.html">Scatter plot</a></li><li><a href="examples/./bubble-3d/index.html">3D bubbles</a></li><li><a href="examples/./packed-bubble/index.html">Packed bubble chart</a></li><li><a href="examples/./scatter-boost/index.html">Scatter plot with 1 million points</a></li><li><a href="examples/./packed-bubble-split/index.html">Split Packed bubble chart</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Combinations</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./combo-timeline/index.html">Advanced timeline</a></li><li><a href="examples/./combo/index.html">Column line and pie</a></li><li><a href="examples/./combo-dual-axes/index.html">Dual axes line and column</a></li><li><a href="examples/./combo-meteogram/index.html">Meteogram</a></li><li><a href="examples/./combo-multi-axes/index.html">Multiple axes</a></li><li><a href="examples/./combo-regression/index.html">Scatter with regression line</a></li><li><a href="examples/./synchronized-charts/index.html">Synchronized charts</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Styled mode (CSS styling)</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./styled-mode-column/index.html">Styled mode column</a></li><li><a href="examples/./styled-mode-pie/index.html">Styled mode pie</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Accessible charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./accessible-line/index.html">Accessible line chart</a></li><li><a href="examples/./accessible-pie/index.html">Accessible pie chart</a></li><li><a href="examples/./advanced-accessible/index.html">Advanced accessible chart</a></li><li><a href="examples/./sonification/index.html">Sonification</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Dynamic charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./dynamic-click-to-add/index.html">Click to add a point</a></li><li><a href="examples/./live-data/index.html">Live data from dynamic CSV</a></li><li><a href="examples/./dynamic-master-detail/index.html">Master-detail chart</a></li><li><a href="examples/./responsive/index.html">Responsive chart</a></li><li><a href="examples/./dynamic-update/index.html">Spline updating each second</a></li><li><a href="examples/./chart-update/index.html">Update options after render</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>3D charts</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./3d-area-multiple/index.html">3D area chart</a></li><li><a href="examples/./3d-column-interactive/index.html">3D column</a></li><li><a href="examples/./3d-column-null-values/index.html">3D column with null and 0 values</a></li><li><a href="examples/./3d-column-stacking-grouping/index.html">3D column with stacking and grouping</a></li><li><a href="examples/./cylinder/index.html">3D cylinder</a></li><li><a href="examples/./3d-pie-donut/index.html">3D donut</a></li><li><a href="examples/./funnel3d/index.html">3D funnel</a></li><li><a href="examples/./3d-pie/index.html">3D pie</a></li><li><a href="examples/./pyramid3d/index.html">3D pyramid</a></li><li><a href="examples/./3d-scatter-draggable/index.html">3D scatter chart</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Gauges</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./gauge-activity/index.html">Activity gauge</a></li><li><a href="examples/./bullet-graph/index.html">Bullet graph</a></li><li><a href="examples/./gauge-clock/index.html">Clock</a></li><li><a href="examples/./gauge-speedometer/index.html">Gauge series</a></li><li><a href="examples/./gauge-dual/index.html">Gauge with dual axes</a></li><li><a href="examples/./gauge-solid/index.html">Solid gauge</a></li><li><a href="examples/./gauge-vu-meter/index.html">VU meter</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Heat and tree maps</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./heatmap/index.html">Heat map</a></li><li><a href="examples/./heatmap-canvas/index.html">Large heat map</a></li><li><a href="examples/./treemap-large-dataset/index.html">Large tree map</a></li><li><a href="examples/./honeycomb-usa/index.html">Tile map honeycomb</a></li><li><a href="examples/./treemap-coloraxis/index.html">Tree map with color axis</a></li><li><a href="examples/./treemap-with-levels/index.html">Tree map with levels</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>More chart types</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./arc-diagram/index.html">Arc Diagram</a></li><li><a href="examples/./bellcurve/index.html">Bell curve</a></li><li><a href="examples/./box-plot/index.html">Box plot</a></li><li><a href="examples/./column-pyramid/index.html">Column pyramid chart</a></li><li><a href="examples/./dependency-wheel/index.html">Dependency wheel</a></li><li><a href="examples/./dumbbell/index.html">Dumbbell series</a></li><li><a href="examples/./error-bar/index.html">Error bar</a></li><li><a href="examples/./euler-diagram/index.html">Euler diagram</a></li><li><a href="examples/./flame/index.html">Flame chart</a></li><li><a href="examples/./funnel/index.html">Funnel chart</a></li><li><a href="examples/./renderer/index.html">General drawing</a></li><li><a href="examples/./histogram/index.html">Histogram</a></li><li><a href="examples/./lollipop/index.html">Lollipop series</a></li><li><a href="examples/./network-graph/index.html">Network graph (force directed graph)</a></li><li><a href="examples/./organization-chart/index.html">Organization chart</a></li><li><a href="examples/./parallel-coordinates/index.html">Parallel coordinates</a></li><li><a href="examples/./pareto/index.html">Pareto chart</a></li><li><a href="examples/./parliament-chart/index.html">Parliament (item) chart</a></li><li><a href="examples/./polar/index.html">Polar (radar) chart</a></li><li><a href="examples/./polygon/index.html">Polygon series</a></li><li><a href="examples/./pyramid/index.html">Pyramid chart</a></li><li><a href="examples/./polar-radial-bar/index.html">Radial bar chart</a></li><li><a href="examples/./sankey-diagram/index.html">Sankey diagram</a></li><li><a href="examples/./polar-spider/index.html">Spiderweb</a></li><li><a href="examples/./sunburst/index.html">Sunburst</a></li><li><a href="examples/./timeline/index.html">Timeline</a></li><li><a href="examples/./variwide/index.html">Variwide</a></li><li><a href="examples/./vector-plot/index.html">Vector plot</a></li><li><a href="examples/./venn-diagram/index.html">Venn diagram</a></li><li><a href="examples/./waterfall/index.html">Waterfall</a></li><li><a href="examples/./windbarb-series/index.html">Wind barb</a></li><li><a href="examples/./polar-wind-rose/index.html">Wind rose</a></li><li><a href="examples/./wordcloud/index.html">Word cloud</a></li><li><a href="examples/./x-range/index.html">X-range series</a></li>
        </ul>
    </li>

    <li>
        <div class="" tabindex="0"><span>Highcharts Gantt</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./project-management/index.html">Project Management</a></li><li><a href="examples/./resource-management/index.html">Resource Management</a></li><li><a href="examples/./interactive-gantt/index.html">Interactive gantt</a></li><li><a href="examples/./subtasks/index.html">Subtasks</a></li><li><a href="examples/./progress-indicator/index.html">Progress indicator</a></li><li><a href="examples/./left-axis-table/index.html">Left axis as a table</a></li><li><a href="examples/./styled-mode/index.html">Styled mode</a></li><li><a href="examples/./inverted/index.html">Inverted chart</a></li><li><a href="examples/./custom-labels/index.html">Custom data labels with symbols</a></li><li><a href="examples/./download-pdf/index.html">Download PDF</a></li><li><a href="examples/./with-navigation/index.html">With navigation</a></li>
        </ul>
    </li>


    <li>
        <div class="" tabindex="0"><span>General</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./all-maps/index.html">Overview</a></li><li><a href="examples/./topojson-projection/index.html">Built in projection</a></li><li><a href="examples/./category-map/index.html">Categorized areas</a></li><li><a href="examples/./color-axis/index.html">Color axis and data labels</a></li><li><a href="examples/./data-class-two-ranges/index.html">Data classes and popup</a></li><li><a href="examples/./us-counties/index.html">Detailed map US counties</a></li><li><a href="examples/./distribution/index.html">Distribution map</a></li><li><a href="examples/./mapline-mappoint/index.html">GeoJSON with rivers and cities</a></li><li><a href="examples/./all-areas-as-null/index.html">Highlighted areas</a></li><li><a href="examples/./lightning/index.html">Lightning Map</a></li><li><a href="examples/./marker-clusters/index.html">Map with marker clusters</a></li><li><a href="examples/./map-pies/index.html">Map with overlaid pie charts</a></li><li><a href="examples/./pattern-fill-map/index.html">Map with pattern fills</a></li><li><a href="examples/./data-class-ranges/index.html">Multiple data classes</a></li><li><a href="examples/./flight-routes/index.html">Simple flight routes</a></li><li><a href="examples/./us-data-labels/index.html">Small US with data labels</a></li><li><a href="examples/./spider-map/index.html">Spider map</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Dynamic</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./eu-capitals-temp/index.html">Current temperatures in capitals of Europe</a></li><li><a href="examples/./map-drilldown/index.html">Drilldown</a></li><li><a href="examples/./tooltip/index.html">Fixed tooltip with HTML</a></li><li><a href="examples/./projection-explorer/index.html">Projection Explorer</a></li><li><a href="examples/./rich-info/index.html">Rich information on click</a></li><li><a href="examples/./doubleclickzoomto/index.html">Zoom to area by double click</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Input formats</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./latlon-advanced/index.html">Advanced lat/long</a></li><li><a href="examples/./geojson/index.html">GeoJSON areas</a></li><li><a href="examples/./mappoint-latlon/index.html">Map point with lat/long</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Series types</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./heatmap/index.html">Heat map</a></li><li><a href="examples/./map-bubble/index.html">Map bubble</a></li><li><a href="examples/./circlemap-africa/index.html">Tile map circles</a></li><li><a href="examples/./diamondmap/index.html">Tile map diamonds</a></li><li><a href="examples/./honeycomb-usa/index.html">Tile map honeycomb</a></li>
        </ul>
    </li>


    <li>
        <div class="" tabindex="0"><span>General</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./stock-tools-gui/index.html">Stock chart with GUI</a></li><li><a href="examples/./basic-line/index.html">Single line series</a></li><li><a href="examples/./candlestick-and-volume/index.html">Two panes candlestick and volume</a></li><li><a href="examples/./compare/index.html">Compare multiple series</a></li><li><a href="examples/./data-grouping/index.html">52000 points with data grouping</a></li><li><a href="examples/./lazy-loading/index.html">1.7 million points with async loading</a></li><li><a href="examples/./intraday-area/index.html">Intraday area</a></li><li><a href="examples/./intraday-breaks/index.html">Intraday with breaks</a></li><li><a href="examples/./intraday-candlestick/index.html">Intraday candlestick</a></li><li><a href="examples/./flags-general/index.html">Flags marking events</a></li><li><a href="examples/./cumulative-sum/index.html">Cumulative Sum</a></li><li><a href="examples/./responsive/index.html">Responsive chart</a></li><li><a href="examples/./dynamic-update/index.html">Dynamically updated data</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Chart types</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./heikinashi/index.html">Heikin Ashi</a></li><li><a href="examples/./hlc/index.html">HLC</a></li><li><a href="examples/./hollow-candlestick/index.html">Hollow Candlestick</a></li><li><a href="examples/./line-markers/index.html">Line with markers and shadow</a></li><li><a href="examples/./spline/index.html">Spline</a></li><li><a href="examples/./step-line/index.html">Step line</a></li><li><a href="examples/./area/index.html">Area</a></li><li><a href="examples/./areaspline/index.html">Area spline</a></li><li><a href="examples/./arearange/index.html">Area range</a></li><li><a href="examples/./depth-chart/index.html">Depth chart</a></li><li><a href="examples/./areasplinerange/index.html">Area spline range</a></li><li><a href="examples/./candlestick/index.html">Candlestick</a></li><li><a href="examples/./ohlc/index.html">OHLC</a></li><li><a href="examples/./column/index.html">Column</a></li><li><a href="examples/./columnrange/index.html">Column range</a></li><li><a href="examples/./markers-only/index.html">Point markers only</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Various features</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./stock-tools-custom-gui/index.html">Stock chart with custom GUI</a></li><li><a href="examples/./yaxis-plotlines/index.html">Plot lines on Y axis</a></li><li><a href="examples/./yaxis-plotbands/index.html">Plot bands on Y axis</a></li><li><a href="examples/./yaxis-reversed/index.html">Reversed Y axis</a></li><li><a href="examples/./styled-scrollbar/index.html">Styled scrollbar</a></li><li><a href="examples/./scrollbar-disabled/index.html">Disabled scrollbar</a></li><li><a href="examples/./navigator-disabled/index.html">Disabled navigator</a></li>
        </ul>
    </li>
    
    <li>
        <div class="" tabindex="0"><span>Flags and Technical indicators</span><icon class="toggle"></icon></div>
        <ul >
        <li><a href="examples/./all-indicators/index.html">All technical indicators</a></li><li><a href="examples/./macd-pivot-points/index.html">MACD and Pivot points</a></li><li><a href="examples/./sma-volume-by-price/index.html">SMA and Volume by price</a></li><li><a href="examples/./flags-placement/index.html">Flags placement</a></li><li><a href="examples/./flags-shapes/index.html">Flags shapes and colors</a></li>
        </ul>
    </li>

    </ul></div>
    </body>
</html>