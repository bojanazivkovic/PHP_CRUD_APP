<?php  
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predracuni.php';

$od = $_POST['from_date'];
$do = $_POST['to_date'];
$predracuni = Predracuni::getPredracunePoFilteru($od,$do);
?>

		<table class="table table-striped table-bordered" id="tabela_predracuni">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив суоснивача</th> 
                  <th scope="col">Датум креирања предрачуна</th>
                  <th scope="col">Послат дана</th>  
                  <th scope="col">Предрачун</th>                
                </tr>
              </thead>
              <tbody>
                <?php 
                $rb = 1;
                foreach ($predracuni as $pred) {
                $suosnivac = Suosnivac::getSuosnivac($pred->id_suosnivac);
                $urlpredrac = explode('/',trim($pred->generisan_url));
                $url = $urlpredrac[1];
                 ?>
                <tr>
                  <td scope="col"><?=$rb?></td>
                  <td scope="col"><?=$suosnivac->naziv?></td> 
                  <td scope="col"><?=date('d.m.Y.', strtotime($pred->datum_predracuna))?></td>
                  <td scope="col"><?=date('d.m.Y.', strtotime($pred->datum_slanja))?></td>  
                  <td scope="col"><a target="_blank" href="/inc/pdfs/<?=$url?>"><?=$url?></a></td>
                </tr>
                <?php $rb+=1; }  ?>
              </tbody>
         </table>