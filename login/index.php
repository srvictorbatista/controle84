<? include_once('../_config.php');
//-- Se ja estiver logado
if(!empty($_SESSION['USER_ID'])){header('Location: ../');exit();}
?><!DOCTYPE HTML>
<html lang="pt-br">
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TV Livre 84 - Controle84.com</title>
	<meta name="robots" content="noindex">
	<meta name="google" content="notranslate">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../lib/imgs/favicon.png">
	<link rel="icon" type="image/x-icon" href="../lib/imgs/favicon.png">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

  	<!-- Facebook and Twitter integration -->
	<!-- meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" / -->

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
	
	<!-- Font Awesome -->
  	<link rel="stylesheet" href="./lib/plugins/fontawesome-free/css/all.min.css">
	<!-- Animate.css -->
	<link rel="stylesheet" href="launcher/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="launcher/css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="launcher/css/bootstrap.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="launcher/css/style.css">

	<!-- Modernizr JS -->
	<script src="launcher/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="launcher/jsrespond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	<div class="fh5co-loader"></div>

	<aside id="fh5co-aside" role="sidebar" class="text-center" style="background-image: url(launcher/images/img_bg_1_gradient.png);">
		<h1 id="fh5co-logo"><a>TV Livre 84</a></h1>
	</aside>

	<div id="fh5co-main-content" style="overflow: hidden;">
		<div class="dt js-dt" style="padding-bottom: 60px;">
			<div class="dtc js-dtc">
				<!-- div class="simply-countdown-one animate-box" data-animate-effect="fadeInUp" style="padding-top: 60px;"></div -->
				<div style="padding-bottom: 50px;">
					<h1 id="fh5co-logo" style="font-weight: 800; letter-spacing: -2px; color: #fff;font-size:25px; margin-top: 20px; float: left;  position:absolute;top:0;">
						<img src="../lib/imgs/logo.png" alt="Sistema84 Logo" style="opacity:0.8;height: 30px;margin-top:-5px;padding-right:5px;">Controle 84
					</h1>
				</div>
				<div></div>

				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-lg-7" id="content_princ">
								<div class="fh5co-intro animate-box" style="">
									<h2>Controle Financeiro</h2>
									<p>Com recursos aprimorados, estamos orgulhosos em lhe oferecer a melhor tecnologia disponível atualmente. Então, muito sucesso e bons negócios!</p>
								</div>
							</div>
							<div class="forms" style="">
							
								<div id="login" class="col-lg-7 animate-box" style="display: block;">
									<form id="fh5co-form" method="POST" action="lib/php/session.php">
										<div class="form-group">
											<p class="" style="color:#bdbdbd;">Digite suas credenciais para ter acesso:</p>
											<input type="text" class="form-control" name="login" placeholder="Login">
											<input type="hidden" name="host" value="<?=str_replace("login/","",$url);?>">
										</div>
										<div class="form-group">
											<input type="pwd" class="form-control" name="pwd" placeholder="senha">
											<input type="submit" value="Entrar" class="btn btn-primary">
											<p class="tip">Digite seu login, senha e clique em entrar.</p>
											<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
										</div>
									</form>
								</div>	

								<div id="subsc" class="col-lg-7 animate-box">
<? if(empty($_GET['token'])):?>
									<form id="fh5co-form" method="POST" action="lib/php/newuser.php" style="z-index:10;">
										<div class="form-group">
											<p class="" style="color:#bdbdbd;">Cadastre-se informando seus dados:</p>
											<input type="text" class="form-control" name="nome" placeholder="Nome">											
											<input type="hidden" name="host" value="<?=str_replace("login/","",$url);?>">			
										</div>
										<div class="form-group">
											<!-- input type="text" class="form-control" name="telefone" placeholder="Telefone (whatsapp)" -->
											<input type="text" class="form-control" name="email" placeholder="E-mail">
											<input type="submit" value="Enviar" class="btn btn-primary" style="background-color:#02C906;">
											<p class="tip">Digite seus dados para se cadastrar.</p>
											<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
										</div>
									</form>
										<form id="2fawaget" method="POST" action="lib/php/newuser.php">
											<div class="form-group">
												<p class="" style="color:#bdbdbd;"></p>
												<input type="hidden" name="validation" value="">											
												<input type="hidden">			
											</div>
											<div class="form-group">											
												<input type="hidden">											
												<input type="hidden">
												<p class="tip"></p>
												<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
											</div>
										</form>
<? endif;?>

