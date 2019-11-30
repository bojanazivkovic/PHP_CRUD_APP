<?php
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Clanarina.php';
require_once __DIR__.'/../klase/Predstavnik.php';

$id_suosnivac = $_POST['id_suosnivac_uplata_sledece'];
$datum_uplate = $_POST['datum_uplate_sledece'];
$datum_uplate = str_replace(' ', '', $datum_uplate);
$datum_uplate = str_replace(',', '.', $datum_uplate);
$datum_uplate = str_replace('/', '.', $datum_uplate);

$datum_uplate = date('Y-m-d H:i:s', strtotime($datum_uplate));

$iznos = Clanarina::getClanarinu()->iznos;
$godina_za_uplatu = Uplate::getPoslednju($id_suosnivac)->za_godinu;
$za_godinu = $godina_za_uplatu+1;

$datum_apr = Suosnivac::getDatumApr($id_suosnivac);
$datum_apr_godina = date('Y', strtotime($datum_apr));

$minusTriMesecaOdDatumaApr = strtotime(date($datum_apr, strtotime($datum_apr)). '-3 month' );
$datum_uplate_provera = strtotime(date($datum_uplate));

$godina_uplate = date('Y', strtotime($datum_uplate));
$dodaj = ($za_godinu - $datum_apr_godina) + 1;

$istice2017 = Istice::getIstice2017($id_suosnivac);
$istice2017_godina = date('Y', strtotime($istice2017));



$dodajOdIsticanja = ($za_godinu - $istice2017_godina) + 1;



if($datum_uplate_provera < $minusTriMesecaOdDatumaApr){
	header('Location: ../pregled_svih_uplata.php?nijepostojaosuosnivac='.$id_suosnivac);
}else{
	if($datum_apr_godina < 2017){
		//echo 'manji';die();
			$datum_isticanja = strtotime(date($istice2017, strtotime($istice2017)). '+'.$dodajOdIsticanja.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);		
	}else{		
		//echo 'veci';die();
			$datum_isticanja = strtotime(date($datum_apr, strtotime($datum_apr)). '+'.$dodaj.' year' );
			$datum_isticanja = date('Y-m-d H:i:s', $datum_isticanja);		
	}


//echo $id_suosnivac.', datum apr: '.$datum_apr.' uplata: '.$datum_uplate.' istice: '.$datum_isticanja;
//die();

$godUplate = '';
$sveUplateSuosnivaca = Uplate::getSveUplate($id_suosnivac);

//$obavestenje = new Tabela;

foreach ($sveUplateSuosnivaca as $sveUplate) {
	$godUplate = date('Y', strtotime($sveUplate->datum));

}

if($godina_uplate > 2016){
	try{
		$id_uplate = Uplate::insertUplatu($datum_uplate, $iznos, $id_suosnivac, $za_godinu);
		Istice::insertIstice($datum_isticanja, $id_uplate, $id_suosnivac);
		//$countUplate = Uplate::getCountSvihUplata($id_suosnivac)->koliko;
		//echo $countUplate;die();
		/*if($countUplate > 1){
			$obavestenje->posalji_obavestenje($id_suosnivac, $datum_isticanja);
			Uplate::updateObavestenje($id_uplate);
		}*/
		header('Location: ../pregled_svih_uplata.php#'.$id_suosnivac);

	}catch(Exception $e){
		return $e;
	}
		
}else{
	try{
		$id_uplate = Uplate::insertUplatu($datum_uplate, $iznos, $id_suosnivac, $za_godinu);
		header('Location: ../pregled_svih_uplata.php#'.$id_suosnivac);
	}catch(Exception $e){
		return $e;
	}
	
	
}
}

