<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Clanarina.php';

$id_suosnivac = $_POST['id_suosnivac'];
$datum_uplate = $_POST['datum_uplate'];
$datum_uplate = str_replace(' ', '', $datum_uplate);
$datum_uplate = str_replace(',', '.', $datum_uplate);
$datum_uplate = str_replace('/', '.', $datum_uplate);

//$datum_isticanja = $_POST['datum_isticanja'];
$iznos = Clanarina::getClanarinu()->iznos;

$datum_apr = Suosnivac::getDatumApr($id_suosnivac);
$datum_apr_godina = date('Y', strtotime($datum_apr));

$minusTriMesecaOdDatumaApr = strtotime(date($datum_apr, strtotime($datum_apr)). '-3 month' );
$datum_uplate_provera = strtotime(date($datum_uplate));

$godina = date('Y', strtotime($datum_uplate));
$dodaj = ($godina - $datum_apr_godina) + 1;

$istice2017 = Istice::getIsticeNajveci($id_suosnivac);
$istice2017_godina = date('Y', strtotime($istice2017));



$dodajOdIsticanja = ($godina - $istice2017_godina) + 1;

if($datum_uplate_provera < $minusTriMesecaOdDatumaApr){
	header('Location: ../pregled_svih_uplata.php?nijepostojaosuosnivac='.$id_suosnivac);
}else{
	if($datum_apr_godina < 2017){
		if($godina < $istice2017_godina){
			//$dodajOdIsticanja = ($istice2017_godina - $godina);
			$datum_isticanja = strtotime(date($istice2017, strtotime($istice2017)). '+'.$dodajOdIsticanja.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);

		}else{
			$dodajOdIsticanja = ($godina - $istice2017_godina);
			$datum_isticanja = strtotime(date($istice2017, strtotime($istice2017)). '+'.$dodajOdIsticanja.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);
		}
		
	}else{
		if($godina < $datum_apr_godina){
			$dodaj = ($datum_apr_godina - $godina);
			$datum_isticanja = strtotime(date($datum_apr, strtotime($datum_apr)). '+'.$dodaj.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);

		}else{
			$datum_isticanja = strtotime(date($datum_apr, strtotime($datum_apr)). '+'.$dodaj.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);
		}
		
	}


$godUplate = '';
$sveUplateSuosnivaca = Uplate::getSveUplate($id_suosnivac);
foreach ($sveUplateSuosnivaca as $sveUplate) {
	$godUplate = date('Y', strtotime($sveUplate->datum));

}




if($godina > 2016){
	try{
		$id_uplate = Uplate::insertUplatu($datum_uplate, $iznos, $id_suosnivac);
		Istice::insertIstice($datum_isticanja, $id_uplate, $id_suosnivac);
		//header('Location: ../pregled_svih_uplata.php?success='.$id_uplate);
		header('Location: ../pregled_svih_uplata.php#'.$id_suosnivac);
	}catch(Exception $e){
		return $e;
	}
		
}else{
	try{
		$id_uplate = Uplate::insertUplatu($datum_uplate, $iznos, $id_suosnivac);
		//header('Location: ../pregled_svih_uplata.php?success='.$id_uplate);
		header('Location: ../pregled_svih_uplata.php#'.$id_suosnivac);
	}cathc(Exception $e){
		return $e;
	}
	
}
}

		