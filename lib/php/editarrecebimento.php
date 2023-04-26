<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$pagamento_edit_id = filter_input(INPUT_POST, 'pagamento_edit_id', FILTER_SANITIZE_STRING);

//$pagamento_edit_nome = TrataNome(filter_input(INPUT_POST, 'pagamento_edit_nome', FILTER_SANITIZE_STRING));
//$pagamento_edit_email = filter_input(INPUT_POST, 'pagamento_edit_email', FILTER_SANITIZE_STRING);
//$pagamento_edit_telefone = filter_input(INPUT_POST, 'pagamento_edit_telefone', FILTER_SANITIZE_STRING);
//$pagamento_edit_encerrar_contrato = filter_input(INPUT_POST, 'pagamento_edit_encerrar_contrato', FILTER_SANITIZE_STRING);
$pagamento_edit_notas = filter_input(INPUT_POST, 'pagamento_edit_notas', FILTER_SANITIZE_STRING);
$pagamento_edit_pacoteid = filter_input(INPUT_POST, 'pagamento_edit_pacoteid', FILTER_SANITIZE_STRING);
$pagamento_edit_valor_contrato = filter_input(INPUT_POST, 'pagamento_edit_valor_contrato', FILTER_SANITIZE_STRING);
$pagamento_edit_valor_contrato = preg_replace('/[^\d\.\,]/', '', $pagamento_edit_valor_contrato);
$pagamento_val1 = substr($pagamento_edit_valor_contrato, -5, 6);
$pagamento_val1 = str_replace(',', '|', $pagamento_val1);
$pagamento_val1 = str_replace('.', '|', $pagamento_val1);
$pagamento_val2 = substr($pagamento_edit_valor_contrato, -5, 6);
$pagamento_val = str_replace($pagamento_val2, $pagamento_val1, $pagamento_edit_valor_contrato);
$pagamento_val = preg_replace('/[^\d\|]/', '', $pagamento_val);
$pagamento_edit_valor_contrato = str_replace('|', ',', $pagamento_val);
$receb = filter_input(INPUT_POST, 'receb', FILTER_SANITIZE_STRING);
$venc = filter_input(INPUT_POST, 'venc', FILTER_SANITIZE_STRING);


//$pagamento_edit_nome = mb_strtoupper($pagamento_edit_nome); // Todo o nome para maiusculo


//-- ------------------------------------------------------------------------------------------
//-- -------------------------------| Verifica Final de Semana |-------------------------------
//-- ------------------------------------------------------------------------------------------

  $receb_dia = substr($receb,0,2);
  $receb_mes = substr($receb,3,2);
  $receb_ano = substr($receb,6,4);
  $receb_time = substr($receb,11,8);

  $venc_dia = substr($venc,0,2);
  $venc_mes = substr($venc,3,2);
  $venc_ano = substr($venc,6,4);
  /*
  $datavenc_ = mktime(0, 0, 0, $venc_mes, $venc_dia, $venc_ano);
  $dia_semana = date("w", $datavenc_);
  if($dia_semana == 0){
  	 //echo "Domingo\r\n";
  	$aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:12px;\">DOMINGO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	 $pagamento_edit_venc = date('Y-m-d', strtotime("+1 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }elseif($dia_semana == 6){
    //echo "Sábado\r\n";
    $aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:12px;\">SÁBADO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	$pagamento_edit_venc = date('Y-m-d', strtotime("+2 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }
  else{
    //echo "Esta data é um dia útil\r\n";
    $aviso_data_venc = "";
    $pagamento_edit_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  }/**/
  $aviso_data_receb = "";
  $pagamento_edit_receb = "{$receb_ano}-{$receb_mes}-{$receb_dia} {$receb_time}";
  //echo "'{$pagamento_edit_receb}'";

  $aviso_data_venc = "";
  $pagamento_edit_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  //echo "'{$pagamento_edit_venc}'";


//-- ------------------------------------------------------------------------------------------

//$pagamento_edit_telefone = preg_replace('/[^0-9]/', '', $pagamento_edit_telefone);
//if(strlen($pagamento_edit_telefone) <= 10){$pagamento_edit_telefone='';}

// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------


    // -- -------------------------------------------------------
    // -- Editar recebimento
    // -- -------------------------------------------------------
	if(empty($pagamento_edit_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($pagamento_edit_venc)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"pagamento_edit_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($pagamento_edit_receb)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"pagamento_edit_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
    /*
	if(empty($pagamento_edit_telefone)):
			$errors = "ERRO: Verifique o telefone.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"pagamento_edit_telefone\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
	/**/
    // -- -------------------------------------------------------


		$sql = "
	    	UPDATE `_contratos_quitados` SET
	    		`pacote_id` 		= :pacote_id,
	    	 -- `pacote_titulo` 	= :pacote_titulo,
	    	 -- `pacote_descricao` 	= :pacote_descricao,
	    		`notas` 			= :notas,
	    		`valor_pago` 		= CONCAT('',  
										      REPLACE(
										          REPLACE(
										              :valor_pago, '.', ''
										          ), 
										       ',', '.'
										      )
									  ),
	    		`vencimento` 		= :vencimento,
	    		`quitado` 			= :quitado	
	    	  WHERE `id` = :id;    		
    
	    ";
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':pacote_id', "{$pagamento_edit_pacoteid}");
		    //$statment->bindValue(':pacote_titulo', "{$pacote_titulo}");
		    //$statment->bindValue(':pacote_descricao', "{$pacote_descricao}");
		    $statment->bindValue(':notas', "{$pagamento_edit_notas}");
		    $statment->bindValue(':valor_pago', "{$pagamento_edit_valor_contrato}");
		    $statment->bindValue(':vencimento', "{$pagamento_edit_venc}");
		    $statment->bindValue(':quitado', "{$pagamento_edit_receb}");

		    $statment->bindValue(':id', "{$pagamento_edit_id}");
	    if(!$statment->execute()){
		    $errors = true;
		}
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("RECEBIMENTO EDITADO \\r\\n(id: {$pagamento_edit_id})")  );
	            //-- --------------------------------------
		//-- --------------------------------------

//-- --------------------------------------
$sql = "SELECT
	`nome`,
	`contrato_valor_pago`,
    CONCAT('R$ ', FORMAT(`contrato_valor_pago`, 2, 'de_DE')) AS `contrato_valor_pago_formatado`,
    DATE_FORMAT (`contrato_vencimento`, '%d/%m/%Y') AS `contrato_vencimento_formatado`,
    DATE_FORMAT (`contrato_quitado`, '%d/%m/%Y %H:%i:%s') AS `contrato_quitado_formatado`
  FROM `_view_contratos_recebidos` WHERE id='{$pagamento_edit_id}' LIMIT 1";
$statment = $conn->prepare($sql); $statment->execute(); 
$RECEBIDO_DB = $statment->fetch(PDO::FETCH_ASSOC);
$RECEBIDO_DB['contrato_valor_pago'] = @str_replace('.', ',', $RECEBIDO_DB['contrato_valor_pago']);
//echo "CONTRATO: ";print_r($RECEBIDO_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------

//-- -------------------------------------------------------------------------


	
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
		            'title': '<i class=\"far fas fa-solid fa-sack-dollar\"></i> &nbsp Recebimento Editado!', 
		            'body':'<center>Os dados do recebimento <span style=\"font-weight:bold;\">{$RECEBIDO_DB['nome']} {$RECEBIDO_DB['contrato_valor_pago_formatado']} </span>, <span class=\"badge bg-white\">VENCIMENTO {$RECEBIDO_DB['contrato_vencimento_formatado']}</span>, <span class=\"badge  bg-success\">RECEBIDO EM {$RECEBIDO_DB['contrato_quitado_formatado']}</span>, <br>foram <span style=\"font-weight:bold;\">alterados com sucesso</span>! </center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 // window.open('JavaScript:try{	reload_loadpaginaclientes()	}catch(err){void(0)};','tab');
				 window.open('JavaScript:try{	loadfolharelatoriospagamentos()	}catch(err){void(0)};','tab');				 
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