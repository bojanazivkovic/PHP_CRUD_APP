<?php
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Predracuni.php';

$id_predracuna = $_POST['id_predracuna'];
$url = $_POST['uri'];
//echo $_SERVER['DOCUMENT_ROOT'].'/suosnivaci/inc/'.$url;die();

if($url != null){
	unlink($_SERVER['DOCUMENT_ROOT'].'/inc/'.$url);
}

try{
  Predracuni::obrisiPredracun($id_predracuna);
  }catch(Exception $e){
    echo $e->getMessage();
  }
