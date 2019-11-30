<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Clanarina.php';

$danas = date("Y-m-d H:i:s");

$id_suosnivac = Suosnivac::getAll();
foreach ($id_suosnivac as $idsuos) {
	$id = $idsuos->id; 

	$istice = Istice::getIsticeNajveciZaNeaktivne($id);
	foreach ($istice as $ist) {
		$datum_ist = $ist->datum;

	$datum_istPlusMesec = strtotime(date($datum_ist, strtotime($datum_ist)). '+1 month');
	$datum_istPlusMesec = date('Y-m-d H:i:s', $datum_istPlusMesec);

		if($datum_istPlusMesec < $danas){
			Suosnivac::updateStanje($id);
			echo $id.', '.$datum_ist.' - '.$datum_istPlusMesec.'<br>';
		}
	
	}

}

