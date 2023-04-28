<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$pacote_nome = filter_input(INPUT_POST, 'pacote_nome', FILTER_SANITIZE_STRING);
$pacote_descricao = filter_input(INPUT_POST, 'pacote_descricao', FILTER_SANITIZE_STRING);
$pacote_valor = filter_input(INPUT_POST, 'pacote_valor', FILTER_SANITIZE_STRING);
$pacote_pacoteid = filter_input(INPUT_POST, 'pacote_pacoteid', FILTER_SANITIZE_STRING);







$pacote_valor = preg_replace('/[^\d\.\,]/', '', $pacote_valor);
$pacote_val1 = substr($pacote_valor, -5, 6);
$pacote_val1 = str_replace(',', '|', $pacote_val1);
$pacote_val1 = str_replace('.', '|', $pacote_val1);
$pacote_val2 = substr($pacote_valor, -5, 6);
$pacote_val = str_replace($pacote_val2, $pacote_val1, $pacote_valor);
$pacote_val = preg_replace('/[^\d\|]/', '', $pacote_val);
$pacote_valor = str_replace('|', ',', $pacote_val);
//echo $pacote_valor; exit();
if(str_replace(',', '.', $pacote_valor) < 0.01){$pacote_valor='';}
$DEBUG = "$pacote_nome - $pacote_descricao - $pacote_valor - $pacote_pacoteid";


// TOKEN para usuarios logados
//--------------------------------------
//$EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------




//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($pacote_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Cadastra novo cliente
    // -- -------------------------------------------------------
	if(empty($pacote_nome)):
			$errors = "ERRO: Nome do pacote não pode ser vazio.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span> 
		    <SCRIPT>$('input[name=\"pacote_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
	if(empty($pacote_valor)):
			$errors = "ERRO: Valor esta vazio ou incorreto.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span> 
		    <SCRIPT>$('input[name=\"pacote_valor\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------




    $sql = "
    	INSERT INTO `{$PREFIXO_PATH}_pacotes` (
    		`nome`, 
    		`descricao`, 
    		`valor_base`
    	) VALUES (
    		:nome, 
		 	:descricao,
		     CONCAT('',  
		       REPLACE(
		           REPLACE(
		               :valor_base, '.', ''
		           ), 
		        ',', '.'
		       )
		     )
		)		 		
    ";
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("NOVO PACOTE CRIADO! \\r\\n({$pacote_nome}, R\$ {$pacote_valor})")  );
	            //-- --------------------------------------
    $statment = $conn->prepare($sql);
	    $statment->bindValue(':nome', "{$pacote_nome}");
	    $statment->bindValue(':descricao', "{$pacote_descricao}");
	    $statment->bindValue(':valor_base', "{$pacote_valor}");
	$statment->execute();
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
		            'title': '<i class=\'bi bi-check-circle-fill\'></i> Cliente Cadastrado!', 
		            'body':'<center>Novo pacote <span style=\"font-weight:bold;\">cadastrado</span> com <span style=\"font-weight:bold;\">sucesso</span>!</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 $('*[name=\"tab\"]').attr('src','JavaScript:$(\'button[title=Recarregar]\').click();');
				 //window.open('JavaScript:reload_loadpaginapacotes();','tab');
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