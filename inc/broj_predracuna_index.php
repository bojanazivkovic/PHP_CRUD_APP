<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Predracuni.php';
require_once __DIR__.'/../klase/Suosnivac.php';


$id_suosnivac = $_POST['id_suosnivac'];
$datum_predracuna = $_POST['datum_kreiranja'];
$datum_predracuna = date('Y-m-d H:i:s', strtotime($datum_predracuna));
$broj_predracuna=$_POST['broj_predracuna'];
$id_uplate = $_POST['id_uplate'];

//echo $id_suosnivac.', '.$datum_predracuna.', '.$broj_predracuna.', '.$id_uplate;


$provera_da_li_postoji = Predracuni::getAllPoBrojuPredracuna($broj_predracuna);

if($provera_da_li_postoji == null){
	$id_racun = Predracuni::insertBrojPredracuna($datum_predracuna, $broj_predracuna, $id_suosnivac, $id_uplate);
	header('Location: ../index.php');
}else{
	header('Location: ../index.php?postoji_predracun_index='.$broj_predracuna);
}




