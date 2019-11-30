<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Uplate.php';


$id = $_POST['id'];
Uplate::obrisiUplatu($id);
  
