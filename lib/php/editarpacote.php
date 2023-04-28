<? include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];

$pacote_edit_nome = filter_input(INPUT_POST, 'pacote_edit_nome', FILTER_SANITIZE_STRING);
$pacote_edit_descricao = filter_input(INPUT_POST, 'pacote_edit_descricao', FILTER_SANITIZE_STRING);
$pacote_edit_valor = filter_input(INPUT_POST, 'pacote_edit_valor', FILTER_SANITIZE_STRING);
$pacote_edit_id = filter_input(INPUT_POST, 'pacote_edit_id', FILTER_SANITIZE_STRING);







$pacote_edit_valor = preg_replace('/[^\d\.\,]/', '', $pacote_edit_valor);
$pacote_val1 = substr($pacote_edit_valor, -5, 6);
$pacote_val1 = str_replace(',', '|', $pacote_val1);
$pacote_val1 = str_replace('.', '|', $pacote_val1);
$pacote_val2 = substr($pacote_edit_valor, -5, 6);
$pacote_val = str_replace($pacote_val2, $pacote_val1, $pacote_edit_valor);
$pacote_val = preg_replace('/[^\d\|]/', '', $pacote_val);
$pacote_edit_valor = str_replace('|', ',', $pacote_val);
//echo $pacote_edit_valor; exit();
if(str_replace(',', '.', $pacote_edit_valor) < 0.01){$pacote_edit_valor='';}
$DEBUG = "E: $pacote_edit_nome - $pacote_edit_descricao - $pacote_edit_valor - $pacote_edit_id";

// TOKEN para usuarios logados
//--------------------------------------
// $EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------




//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Editar clientes
    // -- -------------------------------------------------------
	if(empty($pacote_edit_id)):
			$errors = "ERRO: Esta ação não é permitida.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($pacote_edit_nome)):
			$errors = "ERRO: Nome é obrigatório.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"pacote_edit_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($pacote_edit_valor)):
			$errors = "ERRO: Verifique o valor.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span>
		    <SCRIPT>$('input[name=\"pacote_edit_valor\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------



		$sql = "
	    	UPDATE `{$PREFIXO_PATH}_pacotes` SET
	    		`nome` = :nome,
	    		`descricao` = :descricao,
	    		`valor_base` =      
		    		CONCAT('',  
				       REPLACE(
				           REPLACE(
				               :valor, '.', ''
				           ), 
				        ',', '.'
				       )
				     )
	    	  WHERE `{$PREFIXO_PATH}_pacotes`.`id` = :id;
	    ";	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("PACOTE EDITADO! \\r\\n(id: {$pacote_edit_id})")  );
	            //-- --------------------------------------
	    $statment = $conn->prepare($sql);
		    $statment->bindValue(':nome', "{$pacote_edit_nome}");
		    $statment->bindValue(':descricao', "{$pacote_edit_descricao}");
		    $statment->bindValue(':valor', "{$pacote_edit_valor}");
		    $statment->bindValue(':id', "{$pacote_edit_id}");
	    if(!$statment->execute()){
		    $errors = true;
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
		            'title': '<i class=\"far fas fa-solid fa-box-open nav-icon\"></i> <sup style=\"font-size: 12px;margin-left:-5px;\"><i class=\"far fas fa-solid fa-pen\"></i></sup> &nbsp Pacote Editado!', 
		            'body':'<center>Os dados do pacote <span style=\"font-weight:bold;\">{$pacote_edit_nome}</span>, <br>foram <span style=\"font-weight:bold;\">alterados com sucesso</span>!</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 $('*[name=\"tab\"]').attr('src','JavaScript:$(\'button[title=Recarregar]\').click();');
				 //window.open('JavaScript:reload_loadpaginacaclientes();','tab');
                 setTimeout(function(){
                 		 //window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').focus();','tab'); 
                         // Rolar para para o topo, ao carregar
    					 //window.open('JavaScript:$(\'html, body\').animate({ scrollTop: 0 }, 1500);','tab');
                 },2000);
	    </script>";
	}
	echo json_encode($data);
exit();
//ENDIF;
//--------------------------------------




?>