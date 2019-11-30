    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Suosnivac.php';
    require_once __DIR__.'/../klase/Predracuni.php';
    require_once __DIR__.'/../klase/Istice.php';
    ?> 

    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Искључи слање предрачуна</h1> 
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <!-- <li class="active">Dashboard</li> -->
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12">
          <div class="card">
          <!-- <div class="card-header">
            <strong class="card-title">Суоснивач</strong>
          </div> -->
          <div class="card-body">
             <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  <th scope="col">Матични број</th>
                  <th scope="col">Место</th>
                  <th scope="col"></th>
                  <!-- <th scope="col"></th> -->
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
                $danas = date("Y-m-d");
                $suosnivaci = Suosnivac::getAll();
                foreach($suosnivaci as $s){


              //izvlacim isticanje za poslednju uplatu - isto koristim za cron za neaktivne
              $istice = Istice::getIsticeNajveciZaNeaktivne($s->id);
              foreach ($istice as $ist) {
                $uplata = $ist->id_uplate;
                //echo $uplata.'<br>';
                $datum_ist = $ist->datum;

              $datum_istMinusMesec = strtotime(date($datum_ist, strtotime($datum_ist)). '-1 Month');
              $datum_istMinusMesec = date('Y-m-d', $datum_istMinusMesec);

              $datum_istPlusMesec = strtotime(date($datum_ist, strtotime($datum_ist)). '+1 Month');
              $datum_istPlusMesec = date('Y-m-d', $datum_istPlusMesec);





              if($datum_istMinusMesec < $danas && $datum_istPlusMesec > $danas){
              $predracun = Predracuni::getPoslednjiPredracunPoUplati($s->id);
               foreach ($predracun as $pred) {
                 
               
               ?>
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$s->naziv?></td>
                <td><?=$s->maticni?></td>
                <td><?=$s->mesto?></td>
                <td><button type="submit" class="izmeni" name="submit" id='<?= $s->id ?>'>Искључи слање</button></td>
                
              </tr>
              
              <?php $redni_broj++;}}}}?>
            </tbody>
          </table>
          <div id="podaci"></div>
        </div>
      </div>
    </div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->
<script type="text/javascript">

  $(document).ready(function(){

    $("#bootstrap-data-table").on('click','.izmeni', function(){
      var ids = $(this).attr("id");
              //console.log(ids);
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/iskljuci_slanje.php',
                data: {id : ids},
                success: function(data) {
                  $("#podaci").html(data);
                  
                  $('.page-title h1').html('<a href="iskljuci_notifikacije.php"><i class="fa fa-hand-o-left"></i> назад</a>');
                    
                    
                  }
                });
              $('#bootstrap-data-table_wrapper').hide();
            });


  });

</script>

<?php include 'inc/footer.inc.php'; ?> 