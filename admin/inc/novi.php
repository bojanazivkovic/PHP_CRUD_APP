<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../includes/Upload.php';

$ugovor = $_FILES['ugovor'];
$pristupnica = $_FILES['pristupnica'];
$ovlascenje = $_FILES['ovlascenje'];


	$imeFajla = new Tabela;

	try{
		$imeFajla->upload_pdf($ugovor);
		$ugovor = $imeFajla->ispravnoIme($ugovor);
	}catch(Exception $e){
		$ugovor = null;
	}
	try{
		$imeFajla->upload_pdf($pristupnica);
	$pristupnica = $imeFajla->ispravnoIme($pristupnica);
	}catch(Exception $e){
		$pristupnica = null;
	}
	try{
		$imeFajla->upload_pdf($ovlascenje);
	$ovlascenje = $imeFajla->ispravnoIme($ovlascenje);
	}catch(Exception $e){
		$ovlascenje = null;
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



$x = new DateTime($datum_potpisivanja);
$y = new DateTime('now');
$razlika = $y->diff($x);
$razlika_format = $razlika->format("%a");
//echo $razlika_format;
$year = 365;

if($razlika_format < $year){
	$id_glasanje = 2;
}else{
	$id_glasanje = 1;
}

//predstavnik
$ime_prezime = $imeFajla->test_input($_POST['ime_prezime']);
$mobilni = $imeFajla->test_input($_POST['mobilni']);
$email = $imeFajla->test_input($_POST['email']);



require_once __DIR__.'/../../klase/Suosnivac.php';
require_once __DIR__.'/../../klase/Predstavnik.php';
if($naziv != ''){
$suosnivac_id = Suosnivac::insertSuosnivac($naziv, $adresa, $postanski_broj, $mesto, $pak, $maticni_broj, $pib, $datum_potpisivanja, $datum_apr, $napomena, $ugovor, $pristupnica, $ovlascenje, $id_glasanje);
}else{
	header('Location: ../novi_suosnivac.php?unos=greska');
}


if($suosnivac_id !== false){

	
	$id_predstavnik = Predstavnik::insertPredstavnik($ime_prezime, $mobilni, $email, $suosnivac_id);
	$kolikoIhIma = Predstavnik::countPredstavnika($ime_prezime);
		if($kolikoIhIma >= 2){
			header('Location: ../novi_suosnivac.php?success=uspesno&postoji='.$kolikoIhIma.'&ime='.$ime_prezime);
		}else{
			header('Location: ../novi_suosnivac.php?success=uspesno');			
		}	
}else{
	header('Location: ../../index.php?error=greska');
}
