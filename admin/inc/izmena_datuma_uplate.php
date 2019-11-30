<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Suosnivac.php';
require_once __DIR__.'/../../klase/Uplate.php';


$id = $_POST['idu'];
$novi_datum = $_POST['nd'];
$novi_datum = str_replace(' ', '', $novi_datum);
$novi_datum = str_replace(',', '.', $novi_datum);
$novi_datum = str_replace('/', '.', $novi_datum);
$datum = date('Y-m-d H:i:s', strtotime($novi_datum));


if($novi_datum != null && $novi_datum != ''){
	try{
	Uplate::updateUplatu($id, $datum);
	}catch(Exception $e){
		echo $e->getMessage();
	}
}else{
	die();
}