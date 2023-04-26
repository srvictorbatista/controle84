<?
include_once('../../_config.php');

// $cliente_edit_email = filter_input(INPUT_POST, 'cliente_edit_email', FILTER_SANITIZE_STRING);
                        //-- --------------------------------------
                        //-- REGISTRO DE LOG
                        //-- --------------------------------------
                         eval( system_log("{$_SERVER["HTTP_USER_AGENT"]}")  );
                        //-- --------------------------------------





############################################                        
### WHATSAUTO                               
############################################
// Verifica se os dados via APP foram enviados usando o método POST      
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_SERVER['CONTENT_TYPE'] == 'application/x-www-form-urlencoded; charset=UTF-8')){
    // Obtém os dados POST enviados pelo aplicativo
    if($_POST['app'] == 'WhatsAuto'){

        if($_POST['message'] == "{$wa_trustkey}"){


            WhatsAuto_SEND("TESTE: *{$_POST['phone']}*");
            exit();

            
            $login['sugestao']  = substr(mb_strtoupper(preg_replace("/[^a-zA-Z0-9]/", "", $wa_nick.$_SESSION["PREFIX"])), 0, 3).str_pad(rand(0,999) , 3 , '0' , STR_PAD_LEFT);



        // -- -------------------------------------------------------
        // -- Valida se e realmente novo ou se ainda não foi validado
        // -- -------------------------------------------------------
            //-- --------------------------------------
            $sql = "SELECT * FROM `user_profiles` WHERE wa_id='{$wa_id}' LIMIT 1";
            $statment = $conn->prepare($sql); $statment->execute(); 
            $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
            //echo "USER_DB: [$sql]";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
            //-- --------------------------------------

            if(($body == $wa_trustkey) && ($wa_trustkey != $USER_DB['wa_trustkey'])){

                $sql = "
                    UPDATE `user_profiles` SET 
                        `wa_id`         = :wa_id,
                        `wa_nick`       = :wa_nick,
                        `wa_trustkey`   = :wa_trustkey,
                        `nome`          = :nome,
                        `telefone`      = :telefone,
                        `email`         = :email,
                        `login`         = :login

                    WHERE `user_profiles`.`id` = :id 
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':wa_id', "{$wa_id}");
                    $statment->bindValue(':wa_nick', "{$wa_nick}");
                    $statment->bindValue(':wa_trustkey', "{$wa_trustkey}");
                    $statment->bindValue(':nome', "{$USER_DB['nome']}");
                    $statment->bindValue(':telefone', "{$USER_DB['telefone']}");
                    $statment->bindValue(':email', "{$email}");
                    $statment->bindValue(':login', "{$login['sugestao']}");
                    $statment->bindValue(':id', "{$USER_DB['id']}");
                $statment->execute();

                //Confirmado com sucesso!
                if(empty($USER_DB['pwd'])){
                    WA_SEND("{$wa_id}","*Não localizamos seu cadastro!*\\n\\nConfira seu número (com DDD) *".str_replace("55", "0", $wa_id)."* e tente novamente.");
                exit();
                }
                WA_SEND("{$wa_id}","*Confirmação realizada com sucesso!* \\n\\nPara criar sua senha, acesse o link: ".str_replace("lib/hook/","login/",$url)."?token={$USER_DB['pwd']}&t=".time()." ");

            exit();
            }else if($body == $USER_DB['wa_trustkey']){
                WA_SEND("{$wa_id}","*Confirmação já realizada.* \\n\\nPara alterar sua senha, acesse o link: ".str_replace("lib/hook/","login/",$url)."?token={$USER_DB['pwd']}&t=".time()." ");
            exit();
            }else{
                WA_SEND("{$wa_id}","*ERRO:* \\n\\nComando desconhecido.");
            exit();
            }

        }else{
            WhatsAuto_SEND("...");
        }





            //echo "{\r\n\"reply\":  \"AAAA+\"\r\n}";
    }else{
        // Se os dados não puderem ser identificados, exibe um erro
        http_response_code(417);
        echo "{\"Erro\":[\" Os dados enviados são inválidos (COD: 314).\"]}";
    }

exit();
}


