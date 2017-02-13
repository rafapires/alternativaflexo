<?php
if (isset($_POST['Email'])){
	 
	$enviaFormularioParaNome = 'Alternativa Flexo';
	$enviaFormularioParaEmail = 'contato@alternativaflexo.com.br';
	 
	$caixaPostalServidorNome = 'Alternativa Flexo | Web site';
	$caixaPostalServidorEmail = 'noreply@alternativaflexo.com.br';
	$caixaPostalServidorSenha = 'Bkrx@8756';
	 
	$remetenteNome  = $_POST['Nome'];
	$remetenteEmail = $_POST['Email'];
	$assunto  = 'Solicitação de orçamento para: '.$_POST['Produto'];
	$mensagem = $_POST['Mensagem'];
	 
	$mensagemConcatenada = '<h3>Solicitação de orçamento</h3>'; 
	$mensagemConcatenada .= '-------------------------------<br/><br/>'; 
	$mensagemConcatenada .= 'Nome: '.$remetenteNome.'<br/>'; 
	$mensagemConcatenada .= 'E-mail: '.$remetenteEmail.'<br/>'; 
	$mensagemConcatenada .= 'Produto de interesse: '.$_POST['Produto'].'<br/>'; 
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
		$mensagemRetorno = 'Erro ao enviar formulário: '. print($mail->ErrorInfo);
	}else{
		$mensagemRetorno = 'Seu Formulário foi enviado com sucesso! Brevemente entraremos em contato. Obrigado!';
	} 
	echo '<script>alert("'.$mensagemRetorno.'")</script>';
} else {
		$mensagemRetorno = '';
}
?>