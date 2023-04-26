<?
include_once('../../_config.php'); include_once('../../_sessao.php');
//require_once("PHPMailer-5.2-stable/PHPMailerAutoload.php");
///////////////////
$errors = [];
$data = [];
$cliente_nome = trim(TrataNome(filter_input(INPUT_POST, 'cliente_nome', FILTER_SANITIZE_STRING)));
$cliente_telefone = filter_input(INPUT_POST, 'cliente_telefone', FILTER_SANITIZE_STRING);
$cliente_email = filter_input(INPUT_POST, 'cliente_email', FILTER_SANITIZE_STRING);
$cliente_pacoteid = filter_input(INPUT_POST, 'cliente_pacoteid', FILTER_SANITIZE_STRING);
$cliente_notas = filter_input(INPUT_POST, 'cliente_notas', FILTER_SANITIZE_STRING);
$cliente_valor_contrato = filter_input(INPUT_POST, 'cliente_valor_contrato', FILTER_SANITIZE_STRING);
$cliente_valor_contrato = preg_replace('/[^\d\.\,]/', '', $cliente_valor_contrato);
$cliente_val1 = substr($cliente_valor_contrato, -5, 6);
$cliente_val1 = str_replace(',', '|', $cliente_val1);
$cliente_val1 = str_replace('.', '|', $cliente_val1);
$cliente_val2 = substr($cliente_valor_contrato, -5, 6);
$cliente_val = str_replace($cliente_val2, $cliente_val1, $cliente_valor_contrato);
$cliente_val = preg_replace('/[^\d\|]/', '', $cliente_val);
$cliente_valor_contrato = str_replace('|', ',', $cliente_val);
$venc = filter_input(INPUT_POST, 'venc', FILTER_SANITIZE_STRING);


$cliente_nome = mb_strtoupper($cliente_nome); // Todo o nome para maiusculo



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
  	$aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:15px;\">DOMINGO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	 $cliente_venc = date('Y-m-d', strtotime("+1 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }elseif($dia_semana == 6){
    //echo "Sábado\r\n";
    $aviso_data_venc = " <span class=\"badge bg-danger\" style=\"font-size:15px;\">SÁBADO: Data de vencimento, movida para a prox. segunda feira.</span>";
  	$cliente_venc = date('Y-m-d', strtotime("+2 day", strtotime("{$venc_ano}-{$venc_mes}-{$venc_dia}")));
  }
  else{
    //echo "Esta data é um dia útil\r\n";
    $aviso_data_venc = "";
    $cliente_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  }/**/
  $aviso_data_venc = "";
  $cliente_venc = "{$venc_ano}-{$venc_mes}-{$venc_dia}";
  //echo "'{$cliente_venc}'";
//-- ------------------------------------------------------------------------------------------


$cliente_telefone = preg_replace('/[^0-9]/', '', $cliente_telefone);
if(strlen($cliente_telefone) <= 10){$cliente_telefone='';}


// $DEBUG = "E: $cliente_pacoteid - $cliente_valor_contrato"; echo $DEBUG;


// TOKEN para usuarios logados
//--------------------------------------
//$EXIBE_TOKEN = "\n\n$login_token - {$_SESSION["TOKEN2"]}\n\n";
//--------------------------------------



//IF(	($_POST) && (!@empty($login_senha)) && (!@empty($login_senha2)) && (!@empty($login_login))  && (!@empty($cliente_pacoteid)) /*&& ($_SESSION["PRIVID"]==1)*/	):
    // -- -------------------------------------------------------
    // -- Cadastra novo cliente
    // -- -------------------------------------------------------
	if(empty($cliente_nome)):
			$errors = "ERRO: Nome não pode ser vazio.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span> 
		    <SCRIPT>$('input[name=\"cliente_nome\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------
    /*
	if(empty($cliente_telefone)):
			$errors = "ERRO: Telefone esta vazio ou incorreto.";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span> 
		    <SCRIPT>$('input[name=\"cliente_telefone\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
	/**/
    // -- -------------------------------------------------------
    $sql = "SELECT id AS cliente_id, nome FROM `_clientes` WHERE `nome` = '$cliente_nome' LIMIT 1";
	$statment = $conn->prepare($sql); $statment->execute();  
	$CLIENTE_DB = $statment->fetch(PDO::FETCH_ASSOC);
	if($CLIENTE_DB['nome'] == $cliente_nome):
			$errors = "ERRO: Este cliente já possui cadastro!";
		    $data['success'] = false;
		    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> ".str_replace("\n", "<br>", $errors)."</span> 
		    <SCRIPT>$('input[name=\"cliente_telefone\"]').focus();</SCRIPT>";
		    $data['errors'] = $errors;
	echo json_encode($data);
	exit();
	endif;
    // -- -------------------------------------------------------




    $sql = "
    	INSERT INTO `_clientes` (
    		`nome`,
    		`telefone`,
    		`email`
    	 )
    	VALUES (
    		:nome,
    		:telefone,
    		:email
    	 )    		
    ";
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
	            eval( system_log("NOVO CLIENTE CRIADO! \\r\\n({$cliente_nome})")  );
	            //-- --------------------------------------
    $statment = $conn->prepare($sql);
	    $statment->bindValue(':nome', "{$cliente_nome}");
	    $statment->bindValue(':telefone', "{$cliente_telefone}");
	    $statment->bindValue(':email', "{$cliente_email}");
	$statment->execute();
//-- --------------------------------------

$sql = "SELECT id AS cliente_id FROM `_clientes` ORDER BY id DESC LIMIT 1";
$statment = $conn->prepare($sql); $statment->execute(); 
while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){
	$ULTIMOCLIENTE = $row_sql_cont['cliente_id'];
}
//echo "---->".$ULTIMOCLIENTE;

