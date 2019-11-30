<?php
//za test - localhost
//require '../includes/PHPMailer.php';
//require '../includes/SMTP.php';

//za produkciju
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
require '/usr/share/php/libphp-phpmailer/class.smtp.php';

require_once __DIR__.'/../klase/Racuni.php';

$id_suosnivac = $_POST['id'];
$attach = $_POST['uri'];
$email_predstavnika = $_POST['mail'];
$br_racuna = $_POST['br_pr'];
$id_uplate = $_POST['iduplate'];
$dat_ist = $_POST['di'];

//za produkciju
$mail = new PHPMailer();

//za test - localhost
//$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->setFrom('godisnja.naknada@rnids.rs', 'Годишња накнада');
$mail->addReplyTo('opsti.poslovi@rnids.rs', 'Општи послови');
$mail->addAddress($email_predstavnika);
//$mail->addAddress('bojana.zivkovic@rnids.rs');
$mail->addCC('opsti.poslovi@rnids.rs');
$mail->addBCC('bojana.zivkovic@rnids.rs');
$mail->CharSet = 'UTF-8';
$mail->Subject = 'РНИДС Годишња накнада';
		$mail->AddEmbeddedImage('/var/www/html/images/logo-cir.png', 'logoimg');
		$mail->Body = '<div style="font-family:Roboto Light">Поштовани/а, <br><br>Захваљујемо Вам се на уплати, успешно је евидентирана у нашем систему. <br>У прилогу вам достављамо фактуру за наведену уплату.<br><br>Ваша годишња накнада истиче '.date('d.m.Y', strtotime($dat_ist)).'. О обнови Ваше годишње накнаде бићете благовремено обавештени.<br><br><br>Поздрав,<br><br><b>Канцеларија РНИДС</b><br><br><table style="font-family:Roboto Light"><tr><td><img src="cid:logoimg"></td><td><span style="font-size:12px">Фондација "Регистар националног интернет домена Србије"</span><br><span style="font-size:10px">Жоржа Клемансоа 18а/I, 11108 Београд, ПАК 101147<br>Tel: 011.7281.281  |  rnids.rs   |  домен.срб<br>domen.rs   |   домен.срб   |   FB   |   TW   |   LN   |   YT</span></td></tr></table></div>';
$mail->addAttachment($attach);
$mail->isHTML(true);
$mail->IsSMTP();
require_once __DIR__.'/../inc/mail_config.php';
if(!$mail->send()) {
  echo 'Email is not sent.';
  echo 'Email error:<pre> ' . $mail->ErrorInfo.'</pre>';
} else {
	$poslat = Racuni::updatePoslat($id_uplate);
  echo 'Email has been sent.';
}
?>
