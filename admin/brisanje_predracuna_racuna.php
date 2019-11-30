    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Suosnivac.php';
    require_once __DIR__.'/../klase/Predracuni.php';
    require_once __DIR__.'/../klase/Racuni.php';
    ?> 

    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Брисање предрачуна</h1> 
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
             <table id="tabela_brisanje_predracuna" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив суоснивача</th>
                  <th scope="col">Број предрачуна</th>
                  <th scope="col">Датум креирања</th>
                  <th scope="col">Предрачун</th>
                  <th scope="col"></th>
                  <!-- <th scope="col"></th> -->
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
                $danas = date("Y-m-d");
                $predracuni = Predracuni::getSvePredracune();
                foreach($predracuni as $pred){
                $suosnivac = Suosnivac::getSuosnivac($pred->id_suosnivac)->naziv;
               ?>
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$suosnivac?></td>
                <td class="broj_pred"><?=$pred->broj_predracuna?></td>
                <td><?=date('d.m.Y.', strtotime($pred->datum_predracuna))?></td>
                <td><a href="/inc/<?=$pred->generisan_url?>" class='gen_url'><?=$pred->generisan_url?></a></td>
                <td><button type="submit" class="obrisi_predracun" name="<?=$pred->generisan_url?>" id='<?= $pred->id?>'>Обриши</button></td>          
              </tr>             
              <?php $redni_broj++;}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </div>
</div> <!--content mt-3-->



<div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Брисање рачуна</h1> 
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
             <table id="tabela_brisanje_racuna" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив суоснивача</th>
                  <th scope="col">Број рачуна</th>
                  <th scope="col">Рачун</th>
                  <th scope="col"></th>
                  <!-- <th scope="col"></th> -->
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
                $racuni = Racuni::getSveRacune();
                foreach($racuni as $rac){
                $suosnivac = Suosnivac::getSuosnivac($rac->id_suosnivac)->naziv;
               ?>
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$suosnivac?></td>
                <td><?=$rac->broj_racuna?></td>
                <td><a href="/inc/<?=$rac->generisan_url?>"><?=$rac->generisan_url?></a></td>
                <td><button type="submit" class="obrisi_racun" name="<?=$rac->generisan_url?>" id='<?=$rac->id?>'>Обриши</button></td>
                
              </tr>
              
              <?php $redni_broj++;}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </div>
</div> <!--content mt-3-->





</div><!-- right -->
<script type="text/javascript">

  $(document).ready(function(){

    $("#tabela_brisanje_predracuna").on('click','.obrisi_predracun', function(e){
      e.preventDefault();
          var id = $(this).attr("id");
          var url = $(this).attr("name");
      $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/obrisi_predracun.php',
                data: {id_predracuna : id, uri : url},
                success: function(data) {
                  location.reload();
                  //console.log(data)
                  }
                });
              $('#bootstrap-data-table_wrapper').hide();
        });

    $("#tabela_brisanje_racuna").on('click','.obrisi_racun', function(e){
      e.preventDefault();
          var id = $(this).attr("id");
          var url = $(this).attr("name");
      $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/obrisi_racun.php',
                data: {id_racuna : id, uri : url},
                success: function(data) {
                  location.reload();
                  //console.log(data)
                  }
                });
              $('#bootstrap-data-table_wrapper').hide();
        });






    });

</script>




<?php include 'inc/footer.inc.php'; ?> 