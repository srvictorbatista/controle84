<?

#################################################################################################
#######################################| conn drive PDO |########################################
#################################################################################################
    $dbHost = "seu_dominio.com";
    $dbUser = "seu_usuario";
    $dbPass = "seua_senha";
    $dbName = "nome_do_db";
    #-- -----------------------------------------
    #-- CONN GLOBAL
    #-- -----------------------------------------
    $driverMySQL = "mysql:host={$dbHost};dbname={$dbName}";
    try {
      $conn = new PDO($driverMySQL, $dbUser, $dbPass);
        $conn->exec("SET CHARACTER SET utf8");
        $conn->prepare("SET @@lc_time_names='pt_BR'; SET lc_time_names='pt_BR';")->execute();
    }catch(PDOException $e){
        $alert =  "ERROR \\nNA CONEXÃO COM O BANCO...\\n";
        $erro = utf8_encode($e->getMessage());
        echo "ERROR: {$erro}";
        echo "<SCRIPT>alert(\"{$alert} {$erro}\");window.open(\"#install\",\"_self\");</SCRIPT>";
    }
#-- -----------------------------------------
#################################################################################################






//$PREFIXO_PATH = preg_replace("/[^0-9a-zA-Z]/","", explode("/",$_SERVER['SCRIPT_NAME'])[1]);
$PREFIXO_PATH   = preg_replace("/[^0-9a-zA-Z]/","", explode("/",$_SERVER['SCRIPT_NAME'])[1]) ."_". substr(hash("sha256", explode("/",$_SERVER['SCRIPT_NAME'])[1]) ,5,3).hexdec(substr(hash("sha256", explode("/",$_SERVER['SCRIPT_NAME'])[1]) ,0,8)) % 10;


$SQL = "
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_clientes`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text COLLATE utf8_unicode_ci NOT NULL,
  `telefone` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_clientes_bkp`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_clientes_bkp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(25) NOT NULL,
  `nome` text COLLATE utf8_unicode_ci NOT NULL,
  `telefone` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `cadastro` datetime NOT NULL,
  `exclusao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_contratos`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_contratos` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(25) NOT NULL,
  `pacote_id` int(25) NOT NULL,
  `pacote_titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `pacote_descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `notas` text COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(25,4) NOT NULL,
  `vencimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_contratos_quitados`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_contratos_quitados` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(25) NOT NULL,
  `pacote_id` int(25) NOT NULL,
  `pacote_titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `pacote_descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `notas` text COLLATE utf8_unicode_ci NOT NULL,
  `valor_pago` decimal(25,4) NOT NULL,
  `vencimento` date NOT NULL,
  `quitado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_contratos_quitados_bkp`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_contratos_quitados_bkp` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `quitado_id` int(25) NOT NULL,
  `cliente_id` int(25) NOT NULL,
  `pacote_id` int(25) NOT NULL,
  `pacote_titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `pacote_descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `notas` text COLLATE utf8_unicode_ci NOT NULL,
  `valor_pago` decimal(25,4) NOT NULL,
  `vencimento` date NOT NULL,
  `quitado` datetime NOT NULL,
  `exclusao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `{$PREFIXO_PATH}_pacotes`
--

