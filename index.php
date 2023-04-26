<? 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('_config.php');  include_once('_sessao.php');?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Controle 84 | Sistema de controle</title>
  <meta name="robots" content="noindex">
  <!-- // [PWA Builder] // -->
  <meta name="theme-color" content="#f9f9f9">
  <link rel="canonical" href="https://controle84.com/">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
  <meta name="apple-mobile-web-app-title" content="Controle 84 | IPTV">
  <link rel="apple-touch-icon" href="./lib/imgs/favicon.png">
  <link rel="manifest" href="./lib/pwa/manifest.json" />
  <!-- // [PWA Builder] END // -->
  <script>
  // [PWA Builder]
  // Este é o service worker com a rede Cache-first
  // Adicione este conteúdo abaixo à sua página HTML ou adicione o arquivo js à sua página no topo para registrar o service worker
  // Verifique a compatibilidade do navegador em que estamos executando
  if ("serviceWorker" in navigator) {
    if (navigator.serviceWorker.controller) {
      console.log("[PWA Builder] Service worker ativo encontrado, sem necessidade de registro");
    }else{
      // Registra o service worker
      navigator.serviceWorker.register("sw-pwa.js", {
      scope: "./" //ESCOPO MAXIMO PERMITIDO
      }).then(function (reg) {
      console.log("[PWA Builder] O service worker foi registrado para o escopo: " + reg.scope);
      });
    }
  }
  // [PWA Builder] END
  </script>  
  <!-- Lib Not-fi -->
  <script src="./lib/pwa/sw.js"></script>
  <script src="./lib/pwa/push.min.js"></script>
  <!-- jQuery -->
  <script src="./lib/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="./lib/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./lib/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="./lib/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="./lib/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="./lib/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="./lib/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="./lib/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./lib/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="./lib/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="./lib/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="./lib/plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./lib/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="./lib/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="icon" type="image/x-icon" href="./lib/imgs/favicon.png">
  <meta name="google" content="notranslate">
  <!-- LOAD PAGE -->
  <style>
  .loader_center{
    width: 100%;
    height: 100%;
    background: #6C7A89;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
  }
  .loader {
    position: fixed;
    top: -1000px;
    width: 200px;
    height: 1000px;
    z-index: 9999999;
    background: url('./lib/imgs/load.png') center bottom no-repeat #1A4AA1;
    background-size: 100% auto;
    border:solid 0px #1A4AA1;
    border-radius: 0px 0px 15px 15px;
    background-color: rgba(12, 148, 212, 0.3) /* #1A4AA1*/;
  }
  .aguarde_{
    position: fixed;
    margin:0px;
    top:0px; left:0px;
    width:100%; height: 100%;
    background-color: #333;
    z-index: 9999998;
  }
  @media (min-width: 779px) {
    .fas.fa-bars{
      display:none;
    }

  }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode" data-panel-auto-height-mode="height">

<!-- LOAD PAGE -->
<div class="loader_center"><div class="loader"></div></div><SCRIPT>$(".loader").animate({top:'-200px'},4700);</SCRIPT>

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="font-size: 50px; top: -25px; left:-15px;"><i class="fas fa-bars"></i></a>
      </li>

<? 
//-- --------------------------------------
// -- Verifica hosts e permissoes
//-- --------------------------------------
$sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE user_id='{$_SESSION["USER_ID"]}' AND `host` = '{$system_host}' AND `autorization` LIKE '%BKP_ZEROPAPER%';";
$statment = $conn->prepare($sql); $statment->execute(); 
$USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "USER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------

