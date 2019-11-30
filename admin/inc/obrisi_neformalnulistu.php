<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Konferencija.php';

$id = $_POST['id'];

try{
  Konferencija::obrisiNeformalnuListu($id);
  }catch(Exception $e){
    echo $e->getMessage();
  }

?>
