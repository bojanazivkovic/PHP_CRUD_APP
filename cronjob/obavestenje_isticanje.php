<?php
//za test - localhost
//require '../includes/PHPMailer.php';
//require '../includes/SMTP.php';

//za produkciju
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
require '/usr/share/php/libphp-phpmailer/class.smtp.php';

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Clanarina.php';


$redni_broj = 1;
$nizMesec = array();

$danas = date("Y-m-d");

$id_suosnivac = Suosnivac::getAll();
foreach ($id_suosnivac as $idsuos) {
	$id = $idsuos->id; 
	$naziv = $idsuos->naziv;
	
	
//izvlacim isticanje za poslednju uplatu - isto koristim za cron za neaktivne
	$istice = Istice::getIsticeNajveciZaNeaktivne($id);
	
	foreach ($istice as $ist) {
		$datum_ist = $ist->datum;

	$datum_istMinusMesec = strtotime(date($datum_ist, strtotime($datum_ist)). '-1 month');
	$datum_istMinusMesec = date('Y-m-d', $datum_istMinusMesec);

		
		if($datum_istMinusMesec === $danas){
			//Suosnivac::updateStanje($id);			
			
			$x =  $redni_broj.'. <b>'.$naziv.'</b> - истиче: <b>'.date('d.m.Y',strtotime($datum_ist)).'</b>';
			array_push($nizMesec, $x);
			//echo $x;
			$redni_broj++;
		}	

	}

}


if(!empty($nizMesec)){

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
$mail->Subject = 'Обавештење о истицању годишње накнаде';
$mail->Body = '<h2 style="color:red;">Годишња накнада истиче за месец дана:</h2><p>'.implode('<br>', $nizMesec).'</p>';

$mail->isHTML(true);
$mail->IsSMTP();
require_once __DIR__.'/../inc/mail_config.php';
if(!$mail->send()) {
  echo 'Email is not sent.';
  echo 'Email error:<pre> ' . $mail->ErrorInfo.'</pre>';
} else {
  echo 'Email has been sent.<br>';
  echo implode('<br>', $nizMesec);
}


}else{
	echo 'nema isticanja';
}



?>
