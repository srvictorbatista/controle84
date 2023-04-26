<?
include_once('../../../_config.php');

$email      = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : false;
$wpp = filter_input(INPUT_POST, 'wpp', FILTER_SANITIZE_NUMBER_INT) ? str_replace("-","",str_replace(".","",filter_input(INPUT_POST, 'wpp', FILTER_SANITIZE_NUMBER_INT)))/1 : false;
    $wpp = preg_replace('/^[0-9]/', '', $wpp); if(strlen($wpp) <= 9){$wpp='';}else{$wpp='55'.$wpp;}
    $wpp = substr($wpp, -8); //Pegando apenas os 8 últimos caracters









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
    // -- Valida se e realmente existe e foi validado
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE email='{$email}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
         //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n"; exit();
        //-- --------------------------------------
    
    // -- -------------------------------------------------------
    // -- Usuario (com email validado)
    // -- -------------------------------------------------------
    if(
        (!empty($USER_DB['email'])) && 
        (
            (empty($USER_DB['wa_trustkey'])) || 
            (@$USER_DB['wa_trustkey'] == $wa_trustkey)
        )
    ):
        //-- ------------------------------------------------
        //-- Retira validação (reabre edição de credenciais)
        //-- ------------------------------------------------
                    $sql = "
                        UPDATE `user_profiles` SET 
                            `wa_trustkey`   = :wa_trustkey
                        WHERE `user_profiles`.`id` = :id 
                    ";
                    $statment = $conn->prepare($sql);
                        $statment->bindValue(':wa_trustkey', "");
                        $statment->bindValue(':id', "{$USER_DB['id']}");
                    $statment->execute();
        //-- ------------------------------------------------


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
            $mail->addAddress("{$USER_DB['email']}", "{$USER_DB['nome']}");         // Detinatario (Name is optional)
            $mail->addReplyTo($SMTP_MAIL_SEND['REPLITO'], $_SERVER['SERVER_NAME']); // responder para
            $mail->addCC('sistema@controle84.com', 'bkp');
            $mail->addBCC('sistema@controle84.com', 'bkp');

            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');  // Add attachments (Optional name)
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = utf8_decode("{$USER_DB['nome']}: Recuperação de senha");
            $mail->Priority = 1;
            //$mail->Body    = utf8_decode('Este é um conteúdo em HTML, com uma parte em <b>negrito</b> para uma breve demonstração.');
            $mail->Body    = utf8_decode( MailLayout(
                utf8_encode($mail->Subject), 
                "Houve um pedido para alterar sua senha em <b>Controle84</b>.com. Por medida de segurança, <span style=\"color:#FF6D6D;\">não exclua este e-mail</span>. Pois, o link contido nele só <span style=\"color:#FF6D6D;\">funcionará uma unica vez</span>. - <span style=\"font-size:18px;\">Se você não fez esta solicitação.</span> Recomendamos que você guarde esta mensagem em local seguro, ou redefina suas credenciais <span style=\"font-size:18px;white-space: nowrap;\">(login e senha)</span> imediatamente.", 
                "Para redefinir suas credenciais, clique no seguinte link:", 
                "Redefinir minhas credenciais",
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
                $success = "Por favor, verifique seu e-mail para continuar...";
                    $data['errors'] = false;
                    $data['message'] = "<span style=\"color:#999;\">{$success}</span>";
                    $data['success'] = $success;
                echo json_encode($data);
            exit();
            }            
            #########################################
    exit();
    endif;











    ////////////////////////////////////////////////////////////
    //-- Para uso com o whatsapp API (atualmente desativado)
    ////////////////////////////////////////////////////////////

    // -- -------------------------------------------------------
    // -- Verifica pedido (redefinir credenciais)
    // -- -------------------------------------------------------
    if(!empty($wpp)):
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE wa_id LIKE '%{$wpp}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
                WA_SEND("{$USER_DB['wa_id']}","*REDEFINIÇÃO DE SENHA.* \\n\\nPara redefinir sua senha, acesse o link: ".str_replace("lib/php/","",$url)."?token={$USER_DB['pwd']}&t=".time()." ");

                $success = "Um link de redefinição de senha <span style=\"white-space:nowrap;\">foi enviado para o whatssapp informado. </span><br><span style=\"color:#888;\">Caso não receba uma mensagem imediatamente, verifique se <span style=\"white-space:nowrap;\">o número esta correto.</span></span>";
                $data['success'] = true;
                $data['message'] = "<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i>&nbsp ".str_replace("\n", "<br>", $success)."</span>";
                $data['errors'] = false;
    echo json_encode($data);
    exit();
    endif;


            
    $errors = "ERRO: Esta ação não é permitida!";
    $data['success'] = false;
    $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i>&nbsp ".str_replace("\n", "<br>", $errors)."</span>";
    $data['errors'] = $errors;
echo json_encode($data);
?>