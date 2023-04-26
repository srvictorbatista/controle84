<? include_once('../../_config.php'); include_once('../../_sessao.php');

 /* Constantes de configuração */  
 define('QTDE_REGISTROS', 8);   
 define('RANGE_PAGINAS', 1);


$CONTRATO["EM_ATRASO"]=0; // Vencido
$CONTRATO["A_VENCER"]=0;   // A vencer
$CONTRATO["REGULAR"]=0;    // Regular
$CONTRATO["NULL"]=0; 
   
 /* Recebe o número da página via parâmetro na URL */  // $_POST['pagina']=2;
 $pagina_atual = (isset($_POST['pagina']) && is_numeric($_POST['pagina'])) ? $_POST['pagina'] : 1;
 if(!@empty($_POST['search'])){ $search = $_POST['search'];}
 if(!@empty($_POST['busc_venc'])){ $busc_venc = $_POST['busc_venc'];}
 //echo "$busc_venc\r\n";
 $venc = $busc_venc;
  $venc1_dia = substr($venc,0,2);
  $venc1_mes = substr($venc,3,2);
  $venc1_ano = substr($venc,6,4);
 $datavenc1_ = "{$venc1_ano}-{$venc1_mes}-{$venc1_dia}";
  $venc2_dia = substr($venc,13,2);
  $venc2_mes = substr($venc,16,2);
  $venc2_ano = substr($venc,19,4);
 $datavenc2_ = "{$venc2_ano}-{$venc2_mes}-{$venc2_dia}";

 if($datavenc1_ != $datavenc2_){
  $busc_venc = "`contrato_vencimento` >= '{$datavenc1_}' AND `contrato_vencimento` <='{$datavenc2_}'";
 }else{
  $busc_venc = "`contrato_vencimento` = '{$datavenc1_}'";
 }
   
if($datavenc1_ == date("Y-m-d")){
    $NOT_FOUND = "<br><p class=\"btn-primary\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold; cursor:pointer;\" onclick=\"window.open('JavaScript:novocliente();','_parent')\">Nenhum registro para hoje.</p>";
   }else{    
    $NOT_FOUND = "<br><p class=\"bg-danger\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold; cursor:pointer;\" onclick=\"window.open('JavaScript:novocliente();','_parent')\">Nenhum registro encontrado!</p>";
   }

 //echo "{$busc_venc}\r\n";

   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS; 


 //-- -----------------------------------------
 if(!@empty($search) /*&& (strlen($search) >= 3)*/){ // listagem com pesquisa
   $PESQ = " <span style=\"color:#AAA;\">Pesquisa:</span> ".TrataNome("{$search}")."...";
  if( 
      ($search == 'todos') || 
      ($search == 'TODOS') || 
      ($search == 'Todos') ||
      ($search == 'todo') || 
      ($search == 'TODO') || 
      ($search == 'Todo') 
    ){  $search = '%'; }
 $AUTOFOCUS = "onfocus=\"this.selectionStart = this.selectionEnd = this.value.length;\" autofocus=\"true\"";
 $AUTOFOCUS2 = "$('input[name=search]').focus();";
 $sql = "
        -- ----------------------------------------------------------
        SELECT * FROM `_view_bases`
        WHERE `_view_bases`.`cliente_nome` LIKE '%$search%'
        AND {$busc_venc}
        OR `_view_bases`.`cliente_nome` LIKE '%$search%'
        -- AND `contrato_id` IS NULL
        ORDER BY `_view_bases`.`contrato_vencimento` ASC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . "
        -- ----------------------------------------------------------
    ";
     /* Conta quantos registos existem na tabela */  
      $sqlContador = "SELECT COUNT(*) AS `total_registros` FROM `_view_bases` WHERE `_view_bases`.`cliente_nome` LIKE '%$search%' AND {$busc_venc} OR `_view_bases`.`cliente_nome` LIKE '%$search%'"; 
      //$sqlContadorStatus = "SELECT `contrato_status` AS `status`, COUNT(*) AS `total` FROM `_view_bases` WHERE `cliente_nome` LIKE  '%$search%' GROUP BY `contrato_status`";
      //$sqlContadorStatusNULL = "SELECT COUNT(*) AS `total` FROM  `_view_bases` WHERE `contrato_id` IS NULL AND  `cliente_nome` LIKE  '%$search%'";
      $sqlContadorStatus = "SELECT `contrato_status` AS `status`, COUNT(*) AS `total` FROM `_view_bases` GROUP BY `contrato_status`";
      $sqlContadorStatusNULL = "SELECT COUNT(*) AS `total` FROM  `_view_bases` WHERE `contrato_id` IS NULL";

 }else{ $search='';  // listagem sem pesquisa
$PESQ = " <span style=\"color:#AAA;\">Listagem de Clientes {[TOTAL]}</span>";
$AUTOFOCUS="";
$AUTOFOCUS2 = "";
 $sql = "
        -- ----------------------------------------------------------
        SELECT * FROM `_view_bases`
        WHERE {$busc_venc}
        ORDER BY `_view_bases`.`contrato_vencimento` ASC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . "
        -- ----------------------------------------------------------
    ";
     /* Conta quantos registos existem na tabela */  
     $sqlContador = "SELECT COUNT(*) AS `total_registros` FROM `_view_bases` WHERE {$busc_venc}"; 
     $sqlContadorStatus = "SELECT `contrato_status` AS `status`, COUNT(*) AS `total` FROM `_view_bases` GROUP BY `contrato_status`";
     $sqlContadorStatusNULL = "SELECT COUNT(*) AS `total` FROM  `_view_bases` WHERE `contrato_id` IS NULL";
}
//echo "{$sql}";
      /*
        cliente_nome
        cliente_id
        cliente_telefone
        cliente_email
        cliente_cadastro
        contrato_id
        contrato_pacote_id
        contrato_titulo
        contrato_descricao
        contrato_notas
        contrato_valor_base
        contrato_preco
        contrato_dias_atraso
        contrato_status
        contrato_vencimento
        contrato_vencimento_formatado
        pacote_id
        pacote_nome
        pacote_descricao
        pacote_valor_base
        pacote_preco
      */

      /*
      status
      status_total
      */
 $stm = $conn->prepare($sql);
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);
 //-- -------------------------------
 $stm = $conn->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);
 //-- -------------------------------
 $stm = $conn->prepare($sqlContadorStatusNULL);   
 $stm->execute();   
 $sqlContadorStatusNULL = $stm->fetch(PDO::FETCH_OBJ); 
 $CONTRATO["NULL"] = $sqlContadorStatusNULL->total;
 //-- -------------------------------
 $stm = $conn->prepare($sqlContadorStatus);   
 $stm->execute();
  while($n_contrato = $stm->fetch(PDO::FETCH_ASSOC)){
      $CONTRATO[$n_contrato['status']] = $n_contrato['total'];
      $CONTRATO["status"] = $n_contrato['status'];
      $CONTRATO["total"] = $n_contrato['total'];
  } $CONTRATO["REGULAR"] = $CONTRATO["REGULAR"]-$CONTRATO["NULL"]; // Retira contratos nulos, da soma de regulares
  $CONTRATO["TOTAL"] = ($CONTRATO["EM_ATRASO"] + $CONTRATO["A_VENCER"] + $CONTRATO["REGULAR"] + $CONTRATO["NULL"]);
 //-- -----------------------------------------

