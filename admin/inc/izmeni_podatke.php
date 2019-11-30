<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Suosnivac.php';
require_once __DIR__.'/../../klase/Predstavnik.php';
require_once __DIR__.'/../../includes/Upload.php';
require_once __DIR__.'/../../klase/Predracuni.php';
require_once __DIR__.'/../../klase/Direktor.php';
require_once __DIR__.'/../../klase/Clanarina.php';
require_once __DIR__.'/../../klase/Uplate.php';

use Dompdf\Dompdf;
use Dompdf\Options;

require_once ('../../dompdf/autoload.inc.php');	

$id = $_POST['ids'];
$iznos = Clanarina::getClanarinu()->iznos;
$ugovor = $_FILES['novi_ugovor'];
$pristupnica = $_FILES['nova_pristupnica'];
$ovlascenje = $_FILES['novo_ovlascenje'];
$stari_ugovor = $_POST['stari_ugovor'];
$stara_pristupnica = $_POST['stara_pristupnica'];
$staro_ovlascenje = $_POST['staro_ovlascenje'];

	$imeFajla = new Tabela;

	try{
		$imeFajla->upload_pdf($ugovor);
		$ugovor = $imeFajla->ispravnoIme($ugovor);
	}catch(Exception $e){
		$ugovor = $stari_ugovor;
	}

	
	try{
		$imeFajla->upload_pdf($pristupnica);
		$pristupnica = $imeFajla->ispravnoIme($pristupnica);
	}catch(Exception $e){
		$pristupnica = $stara_pristupnica;
	}
	try{
		$imeFajla->upload_pdf($ovlascenje);
		$ovlascenje = $imeFajla->ispravnoIme($ovlascenje);
	}catch(Exception $e){
		$ovlascenje = $staro_ovlascenje;
	}



	

$naziv = $imeFajla->test_input($_POST['naziv']);
$adresa = $imeFajla->test_input($_POST['adresa']);
$postanski_broj = $imeFajla->test_input($_POST['postanski_broj']);
$mesto = $imeFajla->test_input($_POST['mesto']);
$pak = $imeFajla->test_input($_POST['pak']);
$maticni_broj = $imeFajla->test_input($_POST['maticni_broj']);
$pib = $imeFajla->test_input($_POST['pib']);
$napomena = $imeFajla->test_input($_POST['napomena']);

$datum_potpisivanja = $imeFajla->test_input($_POST['datum_potpisivanja']);
$datum_apr = $imeFajla->test_input($_POST['datum_apr']);

//na ne bi pravilo problem kad kopiraju datum sa sajta, zbog razmaka izmedju brojeva
$datum_apr = str_replace(' ', '', $datum_apr);
$datum_apr = str_replace(',', '.', $datum_apr);
$datum_apr = str_replace('/', '.', $datum_apr);
$datum_potpisivanja = str_replace(' ', '', $datum_potpisivanja);
$datum_potpisivanja = str_replace(',', '.', $datum_potpisivanja);
$datum_potpisivanja = str_replace('/', '.', $datum_potpisivanja);


if($datum_potpisivanja == ''){
	$datum_potpisivanja = null;
}else {
	$datum_potpisivanja = date('Y-m-d H:i:s', strtotime($datum_potpisivanja));
}

if($datum_apr == ''){
	$datum_apr = null;
}else{
	$datum_apr = date('Y-m-d H:i:s', strtotime($datum_apr));
}



$id_glasanje = $_POST['pravo_glasa'];


//predstavnik
$ime_prezime = $imeFajla->test_input($_POST['ime_prezime']);
$mobilni = $imeFajla->test_input($_POST['mobilni']);
$email = $imeFajla->test_input($_POST['email']);


//$test = $naziv.', '.$adresa.', '.$mesto.', '.$pak.', '.$maticni_broj.', '.$pib.', '.$datum_potpisivanja.', '.$datum_apr.', '.$ugovor.', '.$pristupnica.', '.$ovlascenje.', '.$ime_prezime.', '.$mobilni.', '.$email;

