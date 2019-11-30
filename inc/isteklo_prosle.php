<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Clanarina.php';


$godina = date("Y");
$za_godinu = $godina-2;

$id_suosnivac = $_POST['id_suosnivac_istek_prosle'];
$datum = $_POST['datum_uplate_istek_prosle'];
$datum = date('Y-m-d H:i:s', strtotime($datum));

//$x = date('Y-m-d H:i:s', $datum);
$fiktivni_datum_uplate = strtotime(date($datum, strtotime($datum)). '-1 year' );
$fiktivni_datum_uplate = date('Y-m-d H:i:s', $fiktivni_datum_uplate);
$iznos = Clanarina::getClanarinu()->iznos;


$id_uplate = Uplate::insertUplatu($fiktivni_datum_uplate, $iznos, $id_suosnivac, $za_godinu);


if($id_uplate !== false){
		Istice::insertIstekloProsle($datum, $id_uplate, $id_suosnivac);
		header('Location: ../pregled_svih_uplata.php#'.$id_suosnivac);
	}else{
		header('Location: ../pregled_svih_uplata.php?error=neuspesno');
	}


