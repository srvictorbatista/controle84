<? include_once('../_config.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Controle 84 - Migração e importação de clientes</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../lib/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../lib/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../lib/dist/css/adminlte.min.css">
    <link rel="icon" type="image/x-icon" href="../lib/imgs/favicon.png">
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
<div class="wrapper">




</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../lib/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../lib/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../lib/dist/js/adminlte.min.js"></script>
<!-- Sistema84 App -->
<script src="../lib/dist/js/adminlte.js"></script>
<!-- Sistema84 for demo purposes -->
<!-- script src="./lib/dist/js/demo.js"></script -->
<!-- DinamicoInterno -->
<SCRIPT src="../lib/functions.js?pgn=<?=$THISFILE;?>"></SCRIPT>
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



















<?
$_POST['token'] = @$_POST['token'] ? $_POST['token'] : '';
$_GET['token'] = @$_GET['token'] ? $_GET['token'] : '';
$_POST['COPY'] = @$_POST['COPY'] ? $_POST['COPY'] : '';


if(($_POST['token'] == '') || ($_POST['token'] != $_GET['token']) || ($_POST['token'] != "{$_SESSION['PREFIX']}{$_SESSION['TOKEN5']}{$_SESSION['TOKEN0']}{$_SESSION['TOKEN2']}")){
	echo "
	<SCRIPT>
	document.addEventListener('DOMContentLoaded', function(e){
		setTimeout(function(){    		
			MODAL(
			    [
			        {
			            'title': '<i class=\"far fa-brands fa-expeditedssl\"></i> &nbsp ACESSO NEGADO: [{$_SESSION['PREFIX']}]', 
			            'body':'<span style=\'font-size:20px;\'>O token desta página expirou!</span> <br>O atalho \"<strong><i class=\"far fa-solid fa-earth-asia\"></i> <!-- span style=\"padding:9px 17px; background: url(https://www.zeropaper.com.br/assets/framework/sprites.svg) no-repeat -18px -5px;\"></span --> &nbsp;z.p - bkp</strong>\" utilizado, é antigo de mais para ser utilizado, gere um novo! <br><br>Por medida de segurança, esta página renova suas chaves de acesso periodicamente de forma automatica. <br>', 
			            'action':'#MDL_ACTION',
			            'method':'POST',
			        },
			        //{'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
			    ]
			);
			$('button[aria-label=Close]').css('display','none');
			$('#MDLl32E2A41B').off('click');

    		//*
	          audio = $('#bgSong'); 
			  audio.attr('src','../lib/song/alert.mp3'); 
			  audio.attr('volume','0,8'); //audio.load(); //audio.play();
            /**/
    	}, 500);
	});          		
	</SCRIPT>
	<audio src=\"\" id=\"bgSong\" preload=\"auto\" autoplay></audio>
	";


            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
            eval( system_log("ACESSO NEGADO: [{$_SESSION['PREFIX']}]")  );
            //-- --------------------------------------
	 exit();
}

/*
$_POST['COPY'] = "[MES]: março 2023

        19/03
           
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/03
           
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/03
           
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/03
           
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/03
           
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/03
           
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/03
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/03
          Esta movimentação está com o pagamento atrasado. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: fevereiro 2023

        19/02
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/02
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/02
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/02
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/02
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/02
          Esta movimentação está com o pagamento atrasado. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/02
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/02
          Esta movimentação está com o pagamento atrasado. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: janeiro 2023

        19/01
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/01
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/01
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/01
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/01
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/01
          Esta movimentação está com o pagamento atrasado. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/01
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/01
          Esta movimentação foi efetivada. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: dezembro 2022

        19/12
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/12
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
            
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- À vista     18/12
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/12
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/12
          Esta movimentação foi efetivada. 
        H001KESSYA
            
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- À vista     12/12
          Esta movimentação foi efetivada. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/12
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/12
          Esta movimentação foi efetivada. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: novembro 2022

        19/11
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/11
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/11
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/11
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/11
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/11
          Esta movimentação foi efetivada. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/11
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/11
          Esta movimentação foi efetivada. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: outubro 2022

        19/10
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/10
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/10
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/10
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/10
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/10
          Esta movimentação foi efetivada. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/10
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/10
          Esta movimentação foi efetivada. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: setembro 2022

        19/09
          Esta movimentação foi efetivada. 
        H006ANTONIO
       
        recorrente
           
        H006ANTONIO
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/09
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/09
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/09
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/09
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     12/09
          Esta movimentação foi efetivada. 
        H008LIEDSON
       
        recorrente
           
        H008LIEDSON
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     03/09
          Esta movimentação foi efetivada. 
        S001EDEMILSOM
       
        recorrente
           
        S001EDEMILSOM
       
        R$30,00
        
        Pago: R$0,00
         -- Repete     02/09
          Esta movimentação foi efetivada. 
        H005JOSE
       
        recorrente
           
        H005JOSE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: agosto 2022

        18/08
          Esta movimentação foi efetivada. 
        H004FRANCINEIDE
       
        recorrente
           
        H004FRANCINEIDE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     18/08
          Esta movimentação foi efetivada. 
        H003FRANKLAYNE
       
        recorrente
           
        H003FRANKLAYNE
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     15/08
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/08
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

[MES]: julho 2022

        15/07
          Esta movimentação foi efetivada. 
        H002ZILMA
       
        recorrente
           
        H002ZILMA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete     14/07
          Esta movimentação foi efetivada. 
        H001KESSYA
       
        recorrente
           
        H001KESSYA
       
        R$50,00
        
        Pago: R$0,00
         -- Repete

";/**/

echo "
	<SCRIPT>
	document.addEventListener('DOMContentLoaded', function(e){
		setTimeout(function(){
		    MODAL(
			    [
			        {
			            'title': '<i class=\"fa-solid fa-gear\"></i> &nbsp Recebendo dados', 
			            'body':'<center><span style=\'font-size:35px;\'>Por favor, aguarde... &nbsp; <i class=\"fas fa-sync-alt fa-spin\"></i></span></center>', 
			            'action':'#MDL_ACTION',
			            'method':'POST',
			        },
			        //{'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
			    ]
			);
			$('button[aria-label=Close]').css('display','none');
			$('#MDLl32E2A41B').off('click');
    	}, 500);
	});          		
	</SCRIPT>";

            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
            eval( system_log("Recebendo dados...")  );
            //-- --------------------------------------










//-- --------------------------------------
// -- Verifica hosts e permissoes
//-- --------------------------------------
$sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE user_id='{$_SESSION["USER_ID"]}' AND `host` = '{$system_host}' AND `autorization` LIKE '%BKP_ZEROPAPER%';";
$statment = $conn->prepare($sql); $statment->execute(); 
$USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "USER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------

if($USER_ROLES_DB['count'] < 1){ // PROIBIDO (SEM AUTORIZACAO)
echo "
  <SCRIPT>
  document.addEventListener('DOMContentLoaded', function(e){
    setTimeout(function(){
        MODAL(
          [
              {
                  'title': '<i class=\"far fa-solid fa-ban\"></i> <i class=\"far fa-solid fa-download\"></i> &nbsp Migração de dados', 
                  'body':'Este recurso esta desabilitado para este usuário. <br>Consulte o suporte, para mais informações.', 
                  'action':'#MDL_ACTION',
                  'method':'POST',
              },
              //{'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
          ]
      );
      $('button[aria-label=Close]').css('display','none');
      $('#MDLl32E2A41B').off('click');
      }, 8500);
  });             
  </SCRIPT>";


            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
            eval( system_log("PROIBIDO (SEM AUTORIZACAO)")  );
            //-- --------------------------------------
exit();
}
//-- --------------------------------------
// echo "<SCRIPT> setTimeout(function(){ \$('#MDLl32E2A41B form .modal-body').html('<center style=\"padding:60px 0px;\"><h4>O suporte restringiu a utlização deste recurso.<br><br></h4></center>'); }, 5000);</SCRIPT>"; eval( system_log("ACESSO NEGADO (linha: 952)")  ); exit(); //AINDA NEGADO!




$_POST['COPY'] = str_replace("Repete", "\r\n", $_POST['COPY']);
$_POST['COPY'] = str_replace("À vista", "\r\n", $_POST['COPY']);
$_POST['COPY'] = str_replace("\r\n\r\n        ", "\r\n         --\r\n        ", $_POST['COPY']);

$COPY = explode('[MES]: ',$_POST['COPY']);
$keys = array_keys($COPY);
$size = count($COPY)-1;

//*
//-- ------------------------------------------------------------
//-- - iteração regressiva (do mais antigo para o mais atual) ---
$AVISOS=''; 
for($i = $size; $i > 0; $i--){
	$aviso_contrato=''; $aviso_novo_cliente=''; $aviso_cliente_encontrato='';
    $key   = $keys[$i]; $mes = $COPY[$key];
    $linha = explode("\r\n", $mes);
    $ANOmes = trim(preg_replace('/[^0-9]/', '', $linha[0]));
    	//echo "{$linha[0]}\r\n";
    	$clientes = explode("--", $mes);


    	for($ii = count($clientes)-2; $ii > 0; $ii--){
    		$ClientesLinha = explode("\r\n",$clientes[$ii]);
    		$ClientPagamentoStatus = trim($ClientesLinha[2]);
    		$ReferenciaDiaMesAno =  trim($ClientesLinha[1])."/".$ANOmes;
    		//echo $ReferenciaDiaMesAno;
    		  $ref_dia = substr($ReferenciaDiaMesAno,0,2);
			  $ref_mes = substr($ReferenciaDiaMesAno,3,2);
			  $ref_ano = substr($ReferenciaDiaMesAno,6,4);
			$ReferenciaTimeDB = date("H:i:s");
			$ReferenciaDataDB = "{$ref_ano}-{$ref_mes}-{$ref_dia}";
			$ProxVencDataDB	  = date("Y-m-d", strtotime("+1 month", strtotime($ReferenciaDataDB)));
			$DataCadastro =  "{$ReferenciaDataDB} {$ReferenciaTimeDB}";
			//echo "{$DataCadastro}";
			$NomeCliente = trim($ClientesLinha[3]);
			//echo "{$NomeCliente}\r\n";
			$ContratoValorDB = trim(str_replace(',','.',preg_replace('/[^0-9,]/', '', $ClientesLinha[9])));
			//echo "{$ContratoValorDB}";
			//echo "{$ReferenciaDataDB} - {$ProxVencDataDB}";


	if($ClientPagamentoStatus == "Esta movimentação foi efetivada."){


			//*
			//-- --------------------------------------
			//-- -- Consulta se o cliente já exite ----
			$sql = "SELECT * FROM `_view_bases` WHERE cliente_nome='{$NomeCliente}' LIMIT 1";
			$statment = $conn->prepare($sql); $statment->execute(); 
			$VIEW_BASES_DB = $statment->fetch(PDO::FETCH_ASSOC);
			//$VIEW_BASES_DB['valor'] = @str_replace('.', ',', $VIEW_BASES_DB['valor']);
			//echo "VIEW_BASES: ";print_r($VIEW_BASES_DB); echo "\r\n-------------------------------------\r\n";
			//-- --------------------------------------

			//-- -- Cadastra cliente inexistente ------
			if(empty($VIEW_BASES_DB['cliente_nome'])){
			// echo "NAO ENCONTRADO!";
			//////////////////////////////////////////////////////////////////
			$aviso_novo_cliente = "<span class=\"badge bg-success\" style=\"font-size:15px;\">Cliente {$NomeCliente} importado em {$DataCadastro}.</span> <br>";
			    $sql = "
			    	INSERT INTO `_clientes` (
			    		`nome`,
			    		`telefone`,
			    		`email`,
			    		`cadastro`
			    	 )
			    	VALUES (
			    		:nome,
			    		:telefone,
			    		:email,
			    		:cadastro
			    	 )    		
			    ";

			    $statment = $conn->prepare($sql);
				    $statment->bindValue(':nome', "{$NomeCliente}");
				    $statment->bindValue(':telefone', "");
				    $statment->bindValue(':email', "");
				    $statment->bindValue(':cadastro', "{$DataCadastro}");
				$statment->execute();
			//-- --------------------------------------

			//-- --------------------------------------
			//-- -- Pega o ultimo id cadastrado -------
			$sql = "SELECT id AS cliente_id FROM `_clientes` ORDER BY id DESC LIMIT 1";
			$statment = $conn->prepare($sql); $statment->execute(); 
			while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){
				$ULTIMOCLIENTE = $row_sql_cont['cliente_id'];
			}
			//echo "---->".$ULTIMOCLIENTE;

			// echo "{$ContratoValorDB}";
			//-- --------------------------------------
			//-- --- Procura por pacotes compativeis --
			$sql = "SELECT IFNULL(id,0) AS id, nome, descricao FROM `_pacotes` WHERE valor_base='{$ContratoValorDB}' LIMIT 1";
			$statment = $conn->prepare($sql); $statment->execute();
			$PACOTE_NOME='';$PACOTE_DESC='';$PACOTE_VALO='';
			while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){
				$PACOTE_ID = $row_sql_cont['id'];
				$PACOTE_NOME = $row_sql_cont['nome'];
				$PACOTE_DESC = $row_sql_cont['descricao'] ? $row_sql_cont['descricao'] : 'Contrato migrado, mediante importação de dados';
			}
			//echo "---->".$PACOTE_NOME; exit();
			$CONTRATO_VALOR_DB = str_replace(".", ",", $ContratoValorDB);


			//-- --------------------------------------
			//-- --------------------------------------
			    $sql = "
			    	INSERT INTO `_contratos` (
			    		`cliente_id`,
			    		`pacote_id`,
			    		`pacote_titulo`,
			    		`pacote_descricao`,
			    		`notas`,
			    		`valor`,
			    		`vencimento`
			    	 )
			    	VALUES (
			    		:cliente_id,
			    		:pacote_id,
			    		:pacote_titulo,
			    		:pacote_descricao,
			    		:notas,
					    CONCAT('',  
						      REPLACE(
						          REPLACE(
						              :valor, '.', ''
						          ), 
						       ',', '.'
						      )
						    ),
			    		:vencimento
			    	 )    		
			    ";

			    $statment = $conn->prepare($sql);
				    $statment->bindValue(':cliente_id', "{$ULTIMOCLIENTE}");
				    $statment->bindValue(':pacote_id', "{$PACOTE_ID}");
				    $statment->bindValue(':pacote_titulo', "{$PACOTE_NOME}");
				    $statment->bindValue(':pacote_descricao', "{$PACOTE_DESC}");
				    $statment->bindValue(':notas', "Cliente migrado, mediante importação de dados");
				    $statment->bindValue(':valor', "{$CONTRATO_VALOR_DB}");
				    $statment->bindValue(':vencimento', "{$ReferenciaDataDB}");
				$statment->execute();
			//-- --------------------------------------


				    // -- -------------------------------------------------------
					//-- Quita o primeiro contrato na data do cadastro
					//-- --------------------------------------------------------
					//-- --------------------------------------
					$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$ULTIMOCLIENTE}' LIMIT 1";
					$statment = $conn->prepare($sql); $statment->execute(); 
					$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
					$CONTRATO_DB['valor'] = str_replace('.', ',', $CONTRATO_DB['valor']);
					//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
					//-- --------------------------------------
						$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Primeira quitação registrada em {$ReferenciaDiaMesAno}.</span> <br>";
					    $sql = "
					    	INSERT INTO `_contratos_quitados` (
					    		`cliente_id`,
					    		`pacote_id`,
					    		`pacote_titulo`,
					    		`pacote_descricao`,
					    		`notas`,
					    		`valor_pago`,
					    		`vencimento`,
					    		`quitado`
					    	 )
					    	VALUES (
					    		:cliente_id,
					    		:pacote_id,
					    		:pacote_titulo,
					    		:pacote_descricao,
					    		:notas,   
							    CONCAT('',  
								      REPLACE(
								          REPLACE(
								              :valor, '.', ''
								          ), 
								       ',', '.'
								      )
								    ),
					    		:vencimento,
					    		:quitado
					    	 )    		
					    ";

					    $statment = $conn->prepare($sql);
						    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
						    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
						    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
						    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
						    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
						    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
						    $statment->bindValue(':vencimento', "{$ReferenciaDataDB}");						    
						    $statment->bindValue(':quitado', "{$DataCadastro}");
						$statment->execute();
					//-- --------------------------------------------------------
					//-- --- Acrescenta 1 mês ao vencimento do contrato criado
					    $sql = "
				    	UPDATE `_contratos` SET 
				    	`pacote_id` = :pacote_id,
				    	`pacote_titulo` = :pacote_titulo,
				    	`pacote_descricao` = :pacote_descricao,
				    	`notas` = :notas,
				    	`valor` = CONCAT('',  
							      REPLACE(
							          REPLACE(
							              :valor, '.', ''
							          ), 
							       ',', '.'
							      )
							    ), 
				    	`vencimento` = :vencimento
				    	WHERE `_contratos`.`cliente_id` = :cliente_id;
				    ";

				    $statment = $conn->prepare($sql);
					    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
					    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
					    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
					    $statment->bindValue(':notas', "{$CONTRATO_DB['pacote_descricao']}");
					    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
					    $statment->bindValue(':vencimento', "{$ProxVencDataDB}");   
					    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
					$statment->execute();
					//-- --------------------------------------------------------
			//////////////////////////////////////////////////////////////////
			}else{
			// echo "ENCONTRADO!";
			$aviso_cliente_encontrato = "<span class=\"badge bg-primary\" style=\"font-size:15px;\">Cliente {$VIEW_BASES_DB['cliente_nome']} encontrado.</span> <br>";


				    // -- -------------------------------------------------------
					//-- Quita o contrato no vencimento de referencia
					//-- --------------------------------------------------------
					//-- --------------------------------------
					$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$VIEW_BASES_DB['cliente_id']}' LIMIT 1";
					$statment = $conn->prepare($sql); $statment->execute(); 
					$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
					$CONTRATO_DB['valor'] = @str_replace('.', ',', $CONTRATO_DB['valor']);
					//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
					//-- --------------------------------------
						$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Quitação registrada em {$ReferenciaDiaMesAno}.</span> <br>";
					    $sql = "
					    	INSERT INTO `_contratos_quitados` (
					    		`cliente_id`,
					    		`pacote_id`,
					    		`pacote_titulo`,
					    		`pacote_descricao`,
					    		`notas`,
					    		`valor_pago`,
					    		`vencimento`,
					    		`quitado`
					    	 )
					    	VALUES (
					    		:cliente_id,
					    		:pacote_id,
					    		:pacote_titulo,
					    		:pacote_descricao,
					    		:notas,   
							    CONCAT('',  
								      REPLACE(
								          REPLACE(
								              :valor, '.', ''
								          ), 
								       ',', '.'
								      )
								    ),
					    		:vencimento,
					    		:quitado
					    	 )    		
					    ";

					    $statment = $conn->prepare($sql);
						    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
						    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
						    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
						    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
						    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
						    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
						    $statment->bindValue(':vencimento', "{$ReferenciaDataDB}");
						    $statment->bindValue(':quitado', "{$DataCadastro}");
						$statment->execute();
					//-- --------------------------------------------------------
					//-- --- Acrescenta 1 mês ao vencimento do contrato referenciado
					    $sql = "
				    	UPDATE `_contratos` SET 
				    	`pacote_id` = :pacote_id,
				    	`pacote_titulo` = :pacote_titulo,
				    	`pacote_descricao` = :pacote_descricao,
				    	`notas` = :notas,
				    	`valor` = CONCAT('',  
							      REPLACE(
							          REPLACE(
							              :valor, '.', ''
							          ), 
							       ',', '.'
							      )
							    ), 
				    	`vencimento` = :vencimento
				    	WHERE `_contratos`.`cliente_id` = :cliente_id;
				    ";

				    $statment = $conn->prepare($sql);
					    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
					    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
					    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
					    $statment->bindValue(':notas', "{$CONTRATO_DB['pacote_descricao']}");
					    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
					    $statment->bindValue(':vencimento', "{$ProxVencDataDB}");   
					    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
					$statment->execute();
					//-- --------------------------------------------------------

			
			// exit();
			}/**/
	}//Esta movimentação foi efetivada.

			$AVISOS .= "{$aviso_novo_cliente}{$aviso_cliente_encontrato}{$aviso_contrato}<hr>";
			
    	}


}
//-- ------------------------------------------------------------

echo "
	    <script>
	    setTimeout(function(){
		    MODAL(
			    [
			        {
			            'title': '<i class=\"far fa-solid fa-wand-magic-sparkles\"></i><i class=\"far fa-solid fa-download\"></i> &nbsp Clientes migrados com sucesso!', 
			            'body':'<center>{$AVISOS}</center>', 
			            'action':'#MDL_ACTION',
			            'method':'POST',
			        },
			        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
			    ]
			);
        },2000);
	    </script>";
/**/





            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
            eval( system_log("Clientes migrados com sucesso!")  );
            //-- --------------------------------------
exit();
?>