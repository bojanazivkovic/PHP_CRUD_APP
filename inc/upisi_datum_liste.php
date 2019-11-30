<?php
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Konferencija.php';


$id_konferencija = $_POST['id_konf'];


$datum_liste = $_POST['datum_liste'];
$datum_liste = str_replace(' ', '', $datum_liste);
$datum_liste = str_replace(',', '.', $datum_liste);
$datum_liste = str_replace('/', '.', $datum_liste);

$datum_liste = date('Y-m-d H:i:s', strtotime($datum_liste));




try{
		$upisi_datum = Konferencija::insertDatumListe($datum_liste, $id_konferencija);
		header('Location: ../lista_glasanje.php');
		echo 'uspesno';
	}catch(Exception $e){
		return $e;
	}