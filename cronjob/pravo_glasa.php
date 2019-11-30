<?php

require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Glasanje.php';
require_once __DIR__.'/../klase/Pravoglasa.php';
require_once __DIR__.'/../klase/Konferencija.php';
require_once __DIR__.'/../klase/Prisustvokonferenciji.php';

$danas = date("Y-m-d H:i:s");

$ukupno_konferencije = Konferencija::countSveKonferencije();
foreach ($ukupno_konferencije as $ukupno) {
	$countKonferencije = $ukupno->ukupno;
}
//echo $countKonferencije/2;
//echo '<br>';

$id_suosnivac = Suosnivac::getAll();
foreach ($id_suosnivac as $idsuos) {
	$id = $idsuos->id; 
	$naziv = $idsuos->naziv;

	$prisustvovao = Prisustvokonferenciji::countPrisustvoSuosnivaca($id);
	//echo 'Prisustvovao na koliko konferencija: '.$naziv.' - '.$prisustvovao.'<br>';

	$datum_apr = $idsuos->datum_apr;
	$datum_aprPlusGodina = strtotime(date($datum_apr, strtotime($datum_apr)). '+1 year');
	$datum_aprPlusGodina = date('Y-m-d H:i:s', $datum_aprPlusGodina);


	$id_glasanje = $idsuos->id_glasanje;
	//$pravo_glasa = Glasanje::getGlasanje($id_glasanje)->pravo;


	$istice = Istice::getIsticeNajveciZaNeaktivne($id);
	
	foreach ($istice as $ist) {
		$datum_ist = $ist->datum;

	$datum_istPlusMesec = strtotime(date($datum_ist, strtotime($datum_ist)). '+1 month');
	$datum_istPlusMesec = date('Y-m-d H:i:s', $datum_istPlusMesec);

	//echo $naziv.' * datum isticanja'.$datum_ist.', datum ist + mesec'.$datum_istPlusMesec.'$datum_ist < $danas && $datum_istPlusMesec > $danas<br>';

	if($datum_ist < $danas){
		//ako je isteklo, nema pravo glasa
		$pravo_glasa = 3;
	}else if ($datum_aprPlusGodina > $danas && $datum_ist > $danas || $countKonferencije/2 >= $prisustvovao){
		//ako je prvih godinu dana od kad je suosnivac i ako nije istekla naknada, onda ima delimicno pravo glasa
		$pravo_glasa = 2;
	}else if ($datum_ist > $danas && $datum_aprPlusGodina < $danas && $countKonferencije/2 < $prisustvovao){
		//ako nije istekla naknada i nije mu prva godina od kad je suosnivac, onda ima pravo glasa
		$pravo_glasa = 1;
	}

//echo 'Pravo glasa: '.$naziv.' - '.$pravo_glasa.'<br>';
	Suosnivac::updatePravoGlasa($id, $pravo_glasa);
	Pravoglasa::pravoGlasaInsert($id, $danas, $pravo_glasa);
	}
}
