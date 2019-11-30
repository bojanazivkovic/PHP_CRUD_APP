<?php 
require_once __DIR__.'/../klase/Tabela.php';


$id = $_POST['id'];

require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';
$suosnivac_naziv = Suosnivac::getSuosnivac($id)->naziv;


if($suosnivac_naziv !== false){
	echo $suosnivac_naziv;
}else{
	header('Location: ../index.php?error=greska');
}
