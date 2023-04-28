<?
include_once('../../../_config.php');

$nome       = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$host       = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING) : false;
$email      = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : false;
$telefone   = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT) ? str_replace("-","",str_replace(".","",filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT)))/1 : false;
$COOKIE     = preg_replace("/^[a-zA-Z0-9-]/","", trim($_COOKIE['PHPSESSID'])) ? preg_replace("/^[a-zA-Z0-9-]/","", trim($_COOKIE['PHPSESSID'])) : false;

$nome       = TrataNome($nome);


$validation = filter_input(INPUT_POST, 'validation', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'validation', FILTER_SANITIZE_STRING) : false;



    // -- -------------------------------------------------------
    // -- Novo Usuario validado
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------
    // -- Valida se é realmente novo ou se ainda não foi validado
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE pwd='{$validation}' AND `wa_trustkey` = '{$wa_trustkey}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
    if(!empty($USER_DB['pwd']) && !empty($validation)):
            $data['success'] = false;
            $data['message'] = "<input type=\"hidden\" name=\"goit\" value=\"".str_replace("lib/php/","",$url)."?token=TEMP{$_SESSION["PREFIX"]}{$_SESSION["TOKEN"]}&t=".time()."\">";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    elseif(!empty($validation)):
            $data['success'] = false;
            $data['message'] = "<center style=\"color:#DDD;opacity: 0.7;font-size:14px;font-weight:normal;\">
                                  Aguardando validação...
                                  <span style=\"padding:15px; background: url(launcher/images/loader.gif) center no-repeat;background-size: 20px; opacity: 0.8;}\"></span>
                                </center>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- -------------------------------------------------------





