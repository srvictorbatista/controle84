<? include_once('../../_config.php'); include_once('../../_sessao.php');

 /* Constantes de configuração */  
 define('QTDE_REGISTROS', 14);   
 define('RANGE_PAGINAS', 1);   
   
 /* Recebe o número da página via parâmetro na URL */  // $_POST['pagina']=2;
 $pagina_atual = (isset($_POST['pagamentos_folha']) && is_numeric($_POST['pagamentos_folha'])) ? $_POST['pagamentos_folha'] : 1;
 if(!@empty($_POST['search'])){ $search = $_POST['search'];} // SEARCH não esta senho usado em pagamentos

 if(!@empty($_POST['pagamentos_mes'])){ $SearchData = $_POST['pagamentos_mes'];}
  $DetalheMes = substr($SearchData,0,2);	
  $DetalheAno = substr($SearchData,3,4);

   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS; 





 if(!@empty($search)){ // listagem com pesquisa
 $PESQ = " <span style=\"color:#AAA;\">Pesquisa:</span> {$search}...";
 $AUTOFOCUS = "onfocus=\"this.selectionStart = this.selectionEnd = this.value.length;\" autofocus=\"true\"";
 $AUTOFOCUS2 = "$('input[name=search]').focus();";
 $sql = "
        -- ----------------------------------------------------------
		SELECT 
			`id`,
			`cliente_id`,
			`cliente_nome`,
			`cliente_telefone`,
			`cliente_email`,
			`cliente_cadastro`,
			`pacote_id`,
			`contrato_titulo`,
			`contrato_descricao`,
			`contrato_notas`,
			`contrato_valor_base`,
			`contrato_valor_preco`,
			`contrato_vencimento`,
			`contrato_vencimento_formatado`,
			`contrato_status`,
			`contrato_quitado`,
			`contrato_quitado_formatado`,
			`contrato_dias_atraso`,
            `referencia_mes`,
            `referencia_ano`
          
          FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
		  WHERE		    
		     MONTH(`contrato_vencimento`) = {$DetalheMes}
		     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
			   AND (
			   		`cliente_nome` LIKE '%$search%' 
			   		OR  `contrato_titulo` LIKE '%$search%'
			   )
		  OR
		     MONTH(`contrato_quitado`) = {$DetalheMes}
		     AND YEAR(`contrato_quitado`) = {$DetalheAno}
			   AND (
			   		`cliente_nome` LIKE '%$search%' 
			   		OR  `contrato_titulo` LIKE '%$search%'
			   )
		ORDER BY  `contrato_quitado` ASC, `contrato_vencimento` ASC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . ";
        -- ----------------------------------------------------------




        /*
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
        */
    ";
     /* Conta todos os registos na tabela além de uma exibição geral */
      $sqlContador = "/* SELECT COUNT(*) AS total_registros FROM {$PREFIXO_PATH}_pacotes WHERE `nome` LIKE '%$search%' */  
        -- ----------------------------------------------------------
		SELECT (
		    SELECT COUNT(*) FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
				WHERE		    
				     MONTH(`contrato_vencimento`) = {$DetalheMes}
				     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
				OR
				     MONTH(`contrato_quitado`) = {$DetalheMes}
				     AND YEAR(`contrato_quitado`) = {$DetalheAno}
		    ) AS `total_registros`,
			`id`,
			`cliente_id`,
			`cliente_nome`,
			`cliente_telefone`,
			`cliente_email`,
			`cliente_cadastro`,
			`pacote_id`,
			`contrato_titulo`,
			`contrato_descricao`,
			`contrato_notas`,
			`contrato_valor_base`,
			`contrato_valor_preco`,
			`contrato_vencimento`,
			`contrato_vencimento_formatado`,
			`contrato_status`,
			`contrato_quitado`,
			`contrato_quitado_formatado`,
			`contrato_dias_atraso`,
            `referencia_mes`,
            `referencia_ano`
          
          FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
		  WHERE		    
		     MONTH(`contrato_vencimento`) = {$DetalheMes}
		     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
			   AND (
			   		`cliente_nome` LIKE '%$search%' 
			   		OR  `contrato_titulo` LIKE '%$search%'
			   )
		  OR
		     MONTH(`contrato_quitado`) = {$DetalheMes}
		     AND YEAR(`contrato_quitado`) = {$DetalheAno}
			   AND (
			   		`cliente_nome` LIKE '%$search%' 
			   		OR  `contrato_titulo` LIKE '%$search%'
			   )
		  ORDER BY  `contrato_quitado` ASC, `contrato_vencimento` ASC;

        -- ---------------------------------------------------------- "; 

 }else{ $search='';  // listagem sem pesquisa
$PESQ = " <span style=\"color:#AAA;\"> Detalhamento de Caixa: [REFERENCIA]</span>";
$AUTOFOCUS="";
$AUTOFOCUS2 = "";
 $sql = "
        -- ----------------------------------------------------------
		SELECT 
			`id`,
			`cliente_id`,
			`cliente_nome`,
			`cliente_telefone`,
			`cliente_email`,
			`cliente_cadastro`,
			`pacote_id`,
			`contrato_titulo`,
			`contrato_descricao`,
			`contrato_notas`,
			`contrato_valor_base`,
			`contrato_valor_preco`,
			`contrato_vencimento`,
			`contrato_vencimento_formatado`,
			`contrato_status`,
			`contrato_quitado`,
			`contrato_quitado_formatado`,
			`contrato_dias_atraso`,
            `referencia_mes`,
            `referencia_ano`
		  FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
		  WHERE
		     MONTH(`contrato_vencimento`) = {$DetalheMes}
		     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
		  OR
		     MONTH(`contrato_quitado`) = {$DetalheMes}
		     AND YEAR(`contrato_quitado`) = {$DetalheAno}
		ORDER BY  `contrato_quitado` ASC, `contrato_vencimento` ASC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . ";
        -- ----------------------------------------------------------




        /*
        -- ----------------------------------------------------------
        SELECT 
          `id`,`nome`,`descricao`,`valor_base`,
          CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco`
        FROM `{$PREFIXO_PATH}_pacotes`
        ORDER BY `id` DESC
         LIMIT {$linha_inicial}, " . QTDE_REGISTROS . "
        -- ----------------------------------------------------------
        */
    ";
     /* Conta todos os registos na tabela além de uma exibição geral */  
     $sqlContador = "
        -- ----------------------------------------------------------
		SELECT (
		    SELECT COUNT(*) FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
				WHERE		    
				     MONTH(`contrato_vencimento`) = {$DetalheMes}
				     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
				OR
				     MONTH(`contrato_quitado`) = {$DetalheMes}
				     AND YEAR(`contrato_quitado`) = {$DetalheAno}
		    ) AS `total_registros`,
			`id`,
			`cliente_id`,
			`cliente_nome`,
			`cliente_telefone`,
			`cliente_email`,
			`cliente_cadastro`,
			`pacote_id`,
			`contrato_titulo`,
			`contrato_descricao`,
			`contrato_notas`,
			`contrato_valor_base`,
			`contrato_valor_preco`,
			`contrato_vencimento`,
			`contrato_vencimento_formatado`,
			`contrato_status`,
			`contrato_quitado`,
			`contrato_quitado_formatado`,
			`contrato_dias_atraso`,
            `referencia_mes`,
            `referencia_ano`
          
          FROM `_view_{$PREFIXO_PATH}_contratos_relatorios` 
		  WHERE		    
		     MONTH(`contrato_vencimento`) = {$DetalheMes}
		     AND YEAR(`contrato_vencimento`) = {$DetalheAno}
		  OR
		     MONTH(`contrato_quitado`) = {$DetalheMes}
		     AND YEAR(`contrato_quitado`) = {$DetalheAno}
		  ORDER BY  `contrato_quitado` ASC, `contrato_vencimento` ASC;

        -- ---------------------------------------------------------- "; 
}

		//*
		if($DetalheMes == "/"){
	 	        $data['success'] = "SEM DADOS PARA ESTE RELATÓRIO";
		        $data['message'] = "<CENTER style=\"color:#AAA;font-weight:bold;\">{$data['success']}</CENTER>
		        		<SCRIPT>
		        			alert('<CENTER style=\"font-size:22px;font-weight:bold;\">{$data['success']}</CENTER>');
		        			\$('#MDLl32E2A41B').css('background-color','#343A40EF');
					      	\$('button[aria-label=Close]').css('display','none');
					      	\$('#MDLl32E2A41B').off('click');
					      	\$('button[name=NAME1]').css('display','none');
					      	\$('.fa-exclamation-triangle').addClass('fa-pisca');
					      	\$('#MDLl32E2A41B #resultado').html('<span style=\"color:#AAA;\">Volte a esta página, após registrar ao menos 1 recebimento.<span>');
		        		</SCRIPT>";
		  echo json_encode($data); exit();
	 	  //die(json_encode($data));
	 	}/**/
	 
	 //-- -------------------------------------------------------------
	 //-- ----------------| SOMA SALDOS TOTAIS |-----------------------
	 //-- -------------------------------------------------------------
     $stm = $conn->prepare($sqlContador);
	 $stm->execute();   
	 $todos = $stm->fetchAll(PDO::FETCH_OBJ);
	 $SOMA_SALDO=0;
	    if(!empty($todos)): 
	       foreach($todos as $ALL_LIST_IEM):
              $QuitadoMes = substr($ALL_LIST_IEM->contrato_quitado,5,2);	
  			  $QuitadoAno = substr($ALL_LIST_IEM->contrato_quitado,0,4);
              $VencimeMes = substr($ALL_LIST_IEM->contrato_vencimento,5,2);
              $VencimeAno = substr($ALL_LIST_IEM->contrato_vencimento,0,4);
              if("{$ALL_LIST_IEM->contrato_status}"=="RECEBIDO"){
              	if("{$DetalheMes}/{$DetalheAno}" == "{$QuitadoMes}/{$QuitadoAno}"){
              		$SOMA_SALDO +=$ALL_LIST_IEM->contrato_valor_base;
              	}
              }
	       endforeach;
	    else:

	    endif;
	 //-- -------------------------------------------------------------




 $stm = $conn->prepare($sql);
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   


 $stm = $conn->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);   
   
 /* Idêntifica a primeira página */  
 $primeira_pagina = 1;
   
 /* Cálcula qual será a última página */  
 if(@$valor->total_registros < 1){ 	
 		//die("SEM RECB");
 	        $data['success'] = false; // SEM DADOS
		    $data['message'] = "
		          <SCRIPT>
		          	\$('#MDLl32E2A41C .card-title').html('<span style=\"font-size:20px;font-weight:500;\">Detalhamento de Caixa (sem dados)</span>');
		          	\$('#MDLl32E2A41C #SelectRelatorioPagina option').html('SEM DADOS');
		          </SCRIPT>
		    	<p class=\"/*bg-danger*/\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold; /*cursor:pointer;*/\" onclick=\"\">Nenhum registro encontrado!</p>  ";
		  die( json_encode($data) );
 }
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

            /* Loop para montar a páginação do select com os números */ 
             $SelicetFolhaPagamentos='';  
            $pagsN='';for ($i=$primeira_pagina; $i <= $ultima_pagina; $i++):
              if(($i == $pagina_atual)){
                $SelicetFolhaPagamentos .="<option value=\'{$i}\' selected=\'true\' disabled=\'disabled\'>Folha ".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>\\r\\n";
              }else{
            	$SelicetFolhaPagamentos .="<option value=\'{$i}\'>Folha ".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>\\r\\n";
              }
            endfor;








  
    $RESULT_REQUEST_LIST =  "";
    if(!empty($dados)): 


     
     

     $RESULT_REQUEST_LIST =  "
                <table class=\"table  table-bordered table-striped\" id=\"RelatorioDetalhado\" style=\"margin:0px; background-color:#242E3580; color:#AAA;\">
                  <thead>
                    <tr style=\"background-color: #2D343A;\">
                      <th colspan=\"2\" style=\"width:140px;\"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nome do cliente</th>
                      <th style=\"width:100px;\">Vencimento</th>
                      <th width=\"*\">Pacote/Plano/Contrato</th>
                      <th colspan=\"2\">Status / Valor</th>
                    </tr>
                  </thead>
                  <tbody>
       ";


             foreach($dados as $LIST_IEM):
              $QuitadoMes = substr($LIST_IEM->contrato_quitado,5,2);	
  			  $QuitadoAno = substr($LIST_IEM->contrato_quitado,0,4);
              $VencimeMes = substr($LIST_IEM->contrato_vencimento,5,2);
              $VencimeAno = substr($LIST_IEM->contrato_vencimento,0,4);
	             if("{$LIST_IEM->contrato_status}"=="EM_ATRASO"){
	             	$CONTRATO_STATUS = "<span class=\"badge bg-danger\">EM ATRASO A {$LIST_IEM->contrato_dias_atraso} DIAS</span>";
	             }else if("{$LIST_IEM->contrato_status}"=="RECEBIDO"){
		             	if("{$DetalheMes}/{$DetalheAno}" == "{$QuitadoMes}/{$QuitadoAno}"){
		             		$QuitadoBG = "bg-success";
		             	}else{
		             		$QuitadoBG = "bg-white\" style=\"color:#666 !important;";
		             	}
	             	$CONTRATO_STATUS = "
	             						<!-- span class=\"badge bg-primary\">VENCIMENTO {$LIST_IEM->contrato_vencimento_formatado}</span -->
	             						<span class=\"badge {$QuitadoBG}\">RECEBIDO EM {$LIST_IEM->contrato_quitado_formatado}</span>
	             						
	             	";
	             }else if("{$LIST_IEM->contrato_status}"=="REGULAR"){
	             	$CONTRATO_STATUS = "
	             						<span class=\"badge bg-secondary\" style=\" opacity:0.6;\">EM DIA (aguardando vencimento)</span> <!-- span class=\"badge bg-primary\">EM DIA (aguardando vencimento)</span -->
	             	";
	             }else if("{$LIST_IEM->contrato_status}"=="A_VENCER"){
	             	$CONTRATO_STATUS = "
	             						<span class=\"badge bg-warning\" style=\" opacity:1; color:#333 !important;\">A VENCER EM BREVE</span>
	             	";
	             }else{
	             	$CONTRATO_STATUS = "*** STATUS *** ({$LIST_IEM->contrato_status})";
	             }

	             if("{$DetalheMes}/{$DetalheAno}" ==  "{$VencimeMes}/{$VencimeAno}"){
	             	$CONTRATO_VENCIMENTO = "{$LIST_IEM->contrato_vencimento_formatado}";
	             }else{
	             	$CONTRATO_VENCIMENTO = "<b style=\"color:#CCC;\">{$LIST_IEM->contrato_vencimento_formatado}</b>";
	             }

	             if(!empty(trim($LIST_IEM->contrato_notas))){
	             	$CONTRATO_NOTAS = "
	                      	<span class=\"badge bg-secondary\" style=\"font-size:10px;padding:4px 4px; text-align:left; opacity:0.6; min-width:70px;max-width:17vw; overflow:hidden;text-overflow:ellipsis;\"><sup>nota:</sup> {$LIST_IEM->contrato_notas}</span>";
	                $LIST_NOTAS=str_replace("\r\n","\\\\n",$LIST_IEM->contrato_notas);
	             }else{
	             	$CONTRATO_NOTAS = "";
	             	$LIST_NOTAS = "";
	             }

              $REFERENCIA = TrataNome("{$LIST_IEM->referencia_mes} de {$LIST_IEM->referencia_ano}");
              $PESQ = str_replace("[REFERENCIA]", $REFERENCIA, $PESQ);

              if("{$LIST_IEM->contrato_status}"=="RECEBIDO"){
                  $ONCLICK_EDIT = "
                    onClick=\"
                 window.open('\
                    JavaScript:\
                     pagamentoedit(\
                            pagamento_edit_title = \'<i class=`far fas fa-solid fa-sack-dollar`></i> &nbsp; Editar Recebimento (AJUSTES)\',\
                            pagamento_edit_id = \'{$LIST_IEM->id}\',\
                            pagamento_edit_nome = \'{$LIST_IEM->cliente_nome}\',\
                            pagamento_edit_email = \'{$LIST_IEM->cliente_email}\',\
                            pagamento_edit_telefone = \'{$LIST_IEM->cliente_telefone}\',\
                            pagamento_edit_pacoteid = \'{$LIST_IEM->pacote_id}\',\
                            pagamento_edit_notas = \'{$LIST_NOTAS}\',\
                            pagamento_edit_valor_contrato = \'{$LIST_IEM->contrato_valor_preco}\',\
                            pagamento_edit_venc = \'{$LIST_IEM->contrato_vencimento_formatado}\',\
                            pagamento_edit_data = \'{$LIST_IEM->contrato_quitado_formatado}\'\
                     );\
                    ','_parent');\"";

                   $ONCLICK_DELL = "onClick=\"delrecebimento('{$LIST_IEM->id}', '{$LIST_IEM->cliente_nome} <sup><span class=\'badge bg-secondary\' style=\'white-space:nowrap; font-size:12px;\'>".str_replace(",","&amp;#44;",$LIST_IEM->contrato_valor_preco)."</span></sup>');\"";
              }else{
                  $ONCLICK_EDIT = "
                    onClick=\"
                    window.open('\
                    JavaScript:\
                     clienteedit(\
                            cliente_edit_title = \'<i class=`far fas fa-user-edit nav-icon`></i> &nbsp; Editar Cliente (contrato)\',\
                            cliente_edit_id = \'{$LIST_IEM->cliente_id}\',\
                            cliente_edit_nome = \'{$LIST_IEM->cliente_nome}\',\
                            cliente_edit_email = \'{$LIST_IEM->cliente_email}\',\
                            cliente_edit_telefone = \'{$LIST_IEM->cliente_telefone}\',\
                            cliente_edit_pacoteid = \'{$LIST_IEM->pacote_id}\',\
                            cliente_edit_notas = \'{$LIST_NOTAS}\',\
                            cliente_edit_valor_contrato = \'{$LIST_IEM->contrato_valor_preco}\',\
                            cliente_edit_data = \'{$CONTRATO_VENCIMENTO}\'\
                     );\
                    ','_parent')\"";

                   $ONCLICK_DELL = "onClick=\"encerrarcontrato('{$LIST_IEM->cliente_id}', '{$LIST_IEM->cliente_nome} <sup><span class=\'badge bg-secondary\' style=\'white-space:nowrap; font-size:12px;\'>".str_replace(",","&amp;#44;",$LIST_IEM->contrato_valor_preco)."</span></sup>');\"";
              }
                    
                  $RESULT_REQUEST_LIST .=  "

                    <tr style=\"white-space: nowrap;\">
                      <td width=\"5%\">
                       <div style=\"white-space: nowrap;\">
                      	<button type=\"button\" class=\"btn btn-default btn-sm\" style=\"margin-right: 5px;\" action=\"excluir\" title=\"Excluir\" {$ONCLICK_DELL}>
                          <i class=\"far fa-trash-alt\"></i>
                        </button>

                      	<button type=\"button\" class=\"btn btn-default btn-sm\" style=\"\" action=\"editar\" title=\"Editar\" {$ONCLICK_EDIT}>
                          <i class=\"fas fa-solid fa-pen-to-square /*fa-solid fa-square-pen*/\"></i>
                        </button>
                      </div>

                      </td>
                      <td><span
	                    style=\"font-weight:400; font-size:18px;
	                        width:100%;
	                        min-width:150px; 
	                        display: -webkit-box;
	                        -webkit-line-clamp: 1;
	                        overflow: hidden;
	                        -webkit-box-orient: vertical;
	                    \">{$LIST_IEM->cliente_nome}&nbsp;
	                  </span></td>
                      <td>{$CONTRATO_VENCIMENTO} </td>
                      <td>
                      	{$LIST_IEM->contrato_titulo} &nbsp; 
                      	{$CONTRATO_NOTAS} &nbsp; 
	                      <!-- div style=\"width:60px;float:right;\">
	                        <div class=\"progress progress-xs\">
	                          <div class=\"progress-bar progress-bar-danger\" style=\"width:55%;\"></div>
	                        </div>
	                      	<div class=\"progress_title\">55%</div>
	                      </div -->
                      </td>
                      <td style=\"width:100px;\">
                      	{$CONTRATO_STATUS} 
                      </td>
                      <td  style=\"white-space: nowrap; width:80px;\" align=\"right\">
                      <span
	                    style=\"font-weight:500; font-size:20px;
	                        width:100%;
	                        min-width:80px;
	                    \">
                      	{$LIST_IEM->contrato_valor_preco}
                      	</span>
	                  </td>
                    </tr>
                  ";
               $LIST_DESQ = '';
             endforeach;

   $RESULT_REQUEST_LIST .=  "
                    <tr style=\"font-size:1.2em;\">
                      <td colspan=\"4\" style=\"border:none;background-color:#3A4248;\"> </td>
                      <td colspan=\"2\"><span style=\"font-weight:bold;\">SALDO:</span> &nbsp; &nbsp; <span style=\"float:right;\">R$ ".number_format("{$SOMA_SALDO}",2,",",".")." </span></td>
                  </tbody>
                </table>
                <!-- /.table -->
   ";













            else:
              $RESULT_REQUEST_LIST =  "<p class=\"/*bg-danger*/\" style=\"border-radius: 0.20rem; color:#FFF;padding:15px 20px; text-align:center;font-weight:bold; /*cursor:pointer;*/\" onclick=\"\">Nenhum registro encontrado!</p>  ";
            endif;







 /* Seta os controles da paginação */
