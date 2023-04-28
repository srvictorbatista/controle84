<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$encerrarfaturas_id = filter_input(INPUT_POST, 'encerrarfaturas_id', FILTER_SANITIZE_STRING);



// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------

$RETONRO_ENCER=""; 


//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Editar clientes - Encerrar contratos
    // -- -------------------------------------------------------
	if(empty($encerrarfaturas_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	FOREACH(explode(',', str_replace('check','', $encerrarfaturas_id)) AS $ID_CLIENTE_ENCER){ 
		$aviso_contrato='';
		//-- --------------------------------------
		$sql = "SELECT * FROM `{$PREFIXO_PATH}_clientes` WHERE id='{$ID_CLIENTE_ENCER}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CLIENTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
		//echo "CLIENTE_DB: ";print_r($CLIENTE_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
		

		//-- --------------------------------------
		$sql = "SELECT * FROM `{$PREFIXO_PATH}_contratos` WHERE cliente_id='{$ID_CLIENTE_ENCER}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		$CONTRATO_DB['valor'] = @str_replace('.', ',', $CONTRATO_DB['valor']);
		//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
		if(empty($CONTRATO_DB['vencimento'])):
				$errors = "Esta ação não é permitida para clientes sem contrato.";
			    $data['success'] = false;
			    $data['message'] = "<SCRIPT>alert('<h5>{$errors}</h5>')</SCRIPT>";
			    $data['errors'] = $errors;
		echo json_encode($data);
		exit();
		endif;
		  $venc_dia = substr($CONTRATO_DB['vencimento'],8,2);
		  $venc_mes = substr($CONTRATO_DB['vencimento'],5,2);
		  $venc_ano = substr($CONTRATO_DB['vencimento'],0,4);
		//-- --------------------------------------


	    /*
	    // -- -------------------------------------------------------
		//-- Quitar o contrato na data atual, antes de exclui-lo
		//-- --------------------------------------------------------
		//-- --------------------------------------
			$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Vencimento {$venc_dia}/{$venc_mes}/{$venc_ano} foi quitado.</span> <br>";
			//echo $aviso_contrato;exit();
		    $sql = "
		    	INSERT INTO `{$PREFIXO_PATH}_contratos_quitados` (
		    		`cliente_id`,
		    		`pacote_id`,
		    		`pacote_titulo`,
		    		`pacote_descricao`,
		    		`notas`,
		    		`valor_pago`,
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
			    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
			    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
			    $statment->bindValue(':vencimento', "{$CONTRATO_DB['vencimento']}");
			$statment->execute();
		//-- --------------------------------------------------------
		/**/

		$sql = "
			DELETE FROM `{$PREFIXO_PATH}_contratos` 
			WHERE `{$PREFIXO_PATH}_contratos`.`cliente_id` = :id;    
	    ";
            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
				//-- --------------------------------------
				$_try_sql = "SELECT * FROM `{$PREFIXO_PATH}_contratos` ORDER BY `id` DESC LIMIT 1";
				$statment = $conn->prepare($_try_sql); $statment->execute(); 
				$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
				//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
				//-- --------------------------------------
            eval( system_log("CONTRATO ENCERRADO! \\r\\n(cliente_id: {$CONTRATO_DB['cliente_id']}, pacote_id: {$CONTRATO_DB['pacote_id']}, pacote_titulo: {$CONTRATO_DB['pacote_titulo']}, pacote_descricao: {$CONTRATO_DB['pacote_descricao']}, notas: {$CONTRATO_DB['notas']}, valor: {$CONTRATO_DB['valor']}, vencimento: {$CONTRATO_DB['vencimento']})")  );
            //-- --------------------------------------
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':id', "{$ID_CLIENTE_ENCER}");
	    $statment->execute();
	    //-- --------------------------------------------------------

		$RETONRO_ENCER .= "Cliente: <span style=\"font-weight:bold;\">{$CLIENTE_DB['nome']}</span> <br>{$aviso_contrato}<hr>";
	}

	
	//-- --------------------------------------
	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	}else{
	    $data['success'] = true;
	    $data['message'] = "
	    <script>
	    MODAL(
		    [
		        {
		            'title': '<i class=\"fa-regular fa-circle-down\"></i> &nbsp Contratos encerrados!', 
		            'body':'<center>Os seguites contratos foram encerrados: <br><br>{$RETONRO_ENCER}</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 // try{	reload_loadpaginaclientes()	}catch(err){void(0)};
				    try{	loadfolharelatoriospagamentos()	}catch(err){void(0)};
                 setTimeout(function(){
                 		 window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').click();','tab'); 
                         // Rolar para para o topo, ao carregar
    					 // window.open('JavaScript:$(\'html, body\').animate({ scrollTop: 0 }, 1500);','tab');
                 },2000);
	    </script>";
	}
	echo json_encode($data);
exit();
//ENDIF;
//--------------------------------------




?>