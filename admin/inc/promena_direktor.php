<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Direktor.php';

$id=$_POST['ids'];
$ime = $_POST['novo_ime'];
$funkcija = $_POST['nova_funkcija'];

Direktor::updateDirektor($id, $ime, $funkcija);
header('Location: ../promeni_direktora.php?success=uspesno');
