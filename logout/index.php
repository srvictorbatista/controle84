<? http_response_code(102);
// removendo todas as sessões
// session_start();
	include_once('../_config.php');
						//-- --------------------------------------
						//-- REGISTRO DE LOG
						//-- --------------------------------------
						eval( system_log('SAIU DO SISTEMA')  );
						//-- --------------------------------------
	//-- --------------------------------------
	$sql = "
	   	DELETE FROM `user_sessions` 
	   	WHERE `sessao` = :sessao
	   	";
	   $statment = $conn->prepare($sql);
	   $statment->bindValue(':sessao', "{$_SESSION['SESSAO_ID']}");
	if(!$statment->execute()){ $errors = true;}
	//-- --------------------------------------
session_destroy();
unset( $_SESSION );
// removendo sessões do usuario (por precaução)
unset( $_SESSION['USER_ID'] );
unset( $_SESSION['NOME'] );
$_SESSION['USER_ID'] = null;
$_SESSION['NOME'] = null;
header('Location: ../login/'); exit();
?>