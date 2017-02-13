<?php
if (isset($_POST['Email'])){
	 
	$enviaFormularioParaNome = 'Alternativa Flexo';
	$enviaFormularioParaEmail = 'contato@alternativaflexo.com.br';
	 
	$caixaPostalServidorNome = 'Alternativa Flexo | Web site';
	$caixaPostalServidorEmail = 'noreply@alternativaflexo.com.br';
	$caixaPostalServidorSenha = 'Bkrx@8756';
	 
	$remetenteNome  = $_POST['Nome'];
	$remetenteEmail = $_POST['Email'];
	$remetenteEmpresa = $_POST['Empresa'];
	$assunto  = 'Contato via site Alternativa Flexo';
	$mensagem = $_POST['Comentarios'];
	 
	$mensagemConcatenada = '<h3>Formulário enviado via website</h3>'; 
	$mensagemConcatenada .= '-------------------------------<br/><br/>'; 
	$mensagemConcatenada .= 'Nome: '.$remetenteNome.'<br/>'; 
	$mensagemConcatenada .= 'E-mail: '.$remetenteEmail.'<br/>'; 
	$mensagemConcatenada .= 'Empresa: '.$remetenteEmpresa.'<br/>'; 
	$mensagemConcatenada .= '-------------------------------<br/><br/>'; 
	$mensagemConcatenada .= 'Mensagem: "'.$mensagem.'"<br/>';
	  
	require_once('js/PHPMailer-master/PHPMailerAutoload.php');
	 
	$mail = new PHPMailer();
	 
	$mail->IsSMTP();
	$mail->SMTPAuth  = true;
	$mail->Charset   = 'utf8_decode()';
	$mail->Host  = 'smtp.'.substr(strstr($caixaPostalServidorEmail, '@'), 1);
	$mail->Port  = '587';
	$mail->Username  = $caixaPostalServidorEmail;
	$mail->Password  = $caixaPostalServidorSenha;
	$mail->From  = $caixaPostalServidorEmail;
	$mail->FromName  = utf8_decode($caixaPostalServidorNome);
	$mail->IsHTML(true);
	$mail->Subject  = utf8_decode($assunto);
	$mail->Body  = utf8_decode($mensagemConcatenada);
	 
	 
	$mail->AddAddress($enviaFormularioParaEmail,utf8_decode($enviaFormularioParaNome));
	 
	if(!$mail->Send()){
		$mensagemRetorno = '<h3>Erro ao enviar formulário: '. print($mail->ErrorInfo).'</h3>';
	}else{
		$mensagemRetorno = '<h3 style="color:#106a16;">Formulário foi enviado com sucesso! Brevemente entraremos em contato. <br><br>Obrigado!</h3>';
	} 
} else {
		$mensagemRetorno = '';
}
##########################################
$title = 'Endereço e Contato | Alternativa Flexo - Soluções para sistemas Flexográficos';
include("_head.php"); ?>
<style>
.contato {
	text-decoration:underline;
	font-weight:bold!important;
}
</style>
<body>
<div id="wrapper">
  <?php include("_header.php"); ?>
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="index.php"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i></li>
					<li class="active">Contato</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
    <?php echo $mensagemRetorno; ?>
	<div class="map">
		<iframe src="https://maps.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1839.9262077218107!2d-47.605583356258684!3d-22.733726267559597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6da2c39399cbb947!2sAlternativa+Flexo!5e0!3m2!1spt-PT!2sbr!4v1469464566442">
		</iframe>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
	
		<form role="form" class="register-form" method="post" name="form-contato" action="contato.php">
			<h2>Entre em contato <small>Preencha o formulário abaixo</small></h2>        
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
                        <input type="text" name="Nome" id="first_name" class="form-control input-md" placeholder="Nome" tabindex="1" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="Empresa" id="company" class="form-control input-md" placeholder="Empresa" tabindex="2" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="Email" id="email" class="form-control input-md" placeholder="Email" tabindex="2" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<textarea class="form-control" rows="8" name="Comentarios" placeholder="Comentários" required></textarea>
			</div>

			
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-md-4"><input type="submit" value="Enviar mensagem" class="btn btn-theme btn-block btn-md" tabindex="7"></div>
				<div class="col-xs-12 col-md-8">Por favor, preencha todos os campos!</div>
			</div>
		</form>

			</div>
		</div>
	</div>
	</section>
<?php include("_footer.php"); ?>