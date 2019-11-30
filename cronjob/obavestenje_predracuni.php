<?php
//za test - localhost
//require '../includes/PHPMailer.php';
//require '../includes/SMTP.php';

//za produkciju
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
require '/usr/share/php/libphp-phpmailer/class.smtp.php';

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predracuni.php';

$redni_broj = 1;
$x = '';

$x.= '<table style = "border-collapse: collapse;width: 100%;">';
$x.= '<tr><td style="border: 1px solid #ddd;padding: 8px;">РБ:</td><td style="border: 1px solid #ddd;padding: 8px;">Датум креирања предрачуна:</td><td style="border: 1px solid #ddd;padding: 8px;">Број предрачуна:</td><td style="border: 1px solid #ddd;padding: 8px;">Назив суоснивача:</td><td style="border: 1px solid #ddd;padding: 8px;">Линк ка предрачуну:</td></tr>';

$predracuni = Predracuni::getPredracunePoslednjihMesecDana();
foreach ($predracuni as $pred) {
	$urlpredrac = explode('/',trim($pred->generisan_url));
    $url = $urlpredrac[1];
    
	$naziv_suos = Suosnivac::getSuosnivac($pred->id_suosnivac)->naziv;

	$x.= '<tr><td style="border: 1px solid #ddd;padding: 8px;">'.$redni_broj.'. </td><td style="border: 1px solid #ddd;padding: 8px;">'.date('d.m.Y.',strtotime($pred->datum_predracuna)).'</td><td style="border: 1px solid #ddd;padding: 8px;">'.$pred->broj_predracuna.'</td><td style="border: 1px solid #ddd;padding: 8px;">'.$naziv_suos.'</td><td style="border: 1px solid #ddd;padding: 8px;"><a href="10.10.10.233/inc/pdfs/'.$url.'" target="_blank">'.$url.'</a></td></tr>';
	$redni_broj++;
}
$x.= '</table>';

//za produkciju
$mail = new PHPMailer();

//za test - localhost
//$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->setFrom('godisnja.naknada@rnids.rs','Годишња накнада');
$mail->addReplyTo('opsti.poslovi@rnids.rs', 'Општи послови');
//za test
//$mail->addAddress('bojana.zivkovic@rnids.rs');

//za produkciju
$mail->addAddress('opsti.poslovi@rnids.rs');
$mail->addBCC('bojana.zivkovic@rnids.rs');
$mail->CharSet = 'UTF-8';
$mail->Subject = 'Издати предрачуни';
$mail->Body = '<h2 style="color:red;">Издати предрачуни:</h2><p>'.$x.'</p>';

$mail->isHTML(true);
$mail->IsSMTP();
require_once __DIR__.'/../inc/mail_config.php';
if(!$mail->send()) {
  echo 'Email is not sent.';
  echo 'Email error:<pre> ' . $mail->ErrorInfo.'</pre>';
} else {
  echo 'Email has been sent.<br>';
}

?>
