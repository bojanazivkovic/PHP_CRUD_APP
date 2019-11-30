<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Racuni.php';
require_once __DIR__.'/../klase/Suosnivac.php';


$broj_racuna = $_POST['brr'];
$id_uplate = $_POST['idu'];

$provera_da_li_postoji = Racuni::getAllPoBrojuRacuna($broj_racuna);

if($provera_da_li_postoji != null){
	$id_racun = Racuni::poslatRacun($broj_racuna, $id_uplate);
	header('Location: ../posalji_racun.php');
}else{
	echo 'nije generisan racun';
}




