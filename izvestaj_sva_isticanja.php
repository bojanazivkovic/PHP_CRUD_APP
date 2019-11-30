    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 
    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Glasanje.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Istice.php';
    $suosnivaci = Suosnivac::getSvePoAprRedu();
    $prvi_kvartal = 0;
    $drugi_kvartal = 0;
    $treci_kvartal = 0;
    $cetvrti_kvartal = 0;
    foreach($suosnivaci as $s){              
       $ids = $s->id;
       $istice = Istice::getPoslednjeIsticanje($ids);  
       $date = strtotime($istice);
              $month = date('n',$date);
              //echo date('n',$date).', ';

                if($month >= 1 && $month <=3){
                  $prvi_kvartal++;
                }else if($month >= 4 && $month  <=6){
                  $drugi_kvartal++;

                }else if($month >= 7 && $month  <=9){
                  $treci_kvartal++;

                }else {
                  $cetvrti_kvartal++;
                } 
     }
    ?> 
    <div class="breadcrumbs">
      <div class="col-sm-6">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Истицање накнада суоснивача:</h1>           
          </div>
        </div>
      </div>
      <div class="col-sm-6" style="text-align: right;">
        <?php 
          echo 'Први квартал = <b>'.$prvi_kvartal.'</b>, Други квартал = <b>'.$drugi_kvartal.'</b><br>'; 
          echo 'Трећи квартал = <b>'.$treci_kvartal.'</b>, Четврти квартал = <b>'.$cetvrti_kvartal.'</b>';
          ?>
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">       
        <div class="col-lg-12 tabela">
          <div class="card">
          <div class="card-body">
             <table id="bootstrap-data-table-export" class="table table-striped table-bordered" style="width:100%; font-size: 12px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  <th scope="col">Накнада истиче</th>
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;               
               foreach($suosnivaci as $s){ 
                
                $ids = $s->id;
                $pravo_glasa = Glasanje::getGlasanje($s->id_glasanje)->pravo;
                $predstavnik = Predstavnik::getPredstavnik($ids);
                $istice = Istice::getPoslednjeIsticanje($ids);               
              ?>              
               <tr>
                  <td><?php echo $redni_broj;?></td>
                  <td><?=$s->naziv?></label></td>
                  <td><?=date('Y-m-d', strtotime($istice))?></td>               
              </tr>            
              <?php $redni_broj++;} ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- col-lg-12 -->
  </div>
</div> <!--content mt-3-->

</div><!-- right -->

  
<?php include 'inc/footer.inc.php'; ?> 