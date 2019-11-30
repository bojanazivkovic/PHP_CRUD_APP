<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Racuni.php';
require_once __DIR__.'/../klase/Suosnivac.php';


$id_suosnivac = $_POST['id_suosnivac'];
$uneo = $_POST['racun_generisao'];

$broj_racuna=$_POST['broj_racuna'];
$id_uplate = $_POST['id_uplate'];

//echo $id_suosnivac.', '.$datum_racuna.', '.$broj_racuna.', '.$id_uplate;die();


$provera_da_li_postoji = Racuni::getAllPoBrojuRacuna($broj_racuna);

if($provera_da_li_postoji == null){
	$id_racun = Racuni::insertBrojRacuna($broj_racuna, $id_suosnivac, $id_uplate, $uneo);
	header('Location: ../posalji_racun.php');
}else{
	header('Location: ../posalji_racun.php?postoji_racun='.$broj_racuna);
}




