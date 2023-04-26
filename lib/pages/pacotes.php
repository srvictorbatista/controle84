<? include('../../_config.php'); include_once('../../_sessao.php');?>
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
            <h1>Pacotes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- li class="breadcrumb-item"><a href="JavaScript:MODAL();">MODAL()</a></li -->
              <li class="breadcrumb-item active"> Gerenciar e consultar pacotes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
 


        <!-- /.col -->
        <div class="col-md-12" style="width:100%;">





          <!-- BOX -->
          <div id="MDLl32E2A41C">



				<DIV id="AjaxSearchDisplay" class="card card-primary card-outline">

		            
		           
		           <div class="card-header p-0">
		            <!-- /.card-controler -->
		            <form id="search" onsubmit="return false">
		            <input type="hidden" name="pagina">
		            <div class="card-header"><center>
		              <a href="JavaScript:novopacote();" class="btn btn-primary mb-1 col-md-2" style="margin: -5px 10px 0px -15px; float:left;">
		              	<!-- i class="far fas fa-solid fa-dice-d6 nav-icon"></i><sup style="font-weight: 900;font-size: 17px;margin: 0px -2px 0px -2px;">+</sup -->
		              	<i class="far fas fa-solid fa-box-open nav-icon"></i><sup style="font-weight: 900;font-size: 17px;margin: 0px -2px 0px -2px;">+</sup>
		              	<!-- i class="nav-icon far fas fa-solid fa-box"></i><sup style="font-weight: 900;font-size: 17px;margin: 0px -2px 0px -2px;">+</sup -->
		              	 &nbsp; Novo Pacote</a></center> &nbsp; &nbsp;
		              <h3 class="card-title" style="margin:0px 0px 18px 0px;">
		              	<span style="color:#AAA;">Por favor, aguarde...</span>
		              </h3>
		              <div class="card-tools col-md-2">
		                <div class="input-group input-group-sm">
		                  <input type="text" name="search" class="form-control" placeholder="Pesquisar" onKeyUp="
	                        try{
	                          //function(){
	                            $SEARCH = $('#MDLl32E2A41C #search input[name=search]').val();
	                            if(($SEARCH != $SEARCH_ANT) && ($SEARCH.length > 2) || ($SEARCH.length < 1)){
                              	  $('input[name=pagina]').val(1);
	                              loadpaginapacotes(null, $SEARCH);
	                              //console.log('\''+$SEARCH +'\' - \''+$SEARCH_ANT+'\'');
	                              $SEARCH_ANT = $SEARCH;
	                            }
	                          //}
	                        }catch(e){
	                          $SEARCH_ANT='';
	                        }		                    
		                  " value="">
		                  <!-- script>$('input[name=search]').focus();</script -->
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
		                <button type="button" class="btn btn-default btn-sm checkbox-toggle" onClick="checkall_loadpaginacaclientes()" title="Selecionar todos">
		                  <i class="far fa-square"></i>
		                </button>
		                  <div class="btn-group">
		                    <button type="button" class="btn btn-default btn-sm" title="Excluir selecionados">
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

			              <div id="box_content" class="table-responsive mailbox-messages">
			              	<center style="font-weight:bold;color:#BBB;padding:20px;"><i class="fas fa-sync-alt fa-spin" style="/*animation: loading 1.2s linear infinite;*/"></i> &nbsp; CARREGANDO...</center>
			              </div>
			              <!-- /.mail-box-messages -->

		             <div class="card-footer p-0">
		              <div class="mailbox-controls">
		                <!-- Check all button -->
		                <button type="button" class="btn btn-default btn-sm checkbox-toggle" onClick="checkall_loadpaginacaclientes()" title="Selecionar todos">
		                  <i class="far fa-square"></i>
		                </button>
		                  <div class="btn-group">
		                    <button type="button" class="btn btn-default btn-sm" title="Excluir selecionados">
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
    $('html, body').animate({ scrollTop: 0 }, 1500);
  })
</script>
</body>
</html>
