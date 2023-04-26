<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$delpacote_id = filter_input(INPUT_POST, 'delpacote_id', FILTER_SANITIZE_STRING);

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
    // -- Exclui pacote
    // -- -------------------------------------------------------
	if(empty($delpacote_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("{$errors}")  );
	            //-- --------------------------------------
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------


	FOREACH(explode(',', str_replace('check','', $delpacote_id)) AS $ID_PACOTE_DEL){
            //-- --------------------------------------
            //-- REGISTRO DE LOG
            //-- --------------------------------------
				//-- --------------------------------------
				$_try_sql = "SELECT * FROM `_pacotes` WHERE `_pacotes`.`id` = '{$ID_PACOTE_DEL}' LIMIT 1";
				$statment = $conn->prepare($_try_sql); $statment->execute(); 
				$PACOTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
				//echo "PACOTE_DB: ";print_r($PACOTE_DB); echo "\r\n-------------------------------------\r\n";
				//-- --------------------------------------
            eval( system_log("PACOTE EXCLUIDO! \\r\\n(id: {$PACOTE_DB['id']}, nome: {$PACOTE_DB['nome']}, descricao: {$PACOTE_DB['descricao']}, valor_base: {$PACOTE_DB['valor_base']})")  );
            //-- --------------------------------------
		$sql = "
	    	DELETE FROM `_pacotes` WHERE `_pacotes`.`id` = {$ID_PACOTE_DEL}
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
		            'title': '<i class=\"far fa-trash-alt\"></i> &nbsp Pacote Excluido!', 
		            'body':'<center>Todos os <span style=\"font-weight:bold;\">pacotes selecionados</span>, foram <span style=\"font-weight:bold;\">excluidos com sucesso</span>!</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 $('*[name=\"tab\"]').attr('src','JavaScript:$(\'button[title=\"Recarregar\"]\').click();');
				 window.open('JavaScript:reload_loadpaginapacotes();','tab');
                 setTimeout(function(){
                 		$('*[name=\"tab\"]').attr('src','JavaScript:$(\'button[title=\"Recarregar\"]\').click();');
                 		//window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').focus();','tab'); 
                        // Rolar para para o topo, ao carregar
    					// window.open('JavaScript:$(\'html, body\').animate({ scrollTop: 0 }, 1500);','tab');
                 },2000);
	    </script>";
	}
	//print_r($data);
	echo json_encode($data);
exit();
//ENDIF;
//--------------------------------------




?>