//echo $test.'<br>';

$poslednji_predracun = Predracuni::getPoslednjiPredracunPoUplati($id);
foreach ($poslednji_predracun as $pos_pred) {
	$broj_pred = $pos_pred->broj_predracuna;
	$url_predracuna = $pos_pred->generisan_url;
	$datum_predrac =$pos_pred->datum_predracuna;
	$predracun_izdao=$pos_pred->uneo;
	$id_uplata = $pos_pred->id_uplate;
}
$direktor = Direktor::getAll();
foreach ($direktor as $dir) {
	$direktor_ime = $dir->ime_prezime;

}

$suos_naziv = $naziv;
$suos_adresa = $adresa;
$suos_postanski_broj = $postanski_broj;
$suos_mesto = $mesto;
$suos_maticni = $maticni_broj;
$suos_pib = $pib;
$br_predracuna = $broj_pred;
$datum = $datum_predrac;
$uneo = $predracun_izdao;


$kolikoIhIma = Predstavnik::countPredstavnika($ime_prezime);

if($broj_pred != '' || $broj_pred != null){

//ovde prvo izgenerise novi predracun

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);

//include template
ob_start();
require_once('../../dompdf/predracun.php');
$template = ob_get_clean();

//$dompdf = new Dompdf();
$dompdf->loadHtml($template);
//set paper size
$dompdf->setPaper('A4', 'portrait');

//render the html to pdf
$dompdf->render();

//skracujem naziv suosnivaca za link ka predracunu
$suos_odvoj = explode(' ',trim($suos_naziv));

if (strlen($suos_odvoj[0]) < 3){
	$suos = $suos_odvoj[0].'_'.$suos_odvoj[1];
}else {
	$suos = $suos_odvoj[0];
}

$suos = htmlspecialchars_decode($suos);

//write pdf to folder
$url = 'pdfs/RNIDS-predračun-'.$br_predracuna.'-'.$suos.'-cl.pdf';


file_put_contents($_SERVER['DOCUMENT_ROOT'].'/inc/'.$url, $dompdf->output());

//echo $suos_naziv.' '.$br_predracuna.'<br>';
$generisi = Predracuni::updateGenerisanPredracun($url, $id_uplata);
		
try{
					Suosnivac::updateSuosnivac($naziv, $adresa, $postanski_broj, $mesto, $pak, $maticni_broj, $pib, $datum_potpisivanja, $datum_apr, $napomena, $ugovor, $pristupnica, $ovlascenje, $id_glasanje, $id);
			}catch(Exception $e){
					echo $e->getMessage();
					}

		try{
					Predstavnik::updatePredstavnik($ime_prezime, $mobilni, $email, $id);
			}catch(Exception $e){
					echo $e->getMessage();
					}
			if($kolikoIhIma >= 2){
			header('Location: ../suosnivaci_izmena.php?success=uspesno&postoji='.$kolikoIhIma.'&ime='.$ime_prezime);
			}else{
			header('Location: ../suosnivaci_izmena.php?success=uspesno');
			}

}else{
		try{
					Suosnivac::updateSuosnivac($naziv, $adresa, $postanski_broj, $mesto, $pak, $maticni_broj, $pib, $datum_potpisivanja, $datum_apr, $napomena, $ugovor, $pristupnica, $ovlascenje, $id_glasanje, $id);
			}catch(Exception $e){
					echo $e->getMessage();
					}

		try{
					Predstavnik::updatePredstavnik($ime_prezime, $mobilni, $email, $id);
			}catch(Exception $e){
					echo $e->getMessage();
					}

			if($kolikoIhIma >= 2){
			header('Location: ../suosnivaci_izmena.php?success=uspesno&postoji='.$kolikoIhIma.'&ime='.$ime_prezime);
			}else{
			header('Location: ../suosnivaci_izmena.php?success=uspesno');
			}
}