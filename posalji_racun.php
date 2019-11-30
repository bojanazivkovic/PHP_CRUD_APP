    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Racuni.php';

    ?> 

    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Пошаљи рачун</h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8"></div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12">
          <div class="card">
          
              <?php if(isset($_GET['postoji_racun'])) {?>
              <div class="card-header">
              <span id="postoji_racun">Већ постоји рачун са бројем <?=$_GET['postoji_racun']; ?>!</span>
              </div>
              <?php }?>
            
          <div class="card-body">
             <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th> 
                  <th scope="col">Последња уплата</th>
                  <th scope="col"></th> 
                  <th scope="col"></th>                 
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               $ova_godina = date('Y');

              $suosnivaci = Suosnivac::getAll();
              foreach ($suosnivaci as $s) {   
              $predstavnik_email = Predstavnik::getPredstavnik($s->id)->email;                    
              //$poslednjaUplata_uplate = Uplate::getSveUplate($s->id);
              
              $poslednjaUplata = Uplate::getPoslednju($s->id);
              //echo $poslednjaUplata->id;die();
              $datum_isteka_naknade = Istice::getIstice($poslednjaUplata->id)->datum;
              
              if($poslednjaUplata->datum >= '2019-03-19'){


              //$uplataDatum = $sve->datum;
              $racun = Racuni::getAll($poslednjaUplata->id);
                foreach ($racun as $rac) {
                  $poslat_racun = $rac->poslat;
                }
                     if($racun == null || $rac->poslat != 1){    
                   ?>
              <tr>
              <td scope="col"><?php echo $redni_broj;?></td>
              <td id="<?=$s->id?>" ><?=$s->naziv?></td>
             
               <?php if($racun == null && $poslednjaUplata != null) {?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><button type="submit" class="<?=$poslednjaUplata->id?> btn btn-secondary mb-1 unesi_br_racuna" data-toggle="modal" data-target="#smallmodal" id="<?=$s->id?>">Унеси број рачуна</button></td>
                  <td></td>
                 

                <?php }else if($rac->generisan_url == null){?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td>Уписан број рачуна: <?=$rac->broj_racuna; ?></td>
                  <td><button type="submit" class='<?=$poslednjaUplata->id?> <?=$rac->broj_racuna;?> <?=$s->naziv;?> btn btn-secondary mb-1 generisi_pdf' id="<?=$s->id?>">Генериши PDF</button></td>
                  
                
                <?php }else if($rac->poslat == 0){?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><button type="submit" class ='<?=$predstavnik_email;?> <?=$rac->generisan_url;?> <?=$rac->broj_racuna;?> <?=$rac->id_uplate;?> <?=$datum_isteka_naknade?> btn btn-secondary mb-1 posalji_racun' id="<?=$s->id?>">Пошаљи рачун</button></td>

                  <td><button type="submit" class="<?=$rac->id_uplate;?> poslat_racun" id="<?=$rac->broj_racuna;?>">Послат раније</button></td>
                  

                <?php } else{?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td>Нема рачуна за слање!</td>
                  <td></td>
                  
                  <?php ?> 
                <?php }?>
              
                </tr>   
            
              <?php $redni_broj++; }
              }

              }?> 
                
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->

<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                              <form action="inc/broj_racuna.php" method="post">
                                <div class="col-12">
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac" id="id_suosnivac" value="">
                                </div>

                                <div class="form-group">
                                  <input type="hidden" name="id_uplate" id="id_uplate" value="">
                                  <label for="broj_racuna" class="control-label mb-1">Број рачуна:</label>
                                  <input id="broj_racuna" name="broj_racuna" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                  <label for="racun_generisao" class="control-label mb-1">Рачун генерисао:</label>
                                  <input id="racun_generisao" name="racun_generisao" type="text" class="form-control" placeholder="име и презиме" required>
                                </div>
                              </div>
                              
                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                               
                                <button type="submit" class="btn btn-primary" id="unesi_uplatu" name="unesi_uplatu">Унеси</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<div class="loading" style="display: none;">Loading&#8230;</div>
<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){

    $(".loading").hide();

    $("#bootstrap-data-table").on('click','.unesi_br_racuna', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac').val(ids);

      var idupl = $(this).attr('class').split(' ')[0];
      $('#id_uplate').val(idupl);


      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel').html('Рачун за: '+data);
           //console.log(data)
        }
      });

    });

  function open_in_tab(url) {
   var win = window.open(url, '_blank');
   win.focus();
  }
    $("#bootstrap-data-table").on('click','.generisi_pdf', function(e){
      e.preventDefault();
      $(".loading").show();
      var ids = $(this).attr('id');
      $('#id_suosnivac').val(ids);
      var idupl = $(this).attr('class').split(' ')[0];
      var br_racuna = $(this).attr('class').split(' ')[1];
      var suos_naziv = $(this).attr('class');
      


      if(suos_naziv.split(' ')[2].replace(/"/g, '').length < 3){
        suos_naziv = suos_naziv.split(' ')[2].replace(/"/g, '')+'_'+suos_naziv.split(' ')[3].replace(/"/g, '')
      }else{
        suos_naziv = suos_naziv.split(' ')[2].replace(/"/g, '')
      }
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/generisiRacun.php',
        data: {id:ids, br:br_racuna, suos:suos_naziv, iduplata:idupl},

        success: function(data){         
          open_in_tab('inc/racuni/RNIDS-račun-'+br_racuna+'-'+suos_naziv+'-cl.pdf','_blank');
          
          location.reload();
          //console.log(data)
        }
      });

    });
  

    $("#bootstrap-data-table").on('click','.posalji_racun', function(e){
      e.preventDefault();

      $(".loading").show();

      var ids = $(this).attr('id');
      var email = $(this).attr('class').split(' ')[0];
      var url = $(this).attr('class').split(' ')[1];
      var br_rac = $(this).attr('class').split(' ')[2];
      var idu = $(this).attr('class').split(' ')[3];
      var dat_isteka = $(this).attr('class').split(' ')[4];
      //console.log(dat_isteka)
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/slanje_racuna.php',
        data: {id:ids, mail:email, uri:url, br_pr:br_rac, iduplate:idu, di:dat_isteka},

        success: function(data){
          location.reload();
          //console.log(data)
        }
      });

    });



    $("#bootstrap-data-table").on('click','.poslat_racun', function(e){
      e.preventDefault();

      $(".loading").show();

      var broj_racuna = $(this).attr('id');
      var id_uplate = $(this).attr('class').split(' ')[0];
      console.log(id_uplate);
      console.log(broj_racuna);
     $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/poslat_racun.php',
        data: {brr:broj_racuna, idu:id_uplate},

        success: function(data){
          location.reload();
          //console.log(data)
        }
      });
      

    });

     setTimeout(function(){
       if($('#postoji_racun').length > 0){
        $('#postoji_racun').remove();
      }    
    },3000);
  });
</script>