$PESQ = str_replace("{[TOTAL]}","({$CONTRATO["TOTAL"]})",$PESQ); // Adiciona total de clientes ao titulo da listagem





   
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
                   <tr class=\"active\" style=\"color:#BBB;white-space: nowrap;\">   
                    <th width=\"50px\">&nbsp;</th>
                    <th width=\"140\">Nome do Cliente</th>
                    <th style=\"width:100px;\">&nbsp;</th>
                    <th width=\"100\">Vencimento</th>
                    <th width=\"*\">Pacote/Plano/Contrato</th>
                   </tr>       
                 </thead> 
                  <tbody>
       ";




             foreach($dados as $LIST_IEM):
              if($LIST_IEM->pacote_preco != $LIST_IEM->contrato_preco){
                $PRECODIF = " &nbsp; <sup><span class=\"badge bg-warning\" style=\"font-size:8px;padding:4px 4px; text-align:left;\"><sup>por:</sup> {$LIST_IEM->contrato_preco}</span></sup>";
              }else{$PRECODIF = "";}
              if(!empty($LIST_IEM->contrato_notas)){
                //--  NOTAS
                $CONTRATO_NOTAS = "{$LIST_IEM->contrato_notas}";
                $CONTRATO_NOTAS = str_replace("[", " &nbsp; <SPAN style=\"color:#FFFFFF;\">", str_replace("]", "</SPAN> ", $CONTRATO_NOTAS));
                $CONTRATO_NOTAS = str_replace("{", " &nbsp; <SPAN style=\"color:#67B6FF;\">", str_replace("}", "</SPAN> ", $CONTRATO_NOTAS));

                // $CONTRATONOTAS = "&nbsp; <span class=\"badge bg-secondary\" style=\"font-size:10px;padding:4px 4px; text-align:left; opacity:0.6; min-width:70px;max-width:25vw/*350px*/; overflow:hidden;text-overflow:ellipsis;\"><sup>nota:</sup> {$LIST_IEM->contrato_notas}</span>";
                $CONTRATONOTAS = "&nbsp; <span class=\"badge\" style=\"margin-bottom:-8px;background-color:#000;color:#FFC107;font-size:16px;font-weight:400;padding:4px 4px;text-align:left; opacity:1; min-width:70px;max-width:25vw/*350px*/; overflow:hidden;text-overflow:ellipsis;\">{$CONTRATO_NOTAS}</span>";
              }else{$CONTRATONOTAS = "";}

              // Regras de estilização 
              $STYLE_NOM='';$TITLE_NOM='';if(empty($LIST_IEM->contrato_id)){ // SEM CONTRATO
                $STYLE_NOM = "color:#FFF;font-weight: bold;";
                $TITLE_NOM="Cliente sem contrato, pacote ou fatura em aberto.";
              }else if($LIST_IEM->contrato_status == "EM_ATRASO"){ // PENDENTE (EM ATRASO)
                $STYLE_NOM = "color:#DC3545 /*#FF0000 RED*/;";
                if($LIST_IEM->contrato_dias_atraso == 1){
                  $TITLE_NOM="Em atraso a {$LIST_IEM->contrato_dias_atraso} dia.";
                }else{
                  $TITLE_NOM="Em atraso a {$LIST_IEM->contrato_dias_atraso} dias.";
                }
              }else if($LIST_IEM->contrato_status == "A_VENCER"){ // A VENCER
                $STYLE_NOM = "color:#FFC107;";
                if($LIST_IEM->contrato_dias_atraso == 0){
                  $TITLE_NOM="Este contrato vence hoje.";
                }else if($LIST_IEM->contrato_dias_atraso == -1){
                  $TITLE_NOM="Este contrato vence amanhã.";
                }else{
                  $TITLE_NOM=str_replace(" -"," ","Este contrato vence em {$LIST_IEM->contrato_dias_atraso} dias.");
                }
              }
              if(!empty($LIST_IEM->pacote_preco)){
                $CONTRATO_PRECO = "&nbsp; - &nbsp;{$LIST_IEM->pacote_preco}";
              }else{
                $CONTRATO_PRECO = "";
              }
              if(!empty($LIST_IEM->contrato_vencimento_formatado)){
                $CONTRATO_VENC = $LIST_IEM->contrato_vencimento_formatado;
              }else{
                $CONTRATO_VENC = date("d/m/Y", strtotime("+1 month"));
              }

              
                  $LIST_NOTAS = str_replace("\r\n","\\\\n", $LIST_IEM->contrato_notas);
                  $ONCLICK = "
                    onClick=\"
                    window.open('\
                    JavaScript:\
                     clienteedit(\
                            cliente_edit_title = \'<i class=`far fas fa-user-edit nav-icon`></i> &nbsp; Editar Cliente\',\
                            cliente_edit_id = \'{$LIST_IEM->cliente_id}\',\
                            cliente_edit_nome = \'{$LIST_IEM->cliente_nome}\',\
                            cliente_edit_email = \'{$LIST_IEM->cliente_email}\',\
                            cliente_edit_telefone = \'{$LIST_IEM->cliente_telefone}\',\
                            cliente_edit_pacoteid = \'{$LIST_IEM->contrato_pacote_id}\',\
                            cliente_edit_notas = \'{$LIST_NOTAS}\',\
                            cliente_edit_valor_contrato = \'{$LIST_IEM->contrato_preco}\',\
                            cliente_edit_data = \'{$CONTRATO_VENC}\'\
                     );\
                    ','_parent')\"";
                    
                  $ONCLICK2 = "
                    onClick=\"
                     renovarfatura(
                            renovarfatura_id = '{$LIST_IEM->cliente_id}',
                            renovarfatura_nome = '{$LIST_IEM->cliente_nome}'
                     );
                     $('#quitarcliente{$LIST_IEM->cliente_id}').html('Renovando...')
                    \"";
              if(($LIST_IEM->contrato_status == "EM_ATRASO") || ($LIST_IEM->contrato_status == "A_VENCER")){
                  $RADIO_RENOV = "
                    <!-- Renovação Automatica -->
                    <div class=\"form-group rado-customized\" style=\"margin:0px;\">
                      <div class=\"icheck-success d-inline\">
                        <input type=\"radio\" id=\"radioPrimary{$LIST_IEM->cliente_id}1\" name=\"r{$LIST_IEM->cliente_id}\">
                        <label for=\"radioPrimary{$LIST_IEM->cliente_id}1\" {$ONCLICK2}>
                          <span id=\"quitarcliente{$LIST_IEM->cliente_id}\" style=\"color:#999;\">
                            Renovar
                          </span>
                        </label>
                      </div>
                    </div>";
              }else{
                $RADIO_RENOV = "";
              }
                    
                  $RESULT_REQUEST_LIST .=  "
                  <tr  style=\"white-space:nowrap; max-height:20px;\">
                    <td>
                      <div class=\"icheck-primary\">
                        <input type=\"checkbox\" value=\"{$LIST_IEM->cliente_nome}\" id=\"check{$LIST_IEM->cliente_id}\">
                        <label for=\"check{$LIST_IEM->cliente_id}\"></label>
                      </div>
                    </td>
                    <td class=\"mailbox-name\" {$ONCLICK} title=\"{$TITLE_NOM}\">
                    <a href=\"JavaScript:void(0);\"
                    style=\"
                        width:100%;
                        min-width:140px; 
                        max-width:180px; 
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        overflow: hidden;
                        -webkit-box-orient: vertical;
                        text-overflow:ellipsis;
                        {$STYLE_NOM}
                    \"><strong>{$LIST_IEM->cliente_nome}</strong>&nbsp;</a>
                    </td>
                    <td>
                    {$RADIO_RENOV}
                    </td>
                    <td class=\"mailbox-date\" style=\"white-space: nowrap;\" {$ONCLICK}>
                    <i class=\"nav-icon far fa-calendar-alt\"></i> {$LIST_IEM->contrato_vencimento_formatado}&nbsp;
                    </td>
                    <td class=\"mailbox-subject\" style=\"white-space: nowrap; padding:10px;\" {$ONCLICK}>
                    {$LIST_IEM->contrato_titulo}<span style=\"font-weight:100;\">{$CONTRATO_PRECO}</span>{$PRECODIF}{$CONTRATONOTAS}
                    </td>
                  </tr>
                  ";
             endforeach;

   $RESULT_REQUEST_LIST .=  "
       </tbody>
                </table>
                <!-- /.table -->
   ";













            else:
              $RESULT_REQUEST_LIST .=  $NOT_FOUND;
            endif;







 /* Seta os controles da paginação */
