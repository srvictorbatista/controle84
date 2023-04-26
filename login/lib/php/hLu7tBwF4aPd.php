<?
include_once('../../../_config.php');

$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING) : false;
$senha1 = filter_input(INPUT_POST, 'senha1', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'senha1', FILTER_SANITIZE_STRING) : false;
$senha2 = filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING) : false;
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING) : false;
$host = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING) : false;
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING) : false;





if(    ($_SERVER['REQUEST_METHOD'] == 'POST')    ) {
    // -- -------------------------------------------------------
    // -- Cria ou renova senha
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------
    // -- Verifica validade e existencia
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE pwd='{$token}' AND `id` = '{$id}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
    // -- -------------------------------------------------------
    // -- Verifica credenciais do form
    // -- -------------------------------------------------------

    if(empty($USER_DB['id']) || empty($USER_DB['pwd']) || empty($token)):            
            $errors = "ERRO: Esta ação é não permitida!";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------
    // -- Valida senha
    // -- -------------------------------------------------------
    if(strlen($senha1) < 6):
            $errors = "ERRO: Senha deve conter no minimo, 6 caracteres.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- ----------------------------------------
    if($senha1 != $senha2):
            $errors = "ERRO: Senha e confirmação devem coincidir.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- -------------------------------------------------------
    // -- Valida login
    // -- -------------------------------------------------------
    if(strlen($login) < 4):
            $errors = "ERRO: Login deve conter no minimo, 4 caracteres.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- -------------------------------------------------------
    // -- Verifica se o login já esta em uso
    // -- -------------------------------------------------------
        //-- --------------------------------------
        $sql = "SELECT count(*) AS `ocorrencias` FROM `user_profiles` WHERE login='{$login}' AND `id` != '{$id}'";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $LOGIN_DB = $statment->fetch(PDO::FETCH_ASSOC);
        $ocorrencias = $LOGIN_DB['ocorrencias'];
        //echo "LOGIN_DB: ";print_r($LOGIN_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
    if($ocorrencias >= 1):
            $errors = "ERRO: Este login já em uso por outro usuario. <br>Por favor, escolha outro.";
            $data['success'] = false;
            $data['message'] = "<span style=\"color:#DC3545;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ".str_replace("\n", "<br>", $errors)."</span>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;


        $pwd = password_hash($senha1.$login, PASSWORD_BCRYPT);
        $wa_id = $USER_DB['wa_id'];

            $sql = "
                UPDATE `user_profiles` SET 
                    `login`         = :login,
                    `pwd`           = :pwd

                WHERE `user_profiles`.`id` = :id 
            ";
            $statment = $conn->prepare($sql);
                $statment->bindValue(':login', "{$login}");
                $statment->bindValue(':pwd', "{$pwd}");
                $statment->bindValue(':id', "{$USER_DB['id']}");
            $statment->execute();

            //Confirmado com sucesso! 
            if(!empty($USER_DB['pwd'])){
                WA_SEND("{$USER_DB['wa_id']}","⚠️ *ATENÇÃO:* Credenciais de acesso alteradas com sucesso!\\nUse eu login ({$login}) e senha para acessar o sistema.\\n\\n🚨 _Caso não tenha sido você, troque sua senha imediatamente._ ");

                        $success = "Sucesso! Por favor, aguarde. <br>Você será logado em seguida...
                                    <input type=\"hidden\" name=\"TokenIn\" value=\"".time()."\">";
                        $data['success'] = true;
                        $data['message'] = "<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i> ".str_replace("\n", "<br>", $success)."</span>";
                        $data['errors'] = false;
                echo json_encode($data);
            exit();
            }


}
echo "{\"message\":[\"sucesso!\"]}";
exit();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
?>