<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$cliente_edit_id = filter_input(INPUT_POST, 'cliente_edit_id', FILTER_SANITIZE_STRING);

$cliente_edit_nome = TrataNome(filter_input(INPUT_POST, 'cliente_edit_nome', FILTER_SANITIZE_STRING));
$cliente_edit_email = filter_input(INPUT_POST, 'cliente_edit_email', FILTER_SANITIZE_STRING);
$cliente_edit_telefone = filter_input(INPUT_POST, 'cliente_edit_telefone', FILTER_SANITIZE_STRING);
$cliente_edit_encerrar_contrato = filter_input(INPUT_POST, 'cliente_edit_encerrar_contrato', FILTER_SANITIZE_STRING);
$cliente_edit_notas = filter_input(INPUT_POST, 'cliente_edit_notas', FILTER_SANITIZE_STRING);
$cliente_edit_pacoteid = filter_input(INPUT_POST, 'cliente_edit_pacoteid', FILTER_SANITIZE_STRING);
$cliente_edit_valor_contrato = filter_input(INPUT_POST, 'cliente_edit_valor_contrato', FILTER_SANITIZE_STRING);
$cliente_edit_valor_contrato = preg_replace('/[^\d\.\,]/', '', $cliente_edit_valor_contrato);
$cliente_val1 = substr($cliente_edit_valor_contrato, -5, 6);
$cliente_val1 = str_replace(',', '|', $cliente_val1);
$cliente_val1 = str_replace('.', '|', $cliente_val1);
$cliente_val2 = substr($cliente_edit_valor_contrato, -5, 6);
$cliente_val = str_replace($cliente_val2, $cliente_val1, $cliente_edit_valor_contrato);
$cliente_val = preg_replace('/[^\d\|]/', '', $cliente_val);
$cliente_edit_valor_contrato = str_replace('|', ',', $cliente_val);
$venc = filter_input(INPUT_POST, 'venc', FILTER_SANITIZE_STRING);


$cliente_edit_nome = mb_strtoupper($cliente_edit_nome); // Todo o nome para maiusculo


//-- ------------------------------------------------------------------------------------------
//-- -------------------------------| Verifica Final de Semana |-------------------------------
//-- ------------------------------------------------------------------------------------------

  $venc_dia = substr($venc,0,2);
  $venc_mes = substr($venc,3,2);
  $venc_ano = substr($venc,6,4);
  /*
  $datavenc_ = mktime(0, 0, 0, $venc_mes, $venc_dia, $venc_ano);
  $dia_semana = date("w", $datavenc_);
  if($dia_semana == 0){
  	 //echo "Domingo\r\n";
  	$aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:12px;\">DOMINGO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	 $cliente_edit_venc = date('Y-m-d', strtotime("+1 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }elseif($dia_semana == 6){
    //echo "Sábado\r\n";
    $aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:12px;\">SÁBADO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	$cliente_edit_venc = date('Y-m-d', strtotime("+2 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }
  else{
    //echo "Esta data é um dia útil\r\n";
    $aviso_data_venc = "";
    $cliente_edit_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  }/**/
  $aviso_data_venc = "";
  $cliente_edit_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  //echo "'{$cliente_edit_venc}'";
//-- ------------------------------------------------------------------------------------------

$cliente_edit_telefone = preg_replace('/[^0-9]/', '', $cliente_edit_telefone);
if(strlen($cliente_edit_telefone) <= 10){$cliente_edit_telefone='';}

// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------




