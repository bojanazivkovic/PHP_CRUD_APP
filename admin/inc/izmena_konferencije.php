<?php 
require_once __DIR__.'/../../klase/Tabela.php';
require_once __DIR__.'/../../klase/Konferencija.php';

$id = $_POST['idkonf'];

$konferencija = $_POST['konferencija'];
$datum = $_POST['datum'];
$datum = date('Y-m-d H:i:s', strtotime($datum));
$vreme = $_POST['vreme'];
$organizator = $_POST['organizator'];
$lokacija = $_POST['lokacija'];

//echo $id.', '.$konferencija.', '.$datum.', '.$vreme.', '.$organizator.', '.$lokacija;
//die();



if($id != null && $id != ''){
    try{
    Konferencija::updateKonferenciju($id, $konferencija, $datum, $vreme, $organizator, $lokacija);

    }catch(Exception $e){
        echo $e->getMessage();
    }
}else{
    die();
}

header('Location: ../konferencija_izmena.php?success=uspesno');