if(
        ($_SERVER['REQUEST_METHOD'] == 'POST') && 
        !empty($COOKIE) &&
        !empty($host)
 ) {


    // -- -------------------------------------------------------
    // -- Novo Usuario
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------
    // -- Valida Nome
    // -- -------------------------------------------------------
    if(strlen($nome) < 3):
            $errors = "ERRO: Nome deve conter no mínimo, 3 caracteres.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    /*
    // -- -------------------------------------------------------
    // -- Valida Telefone
    // -- -------------------------------------------------------
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    if(strlen($telefone) <= 9){$telefone='';}else{$telefone='55'.$telefone;} $telefone = substr($telefone, 0, 4).substr($telefone, -8); //Pegando apenas os 8 últimos caracters e os primeiros 4
    if(empty($telefone)):
            $errors = "ERRO: Verifique o telefone.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>
            <SCRIPT>$('input[name=\"telefone\"]').focus();</SCRIPT>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    /**/

    // -- -------------------------------------------------------
    // -- Valida email
    // -- -------------------------------------------------------
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) ):
        //empty($email)
            $errors = "ERRO: Verifique o e-mail.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    /**/
    // -- -------------------------------------------------------

    // -- -------------------------------------------------------
    // -- Valida se e realmente novo ou se ainda não foi validado
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE email='{$email}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        // echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n"; exit();
        //-- --------------------------------------


    // -- -------------------------------------------------------
    // -- Verifica se é um dos adminitradores
    // -- -------------------------------------------------------
    if( 
        ($USER_DB['id']) == '1' ||
        ($USER_DB['id']) == '2' ||
        ($USER_DB['id']) == '3'
    ){
            //-- --------------------------------------
            //-- Conceder autorizações administrativas
            //-- --------------------------------------

                // -- Reseta permissoes para este host (caso haja)
                $sql = "DELETE FROM `user_roles` WHERE `user_id` = '{$USER_DB['id']}' AND `host` = '{$system_host}';"; $statment = $conn->prepare($sql)->execute();

                $sql = "
                    INSERT INTO `user_roles` (
                        `user_id`,
                        `host`,
                        `autorization_id`
                     )
                    VALUES (
                        :user_id,
                        :host,
                        :autorization_id
                     );
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "1");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "2");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "3");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "4");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "12");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "15");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "19");
                $statment->execute();
            //-- --------------------------------------


                $success = "{$USER_DB['nome']}: Permissões concedidas! <br> Por favor, faça login para entrar.";
                    $data['errors'] = false;
                    $data['message'] = "<span style=\"color:#33AAAA;\">{$success}</span>
                                        <SCRIPT>
                                            \$('input[name=login').val('{$USER_DB['login']}'); 
                                            \$('#login #form_retunr').html('<span style=\"color:#33AAAA;\">Permissões concedidas!</span> <br><span style=\"color:#AAA;\">Por favor, informe suas credenciais.</span>');
                                            setTimeout(function(){   \$('a#login').click();   }, 3000);
                                        </SCRIPT>";
                    $data['success'] = $success;
                echo json_encode($data);
            exit();

    }


    // -- -------------------------------------------------------
    // -- -------------------------------------------------------


    
    // -- -------------------------------------------------------
    // -- Novo (com email não validado)
    // -- -------------------------------------------------------
    if(
        (empty($USER_DB['email'])) && 
        (
            (empty($USER_DB['wa_trustkey'])) || 
            (@$USER_DB['wa_trustkey'] != $wa_trustkey)
        )
    ):            

            $sql = "
                INSERT INTO `user_profiles` (
                    `wa_id`,
                    `wa_nick`,
                    `wa_trustkey`,
                    `nome`,
                    `telefone`,
                    `email`,
                    `pwd`
                 )
                VALUES (
                    :wa_id,
                    :wa_nick,
                    :wa_trustkey,
                    :nome,
                    :telefone,
                    :email,
                    :pwd
                 )          
            ";
            $statment = $conn->prepare($sql);
                $statment->bindValue(':wa_id', "{$telefone}");
                $statment->bindValue(':wa_nick', "");
                $statment->bindValue(':wa_trustkey', "");
                $statment->bindValue(':nome', "$nome");
                $statment->bindValue(':telefone', "{$telefone}");
                $statment->bindValue(':email', "{$email}");
                $statment->bindValue(':pwd', "TEMP{$_SESSION["PREFIX"]}{$_SESSION["TOKEN"]}");
            $statment->execute();


            //-- --------------------------------------
            $sql = "SELECT * FROM `user_profiles` WHERE email='{$email}' LIMIT 1";
            $statment = $conn->prepare($sql); $statment->execute(); 
            $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
            //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
            //-- --------------------------------------
            //-- Autorizações iniciais
            //-- --------------------------------------
                $sql = "
                    INSERT INTO `user_roles` (
                        `user_id`,
                        `host`,
                        `autorization_id`
                     )
                    VALUES (
                        :user_id,
                        :host,
                        :autorization_id
                     );
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "1");
                $statment->execute();
            /*
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "");
                $statment->execute();
            //-- --------------------------------------
            /**/




            require("PHPMailer-5.2-stable/PHPMailerAutoload.php");
            include("layout_padrao.php");

            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();

            //-- ---- C-PANEL
            $mail->Host             = $SMTP_MAIL_SEND['HOST'];            // Specify main and backup SMTP servers
            $mail->SMTPSecure       = $SMTP_MAIL_SEND['CRIPT'];           // Enable tls encryption, `ssl` also accepted
            $mail->Port             = $SMTP_MAIL_SEND['PORT'];            // TCP port to connect to
            $mail->SMTPAuth         = $SMTP_MAIL_SEND['AUTH'];            // Enable SMTP authentication
            $mail->Username         = $SMTP_MAIL_SEND['USER'];            // SMTP username
            $mail->Password         = $SMTP_MAIL_SEND['PSWD'];            // SMTP password

            $mail->setFrom($SMTP_MAIL_SEND['USER'], $_SERVER['SERVER_NAME'].' - NAO RESPONDA');
            $mail->addAddress("{$email}", "{$nome}");// Detinatario (Name is optional)
            $mail->addReplyTo($SMTP_MAIL_SEND['REPLITO'], $_SERVER['SERVER_NAME']); // responder para
            $mail->addCC('sistema@controle84.com', 'bkp');
            $mail->addBCC('sistema@controle84.com', 'bkp');

            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');  // Add attachments (Optional name)
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = utf8_decode("{$nome}: Confirme seu cadastro");
            $mail->Priority = 3;
            //$mail->Body    = utf8_decode('Este é um conteúdo em HTML, com uma parte em <b>negrito</b> para uma breve demonstração.');
            $mail->Body    = utf8_decode( MailLayout(
                utf8_encode($mail->Subject), 
                "Agradecemos por se inscrever em <b>Controle84</b>.com. Você está quase terminando - Por favor, confirme seu e-mail e conclua sua inscrição.", 
                "Para ativar seu cadastro, clique no seguinte link:", 
                "Confirmar e-mail",
                "".str_replace("lib/php/","",$url)."?token={$USER_DB['pwd']}&t=".time()."&mail_trustkey={$wa_trustkey}", 
                "Não responda este e-mail. Pois, ele não é monitorado.",
                "#"
            ) );
            $mail->AltBody = strip_tags($mail->Body);             // Texto plano para clientes que não suportam html

            if(!$mail->send()){
                //echo 'Algo deu errado! Motivo: ' . $mail->ErrorInfo;
                $errors = "ERRO: " . $mail->ErrorInfo;
                        $data['success'] = false;
                        $data['message'] = "<span style=\"color:#999;\">{$errors}</span>
                        <SCRIPT>$('input[name=\"telefone\"]').focus();</SCRIPT>";
                        $data['errors'] = $errors;
                echo json_encode($data);
            exit();
            }else{
                //echo 'E-mail enviado!';
                $success = "<span style=\"color:#CCC;font-size:18px;\">Lhe enviamos um e-mail de confirmação:</span> <br>Por favor, verifique seu e-mail para continuar seu cadastro...";
                    $data['errors'] = false;
                    $data['message'] = "<span style=\"color:#999;\">{$success}</span>";
                    $data['success'] = $success;
                echo json_encode($data);
            exit();
            }            
            #########################################
    exit();
    endif;
    /**/
    // -- -------------------------------------------------------












    ////////////////////////////////////////////////////////////
    //-- Para uso com o whatsapp API (atualmente desativado)
    ////////////////////////////////////////////////////////////

    // -- -------------------------------------------------------
    // -- Valida se e realmente novo ou se ainda não foi validado
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE wa_id='{$telefone}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------

    exit();
    if(
        (!empty($USER_DB['wa_id'])) && 
        (
            (empty($USER_DB['wa_trustkey'])) || 
            (@$USER_DB['wa_trustkey'] != $wa_trustkey)
        )
    ):
            $errors = "
                    <table border=0>
                    <tr>
                    <td style=\"padding-right:20px; min-width:200px;\">
                        Este telefone já esta cadastrado. <br>Escaneie o <span style=\"white-space: nowrap;\">código QR</span> ao lado para valida-lo:
                    </td>
                    <td>                        
                        <a href=\"JavaScript://{$COOKIE}\" onclick=\"window.open('{$wa_url}', '_wa', '_wa, width=535, height=350, toolbar=0, scrollbars=0, location=0, directories=0, status=0, resizable=no');\">
                            <img src=\"../lib/imgs/qrcode_wa.png?t=".time()."\" style=\"width:150px;z-index:1; background: #FFFFFF url('{$wa_qr}') no-repeat center center; background-size: 125px;\"><br>
                            <span style=\"font-size:15px;\">Escaneie o QrCode</span>
                        </a>
                    </td>
                    </tr>
                    </table>
            ";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#999;\">{$errors}</span>
            <SCRIPT>$('input[name=\"telefone\"]').focus();</SCRIPT>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    elseif(@empty($USER_DB['wa_id'])):

            $sql = "
                INSERT INTO `user_profiles` (
                    `wa_id`,
                    `wa_nick`,
                    `wa_trustkey`,
                    `nome`,
                    `telefone`,
                    `email`,
                    `pwd`
                 )
                VALUES (
                    :wa_id,
                    :wa_nick,
                    :wa_trustkey,
                    :nome,
                    :telefone,
                    :email,
                    :pwd
                 )          
            ";
            $statment = $conn->prepare($sql);
                $statment->bindValue(':wa_id', "{$telefone}");
                $statment->bindValue(':wa_nick', "");
                $statment->bindValue(':wa_trustkey', "");
                $statment->bindValue(':nome', "$nome");
                $statment->bindValue(':telefone', "{$telefone}");
                $statment->bindValue(':email', "{$email}");
                $statment->bindValue(':pwd', "TEMP{$_SESSION["PREFIX"]}{$_SESSION["TOKEN"]}");
            $statment->execute();


            //-- --------------------------------------
            $sql = "SELECT * FROM `user_profiles` WHERE wa_id='{$telefone}' LIMIT 1";
            $statment = $conn->prepare($sql); $statment->execute(); 
            $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
            //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
            //-- --------------------------------------
            //-- Autorizações iniciais
            //-- --------------------------------------
                $sql = "
                    INSERT INTO `user_roles` (
                        `user_id`,
                        `host`,
                        `autorization_id`
                     )
                    VALUES (
                        :user_id,
                        :host,
                        :autorization_id
                     );
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "1");
                $statment->execute();
            /*
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "");
                $statment->execute();
            //-- --------------------------
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$USER_DB['id']}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "");
                $statment->execute();
            //-- --------------------------------------
            /**/


            //-- SE VIA WHATSSAPP
            $success = "
                    <table border=0>
                    <tr>
                    <td style=\"padding-right:20px; min-width:200px;\">
                        Cadastro realizado com sucesso! <br>Escaneie o <span style=\"white-space: nowrap;\">código QR</span> ao lado para valida-lo pelo whatsapp:
                    </td>
                    <td>                        
                        <a href=\"JavaScript://{$COOKIE}\" onclick=\"window.open('{$wa_url}', '_wa', '_wa, width=535, height=350, toolbar=0, scrollbars=0, location=0, directories=0, status=0, resizable=no');\">
                            <img src=\"../lib/imgs/qrcode_wa.png?t=".time()."\" style=\"width:150px;z-index:1; background: #FFFFFF url('{$wa_qr}') no-repeat center center; background-size: 125px;\"><br>
                            <span style=\"font-size:15px;\">Escaneie o QrCode</span>
                        </a>
                    </td>
                    </tr>
                    </table>

                    <input type=\"hidden\" class=\"form-control\" name=\"2Fa\" value=\"TEMP{$_SESSION["PREFIX"]}{$_SESSION["TOKEN"]}\">
            ";


            $data['errors'] = false;
            $data['message'] = "<span style=\"color:#999;\">{$success}</span>";
            $data['success'] = $success;
    echo json_encode($data);

    exit();
    else:

            $errors = "ERRO: Um usuário já cadastrado, <br>esta usando este telefone.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    endif;
    /**/
    // -- -------------------------------------------------------


}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 


?>