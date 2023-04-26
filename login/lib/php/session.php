<?
include_once('../../../_config.php');

$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING) : false;
$pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING) ? trim(filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING)) : false;

$host = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING) ? trim(filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING)) : false;







if(    ($_SERVER['REQUEST_METHOD'] == 'POST')    ) {
    // -- -------------------------------------------------------
    // -- Verifica validade e existencia
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE login='{$login}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $USER_DB['pwd'];
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
    // -- -------------------------------------------------------

        //echo " $pwd && $login && $host";
	

		if(password_verify($pwd.$login, $hashed_password) && (strlen($pwd) >= 6) && (strlen($login) >= 3) && (strlen($host) >= 3)){
			$_SESSION["USER_ID"] 		= $USER_DB['id'];
			$_SESSION["NOME"]  			= $USER_DB['nome'];
			$_SESSION["SESSAO_ID"]  	= $_SESSION['TOKEN'];
			//-- --------------------------------------
			//-- grava sessao no DB
			//-- --------------------------------------
			/*
			$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
			$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
			$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
			$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
			$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
			$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
			$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");

			if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true) {
			   // echo "Olá, eu sou mobile";
			} else {
			  //  echo "Olá, eu sou um computador";
			}/**/

			$mobile = FALSE; $DISP = "PC: {$_SERVER['HTTP_USER_AGENT']}"; $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
			foreach($user_agents as $user_agent){
			    if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
			        $mobile = TRUE; $modelo = $user_agent; break;
			    }
			}
			if ($mobile){$DISP = strtolower($modelo);}


			    $sql = "
			    	INSERT INTO `user_sessions` (
			    		`user_id`,
			    		`nome`,
			    		`disp`,
			    		`sessao`
			    	 )
			    	VALUES (
			    		:user_id,
			    		:nome,
			    		:disp,
			    		:sessao
			    	 )    		
			    ";
			    $statment = $conn->prepare($sql);
				    $statment->bindValue(':user_id', "{$USER_DB['id']}");
				    $statment->bindValue(':nome', "{$USER_DB['nome']}");
				    $statment->bindValue(':disp', "{$DISP}");
				    $statment->bindValue(':sessao', "{$_SESSION['TOKEN']}");
		    	if(!$statment->execute()){ $errors = true;}
			//-- --------------------------------------

		            $success = "Passed:  Bem vindo {$USER_DB['nome']}!
		    	                   <input type=\"hidden\" name=\"TokenLoged\" value=\"{$host}??={$_SESSION['TOKEN']}\">";
		            $data['success'] = true;
		            $data['message'] = "<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i> ".str_replace("\n", "<br>", $success)."</span>";
		            $data['errors'] = false;
						//-- --------------------------------------
						//-- REGISTRO DE LOG
						//-- --------------------------------------
						eval( system_log('ENTROU NO SISTEMA')  );
						//-- --------------------------------------
		    echo json_encode($data);   
		exit(); 
		}else{
		            $errors = "ERRO: Credenciais inválidas!";
		            $data['success'] = false;
		            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
		            $data['errors'] = $errors;
						//-- --------------------------------------
						//-- REGISTRO DE LOG
						//-- --------------------------------------
						eval( system_log('FALHA NA AUTENTICAÇÃO')  );
						//-- --------------------------------------
		    echo json_encode($data);
		exit();
		}

}