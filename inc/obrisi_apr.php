<?php 
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';

$id = $_POST['id'];

try{
  Suosnivac::updateBrisanjeApr($id);
  }catch(Exception $e){
    echo $e->getMessage();
  }

?>
