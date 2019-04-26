    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 
    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Glasanje.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Istice.php';
    $suosnivaci = Suosnivac::getSvePoAprRedu();
    ?> 
    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Сви суоснивачи са подацима</h1>           
          </div>
        </div>
      </div>
      <div class="col-sm-8"></div>
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
                  <th scope="col">Адреса</th> 
                  <th scope="col">Поштански број и место</th>
                  <th scope="col" hidden>ПАК</th>
                  <th scope="col">Матични број</th>
                  <th scope="col">ПИБ</th>
                  <th scope="col">Датум потписивања</th>
                  <th scope="col">Датум АПР</th>
                  <th scope="col" hidden>Напомена</th>
                  <th scope="col" hidden>Право гласа</th>
                  <th scope="col" hidden>Представник</th>
                  <th scope="col" hidden>Телефон</th>
                  <th scope="col" hidden>Адреса е-поште</th>
                  <th scope="col" hidden>Накнада истиче</th>
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
                  <td><?=$s->adresa?></td> 
                  <td><?=$s->postanski_broj?> <?=$s->mesto?></td>
                  <td hidden><?=$s->pak?></td>
                  <td><?=$s->maticni?></td>
                  <td><?=$s->pib?></td>
                  <td><?=date('d.m.Y.', strtotime($s->datum_potpisivanja))?></td>
                  <td><?=date('d.m.Y.', strtotime($s->datum_apr))?></td>
                  <td hidden><?=$s->napomena?></td>
                  <td hidden><?=$pravo_glasa?></td>
                  <td hidden><?=$predstavnik->ime_prezime?></td>
                  <td hidden><?=$predstavnik->mobilni?></td>
                  <td hidden><?=$predstavnik->email?></td> 
                  <td hidden><?=date('d.m.Y.', strtotime($istice))?></td>               
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