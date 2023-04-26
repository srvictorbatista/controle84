<? include('../../_config.php');  include_once('../../_sessao.php');


//-- --------------------------------------
$sql = "SELECT * FROM `_view_profiles_permiss` WHERE `host` = '{$system_host}' GROUP BY `login`;";
$statment = $conn->prepare($sql); $statment->execute(); 
$USERS_DB = $statment->fetchAll(PDO::FETCH_ASSOC);
//echo "CONTRATO: ";print_r($USERS_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------

//-- --------------------------------------
$sql = "SELECT * FROM `user_permiss` WHERE 1";//;cliente_id='{$cliente_edit_id}' LIMIT 1";
$statment = $conn->prepare($sql); $statment->execute(); 
$PERMISS_DB = $statment->fetchAll(PDO::FETCH_ASSOC);
//echo "CONTRATO: ";print_r($CONTRATO_DB); echo "\r\n-------------------------------------\r\n";
//-- --------------------------------------





?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administração</title>
    <meta name="robots" content="noindex">
    <meta name="google" content="notranslate">
    <link rel="icon" type="image/png" href="../../lib/imgs/favicon.png">
    <link rel="icon" type="image/x-icon" href="../../lib/imgs/favicon.png">
    <link rel="stylesheet" href="../lib/plugins/DragAndDrop-raiz/css/admin-style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800,900" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
        <div class="boards">
        <div class="board" style="padding-bottom: 50px;">
            <form id="buscauser" method="POST" action="_DB.php" return=".dropzone">
            <h3>Usuário:
                <select name="user_id" onchange="// Carrega permiss do usuario
                $('.card input[name=user_id]').val(  $(this).val()  );

                $(this).submit(); ">
                    <option value="000"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SELECIONE</option><?
                  foreach($USERS_DB as $USER):
                    if(  
                        ($_SESSION['USER_ID'] == 1)  // Se for o ID 01
                    ){
                                if($_SESSION['USER_ID'] == $USER['user_id']){$selected='selected="selected"'; $CHARGE=1;}else{$selected='';}
                                echo "
                                <option value=\"".str_pad($USER['user_id'], 4, '0', STR_PAD_LEFT)."\" {$selected}>{$USER['login']} ({$USER['nome']})</option>";
                    }else{ // Outros IDs
                        if( ($USER['user_id'] != 1) ){
                                if($_SESSION['USER_ID'] == $USER['user_id']){$selected='selected="selected"'; $CHARGE=1;}else{$selected='';}
                                echo "
                                <option value=\"".str_pad($USER['user_id'], 4, '0', STR_PAD_LEFT)."\" {$selected}>{$USER['login']} ({$USER['nome']})</option>";
                        }
                    }
                  endforeach;
                ?>

                </select>
                <input type="hidden" name="permiss_id" value="">
                <input type="hidden" name="operacao" value="">
            </form>


            </h3> 
            <button onclick="$('.dropzone .card form button').click(); /*$('.dropzone').html('');*/">LIMPAR ATRIBUIÇÕES</button>

                <div class="dropzone"></div>
        </div>
        <div class="board font">
            <h3>Acessos Operacionais:</h3>
                <div class="no-dropzone" id="1">

                    <?
                    foreach($PERMISS_DB as $PERMISS_DB1):
                        if(($PERMISS_DB1['color']=='') || ($PERMISS_DB1['color']=='green') || ($PERMISS_DB1['color']=='blue')){
                                echo "
                                    <div class=\"card\" Xdraggable=\"true\"> 
                                      <form id=\"PUT".str_pad($PERMISS_DB1['id'], 4, '0', STR_PAD_LEFT)."\" method=\"POST\" action=\"_DB.php\" return=\".return\">
                                                                                     <button type=\"button\" class=\"add\" onclick=\"
                                                                                         //console.log( $(this).parent().attr('id')  );
                                                                                         $('#'+ $(this).parent().attr('id') +' input[name=operacao]').val('".$_SESSION["TOKEN"].'#A'."');
                                                                                         $(this).parent().submit();

                                                                                        // \$('.dropzone').html(         '<div class=\'card\'>'+\$(this).parent().html()+'</div>' + \$('.dropzone').html()         );

                                                                                        \$('.dropzone .card button').remove();
                                                                                        \$('.dropzone .card').prepend('<button class=\'close\' onclick=\'this.parentElement.remove();\'> REMOVER </button>');
                                                                                    \">ADD</button>
                                        <div class=\"status {$PERMISS_DB1['color']}\"></div> 
                                        <div class=\"content\">#".str_pad($PERMISS_DB1['id'], 4, '0', STR_PAD_LEFT)." - {$PERMISS_DB1['title']}</div>
                                        <input type=\"hidden\" name=\"user_id\" value=\"\" >
                                        <input type=\"hidden\" name=\"permiss_id\" value=\"".str_pad($PERMISS_DB1['id'], 4, '0', STR_PAD_LEFT)."\" >
                                        <input type=\"hidden\" name=\"operacao\" value=\"\" >

                                        <sup style=\"color:#444; font-size:9px;\">{$PERMISS_DB1['autorization']}</sup><br>
                                        <sup style=\"color:#00AAAA;\">{$PERMISS_DB1['description']}</sup>
                                      </form>
                                    </div>
                                ";
                        }
                    endforeach;
                    ?>

                    <!-- div class="card" draggable="true">
                        <div class="status"></div>
                        <div class="content"> Entrar no sistema</div>
                        <sup style="color:#666;">Permite entrar após o login</sup>
                    </div>

                    <div class="card" draggable="true">
                        <div class="status green"></div>
                        <div class="content"> Do videos!</div>
                        <sup style="color:#666;">Descrição do acesso</sup>
                    </div>
                    <div class="card" draggable="true">
                        <div class="status green"></div>
                        <div class="content"> Do videos!</div>
                    </div>
                    <div class="card" draggable="true">
                        <div class="status blue"></div>
                        <div class="content"> Forum</div>
                    </div>
                    <div class="card" draggable="true">
                        <div class="status blue"></div>
                        <div class="content"> Forum</div>
                    </div>
                    <div class="card" draggable="true">
                        <div class="status blue"></div>
                        <div class="content"> Forum</div>
                    </div -->

                </div>
            <button onclick="$('.no-dropzone#1 .card form button').click();/*addTodos(1);*/" >ADICIONAR TODOS</button>
        </div>
        <div class="board font">
            <h3>Acessos Administrativos:</h3>
            <div class="no-dropzone" id="2">
                <?
                foreach($PERMISS_DB as $PERMISS_DB2):
                    if(($PERMISS_DB2['color']=='yelow') || ($PERMISS_DB2['color']=='red')){
                            echo "
                                    <div class=\"card\" Xdraggable=\"true\"> 
                                      <form id=\"PUT".str_pad($PERMISS_DB2['id'], 4, '0', STR_PAD_LEFT)."\" method=\"POST\" action=\"_DB.php\" return=\".return\">
                                                                                     <button type=\"button\" class=\"add\" onclick=\"
                                                                                         //console.log( $(this).parent().attr('id')  );
                                                                                         $('#'+ $(this).parent().attr('id') +' input[name=operacao]').val('".$_SESSION["TOKEN"].'#A'."');
                                                                                         $(this).parent().submit();

                                                                                        // \$('.dropzone').html(         '<div class=\'card\'>'+\$(this).parent().html()+'</div>' + \$('.dropzone').html()         );

                                                                                        \$('.dropzone .card button').remove();
                                                                                        \$('.dropzone .card').prepend('<button class=\'close\' onclick=\'this.parentElement.remove();\'> REMOVER </button>');
                                                                                    \">ADD</button>
                                        <div class=\"status {$PERMISS_DB2['color']}\"></div> 
                                        <div class=\"content\">#".str_pad($PERMISS_DB2['id'], 4, '0', STR_PAD_LEFT)." - {$PERMISS_DB2['title']}</div>
                                        <input type=\"hidden\" name=\"user_id\" value=\"\" >
                                        <input type=\"hidden\" name=\"permiss_id\" value=\"".str_pad($PERMISS_DB2['id'], 4, '0', STR_PAD_LEFT)."\" >
                                        <input type=\"hidden\" name=\"operacao\" value=\"\" >
                                        
                                        <sup style=\"color:#444; font-size:9px;\">{$PERMISS_DB2['autorization']}</sup><br>
                                        <sup style=\"color:#00AAAA;\">{$PERMISS_DB2['description']}</sup>
                                      </form>
                                    </div>
                            ";
                    }
                endforeach;
                ?>

                <!-- div class="card" draggable="true">
                    <div class="status yelow"></div>
                    <div class="content"> Next Level Week</div>
                </div>

                <div class="card" draggable="true">
                    <div class="status red"></div>
                    <div class="content"> Next Level Week</div>
                </div>

                <div class="card" draggable="true">
                    <div class="status red"></div>
                    <div class="content"> Next Level Week</div>
                </div>

                <div class="card" draggable="true">
                    <div class="status red"></div>
                    <div class="content"> Next Level Week</div>
                </div -->

            </div>            
            <button onclick="$('.no-dropzone#2 .card form button').click(); /*addTodos(2);*/" >ADICIONAR TODOS</button>
        </div>
    </div>
    <div class="return" style="position:fixed;top:10px;right:10px;background-color:#333333AF;color:#FFF;font-weight:600;font-size:15px;letter-spacing:.1rem;padding:20px 40px; white-space:nowrap; display:none;" onclick="$(this).hide('500');">...</div>
    <script src="../lib/plugins/DragAndDrop-raiz/js/admin-script.js" defer></script>
    <script src="../lib/plugins/DragAndDrop-raiz/js/DragDropTouch.js" defer></script>
    <? if($CHARGE>0){ echo "<script>  \$(document).ready(function(){ \$('#buscauser select').change();   }); </script> "; } ?>

</body>
</html>