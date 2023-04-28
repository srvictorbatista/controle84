<? 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('../../_config.php'); include_once('../../_sessao.php');?>
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
  <style>
  @media (min-width: 576px) {
    .content-wrapper{
      margin:0px;
    }

  }

  @keyframes loading {
    0% {
      transform: rotate(0);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  </style>
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
            <h1>Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- li class="breadcrumb-item"><a href="JavaScript:MODAL();">MODAL()</a></li -->
              <li class="breadcrumb-item active"> Gerenciar e consultar clientes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="JavaScript:novocliente();" class="btn btn-primary btn-block mb-3"><i class="far fas fa-user-plus nav-icon"></i> &nbsp; Novo Cliente</a>

 
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Legenda</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item" style="padding: 15px 6px 15px 16px; font-weight: bold;">
                    <i class="far fa-circle text-danger" style="margin-right: 6px;"></i> Pendente
                    <span id="nPendente" class="badge bg-danger float-right">-</span>
                </li>
                <li class="nav-item" style="padding: 15px 6px 15px 16px; font-weight: bold;">
                    <i class="far fa-circle text-warning" style="margin-right: 6px;"></i> A vencer
                    <span id="nAVencer" class="badge bg-warning float-right">-</span>
                </li>
                <li class="nav-item" class="nav-item" style="padding: 15px 6px 15px 16px; font-weight: bold;">
                    <i class="far fa-circle text-primary" style="margin-right: 6px;"></i> Quitado
                    <span id="nRegular" class="badge bg-primary float-right">-</span>
                </li>
                <li class="nav-item" class="nav-item" style="padding: 15px 6px 15px 16px; font-weight: bold;">
                    <i class="far fa-circle" style="margin-right: 6px;"></i> Sem pacote
                    <span id="nNull" class="badge bg-white float-right">-</span>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>

<? 






//-- --------------------------------------
// -- Verifica hosts e permissoes
//-- --------------------------------------
$sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE user_id='{$_SESSION["USER_ID"]}' AND `host` = '{$system_host}' AND `autorization` LIKE '%pages/pacotes.php%';";
$statment = $conn->prepare($sql); $statment->execute(); 
$USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "USER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------
if($USER_ROLES_DB['count'] < 1){
 echo "
      <SCRIPT>
          console.warn('SYSTEM AUTORIZATION: [pages/pacotes.php]'); GRAP_MENSAL_MENU='none'; // $('#resumomensal').css('display','none');
      //-- ----------------------------------
      </SCRIPT>
      ";
 $PacotesTile = "{$msg_unpermited}";
 $dados['nome'] = 1;

}else{
 
//-- ------------------------------------------------------------------
//-- ---------------- | PACOTES | ------------------------------------- 
//-- ------------------------------------------------------------------

 $sql = "
        -- ----------------------------------------------------------
        SELECT *,
         CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco`  
            FROM `{$PREFIXO_PATH}_pacotes`
            -- WHERE id = 0
            ORDER BY (valor_base) DESC;
        -- ----------------------------------------------------------
    ";
     /* Conta quantos registos existem na tabela */  
     $sqlContador = "SELECT COUNT(*) AS total_pacotes FROM {$PREFIXO_PATH}_pacotes;"; 


 $stm = $conn->prepare($sql);
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);
 

 $stm = $conn->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);  

$nPacotes  = $valor->total_pacotes;


  if($nPacotes<1){
    $PacotesTile = "<strong style=\"color:#DC3545!important;\">Nenhum pacote</strong>";
  }else if($nPacotes ==1){
    $PacotesTile = "Pacote ({$nPacotes})";

  }else if($nPacotes>1){
    $PacotesTile = "Pacotes ({$nPacotes})";

  }
//-- ------------------------------------------------------------------
}
?>        


          <div class="card customized-scroll" style="max-height:250px;">
            <div class="card-header">
              <h3 class="card-title"><?=$PacotesTile;?></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0 ">
              <ul class="nav nav-pills flex-column">
                <?
                     if(!empty($dados)): 
                             foreach($dados as $LIST_IEM):
                                if(empty($LIST_IEM->descricao)){
                                  $DESCRICAO = "(SEM DESCRIÇÃO)";
                                 }else{
                                   $DESCRICAO = $LIST_IEM->descricao;
                                }

                              echo "
                                <li class=\"nav-item\">
                                  <a href=\"JavaScript:void(0);\" class=\"nav-link\" style=\" font-weight:bold;\" title=\"{$LIST_IEM->nome}: {$DESCRICAO}\">
                                    <i class=\"nav-icon far fas fa-solid fa-box\"></i> &nbsp; {$LIST_IEM->nome} &nbsp; <div style=\"float:right; font-weight:normal;font-style: italic;\">{$LIST_IEM->preco}</div>
                                  </a>
                                </li>
                              ";
                             endforeach;
                      else:
                              echo "

                              <SCRIPT>
                              Novo_Pacote_Empty = function(){
                                window.open(
                                    'JavaScript:$(\'.nav-item a[href=\"lib/pages/pacotes.php\"]\').click();novopacote();'
                                ,'_parent');
                              }
                              </SCRIPT>
                              <p class=\"bg-danger\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold;cursor:pointer;\" onclick=\"Novo_Pacote_Empty();\">Nenhum pacote registrado!</p>  ";
                      endif;
                ?>
                <!-- li class="nav-item active">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="nav-icon far fas fa-solid fa-box"></i> Pacote Inbox
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                  </a>
                </li>
                <li class="nav-item">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <li class="nav-item">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                  </a>
                </li>
                <li class="nav-item">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                  </a>
                </li>
                <li class="nav-item">
                  <a href="JavaScript:void(0);" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                  </a>
                </li -->
              </ul>
            </div>
            <!-- /.card-body -->
          </div>



          <!-- /.card -->
        </div>


        <!-- /.col -->
        <div class="col-md-9">








<!-- ----------------------------------------------------------------- -->






          <!-- BOX -->
          <div id="MDLl32E2A41C">



        <DIV id="AjaxSearchDisplay" class="card card-primary card-outline">

                
               
               <div class="card-header p-0" style="background-color:#2F343A !important;">
                <!-- /.card-controler -->
                <form id="search" onsubmit="return false">
                <input type="hidden" name="pagina">
                <div class="card-header">
                  <h3 class="card-title" style="margin:0px 0px 18px 0px;">
                    <span style="color:#AAA;">Por favor, aguarde...</span>
                  </h3>
                  <div class="card-tools col-md-3">
                    <div class="input-group input-group-sm">

<input type="hidden" name="busc_venc" id="busc_venc" class="form-control" placeholder="" value="<?=date("d/m/Y");?> - <?=date("d/m/Y");?>" />
<div id="btn_busc_venc" class="input-group-text btn-primary" style="margin-right:15px; cursor:pointer;" title="Pesquisar por data de vencimento"><i class="fa fa-calendar"></i></div>









<!-- -------------------------------------------- -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<SCRIPT>
$('#btn_busc_venc').daterangepicker({
    "autoApply": true, 
    "drops": "donw",
    "opens": "left",
    "locale": {
                      "format": "DD/MM/YYYY",
                      "separator": " - ",
                      "applyLabel": "Aplicar",
                      "cancelLabel": "Cancelar",
                      "fromLabel": "De",
                      "toLabel": "Até",
                      "customRangeLabel": "Escolher Período",
                      "daysOfWeek": [
                          "Dom",
                          "Seg",
                          "Ter",
                          "Qua",
                          "Qui",
                          "Sex",
                          "Sáb"
                      ],
                      "monthNames": [
                          "Janeiro",
                          "Fevereiro",
                          "Março",
                          "Abril",
                          "Maio",
                          "Junho",
                          "Julho",
                          "Agosto",
                          "Setembro",
                          "Outubro",
                          "Novembro",
                          "Dezembro"
                      ],
                      "firstDay": 0
                    },
    "alwaysShowCalendars": true,
    ranges: {
        'Pendentes de Amanhã': [moment().add(1, 'days'), moment().add(1, 'days')],
        'Pendentes Hoje': [moment(), moment()],
        'Vencidos Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Nesta Semana': [moment().subtract(6, 'days'), moment()],
        'A 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'No Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    },/*
    "startDate": "23/02/2023",
    "endDate": "23/02/2023"*/
}, function(start, end, label) {
  if(label == 'Escolher Período'){
      label_tit = 'um intervalo';
  }else{
    label_tit = label;
  }
  $('input[name="pagina"]').val(1);
  reload_loadpaginaclientes();
  /*info('\
    <h4>Esta função esta em desenvolvimento </h4>\
    <h5 style="margin-top:-10px;">e estará disponivel em breve...</h5>\
    Ela permitirá que os clientes possam ser listados pelo dia de vencimento em um intervalo específico de tempo: <br>\
    <br>\
    Por exemplo: <br>Você selecionou ' + label_tit + ' <b>de ' + start.format('DD/MM/YYYY') + ' a ' + end.format('DD/MM/YYYY') + '</b><br>\
    <!-- Rótulo utilizado: [' + label + '] <br -->\
    Serão listados os clientes com com os vencimentos entre estas datas.\
    ');/**/
 //$('#busc_venc').attr('style','width:250px;').attr('type','text');
 $('#busc_venc').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
});


//$('#btn_busc_venc').click();
$('.daterangepicker').before().prepend('<!-- center --><h5 style="font-weight:bold;padding:5px 15px;">Por favor, escolha uma data ou período a baixo</h5><!-- /center -->');
</SCRIPT>
<!-- -------------------------------------------- -->


                      <input type="text" name="search" class="form-control" placeholder="Pesquisar" onKeyUp="
                        try{
                          //function(){
                            $SEARCH = $('#MDLl32E2A41C #search input[name=search]').val();
                            if(($SEARCH != $SEARCH_ANT) && ($SEARCH.length > 2) || ($SEARCH.length < 1) || ($SEARCH == '%')){                             
                              $('input[name=pagina]').val(1);
                              loadpaginaclientes(null, $SEARCH.trim());
                              //console.log('\''+$SEARCH +'\' - \''+$SEARCH_ANT+'\'');
                              $SEARCH_ANT = $SEARCH;
                            }
                          //}
                        }catch(e){
                          $SEARCH_ANT='';
                        }
                      " value="">
                      <div class="input-group-append">
                        <div class="btn btn-primary">
                          <i class="fas fa-search"></i>
                        </div>                        
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /form -->
               </div>

                 <div class="card-footer p-0">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle" onClick="checkall_loadpaginaclientes()" title="Selecionar todos">
                      <i class="far fa-square"></i>
                    </button>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" action="renovar" title="Renovar contratos selecionados: <?="\r\n";?>(pagar o atual e renovar por mais 30 dias)">
                          <i class="far fa-regular fa-circle-check"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" action="encerrar" title="Encerrar contratos selecionados: <?="\r\n";?>(dar baixa, quitando vencimento)">
                          <i class="fa-regular fa-circle-down"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" action="excluir" title="Excluir clientes selecionados">
                          <i class="far fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Primeira Página">
                          <i class="fas fa-reply"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Ultima Página">
                          <i class="fas fa-share"></i>
                        </button>
                      </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm" title="Recarregar">
                      <i class="fas fa-sync-alt"></i>
                    </button>

                    <div class="float-right">
                      <span id="pagsN"></span> &nbsp;
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" title="Página anterior">
                          <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Proxima Página">
                          <i class="fas fa-chevron-right"></i>
                        </button>
                      </div>
                      <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                  </div>
                 </div>

                    <div id="box_content" class="table-responsive mailbox-messages scroll-customized">
                      <center style="font-weight:bold;color:#BBB;padding:20px;">CARREGANDO... &nbsp; <i class="fas fa-sync-alt fa-spin" style=""></i></center>
                    </div>
                    <!-- /.mail-box-messages -->

                 <div class="card-footer p-0">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle" onClick="checkall_loadpaginaclientes()" title="Selecionar todos">
                      <i class="far fa-square"></i>
                    </button>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" action="renovar" title="Renovar contratos selecionados: <?="\r\n";?>(pagar o atual e renovar por mais 30 dias)">
                          <i class="far fa-regular fa-circle-check"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" action="encerrar" title="Encerrar contratos selecionados: <?="\r\n";?>(dar baixa, quitando vencimento)">
                          <i class="fa-regular fa-circle-down"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" action="excluir" title="Excluir clientes selecionados">
                          <i class="far fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Primeira Página">
                          <i class="fas fa-reply"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Ultima Página">
                          <i class="fas fa-share"></i>
                        </button>
                      </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm" title="Recarregar">
                      <i class="fas fa-sync-alt"></i>
                    </button>

                    <div class="float-right">
                      <span id="pagsN"></span> &nbsp;
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" title="Página anterior">
                          <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" title="Proxima Página">
                          <i class="fas fa-chevron-right"></i>
                        </button>
                      </div>
                      <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                  </div>
                 </div>


                </div>
                <!-- /.card-body -->
                </form>


            </DIV>



          </div>
          <!-- BOX -->




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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Sistema84 App -->
<script src="../dist/js/adminlte.js"></script>
<!-- Sistema84 for demo purposes -->
<!-- script src="./lib/dist/js/demo.js"></script -->
<!-- DinamicoInterno -->
<SCRIPT src="../functions.js?pgn=<?=$THISFILE;?>"></SCRIPT>
<!-- Page specific script -->
<script>
  $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    });

    // Rolar para para o topo, ao carregar
    // $('html, body').animate({ scrollTop: 0 }, 1500);
  })
</script>
</body>
</html>
