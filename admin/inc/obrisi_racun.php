<?php
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Racuni.php';

$id_racuna = $_POST['id_racuna'];
$url = $_POST['uri'];
//echo $_SERVER['DOCUMENT_ROOT'].'/suosnivaci/inc/'.$url;die();

if($url != null){
	unlink($_SERVER['DOCUMENT_ROOT'].'/inc/'.$url);
} 
try{
  Racuni::obrisiRacun($id_racuna);
  }catch(Exception $e){
    echo $e->getMessage();
  }