//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Editar clientes - Encerrar contrato
    // -- -------------------------------------------------------
	if(!empty($cliente_edit_encerrar_contrato)=='on'):

	    /*
	    // -- -------------------------------------------------------
		//-- Quitar o contrato na data atual, antes de exclui-lo
		//-- --------------------------------------------------------
		//-- --------------------------------------
		$aviso_contrato='';
		$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$cliente_edit_id}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		$CONTRATO_DB['valor'] = str_replace('.', ',', $CONTRATO_DB['valor']);
		//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
			$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Ultimo vencimento foi quitado.</span> <br>";
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
			    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
			    $statment->bindValue(':valor', "{$cliente_edit_valor_contrato}");
			    $statment->bindValue(':vencimento', "{$CONTRATO_DB['vencimento']}");
			$statment->execute();
		//-- --------------------------------------------------------
		/**/

		$sql = "
			DELETE FROM `_contratos` 
			WHERE `_contratos`.`cliente_id` = :id;    
	    ";
            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
				//-- --------------------------------------
				$_try_sql = "SELECT * FROM `_contratos` ORDER BY `id` DESC LIMIT 1";
				$statment = $conn->prepare($_try_sql); $statment->execute(); 
				$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
				//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
				//-- --------------------------------------
            eval( system_log("CONTRATO ENCERRADO! \\r\\n(cliente_id: {$CONTRATO_DB['cliente_id']}, pacote_id: {$CONTRATO_DB['pacote_id']}, pacote_titulo: {$CONTRATO_DB['pacote_titulo']}, pacote_descricao: {$CONTRATO_DB['pacote_descricao']}, notas: {$CONTRATO_DB['notas']}, valor: {$CONTRATO_DB['valor']}, vencimento: {$CONTRATO_DB['vencimento']})")  );
            //-- --------------------------------------
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':id', "{$cliente_edit_id}");
	    $statment->execute();

		$data['success'] = true;
	    $data['message'] = "
	    <script>
	    MODAL(
		    [
		        {
		            'title': '<i class=\"far fas fa-user-edit nav-icon\"></i> &nbsp Cliente Editado!', 
		            'body':'<center>O contrato do cliente <span style=\"font-weight:bold;\">{$cliente_edit_nome}</span>, foi <span style=\"font-weight:bold;\">encerrado</span>!  {$aviso_contrato}</center>', 
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
    					 window.open('JavaScript:$(\'html, body\').animate({ scrollTop: 0 }, 1500);','tab');
                 },2000);
	    </script>";
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
    // -- Editar clientes
    // -- -------------------------------------------------------
	if(empty($cliente_edit_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($cliente_edit_nome)):
			$errors = "ERRO: Nome é obrigatório.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"cliente_edit_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
    /*
	if(empty($cliente_edit_telefone)):
			$errors = "ERRO: Verifique o telefone.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"cliente_edit_telefone\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
	/**/
    // -- -------------------------------------------------------


		$sql = "
	    	UPDATE `_clientes` SET
	    		`nome` = :nome,
	    		`telefone` = :telefone,
	    		`email` = :email  	
	    	  WHERE `_clientes`.`id` = :id;    		
    
	    ";
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("CLIENTE EDITADO!")  );
	            //-- --------------------------------------
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':nome', "{$cliente_edit_nome}");
		    $statment->bindValue(':telefone', "{$cliente_edit_telefone}");
		    $statment->bindValue(':email', "{$cliente_edit_email}");
		    $statment->bindValue(':id', "{$cliente_edit_id}");
	    if(!$statment->execute()){
		    $errors = true;
		}
		//-- --------------------------------------

//-- --------------------------------------
$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$cliente_edit_id}' LIMIT 1";
$statment = $conn->prepare($sql); $statment->execute(); 
$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
$CONTRATO_DB['valor'] = @str_replace('.', ',', $CONTRATO_DB['valor']);
//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------


$aviso_contrato='';
//-- -------------------------------------------------------------------------
//-- -------------------- Quitação por diferença de data |--------------------
//-- Quitar contrato, se a data de vencimento for maior que o atual
//-- -------------------------------------------------------------------------
if(@($CONTRATO_DB['id'] > 0) && ($CONTRATO_DB['vencimento'] < $cliente_edit_venc)){
	$aviso_contrato .= "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Vencimento anterior quitado.</span> <br>";
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

	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("CONTRATO QUITADO \\r\\n(Por diferença de data)")  );
	            //-- --------------------------------------
    $statment = $conn->prepare($sql);
	    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
	    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
	    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
	    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
	    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
	    $statment->bindValue(':valor', "{$cliente_edit_valor_contrato}");
	    $statment->bindValue(':vencimento', "{$CONTRATO_DB['vencimento']}");
	$statment->execute();
}
//-- -------------------------------------------------------------------------


