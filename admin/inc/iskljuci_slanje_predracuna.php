<?php
require_once __DIR__.'/../../klase/Predracuni.php';
require_once __DIR__.'/../../klase/Istice.php';

$id_suosnivac = $_POST['suosnivac_id'];
$id_predracun = $_POST['predracun_id'];
$uplata = $_POST['uplata_id'];
//print_r($_POST['slanje']);die();
//echo $uplata.', '.$id_predracun.', '.$id_suosnivac;die();

if(!empty($_POST['slanje'])) {
    foreach($_POST['slanje'] as $check) {
            //echo $check.'<br>'; 
             if ($check == "petnaest_pre"){
            	Predracuni::updatePoslatPetnaestDanaPre($uplata);
            }else if($check == "dan_pre"){
            	Predracuni::updatePoslatDanPre($uplata);
            }else if ($check == "dan_posle"){
            	Predracuni::updatePoslatDanNakonIsteka($uplata);
            }else if ($check == "petnaest_posle"){
            	Predracuni::updatePoslatPetnaestDanaNakonIsteka($uplata);
            }else if ($check == "dan_pre_brisanja"){
            	Predracuni::updateMesecDanaNakonIsteka($uplata);
            }   
    }

}
header('Location:http://10.10.10.233/admin/iskljuci_notifikacije.php');