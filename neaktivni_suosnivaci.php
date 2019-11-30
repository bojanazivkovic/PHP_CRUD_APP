    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Glasanje.php';
    require_once __DIR__.'/klase/Arhiva.php';

    $suosnivaci = Suosnivac::getSveNeaktivne();
    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Неактивни суоснивачи</h1> 
            
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12 tabela">
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
                  <th scope="col">Датум АПР</th>
                  <th scope="col">Датум истека накнаде</th>
                  <th scope="col">Право гласа</th>
                  <th scope="col">Овл. представник</th>
                  <th scope="col">Обрисан са АПР-а</th> 
                  <th scope="col"></th>                  
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($suosnivaci as $s){ 
                $ids = $s->id;
                $istek_uplate = Istice::getIsticeNajveci($ids);
                $pravo_glasa = Glasanje::getGlasanje($s->id_glasanje);
              ?>              
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$s->naziv?></td>

                <?php if($s->datum_apr != null){?>
                <td><?=date('d.m.Y', strtotime($s->datum_apr));?></td>
                <?php }else {?>
                <td></td>
                <?php }?>

                <!-- datum isteka godinsnje naknade -->
                <?php if($istek_uplate != null){?>
                <td><?=date('d.m.Y', strtotime($istek_uplate));?></td>
                <?php }else {?>
                <td></td>
                <?php }?>

                <!-- pravo glasa -->
                <?php if($s->id_glasanje != null){?>
                <td><?=$pravo_glasa->pravo?></td>
                <?php }else {?>
                <td></td>
                <?php }?>

                <td><?=Predstavnik::getPredstavnik($ids)->ime_prezime?></td>
                
                <?php if($s->apr_obrisan != 0) { ?>
                <td>              
                  Обрисан са АПР <i class="fa fa-check"></i>
                </td> 
                <?php }else{ ?>
                  <td>              
                  <button type="submit" class="obrisi_apr" name="submit" id='<?=$s->id?>'>Обриши са АПР-а</button>
                </td> 
               <?php } ?>
                 
                <td>              
                  <button type="submit" class="vise" name="submit" id='<?=$s->id?>'>Више</button>
                </td>                
              </tr>            
              <?php $redni_broj++;}?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- col-lg-12 -->
     <div id="podaci"></div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->

  
<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){
    
    $("#bootstrap-data-table").on('click','.vise', function(){
      var ids = $(this).attr("id");
              //console.log(ids);
              $('#id_suosnivac').val(ids);
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/svi.php',
                data: {id : ids},
                
                success: function(data) {
                  $("#podaci").html(data);                 
                  $('.page-title h1').html('<a href="neaktivni_suosnivaci.php"><i class="fa fa-hand-o-left"></i> назад</a>');
                  }
                });
              $('.tabela').hide();
            });


    $("#bootstrap-data-table").on('click','.obrisi_apr', function(){
      var ids = $(this).attr("id");
              
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/obrisi_apr.php',
                data: {id : ids},
                
                success: function(data) {
                  location.reload();
                  }
                });
            });


  });
</script>