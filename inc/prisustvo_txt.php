<?php
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Konferencija.php';
require_once __DIR__.'/../klase/Prisustvokonferenciji.php';
require_once __DIR__.'/../klase/Predstavnik.php';

$id_konf = $_GET['id'];

$prisustvo = Prisustvokonferenciji::getAllPrisustvo($id_konf);
$konferencija = Konferencija::getKonferencijuPoId($id_konf);
$naziv_konferencije = $konferencija->naziv;
$datum_konferencije = date('d.m.Y', strtotime($konferencija->datum));

$naziv_fajla = '../prisustvo/'.$naziv_konferencije.'-'.$datum_konferencije.'.txt';
$redniBr = 1;
$fajl = fopen($naziv_fajla, "w") or die("Unable to open file!");

foreach ($prisustvo as $pris) {
	$prisustvovao = $pris->id_suosnivac;
	$predstavnik = Predstavnik::getPredstavnik($prisustvovao)->ime_prezime;
	$suosnivac = Suosnivac::getSuosnivac($prisustvovao)->naziv;
	$s = str_replace(array('&quot;','&quot'), array('"','"'), $suosnivac);
	$text .= $redniBr.". ".$s."\r\n";
	$text .='- Овлашћени представник: '.$predstavnik."\r\n";
	$redniBr++;
}
fwrite($fajl,$text);
fclose($fajl);
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename='.$naziv_konferencije.'-'.$datum_konferencije.'.txt');
readfile($naziv_fajla);