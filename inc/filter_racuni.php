<?php  
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Racuni.php';
require_once __DIR__.'/../klase/Uplate.php';

$od = $_POST['from_date'];
$do = $_POST['to_date'];
$racuni = Racuni::getRacunePoFilteru($od,$do);
?>

		<table class="table table-striped table-bordered" id="tabela_predracuni">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив суоснивача</th> 
                  <th scope="col">Датум креирања рачуна</th>
                  <th scope="col">Послат дана</th>  
                  <th scope="col">Рачун</th>                
                </tr>
              </thead>
              <tbody>
                <?php 
                $rb = 1;
                foreach ($racuni as $rac) {
                $suosnivac = Suosnivac::getSuosnivac($rac->id_suosnivac);
                $datum_uplate = Uplate::getUplatuPoId($rac->id_uplate)->datum;
                $urlrac = explode('/',trim($rac->generisan_url));
                $url = $urlrac[1];
                 ?>
                <tr>
                  <td scope="col"><?=$rb?></td>
                  <td scope="col"><?=$suosnivac->naziv?></td> 
                  <td scope="col"><?=date('d.m.Y.', strtotime($datum_uplate))?></td>
                  <td scope="col"><?=date('d.m.Y.', strtotime($rac->datum_slanja))?></td>  
                  <td scope="col"><a target="_blank" href="/inc/racuni/<?=$url?>"><?=$url?></a></td>
                </tr>
                <?php $rb+=1; }  ?>
              </tbody>
         </table>