<? if(!empty($_GET['token'])):

	$mail_trustkey = filter_input(INPUT_GET, 'mail_trustkey', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 'mail_trustkey', FILTER_SANITIZE_STRING) : false;
	$wa_token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING) : false;
        //-- --------------------------------------
        $sql = "SELECT * FROM `user_profiles` WHERE `pwd` = '{$wa_token}' LIMIT 1";
        $statment = $conn->prepare($sql); $statment->execute(); 
        $USER_DB = $statment->fetch(PDO::FETCH_ASSOC);
        $USER_DB['telefone'] = '0'.explode('55',$USER_DB['telefone'])[1];
        //echo "USER_DB: ";print_r($USER_DB); echo "\r\n-------------------------------------\r\n";
        //-- --------------------------------------


        //-- Pedido de confirmação vindo por e-mail (expira esta pagina)
		if($mail_trustkey == "{$wa_trustkey}"){
			        $sql = "
	                    UPDATE `user_profiles` SET 
	                        `wa_trustkey`   = :wa_trustkey
	                    WHERE `user_profiles`.`id` = :id 
	                ";
	                $statment = $conn->prepare($sql);
	                    $statment->bindValue(':wa_trustkey', "{$wa_trustkey}");
	                    $statment->bindValue(':id', "{$USER_DB['id']}");
	                $statment->execute();
        //-- --------------------------------------
		}


        //-- cadastro ainda não validado
        if(!empty($USER_DB['wa_trustkey'])){
        	echo "
        	<SCRIPT>
        	setTimeout(function(){

	        	\$('#content_princ').html('\
	        						<div class=\"fh5co-intro animate-box\">\\
										<h2 style=\"color:#FBFF00;\">Desculpe: Este link, não é mais válido.</h2>\\
										<p style=\"color:#D98F20;\">Estamos lhe redirecionando. Por favor, aguarde...</p>\\
									</div>\\
	        	');
	        	

        	}, 1000);

        	setTimeout(function(){
        		window.open('{$url}','_self');
        	}, 5000);
        	</SCRIPT>";
        }else{

        	if( substr($USER_DB['pwd'], 0, 4) == 'TEMP'){
        		$formlink = "$('#cad').html('Completar Cadastro'); //$('#tolls a').eq('1').html('Completar Cadastro');\r\n";
        		$formlabel = 'Complete seus dados de acesso:';
        		$formafoot = 'Após finalizar seu cadastro, um administrador deverá <span style="white-space:nowrap;">aprovar seu nível de acesso.</span>';
        	}else{
        		$formlink = "$('#cad').html('Redefinir Credenciais'); //$('#tolls a').eq('1').html('Redefinir Credenciais');\r\n";
        		$formlabel = 'Redefina seus dados de acesso:';
        		$formafoot = 'Não compartilhe estas informações com ninguém.';

        	}
?>
									<form id="fh5co-form">
										<div class="form-group">
											<p class="" style="color:#bdbdbd;"><?="{$formlabel}";?></p>
											<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?="{$USER_DB['nome']}";?>" disabled="true" style="background-color:#CCC;font-weight:bold;color:#888;">			
										</div>
									<? if(!empty($USER_DB['telefone'])){ ?>
										<div class="form-group">
											<input type="text" class="form-control" name="telefone" placeholder="Telefone (whatsapp)" value="<?="{$USER_DB['telefone']}";?>" disabled="true" style="background-color:#CCC;font-weight:bold;color:#888;">
										</div>
									<? } ?>
									<? if(!empty($mail_trustkey)){ ?>
										<div class="form-group">
											<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?="{$USER_DB['email']}";?>" disabled="true" style="background-color:#CCC;font-weight:bold;color:#888;">			
										</div>
									<? } ?>
									</form>
									<form id="fh5co-form" method="POST" action="lib/php/hLu7tBwF4aPd.php">
										<div class="form-group">			
											<input type="text" class="form-control" name="login" placeholder="Login" value="<?="{$USER_DB['login']}";?>" style="margin-bottom:15px;">
											<input type="pwd" class="form-control" name="senha1" placeholder="Senha">
											<button type="button" class="btn btn-primary" style="background-color:#DDD;color:#157C17 /*#02C906*/;margin-top:87px;" onclick="rand_pwd();">
												<i class="fa-solid fa-rotate-right" style="margin-left:-10px;"></i> Sugerir
											</button>
											<input type="hidden" name="host" value="<?=str_replace("login/","",$url);?>">
											<input type="hidden" name="id" value="<?="{$USER_DB['id']}";?>">
											<input type="hidden" name="token" value="<?="{$wa_token}";?>">
										</div>
										<div class="form-group">
											<input type="pwd" class="form-control" name="senha2" placeholder="Senha (repita)">
											<input type="submit" value="Enviar" class="btn btn-primary" style="background-color:#02C906;">
											<p class="tip"><?="{$formafoot}";?></p>
											<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
										</div>
									</form>
		<SCRIPT>
			window.onload = function(){
			  setTimeout(function(){
				$('#cad').click();
				<?="{$formlink}";?>
			  }, 800);
			}
		</SCRIPT>
<? } endif;?>



								</div>		

								<div id="rescue" class="col-lg-7 animate-box">
									<form id="fh5co-form" method="POST" action="lib/php/rescue.php">
										<p class="" style="margin-bottom:20px;color:#bdbdbd;">Recuperação de senha:</p>
										<!-- div class="form-group">
											<input type="text" class="form-control" name="wpp" placeholder="Telefone (whatsapp)">
											<input type="submit" value="Enviar" class="btn btn-primary" style="background-color:#FF7c00;">
											<p class="tip">Para recuperar sua senha, digite seu telefone (whatsapp) cadastrado.</p>
											<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
										</div -->
										<div class="form-group">
											<input type="text" class="form-control" name="email" placeholder="E-mail">
											<input type="submit" value="Enviar" class="btn btn-primary" style="background-color:#FF7c00;">
											<p class="tip">Para recuperar sua senha, digite seu email cadastrado.</p>
											<center style="margin-top:-20px;font-weight:bold;"><div id="form_retunr"></div></center>
										</div>
									</form>
								</div>	

								<div id="tolls" class="col-lg-7">
									<p class="tip">
										O que você esta procurando? <br>
										<a href="JavaScript:void(0);" id="login" onclick="
											$('#login').css('top','-0px').css('display','block');
											$('#subsc').css('top','-0px').css('display','none');											
											$('#rescue').css('top','-0px').css('display','none');
											$('#tolls .tip a').css('font-weight','normal').css('color','#0bbbE6');
											$(this).css('font-weight','bold').css('color','#FFF');
										 " style="font-weight:bold;color:#FFF;">Fazer login</a>, 
										<a href="JavaScript:void(0);" id="cad" onclick="
											$('#login').css('top','-0px').css('display','none');
											$('#subsc').css('top','-0px').css('display','block');											
											$('#rescue').css('top','-0px').css('display','none');
											$('#tolls .tip a').css('font-weight','normal').css('color','#0bbbE6');
											$(this).css('font-weight','bold').css('color','#FFF');
										 ">Cadastrar-se</a>,
										<a href="JavaScript:void(0);" onclick="
											$('#login').css('top','-0px').css('display','none');
											$('#subsc').css('top','-0px').css('display','none');											
											$('#rescue').css('top','-0px').css('display','block');
											$('#tolls .tip a').css('font-weight','normal').css('color','#0bbbE6');
											$(this).css('font-weight','bold').css('color','#FFF');
										 ">Recuperar Senha</a>.
									</p>
								</div>
								
							</div>
						</div>
					</div>
				</div>
					
			</div>
		</div>

		<div id="fh5co-footer">
		<div class="col-lg-7" style="margin:0px;position:fixed;bottom:0;">
			<div class="row">
				<div class="col-md-3">
					<!-- ul id="fh5co-social" style="">
						<li><a href="#"><i class="icon-facebook"></i></a></li>
						<li><a href="#"><i class="icon-twitter"></i></a></li>
						<li><a href="#"><i class="icon-instagram"></i></a></li>
						<li><a href="#"><i class="icon-pinterest-square"></i></a></li>
					</ul -->
				</div>
				<div class="col-md-7 fh5co-copyright" style="float:right; padding:0px 20px 0px 0px;">
					<p style="float:right; position:relative; white-space:nowrap;">Desenvolvedor: Victor Batista - <strong><a target="_blamk" href="https://t.me/levymac">t.me/levymac</a></strong></p>
				</div>
			</div>
		</div>
		</div>
		
	</div>
	
	<!-- jQuery -->
	<script src="launcher/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="launcher/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="launcher/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="launcher/js/jquery.waypoints.min.js"></script>
	<!-- Count Down -->
	<script src="launcher/js/simplyCountdown.js"></script>
	<!-- Main -->
	<script src="launcher/js/main.js"></script>
	<script src="functions.js"></script>

	</body>
</html>

