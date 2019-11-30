<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Konferencija.php';

$imeFajla = new Tabela;
$naziv = $imeFajla->test_input($_POST['konferencija']);
$datum = $imeFajla->test_input($_POST['datum']);
$vreme = $imeFajla->test_input($_POST['vreme']);
$organizator = $imeFajla->test_input($_POST['organizator']);
$lokacija = $imeFajla->test_input($_POST['lokacija']);

//na ne bi pravilo problem kad kopiraju datum sa sajta, zbog razmaka izmedju brojeva
$datum = str_replace(' ', '', $datum);

if($datum == ''){
	$datum = null;
}else {
	$datum = date('Y-m-d H:i:s', strtotime($datum));
}


if($naziv != ''){
$konferencija_id = Konferencija::insertKonferenciju($naziv, $datum, $vreme, $organizator, $lokacija);
header('Location: ../lista_glasanje.php?success=uspesno');
}else{
	header('Location: ../lista_glasanje.php?unos=greska');
}
