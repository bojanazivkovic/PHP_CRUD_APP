    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Predracuni.php';

    ?> 

    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Пошаљи предрачун</h1> 
            
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12">
          <div class="card">
          
              <?php if(isset($_GET['postoji_predracun'])) {?>
              <div class="card-header">
              <span id="postoji_predracun">Већ постоји предрачун са бројем <?=$_GET['postoji_predracun']; ?>!</span>
              </div>
              <?php }?>
            
          <div class="card-body">
             <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th hidden></th>
                  <th scope="col">Назив</th> 
                  <th scope="col">Последња уплата</th>
                  <th scope="col">Истиче</th>
                  <th scope="col"></th> 
                  <th scope="col"></th>                 
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               $ova_godina = date('Y');

              $suosnivaci = Suosnivac::getAll();
              foreach ($suosnivaci as $s) {   
              $napomena = $s->napomena; 
              $datum_isteka_nak = Istice::getIsticeNajveci($s->id); 
              $datum_isteka_naknade = date('d.m.Y.',strtotime($datum_isteka_nak));
              $predstavnik_email = Predstavnik::getPredstavnik($s->id)->email;                    
              //$sve_uplate = Uplate::getSveUplate($s->id);
              
              $sva_isticanja = Istice::getPoslednjeIsticanjeZaPredracun($s->id);
              $poslednjaUplata = Uplate::getPoslednju($s->id);

              $isticePoslednje = Istice::getPoslednje($s->id);
              foreach ($sva_isticanja as $sve) {

              
              $danas = time();
              $istek = strtotime($isticePoslednje->datum);
              $razlika = ceil(($danas - $istek)/60/60/24);
                
                
              $uplataDatumGodina = date('Y', strtotime($sve->datum));
              $predracun = Predracuni::getAll($sve->id);
                foreach ($predracun as $predrac) {
                  $poslat_predracun = $predrac->poslat;
                }
                     if($predracun == null || $predrac->poslat != 1){    
                   ?>
              <tr>
              <td scope="col"><?php echo $redni_broj;?></td>
              <td hidden><?=$razlika;?></td>
              <?php if($napomena != null){ ?>
                <td id="<?=$s->id?>" ><?=$s->naziv?> - <b><span style="color: red">НАПОМЕНА</span></b></td>
                <?php }else {?>
                <td id="<?=$s->id?>" ><?=$s->naziv?></td>
                <?php } ?>
             
               <?php if($predracun == null && $sve != null) {?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><?=date('d.m.Y', strtotime($sve->datum));?></td>
                  <td><button type="submit" class="<?=$poslednjaUplata->id?> btn btn-secondary mb-1 unesi_br_predracuna" data-toggle="modal" data-target="#smallmodal" id="<?=$s->id?>">Унеси број предрачуна</button></td>
                  <td></td>

                <?php }else if($predrac->generisan_url == null){?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><?=date('d.m.Y', strtotime($sve->datum));?></td>
                  <td>Уписан број предрачуна: <?=$predrac->broj_predracuna; ?></td>
                  <td><button type="submit" class='<?=$sve->id?> <?=$predrac->broj_predracuna;?> <?=$s->naziv;?> btn btn-secondary mb-1 generisi_pdf' id="<?=$s->id?>">Генериши PDF</button></td>
                
                <?php }else if($predrac->poslat == 0){?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><?=date('d.m.Y', strtotime($sve->datum));?></td>
                  <td><button type="submit" class ='<?=$predstavnik_email;?> <?=$predrac->generisan_url;?> <?=$predrac->broj_predracuna;?> <?=$predrac->id_uplate;?> <?=$datum_isteka_naknade?> btn btn-secondary mb-1 posalji_predracun' id="<?=$s->id?>">Пошаљи предрачун</button></td>
                  <td></td>

                <?php } else{?>
                  <td><?=date('d.m.Y', strtotime($poslednjaUplata->datum));?></td>
                  <td><?=date('d.m.Y', strtotime($sve->datum));?></td>
                  <td>Нема предрачуна за слање!</td><td></td>
                  <?php //echo Uplate::getPoslednju($ids)->za_godinu + 1; ?> 
                <?php }?>
              
                </tr>   
            
              <?php $redni_broj++; }

              }}?> 
                
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
                                
                              <form action="inc/broj_predracuna.php" method="post">
                                <div class="col-12">
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac" id="id_suosnivac" value="">
                                  <label for="datum_kreiranja" class="control-label mb-1">Датум предрачуна:</label>
                                  <input id="datum_kreiranja" name="datum_kreiranja" type="text" class="form-control" required>
                                </div>

                                <div class="form-group">
                                  <input type="hidden" name="id_uplate" id="id_uplate" value="">
                                  <label for="broj_predracuna" class="control-label mb-1">Број предрачуна:</label>
                                  <input id="broj_predracuna" name="broj_predracuna" type="text" class="form-control" required>
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

    $("#bootstrap-data-table").on('click','.unesi_br_predracuna', function(e){
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
           $('#smallmodalLabel').html('Предрачун за: '+data);
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
      var br_predracuna = $(this).attr('class').split(' ')[1];
      var suos_naziv = $(this).attr('class');
      


      if(suos_naziv.split(' ')[2].replace(/"/g, '').length < 3){
        suos_naziv = suos_naziv.split(' ')[2].replace(/"/g, '')+'_'+suos_naziv.split(' ')[3].replace(/"/g, '')
      }else{
        suos_naziv = suos_naziv.split(' ')[2].replace(/"/g, '')
      }
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/generisiPredracun.php',
        data: {id:ids, br:br_predracuna, suos:suos_naziv, iduplata:idupl},

        success: function(data){
          //window.open('http://10.10.10.234/inc/pdfs/RNIDS-predračun-'+br_predracuna+'-'+suos_naziv+'-cl.pdf','_blank');         
          open_in_tab('inc/pdfs/RNIDS-predračun-'+br_predracuna+'-'+suos_naziv+'-cl.pdf','_blank');
          
          location.reload();
          //console.log(data)
        }
      });

    });
  

    $("#bootstrap-data-table").on('click','.posalji_predracun', function(e){
      e.preventDefault();

      $(".loading").show();

      var ids = $(this).attr('id');
      var email = $(this).attr('class').split(' ')[0];
      var url = $(this).attr('class').split(' ')[1];
      var br_predrac = $(this).attr('class').split(' ')[2];
      var idu = $(this).attr('class').split(' ')[3];
      var dat_isteka = $(this).attr('class').split(' ')[4];
      //console.log(dat_isteka)
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/slanje_predracuna.php',
        data: {id:ids, mail:email, uri:url, br_pr:br_predrac, iduplate:idu, di:dat_isteka},

        success: function(data){
          location.reload();
          //console.log(data)
        }
      });

    });



     setTimeout(function(){
       if($('#postoji_predracun').length > 0){
        $('#postoji_predracun').remove();
      }
      
    },3000);



  });
</script>