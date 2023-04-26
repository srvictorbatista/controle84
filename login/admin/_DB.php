<? include_once('../../_config.php');

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING)/1 : false;
$permiss_id = filter_input(INPUT_POST, 'permiss_id', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'permiss_id', FILTER_SANITIZE_STRING)/1 : false;
$operacao = filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING) : false;




if(    ($_SERVER['REQUEST_METHOD'] == 'POST')    ) {


    // -- -------------------------------------------------------
    // -- Editar permissoes
    // -- -------------------------------------------------------
    if(empty($user_id)):
            $errors = "Selecione o usuario!";
            $data['success'] = false;
            $data['message'] = "<center><span style=\"color:#DC3545;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> <b style=\"font-weight:900;font-size:18px;\">".str_replace("\n", "<br>", $errors)."</b></span></center>

            <SCRIPT>
                clearTimeout(window.TM);
                window.TM = setTimeout(function(){
                        $(\".return\").hide('fast');
                }, 10000);
            </SCRIPT>";
            $data['errors'] = $errors;
    echo json_encode($data);
    exit();
    endif;
    // -- -------------------------------------------------------



    

    // -- -------------------------------------------------------
    // -- ADICIONA ACESSO
    // -- -------------------------------------------------------
    if(!empty($user_id) && !empty($permiss_id) && ($operacao == $_SESSION["TOKEN"].'#A')){ 

        //-- --------------------------------------
        //-- Verifica se ja possui a permissao
        //-- --------------------------------------
        $sql = "SELECT *, count(*) AS `NUM` FROM `_view_profiles_permiss` WHERE `host` = '{$system_host}' AND `user_id` = '{$user_id}' AND `permiss_id` = '{$permiss_id}' LIMIT 1;";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_PERMISS_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_PERMISS_DB: ";print_r($USER_PERMISS_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
        if($USER_PERMISS_DB['NUM'] > 0){
            $data['message'] = "<center><span style=\"color:#E0FB00;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> <b style=\"font-weight:900;font-size:18px;\">PERMISSÂO JÁ CONCEDIDA!</b></span></center> 
            <SCRIPT>
                    $(\".return\").click(function(){    $(\".return\").hide('500');   })

                    clearTimeout(window.TM);
                    window.TM = setTimeout(function(){
                            $(\".return\").hide('fast');
                    }, 3000);

                    $('select[name=user_id]').change();
            </SCRIPT>"; 
            echo json_encode($data);
        }else{
        //-- --------------------------------------
        //-- Segue com adição da permissao
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
                     )          
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':user_id', "{$user_id}");
                    $statment->bindValue(':host', "{$system_host}");
                    $statment->bindValue(':autorization_id', "{$permiss_id}");
                $statment->execute();

            $data['message'] = "CONCEDIDO! #".str_pad($permiss_id, 4, '0', STR_PAD_LEFT)." 
            <SCRIPT>
                    $(\".return\").click(function(){    $(\".return\").hide('500');   })

                    clearTimeout(window.TM);
                    window.TM = setTimeout(function(){
                            $(\".return\").hide('fast');
                    }, 8000);

                    $('select[name=user_id]').change();
            </SCRIPT>"; 
            echo json_encode($data);
        }        
    exit();
    }/**/
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------



     
    
    // -- -------------------------------------------------------
    // -- REMOVE ACESSO
    // -- -------------------------------------------------------
    $MSG_DELETED = "";
    if(!empty($user_id) && !empty($permiss_id) && ($operacao == $_SESSION["TOKEN"].'#Z')){ //* REMOVE ACESSOS

        //-- --------------------------------------
        //-- Busca id unico da permissão a ser excluida
        //-- --------------------------------------
        $sql = "SELECT * FROM `_view_profiles_permiss` WHERE `host` = '{$system_host}' AND `user_id` = '{$user_id}' AND `permiss_id` = '{$permiss_id}' LIMIT 1;";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_PERMISS_DB = $statment->fetch(PDO::FETCH_ASSOC);
        //echo "USER_PERMISS_DB: ";print_r($USER_PERMISS_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------
    // -- -------------------------------------------------------
    if(
        (($permiss_id <= 1) && ($operacao == $_SESSION["TOKEN"].'#Z')) || 
        (($permiss_id == 2) && ($operacao == $_SESSION["TOKEN"].'#Z') && ($user_id == '1'))   ||      // Não remover permissao "0003" para este usuario
        (($permiss_id == 2) && ($operacao == $_SESSION["TOKEN"].'#Z') && ($user_id == '2'))   ||      // Não remover permissao "0003" para este usuario 
        (($permiss_id == 2) && ($operacao == $_SESSION["TOKEN"].'#Z') && ($user_id == '3'))           // Não remover permissao "0003" para este usuario
     ):
        //-- --------------------------------------
        //-- Impede exclusão da permissao SE:
        //-- --------------------------------------
        $MSG_DELETED = "
            <SCRIPT> 
                $(\".return\").html('<center><span style=\"color:#FBFF00;\"><i class=\"bi bi-exclamation-triangle-fill\"></i> <b style=\"font-weight:900;font-size:18px;\">NÃO PERMITIDO!</b></span>  <!-- #".str_pad($permiss_id, 4, '0', STR_PAD_LEFT)." --> </center>'); 
                $(\".return\").show(600);
                $(\".return\").click(function(){    $(\".return\").hide('500');   });

                clearTimeout(window.TM);
                window.TM = setTimeout(function(){
                        $(\".return\").hide('fast');
                }, 5000);

                //$('select[name=user_id]').change();

                $('#buscauser input[name=permiss_id], #buscauser input[name=operacao]').val('');
            </SCRIPT>"; 
        //echo json_encode($data);
        //exit();
    else:
        //-- --------------------------------------
        //-- Segue com exclusão da permissao
        //-- --------------------------------------
                $sql = "
                    DELETE FROM `user_roles` 
                        WHERE `id` = :id      
                ";
                $statment = $conn->prepare($sql);
                    $statment->bindValue(':id', "{$USER_PERMISS_DB['roles_id']}");
                $statment->execute();
        //-- --------------------------------------
        $MSG_DELETED = "
            <SCRIPT> 
                $(\".return\").html('REMOVIDO! #".str_pad($permiss_id, 4, '0', STR_PAD_LEFT)."'); 
                $(\".return\").show(600);
                $(\".return\").click(function(){    $(\".return\").hide('500');   });

                clearTimeout(window.TM);
                window.TM = setTimeout(function(){
                        $(\".return\").hide('fast');
                }, 5000);

                //$('select[name=user_id]').change();

                $('#buscauser input[name=permiss_id], #buscauser input[name=operacao]').val('');
            </SCRIPT>"; 
        //echo json_encode($data);
        //exit();    
    endif;
    }/**/
    // -- -------------------------------------------------------
    // -- -------------------------------------------------------


    
    // -- -------------------------------------------------------
    // --  CARREGA PERMISSOES ATRIBUIDAS NO DB
    // -- -------------------------------------------------------
    //-- --------------------------------------
    $sql = "SELECT * FROM `_view_profiles_permiss` WHERE `host` = '{$system_host}' AND `user_id` = '{$user_id}' ORDER BY `expedition` DESC;";
    $statment = $conn->prepare($sql); $statment->execute(); 
    $USER_PERMISS_DB = $statment->fetchAll(PDO::FETCH_ASSOC);
    //echo "USER_PERMISS_DB: ";print_r($USER_PERMISS_DB); echo "\r\n-------------------------------------\r\n";
    //-- --------------------------------------


    $ID=''; $CARD='';
    foreach($USER_PERMISS_DB as $USER_PERMISS):
           $ID .= str_pad($USER_PERMISS['user_id'], 4, '0', STR_PAD_LEFT)."\r\n";

                            $CARD .= "
                                <div class=\"card\" Xdraggable=\"true\"> 
                                      <form id=\"DEL".str_pad($USER_PERMISS['permiss_id'], 4, '0', STR_PAD_LEFT)."\" method=\"POST\" action=\"_DB.php\" return=\".return\" onsubmit=\"return void(0);\">
                                                                                     <!-- button class=\"close\" onclick=\"this.parentElement.remove();\"> REMOVER </button -->
                                                                                     <button type=\"button\" class=\"close\" onclick=\"
                                                                                         //console.log( $(this).parent().attr('id')  );
                                                                                         $('#buscauser input[name=permiss_id]').val('".str_pad($USER_PERMISS['permiss_id'], 4, '0', STR_PAD_LEFT)."');
                                                                                         $('#buscauser input[name=operacao]').val('".$_SESSION["TOKEN"].'#Z'."');
                                                                                         $('#buscauser').submit();

                                                                                        // \$('.dropzone').html(         '<div class=\'card\'>'+\$(this).parent().html()+'</div>' + \$('.dropzone').html()         );

                                                                                        // \$('.dropzone .card button').remove();
                                                                                        // \$('.dropzone .card').prepend('<button class=\'close\' onclick=\'this.parentElement.remove();\'> REMOVER </button>');
                                                                                    \">REMOVER</button>
                                    <div class=\"status {$USER_PERMISS['color']}\"></div> 
                                    <div class=\"content\">#".str_pad($USER_PERMISS['permiss_id'], 4, '0', STR_PAD_LEFT)." - {$USER_PERMISS['title']}</div>
                                    <!-- sup style=\"color:#444; font-size:9px;\">{$USER_PERMISS['autorization']}</sup><br -->
                                    <sup style=\"color:#00AAAA;\">{$USER_PERMISS['description']}</sup>
                                    </form>                                    
                                </div>
                            ";
    endforeach;



	    $success = "{$CARD} {$MSG_DELETED}";
	    $data['success'] = $success;
	    $data['message'] = " {$success} "; //"<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i> ".str_replace("\n", "<br>", $success)."</span>";
	    $data['errors'] = false;
	echo json_encode($data);


}
exit();
/**/






































$errors = [];
$data = [];
$data['message'] = "Teste ok!";
$data['POST'] = @$_POST;
$data['GET'] = @$_GET;
if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = "<span style=\"color:#EE3333;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ALGO DEU ERRADO: <br>Contate o desenvolvedor. <br>".str_replace("\n", "<br>", $errors)."</span>";
    $data['errors'] = $errors;
}else{
    $success = "success!";
    $data['success'] = $success;
    $data['message'] = "<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i> ".str_replace("\n", "<br>", $success)."</span>";
    $data['errors'] = false;
}
echo json_encode($data);
exit();
?>