$sql = "SELECT nome, descricao FROM `_pacotes` WHERE id='{$cliente_pacoteid}' LIMIT 1";
$statment = $conn->prepare($sql); $statment->execute();
$PACOTE_NOME='';$PACOTE_DESC='';$PACOTE_VALO='';
while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){
	$PACOTE_NOME = $row_sql_cont['nome'];
	$PACOTE_DESC = $row_sql_cont['descricao'];
}
//echo "---->".$PACOTE_NOME; exit();


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
	    $statment->bindValue(':pacote_id', "{$cliente_pacoteid}");
	    $statment->bindValue(':pacote_titulo', "{$PACOTE_NOME}");
	    $statment->bindValue(':pacote_descricao', "{$PACOTE_DESC}");
	    $statment->bindValue(':notas', "{$cliente_notas}");
	    $statment->bindValue(':valor', "{$cliente_valor_contrato}");
	    $statment->bindValue(':vencimento', "{$cliente_venc}");
	$statment->execute();
//-- --------------------------------------
	            //-- --------------------------------------
	            //-- REGISTRO DE LOG
	            //-- --------------------------------------
					//-- --------------------------------------
					$_try_sql = "SELECT * FROM `_contratos` ORDER BY `id` DESC LIMIT 1";
					$statment = $conn->prepare($_try_sql); $statment->execute(); 
					$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
					//echo "CONTRATO_DB: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
				//-- --------------------------------------
	            eval( system_log("NOVO CONTRATO CRIADO! \\r\\n(id: {$CONTRATO_DB['id']})")  );
	            //-- --------------------------------------


	    // -- -------------------------------------------------------
		//-- Quitar o contrato na data atual ao cadastrar contrato
		//-- --------------------------------------------------------
		//-- --------------------------------------
		$aviso_contrato='';
		$sql = "SELECT * FROM `_contratos` WHERE cliente_id='{$ULTIMOCLIENTE}' LIMIT 1";
		$statment = $conn->prepare($sql); $statment->execute(); 
		$CONTRATO_DB = $statment->fetch(PDO::FETCH_ASSOC);
		$CONTRATO_DB['valor'] = str_replace('.', ',', $CONTRATO_DB['valor']);
		//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
		//-- --------------------------------------
			$aviso_contrato = "<span class=\"badge bg-success bg-white\" style=\"font-size:15px;\">Primeira quitação registrada na data de hoje.</span> <br>";
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
	            eval( system_log("CONTRATO QUITADO: \\r\\n(cliente_id: {$CONTRATO_DB['cliente_id']}, valor: R\$ {$CONTRATO_DB['valor']}, vencimento: ". date("d/m/Y").")")  );
	            //-- --------------------------------------
		    $statment = $conn->prepare($sql);
			    $statment->bindValue(':cliente_id', "{$CONTRATO_DB['cliente_id']}");
			    $statment->bindValue(':pacote_id', "{$CONTRATO_DB['pacote_id']}");
			    $statment->bindValue(':pacote_titulo', "{$CONTRATO_DB['pacote_titulo']}");
			    $statment->bindValue(':pacote_descricao', "{$CONTRATO_DB['pacote_descricao']}");
			    $statment->bindValue(':notas', "{$CONTRATO_DB['notas']}");
			    $statment->bindValue(':valor', "{$CONTRATO_DB['valor']}");
			    $statment->bindValue(':vencimento', date("Y-m-d"));
			$statment->execute();
		//-- --------------------------------------------------------

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
		            'body':'<center>Novo cliente <span style=\"font-weight:bold;\">cadastrado</span> com <span style=\"font-weight:bold;\">sucesso</span>! {$aviso_data_venc} {$aviso_contrato}</center>', 
		            'action':'#MDL_ACTION',
		            'method':'POST',
		        },
		        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Fechar', 'link':'javascript:void(0)'}, 
		    ]
		);




                 // Recarregar listagem
				 window.open('JavaScript:loadpaginaclientes();','tab');
                 setTimeout(function(){
                 		 window.open('JavaScript:$(\'.mailbox-controls button[title=Recarregar]\').focus();','tab'); 
                         // Rolar para para o topo, ao carregar
    					 window.open('JavaScript:$(\'html, body\').animate({ scrollTop: 0 }, 1500);','tab');
                 },2000);
	    </script>";
	}
	echo json_encode($data);
exit();
//ENDIF;
//--------------------------------------




?>