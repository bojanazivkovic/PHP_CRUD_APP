<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Clanarina.php';

$id=$_POST['idc'];
$novi_iznos = $_POST['novi_iznos'];
Clanarina::updateClanarinu($id, $novi_iznos);
header('Location: ../promeni_iznos_clanarine.php?success=uspesno');
