<?php
//za test - localhost
//require '../includes/PHPMailer.php';
//require '../includes/SMTP.php';

//za produkciju
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
require '/usr/share/php/libphp-phpmailer/class.smtp.php';

require_once __DIR__.'/../klase/Predracuni.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';

$niz = array();
$danas = date("Y-m-d");

$id_suos = Suosnivac::getAll();
foreach ($id_suos as $ids) {
	$id_suosnivac = $ids->id; 
	$id = $ids->id; 
	$naziv = $ids->naziv;
	

//izvlacim isticanje za poslednju uplatu - isto koristim za cron za neaktivne
	$istice = Istice::getIsticeNajveciZaNeaktivne($id_suosnivac);
	foreach ($istice as $ist) {
		$uplata = $ist->id_uplate;
		$datum_ist = $ist->datum;

	$datum_istPlusPetnaest = strtotime(date($datum_ist, strtotime($datum_ist)). '+15 days');
	$datum_istPlusPetnaest = date('Y-m-d', $datum_istPlusPetnaest);


		if($datum_istPlusPetnaest === $danas){
			

			//poslednji predracun, da uhvatim generisan_url, tj. PDF za slanje 
				$poslednji_predracun = Predracuni::getPoslednjiPredracunPoUplati($id_suosnivac);

				foreach ($poslednji_predracun as $poslednji_predrac) {
					$poslednji = $poslednji_predrac->id_uplate;
					$pdf_predracun = $poslednji_predrac->generisan_url;

					if($uplata === $poslednji && $pdf_predracun != null && $poslednji_predrac->poslat_petnaest_posle !=1){
						$x =  '<b>'.$naziv.'</b> - истиче: <b>'.date('d.m.Y',strtotime($datum_ist)).'</b> '.$pdf_predracun.'<br>';
						//array_push($niz, $x);

						$email_predstavnika = Predstavnik::getPredstavnik($id_suosnivac)->email;
						$datum_isticanja = date('d.m.Y',strtotime($datum_ist));
						//za produkciju mora apsolutna putanja
						$attach = '/var/www/html/inc/'.$pdf_predracun;

						//za test
						//$attach = '../inc/'.$pdf_predracun;

						//za produkciju
						$mail = new PHPMailer();

						//za test - localhost
						//$mail = new PHPMailer\PHPMailer\PHPMailer();

						$mail->setFrom('godisnja.naknada@rnids.rs', 'Годишња накнада');
						$mail->addReplyTo('opsti.poslovi@rnids.rs', 'Општи послови');
						//za produkciju
						$mail->addAddress($email_predstavnika);
						$mail->addCC('opsti.poslovi@rnids.rs');
						$mail->addBCC('bojana.zivkovic@rnids.rs');

						//za test
						//$mail->addAddress('bojana.zivkovic@rnids.rs');

						
						$mail->CharSet = 'UTF-8';
						$mail->Subject = 'РНИДС Годишња накнада истиче '.$datum_isticanja;
						$mail->AddEmbeddedImage('/var/www/html/images/logo-cir.png', 'logoimg');
						$mail->Body = '<div style="font-family:Roboto Light">Поштовани/а, <br><br>Подсећамо Вас да је Ваша Годишња накнада истекла '.$datum_isticanja.'. С обзиром на то да је до престанка статуса суоснивача остало још 15 дана, молимо Вас да нас обавестите уколико нисте заинтересовани за обнављање Годишње накнаде.<br><br>Уколико сте већ извршили уплату, молимо Вас да занемарите ову поруку. Систем је генерисао поруку јер уплата није евидентирана. Ваша уплата биће евидентирана чим буде прокњижена на наш рачун.<br><br><br>Поздрав,<br><br><b>Канцеларија РНИДС</b><br><br><table style="font-family:Roboto Light"><tr><td><img src="cid:logoimg" /></td><td><span style="font-size:12px">Фондација "Регистар националног интернет домена Србије"</span><br><span style="font-size:10px">Жоржа Клемансоа 18а/I, 11108 Београд, ПАК 101147<br>Tel: 011.7281.281  |  rnids.rs   |  домен.срб<br>domen.rs   |   домен.срб   |   FB   |   TW   |   LN   |   YT</span></td></tr></table></div>';
						$mail->addAttachment($attach);
						$mail->isHTML(true);
						

						$mail->IsSMTP();
						require_once __DIR__.'/../inc/mail_config.php';
						if(!$mail->send()) {
						  echo 'Email is not sent.';
						  echo 'Email error:<pre> ' . $mail->ErrorInfo.'</pre>';
						} else {
							$poslat = Predracuni::updatePoslatPetnaestDanaNakonIsteka($poslednji);
						  echo 'Email has been sent.';
						}

						echo $x.' ';
					}else{
						echo 'Nema suosnivaca kojima je istekla naknada!';
					}
					
				}		
			}	

		}

	}


?>