//echo "cliente edit id: {$cliente_edit_pacoteid}\r\n";
if($cliente_edit_pacoteid < 1){
 	$PACOTE_DB['nome']='';
 	$PACOTE_DB['descricao'] = '';
 	// echo "PACOTE: ";print_r($PACOTE_DB); echo "\r\n-------------------------------------\r\n";
}else{
	$sql = "SELECT nome, descricao FROM `_pacotes` WHERE id='{$cliente_edit_pacoteid}' LIMIT 1";
	$statment = $conn->prepare($sql); $statment->execute();
	$PACOTE_NOME='';$PACOTE_DESC='';$PACOTE_VALO='';
	$PACOTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
	// echo "PACOTE: ";print_r($PACOTE_DB); echo "\r\n-------------------------------------\r\n";
	//-- --------------------------------------
}

 //exit();
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
    		:vencimento
    	 )    		
    ";

    $statment = $conn->prepare($sql);
	    $statment->bindValue(':cliente_id', "{$cliente_edit_id}");
	    $statment->bindValue(':pacote_id', "{$cliente_edit_pacoteid}");
	    $statment->bindValue(':pacote_titulo', "{$PACOTE_DB['nome']}");
	    $statment->bindValue(':pacote_descricao', "{$PACOTE_DB['descricao']}");
	    $statment->bindValue(':notas', "{$cliente_edit_notas}");
	    $statment->bindValue(':valor', "{$cliente_edit_valor_contrato}");
	    $statment->bindValue(':vencimento', "{$cliente_edit_venc}");
	$statment->execute();
            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
				//-- --------------------------------------
				$_try_sql = "SELECT * FROM `_contratos` ORDER BY `id` DESC LIMIT 1";
				$statment = $conn->prepare($_try_sql); $statment->execute(); 
				$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
				//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
				//-- --------------------------------------
            eval( system_log("CONTRATO CRIADO! \\r\\n(cliente_id: {$CONTRATO_DB['cliente_id']}, pacote_id: {$CONTRATO_DB['pacote_id']}, pacote_titulo: {$CONTRATO_DB['pacote_titulo']}, pacote_descricao: {$CONTRATO_DB['pacote_descricao']}, notas: {$CONTRATO_DB['notas']}, valor: {$CONTRATO_DB['valor']}, vencimento: {$CONTRATO_DB['vencimento']})")  );
            //-- --------------------------------------
//-- --------------------------------------



	    // -- -------------------------------------------------------
		//-- Quitar o contrato na data atual, após cria-lo
		//-- --------------------------------------------------------
		//-- --------------------------------------
		//$aviso_contrato='';
		$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$cliente_edit_id}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		$CONTRATO_DB['valor'] = str_replace('.', ',', $CONTRATO_DB['valor']);
		//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
			$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Ultimo vencimento foi quitado.</span> <br>";
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
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("CONTRATO QUITADO \\r\\n(durante a criação)")  );
	            //-- --------------------------------------
		    $statment = $conn->prepare($sql);
			    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$cliente_edit_notas}");
			    $statment->bindValue(':valor', "{$cliente_edit_valor_contrato}");
			    $statment->bindValue(':vencimento', date("Y-m-d"));
			$statment->execute();
		//-- --------------------------------------------------------
}else{
    //$cliente_edit_valor_contrato = str_replace(',', '.', $cliente_edit_valor_contrato);
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
    	WHERE `cliente_id` = :cliente_id;
    ";

    $statment = $conn->prepare($sql);
	    $statment->bindValue(':pacote_id', "{$cliente_edit_pacoteid}");
	    $statment->bindValue(':pacote_titulo', "{$PACOTE_DB['nome']}");
	    $statment->bindValue(':pacote_descricao', "{$PACOTE_DB['descricao']}");
	    $statment->bindValue(':notas', "{$cliente_edit_notas}");
	    $statment->bindValue(':valor', "{$cliente_edit_valor_contrato}");
	    $statment->bindValue(':vencimento', "{$cliente_edit_venc}");	    
	    $statment->bindValue(':cliente_id', "{$cliente_edit_id}");
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("CONTRATO EDITADO [vencimento]\r\\n(cliente_id: {$cliente_edit_id}, valor: R\$ {$cliente_edit_valor_contrato}, vencimento: {$cliente_edit_venc})")  );
	            //-- --------------------------------------
	$statment->execute();
}
//-- --------------------------------------
	
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
		            'title': '<i class=\"far fas fa-user-edit nav-icon\"></i> &nbsp Cliente Editado!', 
		            'body':'<center>Os dados do cliente <span style=\"font-weight:bold;\">{$cliente_edit_nome}</span>, <br>foram <span style=\"font-weight:bold;\">alterados com sucesso</span>! {$aviso_contrato}{$aviso_data_venc}</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 window.open('JavaScript:try{	reload_loadpaginaclientes()	}catch(err){void(0)};','tab');
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