############################################
### POSITUS
############################################
// Verifica se os dados JSON foram enviados usando o método POST
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_SERVER['CONTENT_TYPE'] == 'application/json')){

    // Obtém os dados JSON enviados pelo cliente
    $json_data = json_decode(file_get_contents('php://input'), true);
     //echo "<pre>"; json_encode($json_data);   echo $_POST;
    
    // Verifica se os dados foram convertidos com sucesso
    if (is_array($json_data)) {        
        // Usa os dados JSON da maneira que desejar
        // Exemplo: exibe o valor das chaves
        //*




        //*
        echo "<PRE>";
        echo "HTTP_USER_AGENT: {$_SERVER["HTTP_USER_AGENT"]}\r\n";
        echo "-- ---------------------------------------------------\r\n";

        //WHATSAUTO
        echo 'app: '.$json_data['app']."\r\n";
        echo 'sender '.$json_data['sender']."\r\n";
        echo 'message '.$json_data['message']."\r\n";
        echo 'group_name '.$json_data['group_name']."\r\n";
        echo 'phone '.$json_data['phone']."\r\n";
        echo "-- ---------------------------------------------------\r\n";

        //POSITUS
        echo 'nome: '.$json_data['contacts'][0]['profile']['name']."\r\n";
        echo 'wa_id: '.$json_data['contacts'][0]['wa_id']."\r\n";
        echo 'from: '.$json_data['messages'][0]['from']."\r\n";
        echo 'id: '.$json_data['messages'][0]['id']."\r\n";
        echo 'body: '.$json_data['messages'][0]['text']['body']."\r\n";
        echo 'timestamp: '.$json_data['messages'][0]['timestamp']."\r\n";
        echo 'type: '.$json_data['messages'][0]['type']."\r\n";
        echo 'TESTE: '.$json_data['TESTE'][0]['text']."\r\n";
        /**/

        $wa_id              = $json_data['contacts'][0]['wa_id']; // num telefone
        $wa_nick            = urldecode($json_data['contacts'][0]['profile']['name']);
        // $wa_trustkey        = ''; // esta em _config
        $telefone           = $json_data['contacts'][0]['wa_id'];
        $email              = '';
        $body               = trim($json_data['messages'][0]['text']['body']);

        // carga de status
        $recipient_id       = $json_data['statuses'][0]['message']['recipient_id']; // num telefone
        $origin             = $json_data['statuses'][0]['conversation']['origin']['type']; // user_initiated
        $category           = $json_data['statuses'][0]['pricing']['category']; // user_initiated
        $pricing_model      = $json_data['statuses'][0]['pricing']['pricing_model']; // CBP

        $login['sugestao']  = substr(mb_strtoupper(preg_replace("/[^a-zA-Z0-9]/", "", $wa_nick.$_SESSION["PREFIX"])), 0, 3).str_pad(rand(0,999) , 3 , '0' , STR_PAD_LEFT);



    // -- -------------------------------------------------------
    // -- Valida se e realmente novo ou se ainda não foi validado
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE wa_id='{$wa_id}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_DB: [$sql]";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------

        if(($body == $wa_trustkey) && ($wa_trustkey != $USER_DB['wa_trustkey'])){

            $sql = "
                UPDATE `user_profiles` SET 
                    `wa_id`         = :wa_id,
                    `wa_nick`       = :wa_nick,
                    `wa_trustkey`   = :wa_trustkey,
                    `nome`          = :nome,
                    `telefone`      = :telefone,
                    `email`         = :email,
                    `login`         = :login

                WHERE `user_profiles`.`id` = :id 
            ";
            $statment = $conn->prepare($sql);
                $statment->bindValue(':wa_id', "{$wa_id}");
                $statment->bindValue(':wa_nick', "{$wa_nick}");
                $statment->bindValue(':wa_trustkey', "{$wa_trustkey}");
                $statment->bindValue(':nome', "{$USER_DB['nome']}");
                $statment->bindValue(':telefone', "{$USER_DB['telefone']}");
                $statment->bindValue(':email', "{$email}");
                $statment->bindValue(':login', "{$login['sugestao']}");
                $statment->bindValue(':id', "{$USER_DB['id']}");
            $statment->execute();

            //Confirmado com sucesso!
            if(empty($USER_DB['pwd'])){
                WA_SEND("{$wa_id}","*Não localizamos seu cadastro!*\\n\\nConfira seu número (com DDD) *".str_replace("55", "0", $wa_id)."* e tente novamente.");
            exit();
            }
            WA_SEND("{$wa_id}","*Confirmação realizada com sucesso!* \\n\\nPara criar sua senha, acesse o link: ".str_replace("lib/hook/","login/",$url)."?token={$USER_DB['pwd']}&t=".time()." ");

        exit();
        }else if($body == $USER_DB['wa_trustkey']){
            WA_SEND("{$wa_id}","*Confirmação já realizada.* \\n\\nPara alterar sua senha, acesse o link: ".str_replace("lib/hook/","login/",$url)."?token={$USER_DB['pwd']}&t=".time()." ");
        exit();
        }else{
            WA_SEND("{$wa_id}","*ERRO:* \\n\\nComando desconhecido.");
        exit();
        }


	} else {
	    // Se os dados não puderem ser convertidos, exibe um erro
	    $error = json_last_error_msg();
	    http_response_code(417);
	    echo "{\"Erro\":[\" Os dados JSON enviados são inválidos. ($error)\"]}";
	}

} else {
    // Se a solicitação não for do tipo POST ou o cabeçalho Content-Type não for application/json, exibe um erro
    http_response_code(400);
    echo "{\"Erro\":[\" Esta solicitação não é permitida.\"]}";
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 




exit(); //CALLBACK

$errors = [];
$data = [];
$data['message'] = "Teste ok!";
$data['POST'] = @$_POST;
$data['GET'] = @$_GET;
if(!empty($errors)){
    $data['success'] = false;
    $data['errors'] = $errors;
}else{
    $data['success'] = true;
    $data['message'] = "<span style=\"color:#EE3333;\">ALGO DEU ERRADO: <br>Contate o programador.</span>";
    $data['message'] = "<span style=\"color:#33AAAA;\">Success!</span>";
}
echo json_encode($data);
exit();
?>