<? include_once('../../_config.php'); include_once('../../_sessao.php');

 /* Constantes de configuração */  
 define('QTDE_REGISTROS', 8);   
 define('RANGE_PAGINAS', 1);   
   
 /* Recebe o número da página via parâmetro na URL */  // $_POST['pagina']=2;
 $pagina_atual = (isset($_POST['pagina']) && is_numeric($_POST['pagina'])) ? $_POST['pagina'] : 1;
 if(!@empty($_POST['search'])){ $search = $_POST['search'];}
   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS; 



 if(!@empty($search)){ // listagem com pesquisa
 $PESQ = " <span style=\"color:#AAA;\">Pesquisa:</span> {$search}...";
 $AUTOFOCUS = "onfocus=\"this.selectionStart = this.selectionEnd = this.value.length;\" autofocus=\"true\"";
 $AUTOFOCUS2 = "$('input[name=search]').focus();";
 $sql = "
        -- ----------------------------------------------------------
        SELECT 
          `id`,`nome`,`descricao`,`valor_base`,
          CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco` 
        FROM `{$PREFIXO_PATH}_pacotes`
        WHERE `nome` LIKE '%$search%'
        OR `descricao` LIKE '%$search%'
        ORDER BY `id` DESC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . "
        -- ----------------------------------------------------------
    ";
     /* Conta quantos registos existem na tabela */  
      $sqlContador = "SELECT COUNT(*) AS total_registros FROM {$PREFIXO_PATH}_pacotes WHERE `nome` LIKE '%$search%'"; 

 }else{ $search='';  // listagem sem pesquisa
$PESQ = " <span style=\"color:#AAA;\">Listagem de Pacotes</span>";
$AUTOFOCUS="";
$AUTOFOCUS2 = "";
 $sql = "
        -- ----------------------------------------------------------
        SELECT 
          `id`,`nome`,`descricao`,`valor_base`,
          CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco`
        FROM `{$PREFIXO_PATH}_pacotes`
        ORDER BY `id` DESC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . "
        -- ----------------------------------------------------------
    ";
     /* Conta quantos registos existem na tabela */  
     $sqlContador = "SELECT COUNT(*) AS total_registros FROM {$PREFIXO_PATH}_pacotes"; 
}
 $stm = $conn->prepare($sql);
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
  



 $stm = $conn->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);   
   
 /* Idêntifica a primeira página */  
 $primeira_pagina = 1;
   
 /* Cálcula qual será a última página */  
 $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);
   
 /* Cálcula qual será a página anterior em relação a página atual em exibição */   
 $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 1;   
   
 /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */   
 $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 :  $ultima_pagina;  
   
 /* Cálcula qual será a página inicial do nosso range */    
 $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;
   
 /* Cálcula qual será a página final do nosso range */
 $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;
   
 /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */   
 $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder'; 
   
 /* Verifica se vai exibir o botão "Anterior" e "Último" */   
 $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';  
   














