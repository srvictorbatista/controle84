<? include_once('../../_config.php');


  $sqlResumoMensal = "
	-- -----------------------------------
	-- --- PERIODO HISTORICO COMPLETO ----
	-- -----------------------------------
	SELECT 
	-- --------------------
	-- --- MAIS ANTIGO ----
	-- --------------------
	IF(
	 (SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`) < (SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), 
	  CONCAT(
	  	YEAR(STR_TO_DATE((SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`), '%Y-%m-%d')),
	    '-',
	  	LPAD(MONTH(STR_TO_DATE((SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`), '%Y-%m-%d')),2,'0'),
	    '-01'
	  ), 
	  CONCAT(
	  	YEAR(STR_TO_DATE((SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), '%Y-%m-%d')),
	    '-',
	  	LPAD(MONTH(STR_TO_DATE((SELECT MIN(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), '%Y-%m-%d')),2,'0'),
	    '-01'
	  )
	) AS `MAIS_ANTIGO`,

	-- --------------------
	-- --- MAIS RECENTE ---
	-- --------------------
	IF(
	 (SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`) > (SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), 
	  LAST_DAY(
	  CONCAT(
	  	YEAR(STR_TO_DATE((SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`), '%Y-%m-%d')),
	    '-',
	  	LPAD(MONTH(STR_TO_DATE((SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_bases`), '%Y-%m-%d')),2,'0'),
	    '-01'
	  )
	  ), 
	  LAST_DAY(
	  CONCAT(
	  	YEAR(STR_TO_DATE((SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), '%Y-%m-%d')),
	    '-',
	  	LPAD(MONTH(STR_TO_DATE((SELECT MAX(`contrato_vencimento`) FROM `_view_{$PREFIXO_PATH}_contratos_recebidos`), '%Y-%m-%d')),2,'0'),
	    '-01'
	  )
	  )
	) AS `MAIS_RECENTE`
	-- -----------------------------------
	-- -----------------------------------
	;
";
 $statment = $conn->prepare($sqlResumoMensal);   
 $statment->execute();
 $PERIODO = $statment->fetch(PDO::FETCH_ASSOC);
 //echo "\r\n//-- --------------------------------------------------------\r\n//-- ----| De: {$PERIODO['MAIS_ANTIGO']}, a: {$PERIODO['MAIS_RECENTE']} |-------------------\r\n//-- --------------------------------------------------------\r\n\r\n";

	$Historico_Inicio = "{$PERIODO['MAIS_ANTIGO']}";
	$Historico_Fim = "{$PERIODO['MAIS_RECENTE']}";
	$Primeiro_mes = substr($Historico_Inicio,5,2);	
  	$Primeiro_ano = substr($Historico_Inicio,0,4);
	$Ultimo_mes = substr($Historico_Fim,5,2);	
  	$Ultimo_ano = substr($Historico_Fim,0,4);
	$MESES='';$RECEBIDOS='';$PREVISTOS='';
	$OPTION_MES='';$PREV_MENSAL='';
	$BUTTON_PREV='';$BUTTON_NEXT='';
	$MES_BUTTON=0;$INDEX =0;
	$RES_SELECT='';



WHILE(strtotime($Historico_Inicio) <= strtotime($Historico_Fim)):

  $venc_mes = substr($Historico_Inicio,5,2);
  $venc_ano = substr($Historico_Inicio,0,4);
  // echo "\r\n\r\nData: {$venc_mes}/{$venc_ano} : {$Historico_Inicio} <br>\r\n";
  //-- ------------------------------------------------------------------------------------------------------------------
  //-- ------------------------------------------------------------------------------------------------------------------
  //-- ------------------------------------------------------------------------------------------------------------------

	//-- -----------------------------------
	//-- --- BALANCO MENSAL ----------------
	//-- -----------------------------------
	$REFERENCIA_MES_ANO =  "			      	  //-- ---| @MES={$venc_mes}; @ANO={$venc_ano}; |--------";
	$conn->prepare("SET @i=0; SET @MES = {$venc_mes}; SET @ANO = {$venc_ano};")->execute();
	$sqlResumoMensal = "
		SELECT 
		COUNT(*) + (
		  SELECT COUNT(*) FROM `{$PREFIXO_PATH}_contratos_quitados`
		  WHERE MONTH(`vencimento`) = @MES
		      AND YEAR(`vencimento`) = @ANO
		) AS `previsto`, 
		IFNULL(SUM(`contrato_valor_base`),0)+IFNULL((
		        SELECT SUM(`valor_pago`) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ),0) AS `previsto_valores`,
		CONCAT('R$ ', FORMAT(
		    IFNULL(IFNULL(SUM(`contrato_valor_base`),0)+IFNULL((
		        SELECT SUM(`valor_pago`) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ),0),0)
		  , 2, 'de_DE')
		) AS `previsto_valores_formatado`,
		(
		    SELECT IFNULL(COUNT(*),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		) AS `recebidos`,
		CONCAT(FORMAT(
		        IFNULL(
		            (SELECT COUNT(*) *100 FROM `{$PREFIXO_PATH}_contratos_quitados`
		            WHERE MONTH(`quitado`) = @MES
		                  AND YEAR(`quitado`) = @ANO
		            ) / (COUNT(*) + (
		                SELECT COUNT(*) FROM `{$PREFIXO_PATH}_contratos_quitados`
		                WHERE MONTH(`vencimento`) = @MES
		                  AND YEAR(`vencimento`) = @ANO
		            ))
		        ,0)
		, 1, 'de_DE'),'%') AS `recebidos_percent`,
		(
		    SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		) AS `recebidos_valores`,
		CONCAT('R$ ', FORMAT(
		    (
		    SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		  ), 2, 'de_DE')
		) AS `recebidos_valores_formatado`,
		IFNULL(COUNT(*),0)+IFNULL((
		        SELECT COUNT(*) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ),0) - (
		    SELECT IFNULL(COUNT(*),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		) AS `falta`,
		CONCAT(FORMAT(
		    (IFNULL(COUNT(*),0)+(
		        SELECT IFNULL(COUNT(*),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ) - (
		    SELECT IFNULL(COUNT(*),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		  ))*100/(
		    IFNULL(COUNT(*),0) + (
		  SELECT IFNULL(COUNT(*),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		  WHERE MONTH(`vencimento`) = @MES
		      AND YEAR(`vencimento`) = @ANO
		  )), 1, 'de_DE'),'%') AS `falta_percent`,
		IFNULL(SUM(`contrato_valor_base`),0)+(
		        SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ) - (
		    SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		) AS `falta_valores`,

		CONCAT('R$ ', FORMAT(
		    IFNULL(SUM(`contrato_valor_base`),0)+(
		        SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		        WHERE MONTH(`vencimento`) = @MES
		          AND YEAR(`vencimento`) = @ANO   
		    ) - (
		    SELECT IFNULL(SUM(`valor_pago`),0) FROM `{$PREFIXO_PATH}_contratos_quitados`
		    WHERE MONTH(`quitado`) = @MES
		          AND YEAR(`quitado`) = @ANO
		  ), 2, 'de_DE') 
		) AS `falta_valores_formatado`,
		DATE_FORMAT(CONCAT(@ANO,'-',@MES,'-00'), '%M') AS `mes`,
		DATE_FORMAT(CONCAT(@ANO,'-',@MES,'-00'), '%Y') AS `ano`
		FROM `_view_{$PREFIXO_PATH}_bases`
		WHERE MONTH(`contrato_vencimento`) = @MES
		      AND YEAR(`contrato_vencimento`) = @ANO;
		 -- -----------------------------------
		 -- --- BALANCO MENSAL ----------------
		 -- -----------------------------------
		";

		 $statment = $conn->prepare($sqlResumoMensal);   
		 $statment->execute();
		 $RESUMO_MES = $statment->fetch(PDO::FETCH_ASSOC);
		 $statment->closeCursor();

		  $RESUMO_MES_NOME = TrataNome($RESUMO_MES['mes'])." de {$RESUMO_MES['ano']}";

		 if(empty($RESUMO_MES['previsto']) && ($RESUMO_MES['previsto'] < 0)):
		  $QTD_REALIZADO = 0;
		  $QTD_FALTA = 0;
		  $QTD_TOTAL = 0;
		  $PERCENT1 = 0;
		  $PERCENT2 = 0;
		  $RESUMO_MES['recebidos_valores_formatado'] = 'R$ 0,00';
		  $RESUMO_MES['falta_valores_formatado'] = 'R$ 0,00';
		  $RESUMO_MES['falta_valores_formatado'] = 'R$ 0,00';
		  $RESUMO_MES['previsto_valores_formatado'] = 'R$ 0,00';
		 else:
		  $QTD_REALIZADO = $RESUMO_MES['recebidos'];
		  $QTD_FALTA = $RESUMO_MES['falta'];
		  $QTD_TOTAL = $RESUMO_MES['previsto'];
		  //$PERCENT1 = ceil(str_replace(',','.', preg_replace('/[^\d\,\-\d]/', '', $RESUMO_MES['falta_percent'])));
		  $PERCENT1 = $RESUMO_MES['falta_percent'] ? ceil(str_replace(',','.', preg_replace('/[^\d\,\-\d]/', '', $RESUMO_MES['falta_percent']))) : '0';
		  $PERCENT2 = floor(str_replace(',','.', preg_replace('/[^\d\,\-\d]/', '', $RESUMO_MES['recebidos_percent'])));  
		 endif;

		  $RESUMO_REALIZADO = "Recebido ({$QTD_REALIZADO})";
		  $RESUMO_REALIZADO_VALOR = $RESUMO_MES['recebidos_valores_formatado'];
		  $RESUMO_FALTA = "Pendente ({$QTD_FALTA})";
		  $RESUMO_FALTA_VALOR = $RESUMO_MES['falta_valores_formatado'];
		  $RESUMO_PREVISTO = "Previsto ({$QTD_TOTAL})";
		  $RESUMO_PREVISTO_VALOR = $RESUMO_MES['previsto_valores_formatado'];

		  //echo"/*\r\n";print_r($RESUMO_MES);echo"      /**/\r\n";

		  /* -- MODELO --
		  GoPrevMensal(
		    Mes='<?=$RESUMO_MES_NOME;?>',
		    Realizado='<?=$RESUMO_REALIZADO;?>',
		    Realizado_valor='<?=$RESUMO_REALIZADO_VALOR;?>',
		    Falta='<?=$RESUMO_FALTA;?>',
		    Falta_valor='<?=$RESUMO_FALTA_VALOR;?>',
		    Previsto='<?=$RESUMO_PREVISTO;?>',
		    Previsto_valor='<?=$RESUMO_PREVISTO_VALOR;?>',
		    Progresso='Progresso: ',
		    Progresso_val1='<?=$QTD_REALIZADO;?>',
		    Progresso_val2='<?=$QTD_TOTAL;?>',
		    Precent1=<?=$PERCENT1;?>, 
		    Precent2=<?=$PERCENT2;?>
		  );
		  /**/

		  // BARS E DONUT - RECEBIMENTOS
		  if(empty($RES_SELECT)){
		  	$DetalheMes = substr($Historico_Inicio,5,2);	
			$DetalheAno = substr($Historico_Inicio,0,4);
			$DONUT_RECEBIMENTOS[$INDEX]['MESES'] 		= "{$RESUMO_MES_NOME}";
			$DONUT_RECEBIMENTOS[$INDEX]['PERIODO'] 		= "{$DetalheMes}/{$DetalheAno}";
			$DONUT_RECEBIMENTOS[$INDEX]['VALORES'] 		= "{$RESUMO_MES['recebidos_valores']}";
			$DONUT_RECEBIMENTOS[$INDEX]['PREVISTO'] 		= "{$RESUMO_MES['previsto_valores']}";

		  	/*
		  	echo "
			  <!--

			  NOME_MES: {$RESUMO_MES_NOME}
			  PERIODO: {$DetalheMes}/{$DetalheAno}
			  RECEBIDO: {$RESUMO_MES['recebidos_valores']}
			  -- -------------------------------------------------


			   -->";/**/
		  }


		

		 $MES[$INDEX] = strtotime($Historico_Inicio)."&".time();
		 if($INDEX==0){$MES[-1] = strtotime($Historico_Inicio)."&".time();}


		 // Mes informado
		 if(@$_GET['SelectRelatorioMes'] == strtotime($Historico_Inicio)){
		 		 $PREV_MENSAL = "\r\n{$REFERENCIA_MES_ANO}
				        //setTimeout(function(){
				          Relatorio_GoPrevMensal('{$RESUMO_MES_NOME}', '{$RESUMO_REALIZADO}', '{$RESUMO_REALIZADO_VALOR}', '{$RESUMO_FALTA}', '{$RESUMO_FALTA_VALOR}', '{$RESUMO_PREVISTO}', '{$RESUMO_PREVISTO_VALOR}', 'Progresso: ', '{$QTD_REALIZADO}', '{$QTD_TOTAL}', {$PERCENT1}, {$PERCENT2}); 		               
				        //}, 2500); 
				      //-- ----------------------------------\r\n";
		  	
		  	$SELECTED_MES = substr($Historico_Inicio,5,2);	
			$SELECTED_ANO = substr($Historico_Inicio,0,4);


			$RES_SELECT='Resumo ja selecionado!';				 

		 // Mes não informado
		 }elseif((("{$Ultimo_mes}/{$Ultimo_ano}") == ("{$venc_mes}/{$venc_ano}")) && empty($RES_SELECT)){ 
				 $PREV_MENSAL = "\r\n{$REFERENCIA_MES_ANO}
				        //setTimeout(function(){
				          Relatorio_GoPrevMensal('{$RESUMO_MES_NOME}', '{$RESUMO_REALIZADO}', '{$RESUMO_REALIZADO_VALOR}', '{$RESUMO_FALTA}', '{$RESUMO_FALTA_VALOR}', '{$RESUMO_PREVISTO}', '{$RESUMO_PREVISTO_VALOR}', 'Progresso: ', '{$QTD_REALIZADO}', '{$QTD_TOTAL}', {$PERCENT1}, {$PERCENT2}); 		               
				        //}, 500); 
				      //-- ----------------------------------\r\n";

		 }/**/

		 if(@$_GET['SelectRelatorioMes'] == strtotime($Historico_Inicio)){
			 $OPTION_MES = "<option value=\'".strtotime($Historico_Inicio)."&".time()."\' selected=\'true\' disabled=\'disabled\'>{$RESUMO_MES_NOME}</option>".$OPTION_MES;
			 $MES_BUTTON = $INDEX;
			 if(("{$Ultimo_mes}/{$Ultimo_ano}") == ("{$venc_mes}/{$venc_ano}")){ 
					 $MES[$INDEX+1] = strtotime($Historico_Inicio)."&".time();
			 }
		 }else{
		 	if($QTD_TOTAL <= 0){
		 		// Sem dados previstos para este mes
		 		$OPTION_MES = "<option value=\'".strtotime($Historico_Inicio)."&".time()."\' disabled=\'disabled\' style=\'background-color:#233A52; color:#FFFFFF61; \'> &nbsp; &nbsp; &nbsp; {$RESUMO_MES_NOME} (SEM REGISTROS) &nbsp; </option>".$OPTION_MES;	
		 	}else{
		 		$OPTION_MES = "<option value=\'".strtotime($Historico_Inicio)."&".time()."\'> &nbsp; &nbsp; {$RESUMO_MES_NOME} </option>".$OPTION_MES;
		 	}
		 }




		 		 

		 //-- -------------------------------------------------------------------------
		 //-- ---| Ultimo mes como null, se vazio (grafico em javascript) |------------
		 //-- -------------------------------------------------------------------------
		 if(("{$Ultimo_mes}/{$Ultimo_ano}") == ("{$venc_mes}/{$venc_ano}")){
		 	$MESES .= "'{$RESUMO_MES_NOME}'";
		 	if($RESUMO_MES['recebidos_valores']==0){
		 		$RECEBIDOS .= "null,      0";
		 	}else{
		 		$RECEBIDOS .= "{$RESUMO_MES['recebidos_valores']},      0";
		 	}

		 	if($RESUMO_MES['previsto_valores']==0){
		 		$PREVISTOS .= "null";
		 	}else{
		 		$PREVISTOS .= "{$RESUMO_MES['previsto_valores']}";
		 	}		 	
		 }else{
		 	$MESES .= "'{$RESUMO_MES_NOME}', ";
		 	$PREVISTOS .= "{$RESUMO_MES['previsto_valores']}, ";
		 	$RECEBIDOS .= "{$RESUMO_MES['recebidos_valores']}, ";
		 }
		 //-- -------------------------------------------------------------------------

		 




	//-- -----------------------------------
  //-- ------------------------------------------------------------------------------------------------------------------
  //-- ------------------------------------------------------------------------------------------------------------------
  //-- ------------------------------------------------------------------------------------------------------------------
$Historico_Inicio = date("Y-m-d", strtotime("+1 month", strtotime($Historico_Inicio)));$INDEX++;
ENDWHILE;

$GERAL_MESES = "[{$MESES}]";
$GERAL_PREVISTOS = "[{$PREVISTOS}]";
$GERAL_RECEBIDOS = "[{$RECEBIDOS}]";
$GERAL_TITULO_PERIODO = "['<span style=\'white-space: nowrap; font-size:15px;\'>Balanço Completo <span style=\'font-weight:normal;\'>(todo o periodo)</span></span>', 'De {$Primeiro_mes}/{$Primeiro_ano} a {$Ultimo_mes}/{$Ultimo_ano}']";
$OPTION_MES = "'{$OPTION_MES}'";





//-- ----------------------------------------------------------------------------
// -- ---| E BARS DONUT_RECEBIMENTOS |-------------------------------------------
//-- ----------------------------------------------------------------------------
$DONUT_MAX = count($DONUT_RECEBIMENTOS)-1;
$i = ($DONUT_MAX-11); if($i<1){$i=0;}
$DONUT_MIN = ($DONUT_MAX-11); if($DONUT_MIN<1){$DONUT_MIN=0;}

$BUTTON_PREV = $MES[$MES_BUTTON-1];
$BUTTON_NOW  = $MES[$MES_BUTTON];
$BUTTON_NEXT = $MES[$MES_BUTTON+1];
$BUTTON_LAST = $MES[$DONUT_MAX-1];

$DONUT_RECEBIMENTOS_MES='';
$DONUT_RECEBIMENTOS_PERIODO='';
$DONUT_RECEBIMENTOS_VALORES='';
$DONUT_RECEBIMENTOS_PREVISTOS='';
//$CORES 		= array('#3f6791', '#FF00E4', '#F39C12', '#00CDFF', '#05DF52', '#600A66', '#D8FF00', '#FF0000', '#150496', '#F6F6F6', '#A49306', '#48FF00');
$CORES 			= array('#AAD9A3', '#00746B', '#007BFF', '#3c5391', '#6F80AB', '#E58AA3', '#AB0910', '#FB4917', '#CB6A00', '#FFD778', '#E6CB02', '#869C00', '#00A900');
$DONUT_RECEBIMENTOS_CORES='';

while($i <= $DONUT_MAX){
 if($i == $DONUT_MAX){
 	$DONUT_RECEBIMENTOS_MES .= "'{$DONUT_RECEBIMENTOS[$i]['MESES']}'";
    $DONUT_RECEBIMENTOS_PERIODO .= "'{$DONUT_RECEBIMENTOS[$i]['PERIODO']}'";
    $DONUT_RECEBIMENTOS_VALORES .= "{$DONUT_RECEBIMENTOS[$i]['VALORES']},      0";
    $DONUT_RECEBIMENTOS_PREVISTOS .= "{$DONUT_RECEBIMENTOS[$i]['PREVISTO']}";
	$DONUT_RECEBIMENTOS_CORES .= "'#44FF00'";//"'{$CORES[$i]}'"; // FIXA ULTIMA COR EM VERDE FLUORESCENTE

 }else{
   	$DONUT_RECEBIMENTOS_MES .= "'{$DONUT_RECEBIMENTOS[$i]['MESES']}',";
    $DONUT_RECEBIMENTOS_PERIODO .= "'{$DONUT_RECEBIMENTOS[$i]['PERIODO']}',";
    $DONUT_RECEBIMENTOS_VALORES .= "{$DONUT_RECEBIMENTOS[$i]['VALORES']},";
    $DONUT_RECEBIMENTOS_PREVISTOS .= "{$DONUT_RECEBIMENTOS[$i]['PREVISTO']},";
	$DONUT_RECEBIMENTOS_CORES .= "'{$CORES[$i]}',";
 }    
$i++;}

$DONUT_RECEBIMENTOS_MES = "[{$DONUT_RECEBIMENTOS_MES}]";
$DONUT_RECEBIMENTOS_PERIODO = "[{$DONUT_RECEBIMENTOS_PERIODO}]";
$DONUT_RECEBIMENTOS_VALORES = "[{$DONUT_RECEBIMENTOS_VALORES}]";
$DONUT_RECEBIMENTOS_PREVISTOS = "[{$DONUT_RECEBIMENTOS_PREVISTOS}]";
$DONUT_RECEBIMENTOS_TITULOS = "['Periodo de <span style=\'white-space: nowrap;\'>12 meses</span>', 'De {$DONUT_RECEBIMENTOS[$DONUT_MIN]['PERIODO']}, a {$DONUT_RECEBIMENTOS[$DONUT_MAX]['PERIODO']}']";
$DONUT_RECEBIMENTOS_CORES = "[{$DONUT_RECEBIMENTOS_CORES}]";
//-- ----------------------------------------------------------------------------
//-- ----------------------------------------------------------------------------

/*
echo "<!-- 
-- ----------------------------------------------------------------------------
LINHA HISTORICO COMPLETO: 
	MESES: 					$GERAL_MESES
	PREVISTOS: 				$GERAL_PREVISTOS
	RECEBIDOS: 				$GERAL_RECEBIDOS
	GERAL_TITULO_PERIODO: 	$GERAL_TITULO_PERIODO

	OPTION_MES: 			$OPTION_MES

	$PREV_MENSAL

	BUTTON_PREV:			$BUTTON_PREV
	BUTTON_NOW:				$BUTTON_NOW
	BUTTON_NEXT:			$BUTTON_NEXT

-- ----------------------------------------------------------------------------
DONUT RECEBIMENTOS:
	$DONUT_RECEBIMENTOS_MES
	$DONUT_RECEBIMENTOS_TITULOS
	$DONUT_RECEBIMENTOS_VALORES
	$DONUT_RECEBIMENTOS_PERIODO
	$DONUT_RECEBIMENTOS_CORES

-- >";/**/
if(empty(@$_GET['SelectRelatorioMes'])){
	echo "
	<SCRIPT>
	//window.open('?SelectRelatorioMes=$BUTTON_LAST','_self'); // Retorna penultimo mes registrado
	window.open('?SelectRelatorioMes=".strtotime(date("Y-m-01"))."&".time()."','_self'); //Retorna Mes Atual
	</SCRIPT>
	"; 
	exit();
}
?>