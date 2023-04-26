<? include_once('../../_config.php');




//-- --------------------------------------
//-- Verifica se possui historico
//-- --------------------------------------
$sql = "SELECT count(*) AS `N_HISTORICO` FROM `_view_bases`;";
$statment = $conn->prepare($sql); $statment->execute(); 
$HISTORICO_DB = $statment->fetch(PDO::FETCH_ASSOC);
// echo "HISTORICO_DB: {$HISTORICO_DB['N_HISTORICO']} - ";print_r($HISTORICO_DB); echo "\r\n-------------------------------------\r\n"; exit();
//-- --------------------------------------
if($HISTORICO_DB['N_HISTORICO'] > 0){



        //-- -----------------------------------
        //-- --- BALANCO MENSAL ----------------
        //-- -----------------------------------
        $REFERENCIA_MES_ANO =  "//-- ---| @MES=".date("m")."; @ANO=".date("Y")."; |--------";
        $conn->prepare("SET @i=0; SET @MES = ".date("m")."; SET @ANO = ".date("Y").";")->execute();
          $sqlResumoMensal = "
        SELECT 
        COUNT(*) + (
          SELECT COUNT(*) FROM `_contratos_quitados`
          WHERE MONTH(`vencimento`) = @MES
              AND YEAR(`vencimento`) = @ANO
        ) AS `previsto`, 
        IFNULL(SUM(`contrato_valor_base`),0)+IFNULL((
                SELECT SUM(`valor_pago`) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ),0) AS `previsto_valores`,
        CONCAT('R$ ', FORMAT(
            IFNULL(IFNULL(SUM(`contrato_valor_base`),0)+IFNULL((
                SELECT SUM(`valor_pago`) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ),0),0)
          , 2, 'de_DE')
        ) AS `previsto_valores_formatado`,
        (
            SELECT IFNULL(COUNT(*),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
        ) AS `recebidos`,
        CONCAT(FORMAT(
                IFNULL(
                    (SELECT COUNT(*) *100 FROM `_contratos_quitados`
                    WHERE MONTH(`quitado`) = @MES
                          AND YEAR(`quitado`) = @ANO
                    ) / (COUNT(*) + (
                        SELECT COUNT(*) FROM `_contratos_quitados`
                        WHERE MONTH(`vencimento`) = @MES
                          AND YEAR(`vencimento`) = @ANO
                    ))
                ,0)
        , 1, 'de_DE'),'%') AS `recebidos_percent`,
        (
            SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
        ) AS `recebidos_valores`,
        CONCAT('R$ ', FORMAT(
            (
            SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
          ), 2, 'de_DE')
        ) AS `recebidos_valores_formatado`,
        IFNULL(COUNT(*),0)+IFNULL((
                SELECT COUNT(*) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ),0) - (
            SELECT IFNULL(COUNT(*),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
        ) AS `falta`,
        CONCAT(FORMAT(
            (IFNULL(COUNT(*),0)+(
                SELECT IFNULL(COUNT(*),0) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ) - (
            SELECT IFNULL(COUNT(*),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
          ))*100/(
            IFNULL(COUNT(*),0) + (
          SELECT IFNULL(COUNT(*),0) FROM `_contratos_quitados`
          WHERE MONTH(`vencimento`) = @MES
              AND YEAR(`vencimento`) = @ANO
          )), 1, 'de_DE'),'%') AS `falta_percent`,
        IFNULL(SUM(`contrato_valor_base`),0)+(
                SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ) - (
            SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
        ) AS `falta_valores`,

        CONCAT('R$ ', FORMAT(
            IFNULL(SUM(`contrato_valor_base`),0)+(
                SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
                WHERE MONTH(`vencimento`) = @MES
                  AND YEAR(`vencimento`) = @ANO   
            ) - (
            SELECT IFNULL(SUM(`valor_pago`),0) FROM `_contratos_quitados`
            WHERE MONTH(`quitado`) = @MES
                  AND YEAR(`quitado`) = @ANO
          ), 2, 'de_DE') 
        ) AS `falta_valores_formatado`,
        DATE_FORMAT(CONCAT(@ANO,'-',@MES,'-00'), '%M') AS `mes`,
        DATE_FORMAT(CONCAT(@ANO,'-',@MES,'-00'), '%Y') AS `ano`
        FROM `_view_bases`
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
          $RESUMO_MES_NOME = "Mês de ".TrataNome($RESUMO_MES['mes']);

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




        if(!empty($_SESSION["USER_ID"])){
          //-- --------------------------------------
          // -- Verifica hosts e permissoes
          //-- --------------------------------------
          $sql = "SELECT *, count(*) AS `count` FROM `_view_profiles_permiss` WHERE user_id='{$_SESSION["USER_ID"]}' AND `host` = '{$system_host}' AND `autorization` LIKE '%GRAP_MENSAL_MENU%';";
          $statment = $conn->prepare($sql); $statment->execute(); 
          $USER_ROLES_DB = $statment->fetch(PDO::FETCH_ASSOC);
          // echo "USER_ROLES_DB: ";print_r($USER_ROLES_DB); echo "\r\n-------------------------------------\r\n";
          //-- --------------------------------------
          if($USER_ROLES_DB['count'] < 1){
           echo "if((typeof GRAP_MENSAL_MENU === \"undefined\")){  console.warn('SYSTEM AUTORIZATION: [GRAP_MENSAL_MENU]'); GRAP_MENSAL_MENU='none'; $('#resumomensal').css('display','none');  }
                //-- ----------------------------------
                ";

          }else{
           echo "{$REFERENCIA_MES_ANO}
                  setTimeout(function(){
                    GoPrevMensal('{$RESUMO_MES_NOME}', '{$RESUMO_REALIZADO}', '{$RESUMO_REALIZADO_VALOR}', '{$RESUMO_FALTA}', '{$RESUMO_FALTA_VALOR}', '{$RESUMO_PREVISTO}', '{$RESUMO_PREVISTO_VALOR}', 'Progresso: ', '{$QTD_REALIZADO}', '{$QTD_TOTAL}', {$PERCENT1}, {$PERCENT2});                
                  }, 8500); 
                //-- ----------------------------------";
          }
        }else{


         echo "if((typeof GRAP_MENSAL_MENU === \"undefined\")){  console.log('SESSAO USER_ID: [esta vazio]'); GRAP_MENSAL_MENU='none'; $('#resumomensal').css('display','none');  }
                  //-- ----------------------------------
                  ";

        }

}else{ //-- [ELSE] Verifica se possui historico


         echo "if((typeof GRAP_MENSAL_MENU === \"undefined\")){  console.log('SYSTEM INFORMATION - GRAP_MENSAL_MENU: \\n[SEM DADOS HISTORICOS]'); GRAP_MENSAL_MENU='none'; $('#resumomensal').css('display','none');  }
                  //-- ----------------------------------
                  ";

}; //-- [END] Verifica se possui historico
?>



