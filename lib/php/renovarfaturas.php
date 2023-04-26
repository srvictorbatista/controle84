<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$renovarfaturas_id = filter_input(INPUT_POST, 'renovarfaturas_id', FILTER_SANITIZE_STRING);



// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------

$RETONRO_RENOV=""; 


//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Editar clientes - Renovar contratos
    // -- -------------------------------------------------------
	if(empty($renovarfaturas_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	FOREACH(explode(',', str_replace('check','', $renovarfaturas_id)) AS $ID_CLIENTE_RENOV){ 
		$aviso_contrato=''; $aviso_data_venc='';
		//-- --------------------------------------
		$sql = "SELECT * FROM `_clientes` WHERE id='{$ID_CLIENTE_RENOV}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CLIENTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
		//echo "CLIENTE_DB: ";print_r($CLIENTE_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------

		//-- --------------------------------------
		$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$ID_CLIENTE_RENOV}' LIMIT 1";
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

		//-- -------------------------------------------------------------------------
		//-- -------------------------| Quitação automatica |-------------------------
		//-- -------------------------------------------------------------------------
			$aviso_contrato .= "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Vencimento anterior quitado!</span> <br>";
		    $sql = "
				    	INSERT INTO `_contratos_quitados` (
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
			    $statment->bindValue(':cliente_id', "{$ID_CLIENTE_RENOV}");
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
			    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
			    $statment->bindValue(':vencimento', "{$CONTRATO_DB['vencimento']}");
			            //-- --------------------------------------
			            //-- REGISTRO DE LOG
			            //-- --------------------------------------
			            eval( system_log("QUITAÇÃO AUTOMATICA\\r\\n(cliente_id: {$ID_CLIENTE_RENOV}, valor: R\$ {$CONTRATO_DB['valor']}, vencimento: {$CONTRATO_DB['vencimento']})")  );
			            //-- --------------------------------------
			$statment->execute();
		//-- -------------------------------------------------------------------------

		//echo "cliente edit id: {$ID_CLIENTE_RENOV}\r\n";
		if($CONTRATO_DB['pacote_id'] < 1){
		 	$PACOTE_DB['nome']='';
		 	$PACOTE_DB['descricao'] = '';
		 	// echo "PACOTE: ";print_r($PACOTE_DB); echo "\r\n-------------------------------------\r\n";
		}else{
			$sql = "SELECT nome, descricao FROM `_pacotes` WHERE id='{$CONTRATO_DB['pacote_id']}' LIMIT 1";
			$statment = $conn->prepare($sql); $statment->execute();
			$PACOTE_NOME='';$PACOTE_DESC='';$PACOTE_VALO='';
			$PACOTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
			// echo "PACOTE: ";print_r($PACOTE_DB); echo "\r\n-------------------------------------\r\n";
			//-- --------------------------------------
		}


		if(empty($CONTRATO_DB['id'])){
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			//Se o contrato não existir. Cria-lo!
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$aviso_contrato .= "<span class=\"badge bg-success bg-warning\" style=\"font-size:15px;\">Novo contrato atribuido.</span> <br>";
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
		    		-- CURDATE()+INTERVAL 28 DAY
		    		DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
		    	 )
		    ";

		    $statment = $conn->prepare($sql);
			    $statment->bindValue(':cliente_id', "{$ID_CLIENTE_RENOV}");
			    $statment->bindValue(':pacote_id', "");
			    $statment->bindValue(':pacote_titulo', "");
			    $statment->bindValue(':pacote_descricao', "");
			    $statment->bindValue(':notas', "Contrato gerado por renovação automatica");
			    $statment->bindValue(':valor', "");
			$statment->execute();
		//-- --------------------------------------
		}else{
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
		    	-- `vencimento` = DATE(:vencimento)+INTERVAL 28 DAY
		    	 `vencimento` = DATE_ADD(:vencimento, INTERVAL 1 MONTH)
		    	WHERE `_contratos`.`cliente_id` = :cliente_id;
		    ";

		    $statment = $conn->prepare($sql);
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
			    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
			    $statment->bindValue(':vencimento', "{$CONTRATO_DB['vencimento']}");
			    $statment->bindValue(':cliente_id', "{$ID_CLIENTE_RENOV}");
		            //-- --------------------------------------
		            //-- REGISTRO DE LOG
		            //-- --------------------------------------
		            eval( system_log("CONTRATO EDITADO [vencimento]\\r\\n(cliente_id: {$ID_CLIENTE_RENOV}, valor: R\$ {$CONTRATO_DB['valor']}, vencimento: {$CONTRATO_DB['vencimento']})")  );
		            //-- --------------------------------------
			$statment->execute();
		}


		//-- --------------------------------------
		$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$ID_CLIENTE_RENOV}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		  $venc_dia = substr($CONTRATO_DB['vencimento'],8,2);
		  $venc_mes = substr($CONTRATO_DB['vencimento'],5,2);
		  $venc_ano = substr($CONTRATO_DB['vencimento'],0,4);
		//-- --------------------------------------
		$aviso_data_venc .= "<span class=\"badge bg-danger\" style=\"font-size:12px;\">Proximo vencimento em {$venc_dia}/{$venc_mes}/{$venc_ano}</span>";
		//echo "{$CONTRATO_DB['vencimento']} - {$venc_dia}/{$venc_mes}/{$venc_ano}"; exit();
		//-- --------------------------------------
		//-- --------------------------------------

		$RETONRO_RENOV .= "Cliente: <span style=\"font-weight:bold;\">{$CLIENTE_DB['nome']}</span> <br>{$aviso_contrato}{$aviso_data_venc}<hr>";
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
		            'title': '<i class=\"far fa-regular fa-circle-check\"></i> &nbsp Contratos renovados!', 
		            'body':'<center>{$RETONRO_RENOV}</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 window.open('JavaScript:reload_loadpaginaclientes();','tab');
                 setTimeout(function(){
                 		 window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').focus();','tab'); 
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