CREATE TABLE IF NOT EXISTS `{$PREFIXO_PATH}_pacotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `valor_base` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `{$PREFIXO_PATH}_pacotes`
--

INSERT INTO `{$PREFIXO_PATH}_pacotes` (`id`, `nome`, `descricao`, `valor_base`) VALUES
(1, 'PACOTE PADRAO 01', '', '9.9000'),
(2, 'PACOTE PADRAO 02', '', '29.9900'),
(3, 'PACOTE PADRAO 03', '', '49.9900'),
(4, 'PACOTE BASICO', '', '75.0000');

-- --------------------------------------------------------








-- --------------------------------------------------------
-- CADEIA DE VIEWs ----------------------------------------
-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `_view_{$PREFIXO_PATH}_bases`
-- (Veja abaixo para a view atual)
--
CREATE TABLE IF NOT EXISTS `_view_{$PREFIXO_PATH}_bases` (
`cliente_id` int(11)
,`cliente_nome` text
,`cliente_telefone` text
,`cliente_email` text
,`cliente_cadastro` datetime
,`contrato_id` int(25)
,`contrato_pacote_id` int(25)
,`contrato_titulo` text
,`contrato_descricao` text
,`contrato_notas` text
,`contrato_valor_base` decimal(25,4)
,`contrato_preco` varchar(72)
,`contrato_dias_atraso` int(7)
,`contrato_status` varchar(9)
,`contrato_vencimento` date
,`contrato_vencimento_formatado` varchar(10)
,`pacote_id` int(11)
,`pacote_nome` text
,`pacote_descricao` text
,`pacote_valor_base` decimal(25,4)
,`pacote_preco` varchar(72)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `_view_{$PREFIXO_PATH}_contratos_recebidos`
-- (Veja abaixo para a view atual)
--
CREATE TABLE IF NOT EXISTS `_view_{$PREFIXO_PATH}_contratos_recebidos` (
`id` int(25)
,`cliente_id` int(25)
,`nome` mediumtext
,`pacote_id` int(25)
,`pacote_titulo` text
,`contrato_pacote_titulo` text
,`contrato_pacote_descricao` text
,`contrato_notas` text
,`contrato_valor_pago` decimal(25,4)
,`contrato_vencimento` date
,`contrato_quitado` datetime
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `_view_{$PREFIXO_PATH}_contratos_relatorios`
-- (Veja abaixo para a view atual)
--
CREATE TABLE IF NOT EXISTS `_view_{$PREFIXO_PATH}_contratos_relatorios` (
`id` int(25)
,`cliente_id` int(11)
,`cliente_nome` longtext
,`cliente_telefone` mediumtext
,`cliente_email` mediumtext
,`cliente_cadastro` datetime
,`pacote_id` int(25)
,`contrato_titulo` mediumtext
,`contrato_descricao` mediumtext
,`contrato_notas` mediumtext
,`contrato_valor_base` decimal(25,4)
,`contrato_valor_preco` varchar(72)
,`contrato_vencimento` date
,`contrato_vencimento_formatado` varchar(10)
,`contrato_status` varchar(9)
,`contrato_quitado` datetime
,`contrato_quitado_formatado` varchar(19)
,`contrato_dias_atraso` int(11)
,`referencia_mes` varchar(64)
,`referencia_ano` varchar(4)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `_view_{$PREFIXO_PATH}_bases`
--
DROP TABLE IF EXISTS `_view_{$PREFIXO_PATH}_bases`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `_view_{$PREFIXO_PATH}_bases`  
		AS SELECT `{$PREFIXO_PATH}_clientes`.`id` AS `cliente_id`, 
			`{$PREFIXO_PATH}_clientes`.`nome` AS `cliente_nome`, 
			`{$PREFIXO_PATH}_clientes`.`telefone` AS `cliente_telefone`, 
			`{$PREFIXO_PATH}_clientes`.`email` AS `cliente_email`, 
			`{$PREFIXO_PATH}_clientes`.`cadastro` AS `cliente_cadastro`, 
			`{$PREFIXO_PATH}_contratos`.`id` AS `contrato_id`, 
			`{$PREFIXO_PATH}_contratos`.`pacote_id` AS `contrato_pacote_id`, 
			`{$PREFIXO_PATH}_contratos`.`pacote_titulo` AS `contrato_titulo`, 
			`{$PREFIXO_PATH}_contratos`.`pacote_descricao` AS `contrato_descricao`, 
			`{$PREFIXO_PATH}_contratos`.`notas` AS `contrato_notas`, 
			`{$PREFIXO_PATH}_contratos`.`valor` AS `contrato_valor_base`, 
			concat('R$ ',format(`{$PREFIXO_PATH}_contratos`.`valor`,2,'de_DE')) AS `contrato_preco`, 
			(to_days(now()) - to_days(`{$PREFIXO_PATH}_contratos`.`vencimento`)) AS `contrato_dias_atraso`, 
			if((((to_days(now()) - to_days(`{$PREFIXO_PATH}_contratos`.`vencimento`)) >= -(5)) and ((to_days(now()) - to_days(`{$PREFIXO_PATH}_contratos`.`vencimento`)) <= 0)), 'A_VENCER',if(((to_days(now()) - to_days(`{$PREFIXO_PATH}_contratos`.`vencimento`)) > 0),'EM_ATRASO','REGULAR')) AS `contrato_status`, 
			`{$PREFIXO_PATH}_contratos`.`vencimento` AS `contrato_vencimento`, date_format(`{$PREFIXO_PATH}_contratos`.`vencimento`,'%d/%m/%Y') AS `contrato_vencimento_formatado`, 
			`{$PREFIXO_PATH}_pacotes`.`id` AS `pacote_id`, 
			`{$PREFIXO_PATH}_pacotes`.`nome` AS `pacote_nome`, 
			`{$PREFIXO_PATH}_pacotes`.`descricao` AS `pacote_descricao`, 
			`{$PREFIXO_PATH}_pacotes`.`valor_base` AS `pacote_valor_base`, 
			concat('R$ ',format(`{$PREFIXO_PATH}_pacotes`.`valor_base`,2,'de_DE')) AS `pacote_preco` FROM ((`{$PREFIXO_PATH}_clientes` left join `{$PREFIXO_PATH}_contratos` on((`{$PREFIXO_PATH}_contratos`.`cliente_id` = `{$PREFIXO_PATH}_clientes`.`id`))) left join `{$PREFIXO_PATH}_pacotes` on((`{$PREFIXO_PATH}_contratos`.`pacote_id` = `{$PREFIXO_PATH}_pacotes`.`id`)));

-- --------------------------------------------------------

--
-- Estrutura para vista `_view_{$PREFIXO_PATH}_contratos_recebidos`
--
DROP TABLE IF EXISTS `_view_{$PREFIXO_PATH}_contratos_recebidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `_view_{$PREFIXO_PATH}_contratos_recebidos`  AS SELECT `{$PREFIXO_PATH}_contratos_quitados`.`id` AS `id`, `{$PREFIXO_PATH}_contratos_quitados`.`cliente_id` AS `cliente_id`, coalesce(`{$PREFIXO_PATH}_clientes`.`nome`,(select concat(`{$PREFIXO_PATH}_clientes_bkp`.`nome`,' (EXCLUIDO)') from `{$PREFIXO_PATH}_clientes_bkp` where (`{$PREFIXO_PATH}_clientes_bkp`.`cliente_id` = `{$PREFIXO_PATH}_contratos_quitados`.`cliente_id`))) AS `nome`, `{$PREFIXO_PATH}_contratos_quitados`.`pacote_id` AS `pacote_id`, `{$PREFIXO_PATH}_pacotes`.`nome` AS `pacote_titulo`, `{$PREFIXO_PATH}_contratos_quitados`.`pacote_titulo` AS `contrato_pacote_titulo`, `{$PREFIXO_PATH}_contratos_quitados`.`pacote_descricao` AS `contrato_pacote_descricao`, `{$PREFIXO_PATH}_contratos_quitados`.`notas` AS `contrato_notas`, `{$PREFIXO_PATH}_contratos_quitados`.`valor_pago` AS `contrato_valor_pago`, `{$PREFIXO_PATH}_contratos_quitados`.`vencimento` AS `contrato_vencimento`, `{$PREFIXO_PATH}_contratos_quitados`.`quitado` AS `contrato_quitado` FROM ((`{$PREFIXO_PATH}_contratos_quitados` left join `{$PREFIXO_PATH}_clientes` on((`{$PREFIXO_PATH}_contratos_quitados`.`cliente_id` = `{$PREFIXO_PATH}_clientes`.`id`))) left join `{$PREFIXO_PATH}_pacotes` on((`{$PREFIXO_PATH}_contratos_quitados`.`pacote_id` = `{$PREFIXO_PATH}_pacotes`.`id`))) ORDER BY `{$PREFIXO_PATH}_contratos_quitados`.`quitado` DESC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `_view_{$PREFIXO_PATH}_contratos_relatorios`
--
DROP TABLE IF EXISTS `_view_{$PREFIXO_PATH}_contratos_relatorios`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `_view_{$PREFIXO_PATH}_contratos_relatorios`  AS SELECT `_view_{$PREFIXO_PATH}_bases`.`contrato_id` AS `id`, `_view_{$PREFIXO_PATH}_bases`.`cliente_id` AS `cliente_id`, `_view_{$PREFIXO_PATH}_bases`.`cliente_nome` AS `cliente_nome`, `_view_{$PREFIXO_PATH}_bases`.`cliente_telefone` AS `cliente_telefone`, `_view_{$PREFIXO_PATH}_bases`.`cliente_email` AS `cliente_email`, `_view_{$PREFIXO_PATH}_bases`.`cliente_cadastro` AS `cliente_cadastro`, `_view_{$PREFIXO_PATH}_bases`.`contrato_pacote_id` AS `pacote_id`, `_view_{$PREFIXO_PATH}_bases`.`contrato_titulo` AS `contrato_titulo`, `_view_{$PREFIXO_PATH}_bases`.`contrato_descricao` AS `contrato_descricao`, `_view_{$PREFIXO_PATH}_bases`.`contrato_notas` AS `contrato_notas`, `_view_{$PREFIXO_PATH}_bases`.`contrato_valor_base` AS `contrato_valor_base`, concat('R$ ',format(`_view_{$PREFIXO_PATH}_bases`.`contrato_valor_base`,2,'de_DE')) AS `contrato_valor_preco`, `_view_{$PREFIXO_PATH}_bases`.`contrato_vencimento` AS `contrato_vencimento`, date_format(`_view_{$PREFIXO_PATH}_bases`.`contrato_vencimento`,'%d/%m/%Y') AS `contrato_vencimento_formatado`, `_view_{$PREFIXO_PATH}_bases`.`contrato_status` AS `contrato_status`, NULL AS `contrato_quitado`, date_format(NULL,'%d/%m/%Y %T') AS `contrato_quitado_formatado`, `_view_{$PREFIXO_PATH}_bases`.`contrato_dias_atraso` AS `contrato_dias_atraso`, date_format(`_view_{$PREFIXO_PATH}_bases`.`contrato_vencimento`,'%M') AS `referencia_mes`, date_format(`_view_{$PREFIXO_PATH}_bases`.`contrato_vencimento`,'%Y') AS `referencia_ano` FROM `_view_{$PREFIXO_PATH}_bases` WHERE (`_view_{$PREFIXO_PATH}_bases`.`contrato_id` is not null) ;

-- --------------------------------------------------------

";


    //-- --------------------------------------
    //-- INSTALA NOVA COPIA NO BANCO
    //-- --------------------------------------
     $sttintall_indb = $conn->prepare($SQL); if(!$sttintall_indb->execute()){ die("<html style=\"background-color:#730000;\"><CENTER><H2 style=\"margin-top:40vh;font-family:Arial;color:#CDECF5;\">ALGO DEU ERRADO! <br>Contate o administrador do sistema.</H2></CENTER></html>"); }
    //-- -----------------------------
    //-- LIBERA PARA USO
    //-- -----------------------------
     @unlink("index.php");
     @rename("SAKFTHHMYUJ.php", "index.php");     
    die("<html style=\"background-color:#162135;\"><CENTER><H2 style=\"margin-top:40vh;font-family:Arial;color:#00FF00;\">POR FAVOR, AGUARDE... <br>Sua nova instância estará pronta em instantes.</H2></CENTER> <SCRIPT>  setTimeout(function(){   window.location='login';  }, 5000);</SCRIPT></html>");
    //-- --------------------------------------
?>