<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$delcliente_id = filter_input(INPUT_POST, 'delcliente_id', FILTER_SANITIZE_STRING);

$login_login = filter_input(INPUT_POST, 'login_login', FILTER_SANITIZE_STRING);
$login_senha = filter_input(INPUT_POST, 'login_senha', FILTER_SANITIZE_STRING);
$login_senha2 = filter_input(INPUT_POST, 'login_senha2', FILTER_SANITIZE_STRING);
$login_token = filter_input(INPUT_POST, 'login_token', FILTER_SANITIZE_STRING);
$login_novo = filter_input(INPUT_POST, 'login_novo', FILTER_SANITIZE_STRING);
$redefinirsenha_login = filter_input(INPUT_POST, 'redefinirsenha_login', FILTER_SANITIZE_STRING);
$redefinirsenha_email = filter_input(INPUT_POST, 'redefinirsenha_email', FILTER_SANITIZE_STRING);
$redefinirsenha_token = filter_input(INPUT_POST, 'redefinirsenha_token', FILTER_SANITIZE_STRING);

$redef_token = filter_input(INPUT_POST, 'redef_token', FILTER_SANITIZE_STRING);
$redef_key = filter_input(INPUT_POST, 'redef_key', FILTER_SANITIZE_STRING);
$redef_senha = filter_input(INPUT_POST, 'redef_senha', FILTER_SANITIZE_STRING);
$redef_senha2 = filter_input(INPUT_POST, 'redef_senha2', FILTER_SANITIZE_STRING);



// TOKEN para usuarios logados
//--------------------------------------
$EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------




//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Exclui clientes
    // -- -------------------------------------------------------
	if(empty($delcliente_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	FOREACH(explode(',', str_replace('check','', $delcliente_id)) AS $ID_CLIENTE_DEL){
		        // -- -------------------------------------------------------
			    // -- BKP cliente
			    // -- -------------------------------------------------------
				//-- --------------------------------------
				$sql = "SELECT * FROM `{$PREFIXO_PATH}_clientes` WHERE id='{$ID_CLIENTE_DEL}' LIMIT 1";
				$statment = $conn->prepare($sql); $statment->execute(); 
				$CLIENTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
				//echo "CLIENTE: {$ID_CLIENTE_DEL} - ";print_r($CLIENTE_DB); echo "\r\n-------------------------------------\r\n"; exit();
				//-- --------------------------------------

				    $sql = "
				    	INSERT INTO `{$PREFIXO_PATH}_clientes_bkp` (
				    		`cliente_id`,
				    		`nome`,
				    		`telefone`,
				    		`email`,
				    		`cadastro`
				    	 )
				    	VALUES (
				    		:cliente_id,
				    		:nome,
				    		:telefone,
				    		:email,
				    		:cadastro
				    	 )    		
				    ";

				    $statment = $conn->prepare($sql);
					    $statment->bindValue(':cliente_id', "{$CLIENTE_DB['id']}");
					    $statment->bindValue(':nome', "{$CLIENTE_DB['nome']}");
					    $statment->bindValue(':telefone', "{$CLIENTE_DB['telefone']}");
					    $statment->bindValue(':email', "{$CLIENTE_DB['email']}");
					    $statment->bindValue(':cadastro', "{$CLIENTE_DB['cadastro']}");
					if($statment->execute()){
			            //-- --------------------------------------
			            //-- REGISTRO DE LOG
			            //-- --------------------------------------
			            eval( system_log("BKP REGISTRADO [CLIENTE]\\r\\n(cliente_id: {$CLIENTE_DB['id']}, nome: {$CLIENTE_DB['nome']})")  );
			            //-- --------------------------------------
			        }
				//-- --------------------------------------
		$sql = "
	    	DELETE FROM `{$PREFIXO_PATH}_clientes` WHERE `{$PREFIXO_PATH}_clientes`.`id` = {$ID_CLIENTE_DEL}
	    ";
	    $statment = $conn->prepare($sql);
	    if(!$statment->execute()){
		    $errors = true;
		}
		//-- --------------------------------------
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
		            'title': '<i class=\"far fa-trash-alt\"></i> &nbsp Cliente Excluido!', 
		            'body':'<center>Todos os <span style=\"font-weight:bold;\">clientes selecionados</span>, foram <span style=\"font-weight:bold;\">excluidos com sucesso</span>!</center>', 
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


            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
            eval( system_log("Cliente's Excluido's!")  );
            //-- --------------------------------------
	echo json_encode($data);
exit();
//ENDIF;
//--------------------------------------




?>