///////////////////////////////////////////////////////////////////////////////////////////////////////////

            /* Loop para montar a páginação central com os números */   
             $pagsN='';for ($i=$range_inicial; $i <= $range_final; $i++):

              $ITENS_START = (($i-1)*QTDE_REGISTROS)+1;
              $ITENS_END = ($i*QTDE_REGISTROS);

              if(($i == $pagina_atual)){
                if(($ultima_pagina == $pagina_atual)){
                    $pagsN =  "<!-- [$i] -->".ceil($valor->total_registros)."/".ceil($valor->total_registros);
                }else{
                    $pagsN =  "<!-- [$i] -->".$ITENS_START."-".($i*QTDE_REGISTROS)."/".ceil($valor->total_registros);                  
                }
              }
            endfor;








  
    $RESULT_REQUEST_LIST =  "";
    if(!empty($dados)): 

     $RESULT_REQUEST_LIST =  "
                <table class=\"table table-hover table-striped\">    
                 <thead>    
                   <tr class=\"active\" style=\"color:#BBB;\">   
                    <th width=\"50px;\">&nbsp;</th>
                    <th width=\"* /*230px;*/\">Nome do Pacote</th>    
                    <!-- th width=\"*\">Descrição</th -->
                    <th width=\"100px;\">Preço</th>   
                   </tr>       
                 </thead> 
                  <tbody>
       ";

             foreach($dados as $LIST_IEM):
              $LIST_DESQ = str_replace("\r\n","\\\\n", $LIST_IEM->descricao);
                  $ONCLICK = "
                    onClick=\"
                    window.open('\
                    JavaScript:\
                     pacoteedit();\
                     pacoteedit(\
                     null, \
                      \'{$LIST_IEM->id}\', \
                      \'{$LIST_IEM->nome}\', \
                      \'{$LIST_DESQ}\', \
                      \'{$LIST_IEM->preco}\'\
                      );\
                    ','_parent');\"";
                    
                  $RESULT_REQUEST_LIST .=  "
                  <tr style=\"/*cursor:pointer;*/\">
                    <td>
                      <div class=\"icheck-primary\">
                        <input type=\"checkbox\" value=\"{$LIST_IEM->nome}\" id=\"check{$LIST_IEM->id}\">
                        <label for=\"check{$LIST_IEM->id}\"></label>
                      </div>
                    </td>
                    <td class=\"mailbox-name\" {$ONCLICK}>
                    <span
                    style=\"font-weight:400; font-size:18px;
                        width:100%;
                        min-width:150px; 
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        overflow: hidden;
                        -webkit-box-orient: vertical;
                    \">{$LIST_IEM->nome}&nbsp;</span>
                    </td>
                    <!-- td class=\"mailbox-subject\" {$ONCLICK}>
                    {$LIST_IEM->descricao}&nbsp;
                    </td -->
                    <td class=\"mailbox-date\" style=\"white-space: nowrap;\" {$ONCLICK}>
                    <!-- i class=\"nav-icon far fa-calendar-alt\"></i --> {$LIST_IEM->preco}&nbsp;
                    </td>
                  </tr>


                  ";
               $LIST_DESQ = '';
             endforeach;

   $RESULT_REQUEST_LIST .=  "
                  </tbody>
                </table>
                <!-- /.table -->
   ";













            else:
              $RESULT_REQUEST_LIST =  "<p class=\"bg-danger\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold; cursor:pointer;\" onclick=\"window.open('JavaScript:novopacote();','_parent')\">Nenhum registro encontrado!</p>  ";
            endif;







 /* Seta os controles da paginação */
$RESULT_REQUEST_LIST .= "

          <SCRIPT>
          /*
          $('button[title=\"Selecionar todos\"]').click(function(){
            checkall_loadpaginapacotes()
          });/**/
          $('button[title=\"Selecionar todos\"]').attr('onclick',\"\\
            checkall_loadpaginapacotes()\\
          \");


          $('button[title=\"Excluir selecionados\"]').attr('onclick',\"\\
            DELCHECK=verificacheck(); if(DELCHECK > ''){deletepacotes();}else{info('Por favor, selecione ao menos 1 pacote.');}\\
          \");


          $('button[title=\"Primeira Página\"]').attr('onclick',\"\\
            loadpaginapacotes($primeira_pagina,'$search');\\
          \");


          $('button[title=\"Ultima Página\"]').attr('onclick',\"\\
            loadpaginapacotes($ultima_pagina,'$search');\\
          \");


          setTimeout(function(){
            $('button[title=\"Recarregar\"] i').removeAttr(\"style\").removeClass(\"fa-spin\"); //Parar Spin
          }, 500);
          $('button[title=\"Recarregar\"]').attr('onclick',\"\\
            reload_loadpaginapacotes()\\
          \");


          $('*#pagsN').html('{$pagsN}');


          $('button[title=\"Página anterior\"]').attr('onclick',\"\\
            loadpaginapacotes($pagina_anterior,'$search');\\
          \");


          $('button[title=\"Proxima Página\"]').attr('onclick',\"\\
            loadpaginapacotes($proxima_pagina,'$search');\\
          \");

          $('#MDLl32E2A41C .card-title').html('<span style=\"font-size:20px;font-weight:500;\">{$PESQ}</span>');
          </SCRIPT>
";

// echo $RESULT_REQUEST_LIST;




  //if(@$_SESSION["PRIVID"]<=0):
      //$errors = "ALGO DEU ERRADO: \nContate o suporte.";
        $data['success'] = true;
        $data['message'] = $RESULT_REQUEST_LIST;
  echo json_encode($data);
  exit();
  //endif;  


?>