if($USER_ROLES_DB['count'] > 0){
?>

      <li class="nav-item d-none d-sm-inline-block"> 
        <a onclick="info('Antes de utlizar este recurso, consulte o suporte.<br>Ele pode não estar disponivel em sua conta.'); setTimeout(function(){window.open('https://www.zeropaper.com.br/manager/user_account','_blank')}, 15000);" title="Migrar dados do ZeroPaper ao seu Controle 84" href="javascript:  
if($('.months-navigator').text().trim() != ''){
/* Pagina correta */
    if(typeof $COPY == 'undefined'){
        var $COPY =''; i=0;
        function screensave(){
            return '[MES]: '+$('.months-navigator').text().trim()+'\n\n        '+$('#tableTransactions tbody tr.transactions-row').text().trim()+'\n\n';   
        }
    }
  sequencia = setInterval(CaptureBkp, 800);

  $('a[data-toggle=\'modal\']')[0].click();
  $('#mdEditCategory .modal-footer').fadeOut();
  $('#mdEditCategory, #mdEditCategory .modal-header, #mdEditCategory .modal-header *').css({'background-color': '#343A40', 'color':  '#DDD'});
  $('#mdEditCategory').css('max-width','650px').css('background','url(<?="{$url}";?>lib/imgs/wait.gif) #343A40 center center no-repeat');
  $('#mdEditCategory .modal-header h3').html('<img src=\'<?="{$url}";?>lib/imgs/logo.png\' style=\'height:35px;margin-right:15px; box-shadow: 0 10px 20px rgba(0,0,0,.19),0 6px 6px rgba(0,0,0,.23)!important\'><span style=\'font-size:20px;\'>CONTROLE 84</span> &nbsp; - &nbsp; GERANDO BACK-UP').css('background','none');
  $('#mdEditCategory .modal-body').html('<br><span style=\'font-size:18px;\'><center><br><br><br><br><br><br><br><br><br>Por favor, aguarde...</center></span><br><br>');


  function CaptureBkp(){

      if($('#tableTransactions tbody tr.transactions-row').text().trim() == ''){

        /* FIM... */
        setTimeout(function(){
          $ACTION = '<?=("{$url}zp_bkp/?token={$_SESSION['PREFIX']}{$_SESSION['TOKEN5']}{$_SESSION['TOKEN0']}{$_SESSION['TOKEN2']}");?>';
          $('a[data-toggle=\'modal\']')[0].click();
          $('#mdEditCategory .modal-footer').fadeOut();
          $('#mdEditCategory, #mdEditCategory .modal-header, #mdEditCategory .modal-header *').css({'background-color': '#343A40', 'color':  '#DDD'});
          $('#mdEditCategory').css('max-width','650px').css('background','url() #343A40');
          $('#mdEditCategory .modal-header h3').html('<img src=\'<?="{$url}";?>lib/imgs/logo.png\' style=\'height:35px;margin-right:15px; box-shadow: 0 10px 20px rgba(0,0,0,.19),0 6px 6px rgba(0,0,0,.23)!important\'><span style=\'font-size:20px;\'>CONTROLE 84</span> &nbsp; - &nbsp; BACK-UP GERADO COM SUCESSO!');
          $('#mdEditCategory .modal-body').html('          
            <form action=\''+$ACTION+'\' method=\'POST\' target=\'_blank\' >
            <span style=\'font-size:18px;\'>
              <br>
              Clique no botão a baixo para enviar o back-up gerado, ao seu Controle 84: 
              <input type=\'hidden\' name=\'token\' value=\'<?="{$_SESSION['PREFIX']}{$_SESSION['TOKEN5']}{$_SESSION['TOKEN0']}{$_SESSION['TOKEN2']}";?>\'>
              <input type=\'hidden\' name=\'COPY\' style=\'width:100%; min-height:600px;padding:20px;color:#00FF37;background:#333;\' value=\''+$COPY+'\'>
              <br><br>
              <button type=\'submit\' style=\'float:right;border-radius: 0.2rem;border-color: #3F6791;padding:20px 30px;font-size:20px;font-weight:bold;color:#EEE;background:#3F6791; cursor:pointer;\'>ENVIAR</button>
              <br><br>
            </span>
            </form> 
          ');
          console.log($COPY);
          setTimeout(function(){
          $('input[name=token]').value='123 - ok!!!';
          }, 500);
          $COPY ='';i=0;
        }, i*500);

        for(stop = 0; i > stop; stop++) {
            setTimeout(function(){
              $('.months-navigator__arrow.pull-right i').click();
            }, stop*300);
        } 

                
        clearInterval(sequencia);
      }else{
         /* SEGUE! */
         $('.months-navigator__arrow.pull-left').click();
         $COPY += screensave();
         i++;       
      }

    }

      /* ************** */
          
    }else{
          /* Pagina errada ou não logada */
      $('a[data-toggle=\'modal\']')[0].click();
      $('#mdEditCategory .modal-footer').fadeOut();
      $('#mdEditCategory, #mdEditCategory .modal-header, #mdEditCategory .modal-header *').css({'background-color': '#343A40', 'color':  '#DDD'});
      $('#mdEditCategory').css('max-width','650px').css('background','url() #343A40');
      $('#mdEditCategory .modal-header h3').html('<img src=\'<?="{$url}";?>lib/imgs/logo.png\' style=\'height:35px;margin-right:15px; box-shadow: 0 10px 20px rgba(0,0,0,.19), 0 6px 6px rgba(0,0,0,.23)!important\'><span style=\'font-size:20px;\'>CONTROLE 84</span> &nbsp; - &nbsp; GERAÇÃO DE BACK-UP');
      $('#mdEditCategory .modal-body').html('<br><span style=\'font-size:20px;\'>Antes de utilizar este recurso, faça login em seu <br>ZeroPaper -> Transações em seguida, <br>clique novamente em gerar back-up.<br><br></span>');
    }
  " class="nav-link"><span style="padding:3px 11px; background: url(<?="{$url}";?>lib/imgs/zp.png) no-repeat -45px 50%;background-size: auto 20px;opacity: 0.8;"></span> &nbsp;z.p - bkp</a>
      </li>

<?}?>

<? $INATIVO = @$_GET['INATIVO'];?>
<? IF(@$INATIVO==1):?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" onclick="TESTE_MDL_BOX();" class="nav-link">TESTE MODAL [BOX]</a> 
      </li>
<? ENDIF; ?>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <? $INATIVO = @$_GET['INATIVO'];?>
      <? IF(@$INATIVO==1):?>
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <? ENDIF; ?>

      <? IF(@$INATIVO==1):?>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="./lib/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="./lib/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="./lib/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <? ENDIF; ?>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <? IF(@$INATIVO==1):?>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>


<i class="fa-solid fa-eye"></i>
<i class="fa-regular fa-eye"></i>
<i class="fa-brands fa-phabricator"></i>
<i class="fa-solid fa-key"></i>
<i class="fa-solid fa-shield-halved"></i>
<i class="fa-solid fa-user-shield"></i>
<i class="fa-regular fa-circle-user"></i>
<i class="fa-solid fa-circle-user"></i>
<i class="fa-solid fa-gears"></i>
<i class="fa-solid fa-gear"></i>
<i class="fa-solid fa-users-gear"></i>
<i class="fa-solid fa-user-gear"></i>
<i class="fa-solid fa-street-view"></i>
<i class="fa-solid fa-walkie-talkie"></i>
<i class="fa-brands fa-expeditedssl"></i>

<i class="fa-brands fa-creative-commons-share"></i>
<i class="fa-brands fa-creative-commons-by"></i>
       <? ENDIF; ?>

      <!-- li class="nav-item d-none d-sm-inline-block">
        <a href="#" onclick="window.open('logout/','_self')" class="nav-link"><span class="right badge badge-danger" style="font-weight:bold;padding: 10px 5px;position:relative;top:-5px; margin-right:-15px;">LOGOUT</span></a> 
      </li -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/_sistema" class="brand-link">
      <img src="./lib/imgs/logo.png" alt="Sistema84 Logo" class="brand-image /*img-circle*/ elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-weight:bold !important;" title="<?=$VERSIONCOMMENT;?>">Controle 84 &nbsp; <sup style="font-weight:normal !important;"> v. <?=$VERSION;?></sup></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <!-- div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./lib/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Allan Silva</a>
        </div>
      </div -->


      <!-- SidebarSearch Form -->
      <!-- div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div -->







      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="lib/pages/clientes.php?<?=time();?>" class="nav-link">
              <i class="nav-icon far fas fa-duotone fa-users"></i>
              <p>Clientes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="lib/pages/pacotes.php?<?=time();?>" class="nav-link">
              <i class="nav-icon far fas fa-solid fa-box"></i>
              <p>Pacotes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="lib/pages/relatorios.php?<?=time();?>" class="nav-link"  onclick="GoPrevMensal('Aguarde...','Realizado (0)','R$ ','Falta (0)','R$ ','Previsto (0)','R$ ','Carregando... ','0','0',0,0);">
              <i class="nav-icon far fa-solid fa-magnifying-glass-dollar /*far fa-solid fa-inbox*/"></i>
              <p>Relatorios</p>
            </a>
          </li>
          <!-- li class="nav-item">
            <a href="lib/pages/fornecedores.php" class="nav-link">
              <i class="nav-icon far fas fa-solid fa-truck"></i>
              <p>Fornecedores</p>
            </a>
          </li -->





          <li class="nav-header"><HR></li>


















<? $INATIVO = @$_GET['INATIVO'];?>
<? IF(@$INATIVO==1):?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Contatos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left:12px;">
              <li class="nav-item">
                <a href="./clienteplus.html" class="nav-link">
                 <i class="far fas fa-duotone fa-users"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./clienteedit.html" class="nav-link">
                  <i class="far fas fa-solid fa-box"></i>
                  <p>Pacotes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./clienteedit.html" class="nav-link">
                  <i class="far fas fa-solid fa-truck"></i>
                  <p>Fornecedores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./clienteplus.html" class="nav-link">
                 <i class="far fas fa-user-plus nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./clienteedit.html" class="nav-link">
                  <i class="far fas fa-user-edit nav-icon"></i>
                  <p>Editar Cliente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./clienteminus.html" class="nav-link">
                  <i class="far fas fa-user-times"></i>
                  <p>Excluir Cliente</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                UI Elements
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Icons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/buttons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buttons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/sliders.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sliders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/modals.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modals & Alerts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/navbar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Navbar & Tabs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/timeline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/ribbons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ribbons</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/forms/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/advanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Advanced Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/editors.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/validation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Validation</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>jsGrid</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">EXAMPLES</li>
          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/mailbox/mailbox.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/mailbox/compose.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/mailbox/read-mail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/invoice.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/e-commerce.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E-commerce</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/projects.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-add.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-edit.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Edit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-detail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Detail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/contacts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/faq.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>FAQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/contact-us.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contact us</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Extras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Login & Register v1
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="pages/examples/login.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Login v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/register.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Register v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/forgot-password.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Forgot Password v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/recover-password.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Recover Password v1</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Login & Register v2
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="pages/examples/login-v2.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Login v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/register-v2.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Register v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/forgot-password-v2.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Forgot Password v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pages/examples/recover-password-v2.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Recover Password v2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="pages/examples/lockscreen.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lockscreen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/legacy-user-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Legacy User Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/language-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Language Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/404.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 404</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/500.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 500</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/pace.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pace</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/blank.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blank Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starter.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Starter Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/search/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Search</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Enhanced</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">MISCELLANEOUS</li>
          <li class="nav-item">
            <a href="https://.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
          <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Important</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Warning</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Informational</p>
            </a>
          </li>
        </ul>
<? ENDIF; ?>


<!-- -------------------------------------------------------------------- -->
            <div class="card col-md-12 elevation-3 float-left collapsed-card /*card col-md-12 elevation-3 float-left*/"  id="resumomensal" style="min-width:240px; max-width: 250px; font-size:12px; margin-right: 5px; 
            position: fixed; 
            top:240px; 
            z-index: 9999999999999999999999; 
            background-color: #2D343A;
            ">
              <div class="card-header">
                <h2 class="card-title" style="font-size:14px;font-weight:600;">
                    <i class="fas fa-solid fa-sack-dollar"></i>
                    &nbsp; PREVISTO / RECEBIDO
                </h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus /*fas fa-minus*/"></i>
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
                      <span class="float-right /*text-primary*/ text-success" style="color:#44FF00 !important;">
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
            <SCRIPT>
              setTimeout(function(){
                 $('#resumomensal .card-header button[data-card-widget=collapse]').click();
               }, 9000);             
            </SCRIPT>
<!-- -------------------------------------------------------------------- -->

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
<SCRIPT>
  function logout_perg(){
            MODAL(
            [
                {
                    'title': '<span style="font-size:32px;"><i class="fas fa-exclamation-triangle fa-pisca lento" style="color:#A98319;"></i> &nbsp; DESLOGAR</span>', 
                    'body':"<span style=\"font-size:35px;\">Você deseja realmente <span style=\"white-space:nowrap;\">sair do sistema?</span></span>",
                    'action':'#',
                    'method':'POST',
                }, 
                {'type':'button', 'name':'NAO', 'value':'VALOR2', 'label':'NÃO', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'SIM', 'value':'VALOR1', 'label':'SIM', 'link':'JavaScript:window.open(\'logout/\',\'_self\')'},                
                
            ]
        );
        //setTimeout(function(){
          $('#MDLl32E2A41B button[name="SIM"]').attr('style','backgound-color:#CCC;font-size:25px;padding:10px 30px;').attr('type','button').attr('onclick','window.open(\'logout/\',\'_self\')').focus();
          $('#MDLl32E2A41B button[name="NAO"]').attr('style','font-size:25px;padding:10px 30px;').attr('class','btn btn-primary').attr('data-dismiss','modal');
          $('#MDLl32E2A41B .modal-dialog').css('top','30vh');
          $('.modal-backdrop').attr('style','opacity:0.95 !important');
        //}, 10);
  }

<? 
//-- --------------------------------------
// -- Verifica hosts e permissoes
//-- --------------------------------------
$sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE user_id='{$_SESSION["USER_ID"]}' AND `host` = '{$system_host}' AND `autorization` LIKE '%admin/index.php%';";
$statment = $conn->prepare($sql); $statment->execute(); 
$USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "USER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------
$ACCESS_ADMIN_ICO='';$ACCESS_ADMIN_STYLE='color:#FFFFFF8C /*454D55*/ /*#282F34*/;';$ACCESS_ADMIN = '';

if($USER_ROLES_DB['count'] > 0){

    $ACCESS_ADMIN_ICO = "<i class=\"fa-solid fa-user-shield\"></i> &nbsp; "; $ACCESS_ADMIN_STYLE = "color:#66717C /*#282F34*/; cursor:pointer;"; $ACCESS_ADMIN = "onclick=\"Credenciais();\"";
?>

    function Credenciais(){
            MODAL(
            [
                {
                    'title': '<span style="font-size:32px;"><i class="fas fa-exclamation-triangle /*fa-pisca lento*/" style="color:#AACCCC;"></i> Credenciais de Acesso</span></span>', 
                    'body':"<span style=\"font-size:35px;\">Você deseja realmente <span style=\"white-space:nowrap;\">sair do sistema?</span></span>",
                    'action':'#',
                    'method':'POST',
                }, 
                //{'type':'button', 'name':'NAO', 'value':'VALOR2', 'label':'NÃO', 'link':'javascript:void(0)'},
                //{'type':'button', 'name':'SIM', 'value':'VALOR1', 'label':'SIM', 'link':'JavaScript:window.open(\'logout/\',\'_self\')'},                
                
            ]
        );
        //setTimeout(function(){
          $('#MDLl32E2A41B button[name="SIM"]').attr('style','backgound-color:#CCC;font-size:25px;padding:10px 30px;').attr('type','button').attr('onclick','window.open(\'logout/\',\'_self\')').focus();
          $('#MDLl32E2A41B button[name="NAO"]').attr('style','font-size:25px;padding:10px 30px;').attr('class','btn btn-primary').attr('data-dismiss','modal');
          $('#MDLl32E2A41B .modal-dialog').css('top','30vh');
          $('.modal-backdrop').attr('style','opacity:0.95 !important');

          $('#MDLl32E2A41B .modal-dialog').attr('class','modal-dialog-lg');
          $('#MDLl32E2A41B .modal-content').css('height','99.8vh');
          $('#MDLl32E2A41B .modal-body').css('height','85vh').css('margin','0px').css('padding','0px').html('<iframe src="login/admin/?<?=time();?>" style="border:none;width:100vw;height:90.3vh;"></iframe>');
        //}, 10);
    }
    
<?}?>

</SCRIPT>

<center><a href="#" onclick="logout_perg();" class="nav-link"><span class="right badge badge-danger" style="font-weight:bold;padding:15px 10px;position:relative;bottom:95px;opacity:0.8;">DESLOGAR</span></a></center>
<div id="MenuRodape" style="background:#343A40;border-top:solid 1px #4B545C;width:100%;height:33px;position: absolute;bottom: 0;text-align:center;padding: 2px 0px;">
  
  <p style="margin:0;font-weight:bold; <?="{$ACCESS_ADMIN_STYLE}";?>" <?="{$ACCESS_ADMIN}";?>>
    <?="{$ACCESS_ADMIN_ICO}";?>  
    <?="{$_SESSION['NOME']}";?>    
  </p>
</div>

  </aside>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper iframe-mode bg-dark" data-widget="iframe" data-auto-dark-mode="true" data-loading-screen="750">
    <div class="nav navbar navbar-expand-nlg navbar-dark border-bottom border-dark p-0">
      <a class="nav-link bg-dark" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav" role="tablist">
      </ul>
      <a class="nav-link bg-dark" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>


      <a class="nav-link bg-dark" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
      <a class="nav-link bg-danger" href="#" data-widget="iframe-close">Fechar</a>
    </div>
    <div class="tab-content">
      <div class="tab-empty">
        <h2 class="display-5">Página Vazia!</h2>
      </div>
      <div class="tab-loading">
        <div>
          <h2 class="display-4">Carregando... <i class="fa fa-sync fa-spin"></i></h2>
        </div>
      </div>
    </div>
  </div>





    <!-- /.content-wrapper -->
  <footer class="main-footer dark-mode" style="/*height:20px*/; padding:8px 15px; line-height:1.1; background-color: #24282C !important; color:#777; font-size: 0.92em;">
    Desenvolvido por: <strong>Victor Batista <span style="white-space: nowrap;"><sub style="font-size: 1.1em;">*</sub> 2023 - <a target="_blamk" href="https://t.me/levymac">t.me/levymac</a></span></strong>
    <!-- strong>Copyright &copy; 2023 - <a href="https://sistema84.com">controle84.com</a>. &nbsp; </strong>
    All rights reserved. </span -->
    <div class="float-right d-none d-sm-inline-block" title="<?=$VERSIONCOMMENT;?>">
      <b>Versão</b> <?=$VERSION;?>
    </div>
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->




<!-- LOAD PAGE -->
<div class="aguarde_"> <div>
<SCRIPT>
    $(document).ready(function(){
     $(".loader").animate({top: '-1000px'}, 1800, function(){
      $(".loader").delay(2500).fadeOut("slow"); //retire o delay quando for copiar!
      $(".aguarde_").fadeOut(800);

              // Abre HOME  
              //$('a[href="lib/pages/clientes.php?<?=time();?>"]').delay(5000).click();
              $('ul[role="menu"] .nav-item').children('a').delay(5000)[0].click(); // prmiero item do menu
              ///////////////////////////////////////////////////////////
              //-- --------| RECOLHE MENU NA VERSAO MOBILE
              if(window.screen.width <= 779){
                  $('a[data-widget="pushmenu"]').click();
              }
              ///////////////////////////////////////////////////////////
     });
              //*
              ///////////////////////////////////////////////////////////
              //-- --------| RETIRA CACHE DO IFRAME
              // $('a[data-widget="iframe-close"]').attr('style','display:none;');
              $('a[data-widget="iframe-close"], \
                a[data-widget="iframe-scrollleft"], \
                a[data-widget="iframe-scrollright"], \
                ul[role="tablist"]').
              css('display','none');
              // continua em: adminlte.js
              ///////////////////////////////////////////////////////////
              /**/
    });
</SCRIPT>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>  $.widget.bridge('uibutton', $.ui.button)</script>
<!-- Bootstrap 4 -->
<script src="./lib/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="./lib/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Select2 -->
<script src="./lib/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="./lib/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="./lib/plugins/moment/moment.min.js"></script>
<script src="./lib/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="./lib/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="./lib/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="./lib/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="./lib/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="./lib/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="./lib/plugins/dropzone/min/dropzone.min.js"></script>
<!-- Sistema84 App -->
<script src="./lib/dist/js/adminlte.js"></script>
<!-- date-range-picker -->
<!-- script src="./lib/plugins/daterangepicker/daterangepicker.js"></script -->
<!-- script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script -->


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- DinamicoInterno -->
<SCRIPT src="./lib/functions.js?pgn=<?=$THISFILE;?>" defer></SCRIPT>
</body>
</html>
