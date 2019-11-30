<?php
require_once __DIR__.'/../inc/config.php';
require_once __DIR__.'/../includes/Database.php';
require_once __DIR__.'/../includes/Upload.php';


class Tabela{

	public static function getById($id, $tabela, $klasa){
		$db = Database::getInstance();

		$query = "SELECT * FROM $tabela WHERE id = :id";
		$params = [
			':id' => $id
		];
		$records = $db->select($klasa, $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}

	public static function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}

	public static function upload_pdf($data) {
			$upload = Upload::factory('/../dokumenta');
			$upload -> file($data);
			$upload -> set_allowed_mime_types(['jpg/jpeg', 'image/png', 'image/gif','application/pdf']);
			$upload -> set_max_file_size(2);
			$upload -> set_filename($data['name']);
			$data = strtolower($data['name']);
			$data = str_replace(' ', '-', $data);
			$upload -> set_filename($data);
			$upload -> save();
	}

	public static function ispravnoIme($data){
		$data = strtolower($data['name']);
		$data = str_replace(' ', '-', $data);
		$data = 'dokumenta/'.$data; 
		return $data;
	}

	public function formatirano_vreme($vreme){
		return date('d.m.Y', strtotime($vreme));
	}



	public function posalji_obavestenje($ids, $dat_ist){
		//za test - localhost
		//require '../includes/PHPMailer.php';
		//require '../includes/SMTP.php';

		//za produkciju
		require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
		require '/usr/share/php/libphp-phpmailer/class.smtp.php';

		$email_predstavnika = Predstavnik::getPredstavnik($ids)->email;
		//za produkciju
		$mail = new PHPMailer();
		//za test - localhost
		//$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->setFrom('godisnja.naknada@rnids.rs', 'Годишња накнада');		
		//za produkciju
		$mail->addAddress($email_predstavnika);
		$mail->addCC('opsti.poslovi@rnids.rs');
		$mail->addBCC('bojana.zivkovic@rnids.rs');

		//za test
		//$mail->addAddress('bojana.zivkovic@rnids.rs');

		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'РНИДС Годишња накнада';
		$mail->AddEmbeddedImage('/var/www/html/images/logo-cir.png', 'logoimg');
		$mail->Body = '<div style="font-family:Roboto Light">Поштовани/а, <br><br>Захваљујемо Вам се на уплати, успешно је евидентирана у нашем систему.<br><br>Ваша годишња накнада истиче '.date('d.m.Y', strtotime($dat_ist)).'. О обнови Ваше годишње накнаде бићете благовремено обавештени.<br><br><br>Поздрав,<br><br><b>Канцеларија РНИДС</b><br><br><table style="font-family:Roboto Light"><tr><td><img src="cid:logoimg"></td><td><span style="font-size:12px">Фондација "Регистар националног интернет домена Србије"</span><br><span style="font-size:10px">Жоржа Клемансоа 18а/I, 11108 Београд, ПАК 101147<br>Tel: 011.7281.281  |  rnids.rs   |  домен.срб<br>domen.rs   |   домен.срб   |   FB   |   TW   |   LN   |   YT</span></td></tr></table></div>';
		
		$mail->isHTML(true);
		$mail->IsSMTP();
		require_once __DIR__.'/../inc/mail_config.php';
			if(!$mail->send()) {
				echo 'Email is not sent.';
				echo 'Email error:<pre> ' . $mail->ErrorInfo.'</pre>';
			} else {
				echo 'Email has been sent.';
			}
	}

public function cirilLatin($tekst) { 
	
  $s = $tekst;
  $utf8   =array('ć', 'č', 'š', 'ž', 'đ', 'Ć', 'Č', 'Š', 'Ž', 'Đ' );
  $yuscii =array('}', '~', '{', '`', '|', ']', '^', '[', '@', '\\');
  $s = str_replace( $yuscii, $utf8, $s );
  $s = str_replace(array('Љ','Њ','Џ'), array('LJ','NJ','DŽ'), $s);
  $s = str_replace(array('љ','њ','џ'), array('lj','nj','dž') , $s);
  $s = str_replace(array('Љ','Њ','Џ'), array('Lj','Nj','Dž') , $s);
  $s = str_replace(array("'", "\"", "&quot;","„","“","”"), (''), $s);
  
  $latinica = array(
    'A','B','V','G','D','Đ','E','Ž','Z','I','J','K','L','M',
    'N','O','P','R','S','T','Ć','U','F','H','C','Č','Š',
    'a','b','v','g','d','đ','e','ž','z','i','j','k','l','m',
    'n','o','p','r','s','t','ć','u','f','h','c','č','š'    );
  $cirilica = array(
    'А','Б','В','Г','Д','Ђ','Е','Ж','З','И','Ј','К','Л','М',
    'Н','О','П','Р','С','Т','Ћ','У','Ф','Х','Ц','Ч','Ш',
    'а','б','в','г','д','ђ','е','ж','з','и','ј','к','л','м',
    'н','о','п','р','с','т','ћ','у','ф','х','ц','ч','ш'    );
  return str_replace( $cirilica, $latinica, $s );
}






}