$RESULT_REQUEST_LIST .= "

          <SCRIPT>
          $('#nPendente').html('{$CONTRATO["EM_ATRASO"]}'); // Vencido
          $('#nAVencer').html('{$CONTRATO["A_VENCER"]}');   // A vencer
          $('#nRegular').html('{$CONTRATO["REGULAR"]}');    // Regular
          $('#nNull').html('{$CONTRATO["NULL"]}');          // Sem contrato
          


          $('button[title=\"Selecionar todos\"]').attr('onclick',\"\\
            checkall_loadpaginaclientes()\\
          \");


          $('button[action=\"renovar\"]').attr('onclick',\"\\
            DELCHECK=verificacheck(); if(DELCHECK > ''){renovarfaturas();}else{info('Por favor, selecione ao menos 1 cliente.');}\\
          \");


          $('button[action=\"encerrar\"]').attr('onclick',\"\\
            DELCHECK=verificacheck(); if(DELCHECK > ''){info('Por favor, tenha cuidado. <br>Você esta prestes a encerrar um ou mais contratos.');encerrarfaturas();}else{info('Por favor, selecione ao menos 1 cliente.');}\\
          \");


          $('button[action=\"excluir\"]').attr('onclick',\"\\
            DELCHECK=verificacheck(); if(DELCHECK > ''){info('Por favor, tenha cuidado. <br>Você esta prestes a excluir um ou mais clientes.');deleteclientes();}else{info('Por favor, selecione ao menos 1 cliente.');}\\
          \");


          $('button[title=\"Primeira Página\"]').attr('onclick',\"\\
            loadpaginaclientes($primeira_pagina,'$search');\\
          \");


          $('button[title=\"Ultima Página\"]').attr('onclick',\"\\
            loadpaginaclientes($ultima_pagina,'$search');\\
          \");


          setTimeout(function(){
            $('button[title=\"Recarregar\"] i').removeAttr(\"style\").removeClass(\"fa-spin\"); //Parar Spin
          }, 500);
          $('button[title=\"Recarregar\"]').attr('onclick',\"\\
            reload_loadpaginaclientes()\\
          \");


          $('*#pagsN').html('{$pagsN}');


          $('button[title=\"Página anterior\"]').attr('onclick',\"\\
            loadpaginaclientes($pagina_anterior,'$search');\\
          \");


          $('button[title=\"Proxima Página\"]').attr('onclick',\"\\
            loadpaginaclientes($proxima_pagina,'$search');\\
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