$RESULT_REQUEST_LIST .= "

          <SCRIPT>

          $('button[title=\"Primeira Folha\"]').attr('onclick',\"\\
          	loadfolharelatoriospagamentos($primeira_pagina,'$search');\\
          \");


          $('button[title=\"Ultima Folha\"]').attr('onclick',\"\\
            loadfolharelatoriospagamentos($ultima_pagina,'$search');\\
          \");


          $('#MDLl32E2A41C select[name=\"SelectRelatorioPagina\"]').html(\"\\
          {$SelicetFolhaPagamentos}\\
          \");

          //$SelicetFolhaPagamentos


          setTimeout(function(){
            $('button[title=\"Recarregar\"] i').removeAttr(\"style\").removeClass(\"fa-spin\"); //Parar Spin
          }, 500);
          $('button[title=\"Recarregar\"]').attr('onclick',\"\\
            loadfolharelatoriospagamentos()\\
          \");


          $('*#pagsN').html('{$pagsN}');


          $('button[title=\"Folha anterior\"]').attr('onclick',\"\\
            loadfolharelatoriospagamentos($pagina_anterior,'$search');\\
          \");


          $('button[title=\"Proxima Folha\"]').attr('onclick',\"\\
            loadfolharelatoriospagamentos($proxima_pagina,'$search');\\
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





















///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
exit();

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
    $data['message'] = "<span style=\"color:#33AAAA;\"><center>Success!</center></span>";
}
echo json_encode($data);
exit();
?>