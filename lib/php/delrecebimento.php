<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$delrecebimento_id = filter_input(INPUT_POST, 'delrecebimento_id', FILTER_SANITIZE_STRING);



// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------

$RETONRO_EXCLUIR_RECEB=""; 


//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Editar clientes - Encerrar contratos
    // -- -------------------------------------------------------
	if(empty($delrecebimento_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	FOREACH(explode(',', str_replace('check','', $delrecebimento_id)) AS $ID_RECEBIMENTO_EXCLUIR_RECEB){ 
		$aviso_contrato='';
		//-- --------------------------------------
		$sql = "SELECT
			`id`,
			`cliente_id`,
			`nome`,
			`pacote_id`,
			`contrato_pacote_titulo`,
			`contrato_pacote_descricao`,
			`contrato_notas`,
			`contrato_valor_pago`,
		    CONCAT('R$ ', FORMAT(`contrato_valor_pago`, 2, 'de_DE')) AS `contrato_valor_pago_formatado`,
		    `contrato_vencimento`,
		    DATE_FORMAT (`contrato_vencimento`, '%d/%m/%Y') AS `contrato_vencimento_formatado`,
		    `contrato_quitado`,
		    DATE_FORMAT (`contrato_quitado`, '%d/%m/%Y %H:%i:%s') AS `contrato_quitado_formatado`

		  FROM `_view{$PREFIXO_PATH}_contratos_recebidos` WHERE id='{$ID_RECEBIMENTO_EXCLUIR_RECEB}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$RECEBIM_DB = $statment->fetch(PDO::FETCH_ASSOC);
		//echo "RECEBIM_DB: ";print_r($RECEBIM_DB); echo "\r\n-------------------------------------\r\n";
		$ID_CLIENTE_EXCLUIR_RECEB = $RECEBIM_DB['cliente_id'];
		if(!empty($CONTRATO_DB['cliente_id'])):
				$errors = "Esta ação não é permitida, contate o suporte.";
			    $data['success'] = false;
			    $data['message'] = "<SCRIPT>alert('<h5>{$errors}</h5>'); $('#MDLl32E2A41B .fa-exclamation-triangle, #MDLl32E2A41B .modal-title').addClass('fa-pisca');</SCRIPT> ";
			    $data['errors'] = $errors;
		echo json_encode($data);
		exit();
		endif;
		//-- --------------------------------------
		

		//-- --------------------------------------
		$sql = "SELECT * FROM `{$PREFIXO_PATH}_clientes` WHERE id='{$ID_CLIENTE_EXCLUIR_RECEB}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CLIENTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
		//echo "CLIENTE_DB: ";print_r($CLIENTE_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
		

		//-- --------------------------------------
		$sql = "SELECT * FROM `{$PREFIXO_PATH}_contratos` WHERE cliente_id='{$ID_CLIENTE_EXCLUIR_RECEB}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		$CONTRATO_DB['valor'] = @str_replace('.', ',', $CONTRATO_DB['valor']);
		//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
		
		/*
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
		/**/


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



		//-- --------------------------------------------------------
		//-- ------------------- quitados BKP -----------------------
		//-- --------------------------------------------------------
		$sql = "
		    	INSERT INTO `{$PREFIXO_PATH}_contratos_quitados_bkp` (
		    		`quitado_id`,
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
		    		:quitado_id,
		    		:cliente_id,
		    		:pacote_id,
		    		:pacote_titulo,
		    		:pacote_descricao, 
		    		:notas,      
				    :valor_pago,
		    		:vencimento,
		    		:quitado
		    	 )
	    ";
		    $statment = $conn->prepare($sql);
			    $statment->bindValue(':quitado_id', "{$ID_RECEBIMENTO_EXCLUIR_RECEB}");
			    $statment->bindValue(':cliente_id', "{$RECEBIM_DB['cliente_id']}");
			    $statment->bindValue(':pacote_id', "{$RECEBIM_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$RECEBIM_DB['contrato_pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$RECEBIM_DB['contrato_pacote_descricao']}");
			    $statment->bindValue(':notas', "{$RECEBIM_DB['contrato_notas']}");
			    $statment->bindValue(':valor_pago', "{$RECEBIM_DB['contrato_valor_pago']}");
			    $statment->bindValue(':vencimento', "{$RECEBIM_DB['contrato_vencimento']}");
			    $statment->bindValue(':quitado', "{$RECEBIM_DB['contrato_quitado']}");
			$statment->execute();
	    //-- -----------------------------------------------
		$sql = "
			DELETE FROM `{$PREFIXO_PATH}_contratos_quitados` 
			WHERE `{$PREFIXO_PATH}_contratos_quitados`.`id` = :id;    
	    ";
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':id', "{$ID_RECEBIMENTO_EXCLUIR_RECEB}");
	    $statment->execute();
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("RECEBIMENTO EXCLUIDO: \\r\\n(id: {$RECEBIM_DB['id']}, cliente_id: {$RECEBIM_DB['cliente_id']}, pacote_id: {$RECEBIM_DB['pacote_id']}, pacote_titulo: {$RECEBIM_DB['contrato_pacote_titulo']}, pacote_descricao: {$RECEBIM_DB['contrato_pacote_descricao']}, notas: {$RECEBIM_DB['contrato_notas']}, valor_pago: {$RECEBIM_DB['contrato_valor_pago']}, vencimento: {$RECEBIM_DB['contrato_vencimento']}, quitado: {$RECEBIM_DB['contrato_quitado']})")  );
	            //-- --------------------------------------
	    //-- --------------------------------------------------------

		$RETONRO_EXCLUIR_RECEB .= "<span style=\"font-weight:bold;\">{$CLIENTE_DB['nome']}</span>: 		<span class=\"badge bg-white\" style=\"white-space:nowrap; font-size:12px;\">{$RECEBIM_DB['contrato_vencimento_formatado']}</span><br> 		<span class=\"badge bg-success\" style=\"white-space:nowrap; font-size:12px;\">{$RECEBIM_DB['contrato_quitado_formatado']}</span>  		<span class=\"badge bg-secondary\" style=\"white-space:nowrap; font-size:12px;\">{$RECEBIM_DB['contrato_valor_pago_formatado']}</span>		<br>{$aviso_contrato}<hr>";
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
		            'title': '<i class=\"far fa-solid fa-money-bill-trend-up\" style=\"transform:rotate(180deg);-ms-transform:rotate(180deg);\"></i> &nbsp Recebimento excluido!', 
		            'body':'<center>O seguite recebimento foi excluido: <br><br>{$RETONRO_EXCLUIR_RECEB}</center>', 
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
                 		 // window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').focus();','tab'); 
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