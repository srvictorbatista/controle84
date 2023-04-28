<? @include_once('./_config.php');	@include_once('../../_config.php');	 @include_once('../../../_config.php');
			    // -- -------------------------------------------------------
				// -- Acessa sessao aberta pela url (via DB)
                //*
			        //-- --------------------------------------
			        $sql = "SELECT *, COUNT(*) AS 'access' FROM `user_sessions` WHERE `sessao`='{$THISPG}' LIMIT 1";
			        $statment = $conn->prepare($sql); $statment->execute(); 
			        $SESSAO_DB = $statment->fetch(PDO::FETCH_ASSOC);
			        //echo "SESSAO_DB: ";print_r($SESSAO_DB); echo "\r\n-------------------------------------\r\n";
			        //-- --------------------------------------
			        if(($SESSAO_DB['access']>0) && (empty($_SESSION["USER_ID"]))){
						$_SESSION["USER_ID"] 		= $SESSAO_DB['user_id'];
						$_SESSION["NOME"]  			= $SESSAO_DB['nome'];						
						$_SESSION["SESSAO_ID"]  	= $SESSAO_DB['sessao'];
						echo "<SCRIPT>window.location.reload();</SCRIPT>";
						exit();
			    	}
			    // -- -------------------------------------------------------
                
			    	
if(    !empty($_SESSION)    ) {
    // -- -------------------------------------------------------
    // -- Verifica validade e existencia do usuario
    // -- -------------------------------------------------------
    if(empty($_SESSION['USER_ID'])){ die("<SCRIPT>window.open('login/','_parent');</SCRIPT>");}
        //-- --------------------------------------
        $sql = "SELECT `id`, `wa_id`, `wa_nick`, `wa_trustkey`, `nome`, `telefone`, `email`, `login`, `pwd`, `cadastro`, DATE_FORMAT(`cadastro`, '%d de %M de %Y as %H:%i:%s') AS `cadastro_formatado` FROM `user_profiles` WHERE id='{$_SESSION['USER_ID']}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        // echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n"; exit();
        //-- --------------------------------------
    	// -- Verifica hosts e permissoes
        //-- --------------------------------------
        $sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE `user_id`='{$_SESSION['USER_ID']}' AND `host` = '{$system_host}' AND `autorization` LIKE '%{$system_autorization}%';";
        //echo "{$sql}";  exit();
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
        // echo "{$sql}\r\nUSER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n"; exit();
        //-- --------------------------------------
        if($USER_ROLES_DB['count'] < 1){
        	//echo "sem permissao\r\n\r\n\r\n";
        	http_response_code(203);
    			if($system_autorization == "admin/index.php"){ echo "<SCRIPT>window.open('../../logout/','_parent');</SCRIPT>"; exit(); } // Se for a pagina de administração de acesso
    			if($system_autorization == "functions.js/index.php"){ echo "console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');"; exit(); } // Se for a pagina de configuracao
    			if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/index.php")){ header('Location: logout/'); exit(); } // Se for a pagina de entrada, deslogar
    			if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/clientes.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
    			if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/pacotes.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
    			if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/relatorios.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
	            $errors = $msg_unpermited;
	            $data['success'] = false;
	            $data['message'] = str_replace("\n", "<br>", $errors);
	            $data['errors'] = "SYSTEM AUTORIZATION: [{$system_autorization}]";
    		echo json_encode($data);
        exit();
        }
    // -- -------------------------------------------------------
}else{
	//echo "sem permissao\r\n\r\n\r\n";
    http_response_code(203);
    	if($system_autorization == "admin/index.php"){ echo "<SCRIPT>window.open('../../logout/','_parent');</SCRIPT>"; exit(); } // Se for a pagina de administração de acesso
    	if($system_autorization == "functions.js/index.php"){ echo "console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');"; exit(); } // Se for a pagina de configuracao
    	if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/index.php")){ header('Location: logout/'); exit(); } // Se for a pagina de entrada, deslogar
    	if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/clientes.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
    	if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/pacotes.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
    	if($system_autorization == (explode('/',$THISPATCH)[(count(explode('/',$THISPATCH))-2)]."/relatorios.php")){ echo "<span style=\"font-size:30px;font-family:Arial;margin-top:40px;\">{$msg_unpermited}</span><script>console.warn('SYSTEM AUTORIZATION: [{$system_autorization}]');</script>"; exit(); } // Se for uma pagina interna
		$errors = $msg_unpermited;
		$data['success'] = false;
		$data['message'] = str_replace("\n", "<br>", $errors);
		$data['errors'] = "SYSTEM AUTORIZATION: [{$system_autorization}]";
	echo json_encode($data);
exit();
}
/**/
?>