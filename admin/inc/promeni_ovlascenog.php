<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Suosnivac.php';
require_once __DIR__.'/../../klase/Predstavnik.php';
require_once __DIR__.'/../../klase/Arhiva.php';
require_once __DIR__.'/../../includes/Upload.php';

$id=$_POST['ids'];

//predstavnik
$ime_prezime = $_POST['ime_prezime'];
$mobilni = $_POST['mobilni'];
$email = $_POST['email'];

$staro_ime = $_POST['staro_ime'];
$stari_mobilni = $_POST['stari_mobilni'];
$stari_email = $_POST['stari_email'];
$staro_ovlascenje = $_POST['staro_ovlascenje'];

$novo_ovlascenje = $_FILES['novo_ovlascenje'];

$imeFajla = new Tabela;
try{
	$imeFajla->upload_pdf($novo_ovlascenje);
	$novo_ovlascenje = $imeFajla->ispravnoIme($novo_ovlascenje);
	}catch(Exception $e){
		$novo_ovlascenje = null;
	}


//$test = 'Novi podaci: '.$ime_prezime.', '.$mobilni.', '.$email.', '.$novo_ovlascenje.'<br>Stari podaci: '.$staro_ime.','.$stari_mobilni.','.$stari_email.','.$staro_ovlascenje;
//echo $test;
//die();
$kolikoIhIma = Predstavnik::countPredstavnika($ime_prezime);
if($novo_ovlascenje !== null){
	
	try{
Suosnivac::updateOvlascenje($novo_ovlascenje, $id);
}catch(Exception $e){
	echo $e->getMessage();
}
}

try{
Arhiva::arhivaInsert($staro_ime, $stari_mobilni, $stari_email, $staro_ovlascenje, $id);
}catch(Exception $e){
	echo $e->getMessage();
}

try{
Predstavnik::updateOvlascenoLice($ime_prezime, $mobilni, $email, $id);
}catch(Exception $e){
	echo $e->getMessage();
}

if($kolikoIhIma >= 2){
	header('Location: ../ovlasceni_izmena.php?success=uspesno&postoji='.$kolikoIhIma.'&ime='.$ime_prezime);
}else{
	header('Location: ../ovlasceni_izmena.php?success=uspesno');
}


