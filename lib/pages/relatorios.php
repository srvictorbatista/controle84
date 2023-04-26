<? include_once('../../_config.php'); include_once('../../_sessao.php');



//-- --------------------------------------
//-- Verifica se possui historico
//-- --------------------------------------
$sql = "SELECT count(*) AS `N_HISTORICO` FROM `_view_bases`;";
$statment = $conn->prepare($sql); $statment->execute(); 
$HISTORICO_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "HISTORICO_DB: {$HISTORICO_DB['N_HISTORICO']} - ";print_r($HISTORICO_DB); echo "\r\n-------------------------------------\r\n"; exit();
//-- --------------------------------------
if($HISTORICO_DB['N_HISTORICO'] < 1):

  exit("<CENTER style=\"font-family:Arial;color:#FFF;font-size:20px;font-weight:bold; padding-top:140px;\">SEM HISTÓRICO DE TRANSAÇÕES</CENTER>");

ENDIF;

@include_once('../php/_grap_relatorio_geral.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> -- --- </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="icon" type="image/x-icon" href="../imgs/favicon.png">

</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
  <base target="_parent">
<div class="wrapper">
  <!-- Navbar -->










  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-sm-6">
            <h1>Relatórios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- li class="breadcrumb-item"><a href="JavaScript:MODAL();">MODAL()</a></li -->
              <li class="breadcrumb-item active"> Balanços Mensais</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
<!-- ----------------------------------------------------------------- -->







            <!-- BAR CHART -->
            <div id="performance_total" class="card" style="background-color: #2D343A;">
              <div class="card-header">
                <h3 class="card-title">
                <h2 class="card-title" style="font-size:14px;font-weight:600;">
                    <i class="far fa-solid fa-file-contract"></i>
                    <i class="far fa-solid fa-clock-rotate-left"></i>
                     &nbsp; HISTÓRICO DE PERFORMANCE
                </h2></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" style="overflow: hidden; padding: 8px;">
                <h4 id="titulo" style="font-weight:900;">Aguarde...</h4>
                <div class="chart">
                  <canvas id="PrevistoRecebidoTotal" style="min-height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                    <div class="progress-group col-md-12" style="background-color:#282f34; margin-top:1px; margin-bottom: 0px; font-size:13px;font-family:Arial; border-top: solid 1px #666; padding: 1px 8px 8px 8px; white-space: nowrap;">
                      <span id="performance" style="font-size:13px;font-weight: normal;">Desempenho: </span>
                      <span id="performance_valor" class="float-right"></span>
                      <span style="z-index:10;top:-30px;left:129px;height:-50px;position:relative; font-size:11px;">
                        <span id="refresh" style="color: #6C757D40;font-size:14px;">
                          <i class="far fa-solid fa-circle" style="margin-right: 1px;"></i>
                        </span>
                        <span id="referencia">Aguarde...</span>
                      </span>
                      <div class="progress progress-sm" style="min-width: 100%;">
                        <div class="progress-bar bg-primary" style="width: 0%;"></div>
                      </div>
                    </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->





<!-- ----------------------------------------------------------------- -->
      <!-- /.col (FULL TOP) -->
      </div>


        <div class="col-md-2">
<!-- ----------------------------------------------------------------- -->



            <div class="btn-group col-md-12" id="RelatMesSelect" role="group" style="padding: 0px 0px 15px 0px;">
              <button type="button" class="btn btn-primary" id="MesPrev"><i class="far fa-solid fa-chevron-left"></i></button>  
                <select class="form-control" id="SelectRelatorioMes" style="margin-left:4px;margin-right:5px;background-color:#3F6791;border-color:#3F6791;font-size:15px;cursor:pointer;" onchange="window.open('?SelectRelatorioMes='+$(this).val(),'_self')">
                                <option disabled="disabled" selected="true">AGUARDE...</option>
                              </select>
              <button type="button" class="btn btn-primary" id="MesNext"><i class="far fa-solid fa-chevron-right"></i></button>
            </div>





 <!-- /////////////////////////////////////// -->

            <div class="card col-md-12"  id="relatorio_resumomes" style="min-width:100%; /*max-width: 250px;*/ font-size:12px; margin-right: 5px; background-color: #2D343A;
            ">
              <div class="card-header">
                <h2 class="card-title" style="font-size:14px;font-weight:600;">
                    <i class="fas fa-solid fa-sack-dollar"></i>
                    &nbsp; PREVISTO / RECEBIDO
                </h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="/*fas fa-plus*/ fas fa-minus"></i>
                  </button>
                </div>      
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row" style="padding-left:-20px;margin:-20px;">                          
                <span id="refresh" style="color:#6C757D40;"><i class="far fa-solid fa-circle" style="margin-right: 5px;"></i></span>
                <span id="mes">Carregando...</span>
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <center>

                        <div class="box" style="display:none;margin:-15px;">
                          <div class="box-circle">
                            <svg viewBox="73 -17 5 185">
                              <circle cx="70" cy="70" r="70"></circle>
                              <circle id="circleProgress" cx="70" cy="70" r="70"></circle>
                            <svg>
                          </div>
                          <div class="number">
                            <h2>0%</h2>
                          </div>
                        </div>

                      </center>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                <span style="font-weight:bold;">RECEBIMENTOS:</span>
                </div>
                <!-- /.row -->
              </div>
              
              <!-- /.card-body -->
              <div class="card-footer p-0 chart-legend clearfix">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link">
                      <span id="previsto">---</span>
                      <span class="float-right text-warning">
                        <span id="previsto_valor"></span> &nbsp;
                        <i class="fas fa-arrow-right text-sm"></i>
                      </span>
                    </a>
                    <a class="nav-link">
                      <span id="falta">---</span>
                      <span class="float-right text-danger" style="font-weight:bold;">
                        <span id="falta_valor"></span> &nbsp;
                        <i class="fas fa-arrow-left text-sm"></i>
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">                    
                    <a class="nav-link">
                      <span id="realizado">---</span>
                      <span class="float-right text-success" style="color:#44FF00 !important;">
                        <span id="realizado_valor"></span> &nbsp;
                        <i class="fas fa-arrow-up text-sm"></i>
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <div class="progress-group col-md-12">
                      <span id="progresso">---</span>
                      <span id="progresso_valor" class="float-right">Carregando...</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width:0%;"></div>
                      </div>
                    </div>

                  </li>
                </ul>
              </div>
              <!-- /.footer -->
            </div>
            <!-- /.card -->
 <!-- /////////////////////////////////////// -->



<!-- ----------------------------------------------------------------- -->
        </div>
        <!-- /.col -->


        <!-- /.col -->
        <div class="col-md-10">
<!-- ----------------------------------------------------------------- -->



      <div class="col-md-4 float-left" style="">

            <!-- DONUT CHART -->
            <div id="recedebimento12_meses" class="card" style="background-color: #2D343A;">
              <div class="card-header">
                <h2 class="card-title" style="font-size:14px;font-weight:600;">
                    <i class="far fa-solid fa-money-bill-trend-up"></i> &nbsp; RECEBIMENTOS
                </h2>
                

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </div>
              </div>
              <div class="card-body" style="padding:8px;">
                <h4 id="titulo" style="font-weight:900; font-size:16px;padding-left:10px;">Aguarde....</h4>
                <canvas id="Recebimentos" style="min-height: 265px; max-height: 265px; max-width: 100%;"></canvas>
                <div style="font-family:Arial; top:-20px;position:relative; margin: 0px;padding:0px;">
                  <center><span id="total" style="z-index:0;top:-120px;position: relative; font-size:13px;font-weight:bold;text-shadow: 1px 2px #333;">Carregando...</span></center>
                  <!-- /.card-body -->
                  <div class="card-footer p-0 chart-legend clearfix" style="margin:0px;">
                    <ul class="nav nav-pills flex-column" style="margin-bottom: -18px;">
                      <li class="nav-item" style="padding: 1px 5px;">
                          <span id="refresh" style="color: #6C757D40;">
                            <i class="far fa-solid fa-circle" style="margin-right: 5px;"></i>
                          </span>
                          <span id="referencia" style="font-size:11px;">Aguarde...</span><br>
                      </li>
                      <li class="nav-item" style="padding: 8px 5px;">
                        <span id="referencia2" style="font-size:14px;font-weight:bold;"><br></span>
                      </li>
                    </ul>
                  </div>
                  <!-- /.footer -->
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

      </div>
      <!-- /.col (LEFT) -->











      
      <div class="col-md-8 float-left" style="padding:0px 0px 0px 7px;">

            <!-- BAR CHART -->
            <div id="performance12_meses" class="card" style="background-color: #2D343A;">
              <div class="card-header">
                <h3 class="card-title">
                <h2 class="card-title" style="font-size:14px;font-weight:600;">
                    <i class="far fa-solid fa-money-bill-transfer"></i> &nbsp; BALANÇO / PERFORMANCE
                </h2></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" style="overflow: hidden; padding: 8px;">
                <h4 id="titulo" style="font-weight:900;font-size:16px;padding-left:10px;">Aguarde...</h4>
                <div class="chart">
                  <canvas id="PrevistoRecebido" style="min-height: 293px; max-height: 293px; max-width: 100%;"></canvas>
                </div>
                    <div class="progress-group col-md-12" style="background-color:#282f34; margin-top:1px; margin-bottom: 0px; font-size:13px;font-family:Arial; border-top: solid 1px #666; padding: 1px 8px 8px 8px; white-space: nowrap;">
                      <span id="performance" style="font-size:13px;font-weight: normal;">Desempenho: </span>
                      <span id="performance_valor" class="float-right"></span>
                      <span style="z-index:10;top:-30px;left:129px;height:-50px;position:relative; font-size:11px;">
                        <span id="refresh" style="color: #6C757D40;font-size:14px;">
                          <i class="far fa-solid fa-circle" style="margin-right: 1px;"></i>
                        </span>
                        <span id="referencia">Aguarde...</span>
                      </span>
                      <div class="progress progress-sm" style="min-width: 100%;">
                        <div class="progress-bar bg-primary" style="width: 0%;"></div>
                      </div>
                    </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->






      </div>
      <!-- /.col (RIGHT) -->








<!-- ----------------------------------------------------------------- -->
        </div>
        <!-- /.col -->


        <div class="col-md-12">
<!-- ----------------------------------------------------------------- -->



<!-- BOX --- -->





            <div id="MDLl32E2A41C" class="card" style="background-color: #2D343A;">
              <form>
              <div class="card-header">
                <h3 class="card-title">Detalhamento (Listagem Tabular)</h3>
              </div>
              <input type="hidden" name="search" value="">
              <input type="hidden" name="pagamentos_mes" value="<?="{$SELECTED_MES}/{$SELECTED_ANO}";?>">
              <input type="hidden" name="pagamentos_folha" value="01">
              <!-- /.card-header -->
              <div class="card-body"style="background-color: #3A4248; padding: 10px;">

                    <div id="box_content" class="table-responsive">
                      <center style="font-weight:bold;color:#BBB;padding:20px;">CARREGANDO... &nbsp; <i class="fas fa-sync-alt fa-spin" style=""></i></center>
                    </div>
                    <!-- /.table-box-content -->

                <!-- 
                <table class="table  table-bordered table-striped" id="RelatorioDetalhado" style="background-color: #242E3580; color:#AAA;">
                  <thead>
                    <tr style="background-color: #2D343A;">
                      <th style="width:10px">#</th>
                      <th>Task</th>
                      <th style="width:10%; min-width:100px;">Progress</th>
                      <th style="width:40px">Label</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>01.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                    <tr>
                      <td>02.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                    </tr>
                    <tr>
                      <td>03.</td>
                      <td>Cron job running</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-primary">30%</span></td>
                    </tr>
                    <tr>
                      <td>04.</td>
                      <td>Fix and squish bugs</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-success">90%</span></td>
                    </tr>
                    <tr>
                      <td>05.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                    <tr>
                      <td>06.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                    </tr>
                    <tr>
                      <td>07.</td>
                      <td>Cron job running</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-primary">30%</span></td>
                    </tr>
                    <tr>
                      <td>08.</td>
                      <td>Fix and squish bugs</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-success">90%</span></td>
                    </tr>
                    <tr>
                      <td>09.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                    <tr>
                      <td>10.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                    </tr>
                    <tr>
                      <td>11.</td>
                      <td>Cron job running</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-primary">30%</span></td>
                    </tr>
                    <tr>
                      <td>12.</td>
                      <td>Fix and squish bugs</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-success">90%</span></td>
                    </tr>
                    <tr>
                      <td>13.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                    <tr>
                      <td>14.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                    </tr>
                    <tr>
                      <td>15.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-warning">70%</span></td>
                    </tr>
                  </tbody>
                </table>
              -->

              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="padding: 15px 20px;">
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" title="Primeira Folha" onclick="">
                          <i class="fas fa-reply"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Ultima Folha" onclick="">
                          <i class="fas fa-share"></i>
                        </button>
                      </div>

                <div class="btn-group float-right" id="Pagination" role="group" style="">
                    <div class="float-right">
                      <span id="pagsN"><!-- 1/1 --></span> &nbsp;
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" title="Folha anterior" onclick="">
                          <i class="fas fa-chevron-left"></i>
                        </button>

                        <select class="form-control" id="SelectRelatorioPagina" name="SelectRelatorioPagina" title="Selecionar Folha" style="margin-left:4px;margin-right:5px;font-size:15px;cursor:pointer; border-radius: 2px;" onchange="loadfolharelatoriospagamentos($(this).val());">
                          <option value="" selected="true" disabled="disabled">AGUARDE...</option>
                        </select>

                        <button type="button" class="btn btn-default btn-sm" title="Proxima Folha" onclick="">
                          <i class="fas fa-chevron-right"></i>
                        </button>
                      </div>
                      <!-- /.btn-group -->
                    </div>
                </div>
              </div>
              </form>
            </div>
            <!-- /.card -->

            <STYLE>
                  #RelatorioDetalhado tbody tr:hover{background-color:#233038;}
                  #RelatorioDetalhado tbody tr:hover * {color:#FFF !important;}
                  #RelatorioDetalhado tbody tr:hover td .progress_title {font-size:1.05em;margin-top:-16px;}
                  #RelatorioDetalhado tbody tr td{padding: 5px 10px;}
                  #RelatorioDetalhado tbody tr td .progress{margin:10px 0px 0px 0px;}
                  #RelatorioDetalhado tbody tr td .progress_title {text-align: center;font-size:14px;margin-top:-14px;font-weight:900;color:#BBB;}
            </STYLE>






<!-- BOX --- -->




<!-- ----------------------------------------------------------------- -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


















  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- script src="./lib/plugins/chart.js/chart-4.2.1.umd.min.js"></script -->
<!-- Plugin datalabels v1.0.0 para ChartJS 2.9.4 -->
<script src="../plugins/chart.js/chartjs-plugin-datalabels.min.js"></script>
<!-- script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script -->
<!-- script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@1"></script -->

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Sistema84 App -->
<script src="../dist/js/adminlte.js"></script>
<!-- DinamicoInterno -->
<SCRIPT src="../functions.js?pgn=<?=$THISFILE;?>"></SCRIPT>
<!-- Page specific script -->
<script>
setTimeout(function(){


//import ChartDataLabels from 'chartjs-plugin-datalabels';
//-- ----------------------------------
//-- --- Resumo Mensal
//-- ----------------------------------
if((typeof $('#relatorio_resumomes .box .number h2').html() != "undefined")){
  function Relatorio_GoPrevMensal(
    Mes='Mês de Teste',
    Realizado='Realizado (0)',
    Realizado_valor='R$ 0,00',
    Falta='Falta (0)',
    Falta_valor='R$ 0,00',
    Previsto='Previsto (0)',
    Previsto_valor='R$ 0,00',
    Progresso='Progresso: ',
    Progresso_val1='0',
    Progresso_val2='0',
    Precent1=0, 
    Precent2=0
    ){
      if(Precent1>100){Precent1=100;}//if(Precent1<0){Precent1=0;}
      /*if(Precent2>100){Precent2=100;}*/if(Precent2<0){Precent2=0;}
      start = parseFloat($('#relatorio_resumomes .box .number h2').html().replace(/[^0-9]/g,'-'));
      end = parseFloat(Precent1);
      if(start <= end){       
        //console.log('start é menor que end');
        for(i = start; i < end; i++){
          setTimeout(function(){
            $('#relatorio_resumomes .box .number h2').html(
              parseFloat($('#relatorio_resumomes .box .number h2').html().replace(/[^0-9]/g,'-'))+1+'%'
            );            
          }, i*25);    
        }
      }else{
        //console.log('start é maior que end');
        for(i = end; i < start; i++){
          setTimeout(function(){
            $('#relatorio_resumomes .box .number h2').html(
              parseFloat($('#relatorio_resumomes .box .number h2').html().replace(/[^0-9]/g,'-'))-1+'%'
            );            
          }, i*25);    
        }
      }

      //-- -------- Se negativo ---------
      if(end < 0){  
      $('#relatorio_resumomes circle:nth-child(2), #relatorio_resumomes .number h2, #relatorio_resumomes #refresh').
        css({
            "stroke": "#44FF00",//#008888", 
            "color":  "#44FF00"//"#339999"
        });
        setTimeout(function(){ // Converte negativo em positivo (na exibição)
          $('#relatorio_resumomes .box .number h2').html(
             '+'+ parseFloat($('#relatorio_resumomes .box .number h2').html().replace(/[^0-9]/g,''))+'%'
          );
        }, 650);  
      }else{ 
      $('#relatorio_resumomes circle:nth-child(2), #relatorio_resumomes .number h2, #relatorio_resumomes #refresh').
        css({
            "stroke": "#FF9600", 
            "color": "#FF9600"
        });
      }

      setTimeout(function(){
        $('#relatorio_resumomes #mes').html(Mes);

        $('#relatorio_resumomes #realizado').html(Realizado);
        $('#relatorio_resumomes #realizado_valor').html(Realizado_valor);
        
        $('#relatorio_resumomes #falta').html(Falta);
        $('#relatorio_resumomes #falta_valor').html(Falta_valor);
        
        $('#relatorio_resumomes #previsto').html(Previsto);
        $('#relatorio_resumomes #previsto_valor').html(Previsto_valor);

        $('#relatorio_resumomes #progresso').html(Progresso);
        $('#relatorio_resumomes #progresso_valor').html('<b>'+Progresso_val1+'</b>/'+Progresso_val2+' &nbsp; '+Precent2+'%');        
        $('#relatorio_resumomes #circleProgress').css('strokeDashoffset', 440 - (440 * Precent1) /100);
        $('#relatorio_resumomes .progress-bar').css('width',Precent2+'%')
      }, 500);

      setTimeout(function(){
        $('#relatorio_resumomes #refresh').css('color','#454d5540');
      }, 500);
  }
      //-- ----------------------------------
      //-- ---| @MES=03; @ANO=2023; |--------
        //setTimeout(function(){
          //Relatorio_GoPrevMensal('Mês de Dezembro', 'Recebido (2)', 'R$ 1.952,10', 'Pendente (0)', 'R$ 0,00', 'Previsto (2)', 'R$ R$ 1.952,10', 'Progresso: ', '2', '2', 0, 100); 
               
        //}, 8500); 


        <?="{$PREV_MENSAL}";?>



      //-- ----------------------------------


      //-- ----------------------------------
      //-- ----------------------------------
      <? //include_once("../php/_grap_resumo_mes.php"); ?>
      //-- ----------------------------------
}
//-- ----------------------------------







// remove o plugin de todas as instâncias de gráfico
// Chart.plugins.unregister(ChartDataLabels);

  //Chart.version;
  //$(function(){
    /* Chart.js v2.9.4
     * -------
     * Here we will create a few charts using ChartJS
     */



    //--------------------------------------------
    //-- --- DONUT CHART -------------------------
    //--------------------------------------------
    // Get context with jQuery - using jQuery's .get() method.
    var RecebimentosCanvas = $('#Recebimentos').get(0).getContext('2d')
    var donutData        = {
      labels  : <?="{$DONUT_RECEBIMENTOS_MES}";?>,
      titulos: <?="{$DONUT_RECEBIMENTOS_TITULOS}";?>,
      datasets: [
        {
          data: <?="{$DONUT_RECEBIMENTOS_VALORES}";?>,
          backgroundColor : <?="{$DONUT_RECEBIMENTOS_CORES}";?>,
          borderColor:'#555',
          borderWidth:'0.2',
        }
      ],
    }



    var donut_soma=0;
    for(var i=0; i < donutData.datasets[0].data.length; i++) {
      donut_soma +=donutData.datasets[0].data[i];
    }
    $('#recedebimento12_meses #total').html('R$ '+donut_soma.toLocaleString('pt-br', {minimumFractionDigits: 2}));    
    $('#recedebimento12_meses #titulo').html(donutData.titulos[0]);
    $('#recedebimento12_meses #referencia').html(donutData.titulos[1]);
    $('#recedebimento12_meses #refresh').css('color','#48FF00');



    DonutUltimoObj = donutData.datasets[0].data.length-2;
    var value = ': R$ '+ donutData.datasets[0].data[DonutUltimoObj].toLocaleString('pt-br', {minimumFractionDigits: 2}) +' ('+ ((donutData.datasets[0].data[DonutUltimoObj]/donut_soma)*100).toFixed(2)+'%) ';
    var label2 = donutData.labels[DonutUltimoObj]+'<span style="white-space: nowrap;">'+ value +'</span>' || '';
    var color = donutData.datasets[0].backgroundColor[DonutUltimoObj];
    $('#recedebimento12_meses #referencia2').html('<span style=\'background-color:'+color+';padding:2px 10px;border:solid 1px #AAA;\'></span> &nbsp; '+label2);

    setTimeout(function(){
      $('#recedebimento12_meses #refresh').css('color','#454d5540');
    }, 500);
    


    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
      animation  : {"duration": 3000,},
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
        title:{
            display:false,
            text:'Recebimentos',
            fontSize:'15',
            fontColor: '#F1F1F1',        
        },
        legend: {
            display: false,
            position: 'bottom',
            align: 'start',
            labels: {
                fontColor:'#CCC',
            }
        },
        tooltips: {
            enabled: true,
            callbacks: {
                label: function(tooltipItem, donutData, labels) {
                    var label = donutData.labels[tooltipItem.index] || '';
                    var label2 = donutData.labels[tooltipItem.index] || '';
                    var value = donutData.datasets[0].data[tooltipItem.index];
                    var color = donutData.datasets[0].backgroundColor[tooltipItem.index];
                    
                    //donutData;//RecebimentosCanvas;//.data.datasets[index].hidden;
                    if(label){
                       label += ': R$ '+ value.toLocaleString('pt-br', {minimumFractionDigits: 2}) +' ('+ ((value/donut_soma)*100).toFixed(2)+'%) ';
                       label2 += ': <span style="white-space: nowrap;">R$ '+ value.toLocaleString('pt-br', {minimumFractionDigits: 2}) +'</span> ('+ ((value/donut_soma)*100).toFixed(2)+'%) ';
                    }
                     $('#recedebimento12_meses #referencia2').html('<span style=\'background-color:'+color+';padding:2px 10px;border:solid 1px #AAA;\'></span> &nbsp; '+label2);
                    return label;
                }
            },
        }
    }
    
    //-- ----------------------------------
    //*
    var newLegendClickHandler = function (e, legendItem) {
        var index = legendItem.datasetIndex;

        if(index > 1){
            // Do the original logic
            defaultLegendClickHandler(e, legendItem);
        } else {
            let ci = this.chart;
            [
                ci.getDatasetMeta(0),
                ci.getDatasetMeta(1)
            ].forEach(function(meta) {
                meta.hidden = meta.hidden === null ? !ci.data.datasets[index].hidden : null;
            });
            ci.update();
        }
    }/**/
    //-- ---------------------------------






    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    Chart1 = new Chart(RecebimentosCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })    
    //--------------------------------------------




    //--------------------------------------------
    //-- --- BAR CHART ---------------------------
    //--------------------------------------------
    var PrevistoRecebidoCanvas = $('#PrevistoRecebido').get(0).getContext('2d')
    var PrevistoRecebidoData = {
      labels  : <?="{$DONUT_RECEBIMENTOS_MES}";?>,
      titulos : <?="{$DONUT_RECEBIMENTOS_TITULOS}";?>,
      datasets: [
        {
          label               : 'Recebido',
          backgroundColor     : '#44FF00',
          borderColor         : '#7D6D6D',
          pointRadius          : false,
          pointColor          : '#3B8BBA',
          pointStrokeColor    : '#3F6791',
          pointHighlightFill  : '#FFF',
          pointHighlightStroke: '#DDD',
          data                : <?="{$DONUT_RECEBIMENTOS_VALORES}";?>,
        },
        {
          label               : 'Previsto',
          backgroundColor     : '#818181',
          borderColor         : '#7D6D6D',
          pointRadius         : false,
          pointColor          : '#3B8BBA',
          pointStrokeColor    : '#3F6791',
          pointHighlightFill  : '#FFF',
          pointHighlightStroke: '#DDD',
          data                : <?="{$DONUT_RECEBIMENTOS_PREVISTOS}";?>,
        },
      ],
    }

    var bar_soma=0; var bar_recebido=0; var aproveitamento=0; var bar_total=0; var bar_percent = '';
    for(var i=0; i < PrevistoRecebidoData.datasets[0].data.length-1; i++) {
      bar_soma +=PrevistoRecebidoData.datasets[1].data[i];
      bar_recebido+=PrevistoRecebidoData.datasets[0].data[i];
      if(PrevistoRecebidoData.datasets[0].data[i]>= PrevistoRecebidoData.datasets[1].data[i]){
        //console.log(PrevistoRecebidoData.labels[i]);
        aproveitamento++;
      }
      bar_total++;
    }
    bar_percent_recebidos = ((bar_recebido/bar_soma)*100).toFixed(2);
    bar_percent = ((aproveitamento/bar_total)*100).toFixed(2);
    bar_soma_preco='R$ '+bar_soma.toLocaleString('pt-br', {minimumFractionDigits: 2});
    bar_recebido='R$ '+bar_recebido.toLocaleString('pt-br', {minimumFractionDigits: 2});
    bar_aproveitamento = '(<b>'+aproveitamento+'</b>/'+bar_total+') &nbsp; <span style="font-size:15px;font-weight:bold;">'+bar_percent_recebidos+'%</span>';

    $('#performance12_meses #titulo').html(PrevistoRecebidoData.titulos[0]);
    $('#performance12_meses #referencia').html(PrevistoRecebidoData.titulos[1]);
    $('#performance12_meses #performance_valor').html('<span style=\'font-size:10px;\'><b>'+bar_recebido+ '</b> de ' + bar_soma_preco +' &nbsp; '+bar_aproveitamento+'</span>');
    $('#performance12_meses .progress-bar').css('width',bar_percent_recebidos+'%');
    $('#performance12_meses #refresh').css('color','#48FF00');
    setTimeout(function(){
      $('#performance12_meses #refresh').css('color','#454d5540');
    }, 500);

    var PrevistoRecebidoData = $.extend(true, {}, PrevistoRecebidoData)
    var temp0 = PrevistoRecebidoData.datasets[0]
    var temp1 = PrevistoRecebidoData.datasets[1]
    PrevistoRecebidoData.datasets[0] = temp1
    PrevistoRecebidoData.datasets[1] = temp0

    var PrevistoRecebidoOptions = {
      responsive              : true,
      animation               : {"duration": 4000,},
      maintainAspectRatio     : false,
      datasetFill             : false,
      legend: {
          display: true,
          position: 'bottom',
          align: 'start',
          labels: {
              fontColor:'#FFF',
          },
      },
      scales: {
        xAxes: [{
         ticks: {
          fontColor: '#CCC',
          fontSize: '9'
         }
        }]
      },
        tooltips: {
            enabled: true,
            callbacks: {
                label: function(tooltipItem, PrevistoRecebidoData, labels) {
                    var label = PrevistoRecebidoData.labels[tooltipItem.index] || '';
                    var label_sub = PrevistoRecebidoData.datasets[tooltipItem.datasetIndex].label;
                    var value = PrevistoRecebidoData.datasets[1].data[tooltipItem.index];
                    var value_sub = 'R$ '+ PrevistoRecebidoData.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var color = donutData.datasets[0].backgroundColor[tooltipItem.index];
                    var label2 = label+': <span style="white-space: nowrap;">R$ '+ value.toLocaleString('pt-br', {minimumFractionDigits: 2}) +'</span> ('+ ((value/donut_soma)*100).toFixed(2)+'%) ';
                    var previsto = 'R$ '+ PrevistoRecebidoData.datasets[0].data[tooltipItem.index].toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var recebido = 'R$ '+ PrevistoRecebidoData.datasets[1].data[tooltipItem.index].toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var mes_previsto_percent = ((PrevistoRecebidoData.datasets[0].data[tooltipItem.index]/bar_soma)*100).toFixed(2)+'%';
                    var mes_recebido_percent = ((PrevistoRecebidoData.datasets[1].data[tooltipItem.index]/bar_soma)*100).toFixed(2)+'%';

                    if(label){
                      if(label_sub == PrevistoRecebidoData.datasets[0].label){
                        label = ''+label_sub+': '+value_sub+' ('+mes_previsto_percent+')    Recebido: '+recebido+'';
                       }else{
                        label = ''+label_sub+': '+value_sub+' ('+mes_recebido_percent+')    Previsto: '+previsto+'';
                      }
                    }
                    $('#recedebimento12_meses #referencia2').html('<span style=\'background-color:'+color+';padding:2px 10px;border:solid 1px #AAA;\'></span> &nbsp; '+label2);
                    return label;
                }
            },
        }

    }



    Chart2 = new Chart(PrevistoRecebidoCanvas, {
      type: 'bar',
      data: PrevistoRecebidoData,
      options: PrevistoRecebidoOptions
    })    
    //--------------------------------------------
  //})








    //--------------------------------------------
    //-- --- LINE CHART ---------------------------
    //--------------------------------------------
    var PrevistoRecebidoTotalCanvas = $('#PrevistoRecebidoTotal').get(0).getContext('2d')
    var PrevistoRecebidoTotalData = {
      labels  : <?="{$GERAL_MESES}";?>,
      titulos: <?="{$GERAL_TITULO_PERIODO}";?>,
      datasets: [
        {
          label               : ' Recebido',  
          backgroundColor     : '#44FF0000',
          borderColor         : '#44FF00FF',
          borderWidth         : 6,

          pointRadius         : 6,
          pointBackgroundColor: '#44FF00FF',
          pointColor          : '#44FF0091',
          pointStrokeColor    : '#44FF0091',
          pointHighlightFill  : '#44FF0091',
          pointHighlightStroke: '#44FF0091',
          pointHoverBorderWidth: 20,

          fillColor           : '#44ff0091',
          strokeColor         : "#44ff00FF",
          tension: 0.15,
          data                : <?="{$GERAL_RECEBIDOS}";?>,
        },
        {
          label               : ' Previsto',  
          backgroundColor     : '#3F679100',
          borderColor         : '#3F6791FF',
          borderWidth         : 6,

          pointRadius         : 3,
          pointBackgroundColor: '#3F6791FF',
          pointColor          : '#3F6791FF',
          pointStrokeColor    : '#3F6791FF',
          pointHighlightFill  : '#3F6791FF',
          pointHighlightStroke: '#3F6791FF',
          pointHoverBorderWidth: 12,

          fillColor           : '#3F679191',
          strokeColor         : "#3F679191",
          tension: 0.01,
          data                : <?="{$GERAL_PREVISTOS}";?>,
          formatter: Math.round,
        },
      ],
    }

    var line_soma=0; var line_recebido=0; var aproveitamento=0; var line_total=0; var line_percent = '';
    for(var i=0; i < PrevistoRecebidoTotalData.datasets[0].data.length-1; i++) {
      line_soma +=PrevistoRecebidoTotalData.datasets[1].data[i];
      line_recebido+=PrevistoRecebidoTotalData.datasets[0].data[i];
      if(PrevistoRecebidoTotalData.datasets[0].data[i]>= PrevistoRecebidoTotalData.datasets[1].data[i]){
        //console.log(PrevistoRecebidoTotalData.labels[i]);
        aproveitamento++;
      }
      line_total++;
    }
    line_percent_recebidos = ((line_recebido/line_soma)*100).toFixed(2);
    line_percent = ((aproveitamento/line_total)*100).toFixed(2);
    line_soma_preco='R$ '+line_soma.toLocaleString('pt-br', {minimumFractionDigits: 2});
    line_recebido='R$ '+line_recebido.toLocaleString('pt-br', {minimumFractionDigits: 2});
    line_aproveitamento = '(<b>'+aproveitamento+'</b>/'+line_total+') &nbsp; <span style="font-size:15px;font-weight:bold;">'+line_percent_recebidos+'%</span>';

    $('#performance_total #titulo').html(PrevistoRecebidoTotalData.titulos[0]);
    $('#performance_total #referencia').html(PrevistoRecebidoTotalData.titulos[1]);
    $('#performance_total #performance_valor').html('<span style=\'font-size:10px;\'><b>'+line_recebido+ '</b> de ' + line_soma_preco +' &nbsp; '+line_aproveitamento+'</span>');
    $('#performance_total .progress-bar').css('width',line_percent_recebidos+'%');
    $('#performance_total #refresh').css('color','#48FF00');
    setTimeout(function(){
      $('#performance_total #refresh').css('color','#454d5540');
    }, 500);

    var PrevistoRecebidoTotalData = $.extend(true, {}, PrevistoRecebidoTotalData)
    var temp0 = PrevistoRecebidoTotalData.datasets[0]
    var temp1 = PrevistoRecebidoTotalData.datasets[1]
    PrevistoRecebidoTotalData.datasets[0] = temp1
    PrevistoRecebidoTotalData.datasets[1] = temp0

    var PrevistoRecebidoTotalOptions = {
      responsive              : true,
      animation               : {"duration": 6800,},
      maintainAspectRatio     : false,
      datasetFill             : false,
      legend: {
          display: true,
          position: 'bottom',
          align: 'start',
          labels: {
              fontColor:'#AAA',
              usePointStyle: true,
              padding: 20,
          },
      },
      scales: {
        xAxes: [{
                barPercentage: 0.2,
                gridLines: {
                    color: "#555",
                },
                ticks: {
                  fontColor: '#CCCCC40',
                  fontSize: '9'
                }
        }],
        yAxes: [{
                barPercentage: 0.2,
                gridLines: {
                    color: "#88888820",
                },
                ticks: {
                  fontColor: '#CCC',
                  fontSize: '9',
                  beginAtZero: true,
                },
                stacked: false,
        }],


        /*
        plugins: {
            datalabels: {
              display: true,
              color: 'red',
              font: {
                weight: 'bold'
              },
              formatter: function(value, context) {
                return '$' + value;
              }
            }
        },/**/
        //* ...
        plugins: {
          datalabels: {
            backgroundColor: function(context) {
              return context.dataset.borderColor;
            },
            formatter: function(value, context) {
              return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            },
            borderColor: 'white',
            borderRadius: 25,
            borderWidth: 2,
            color: '#FFF',
            font: {
              weight: 'bold',
              color:'#FFF',
            },
          }
        }
        /**/

      },
        tooltips: {
        enabled: true,
        mode: 'index',
        intersect: false,
            callbacks: {
                label: function(tooltipItem, PrevistoRecebidoTotalData, labels) {
                    var label = PrevistoRecebidoTotalData.labels[tooltipItem.index] || '';
                    var label_sub = PrevistoRecebidoTotalData.datasets[tooltipItem.datasetIndex].label;
                    var value = PrevistoRecebidoTotalData.datasets[1].data[tooltipItem.index] || '';
                    var value_sub = 'R$ '+ PrevistoRecebidoTotalData.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var value_previsto = PrevistoRecebidoTotalData.datasets[0].data[tooltipItem.index] || 0;
                    var value_recebido = PrevistoRecebidoTotalData.datasets[1].data[tooltipItem.index] || 0;
                    var color = PrevistoRecebidoTotalData.datasets[0].backgroundColor[tooltipItem.index];
                    var label2 = label+': <span style="white-space: nowrap;">R$ '+ value.toLocaleString('pt-br', {minimumFractionDigits: 2}) +'</span> ('+ ((value/line_soma)*100).toFixed(2)+'%) ';
                    var previsto = 'R$ '+ value_previsto.toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var recebido = 'R$ '+ value_recebido.toLocaleString('pt-br', {minimumFractionDigits: 2});
                    var mes_previsto_percent = ((PrevistoRecebidoTotalData.datasets[0].data[tooltipItem.index]/line_soma)*100).toFixed(2)+'%';
                    var mes_recebido_percent = ((PrevistoRecebidoTotalData.datasets[1].data[tooltipItem.index]/line_soma)*100).toFixed(2)+'%';

                    if(label){
                      if(label_sub == PrevistoRecebidoTotalData.datasets[0].label){
                        label = ''+label_sub+': '+value_sub+' ('+mes_previsto_percent+')';//    Recebido: '+recebido+'';
                       }else{
                        label = ''+label_sub+': '+value_sub+' ('+mes_recebido_percent+')';//    Previsto: '+previsto+'';
                      }
                    }
                    $('#recedebimento12_meses #referencia2').html('<span style=\'background-color:null;padding:2px 10px;border:solid 1px #AAA;\'></span> &nbsp; '+label2);
                    return label;
                }
            },
        }

    }



    Chart3 = new Chart(PrevistoRecebidoTotalCanvas, {
      type: 'line',
      data: PrevistoRecebidoTotalData,
      options: PrevistoRecebidoTotalOptions
    })    

    //--------------------------------------------
  //})

//////////////////////////////////////////////////////////////////////





// SELECT MES DETALHADO
$('#RelatMesSelect #SelectRelatorioMes').html(<?="{$OPTION_MES}";?>);
$('#RelatMesSelect #MesPrev').attr('onclick','window.open(\'?SelectRelatorioMes=<?="{$BUTTON_PREV}";?>\',\'_self\')');
$('#RelatMesSelect #MesNext').attr('onclick','window.open(\'?SelectRelatorioMes=<?="{$BUTTON_NEXT}";?>\',\'_self\')');



/*

var PrevistoRecebidoCanvas = $('#PrevistoRecebido').get(0).getContext('2d');
var PrevistoRecebidoData = {
      labels  : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      titulos:['<span style="white-space: nowrap;">Pevisto / Recebido</span>','De 01/01 a 31/12 de 2023'],
      datasets: [
        {
          label               : 'Recebido',
          backgroundColor     : '#44FF00',
          borderColor         : '#7D6D6D',
          pointRadius          : false,
          pointColor          : '#3B8BBA',
          pointStrokeColor    : '#3F6791',
          pointHighlightFill  : '#FFF',
          pointHighlightStroke: '#DDD',
          data                : [700.60,900.80,400.30,600,800.90,700,1000.99,300,100,140.60,480.60,952.10,      0],
        },
        {
          label               : 'Previsto',
          backgroundColor     : '#818181',
          borderColor         : '#7D6D6D',
          pointRadius         : false,
          pointColor          : '#3B8BBA',
          pointStrokeColor    : '#3F6791',
          pointHighlightFill  : '#FFF',
          pointHighlightStroke: '#DDD',
          data                : [750.60,900.80,400.30,600,800.90,700,1000.99,300,150,140.60,480.60,952.10,      0],
        },
      ],
    }



    var bar_soma=0; var bar_recebido=0; var aproveitamento=0; var bar_total=0; var bar_percent = '';
    for(var i=0; i < PrevistoRecebidoData.datasets[0].data.length-1; i++) {
      bar_soma +=PrevistoRecebidoData.datasets[0].data[i];
      if(PrevistoRecebidoData.datasets[0].data[i]>= PrevistoRecebidoData.datasets[1].data[i]){
        //console.log(PrevistoRecebidoData.labels[i]);
        bar_recebido+=PrevistoRecebidoData.datasets[1].data[i];
        aproveitamento++;
      }
      bar_total++;
    }
    bar_soma='R$ '+bar_soma.toLocaleString('pt-br', {minimumFractionDigits: 2});
    bar_recebido='R$ '+bar_recebido.toLocaleString('pt-br', {minimumFractionDigits: 2});
    bar_percent = ((aproveitamento/bar_total)*100).toFixed(2);
    bar_aproveitamento = '('+aproveitamento+'/<b>'+bar_total+'</b>) &nbsp; <span style="font-size:15px;font-weight:bold;">'+bar_percent_recebidos+'%</span>';

    $('#performance12_meses #titulo').html(PrevistoRecebidoData.titulos[0]);
    $('#performance12_meses #referencia').html(PrevistoRecebidoData.titulos[1]);
    $('#performance12_meses #performance_valor').html('<span style=\'font-size:10px;\'>'+bar_recebido+ ' de <b>' + bar_soma +'</b> &nbsp; '+bar_aproveitamento+'</span>');
    $('#performance12_meses .progress-bar').css('width',bar_percent+'%');
    $('#performance12_meses #refresh').css('color','#48FF00');
    setTimeout(function(){
      $('#performance12_meses #refresh').css('color','#454d5540');
    }, 500);

    var PrevistoRecebidoOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      legend: {
          display: true,
          position: 'bottom',
          align: 'start',
          labels: {
              fontColor:'#FFF',
          },
      },
      scales: {
        xAxes: [{
         ticks: {
          fontColor: '#CCC'
         }
        }]
      }
    }
//Chart.destroy();
//Chart2.update();
Chart2 = new Chart(PrevistoRecebidoCanvas, {
    type: 'bar',
    data: PrevistoRecebidoData,
    options: PrevistoRecebidoOptions
}); /**/



}, 700); 
</script>
</body>
</html>
