    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';

    $suosnivaci = Suosnivac::getAll();
    
    $godina = date("Y");
    $proslaGodina = date('Y', strtotime('-1 year'));
    $sledecaGodina = date('Y', strtotime('+1 year'));

    $danas = date('d.m.Y');
    $preGrejsPerioda = date('d.m.Y', strtotime('-1 month'));
    $grejsPeriod = date('d.m.Y', strtotime('+1 month'));
    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Преглед свих уплата</h1>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <?php if(isset($_GET['success'])){?>
              <span id="success_uplata">Успешно сте унели уплату!</span>
        <?php } ?>
        
        <?php if(isset($_GET['nijepostojaosuosnivac'])){?>
              <span id="postoji">Датум уплате је мањи од датума уписа у АПР!</span>
        <?php } ?>
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
                  <th scope="col" hidden></th>
                  <th scope="col">Назив</th>
                  <th scope="col">Датум АПР</th>
                  <!-- <th scope="col">Истиче <?=$proslaGodina?></th> 
                  <th scope="col">Плаћено <?=$proslaGodina?></th> -->
                  <th scope="col">Истиче <?=$godina?></th>   
                  <th scope="col">Плаћено <?=$godina?></th>
                  <th scope="col">Истиче <?=$sledecaGodina?></th> 
                  <th scope="col"></th> 
                        
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($suosnivaci as $s){ 
                $ids = $s->id;
                $napomena = $s->napomena;

              $trenutna_godina = Uplate::getUplateTrenutnaGodina($ids);
              $prethodna_godina = Uplate::getUplatePrethodnaGodina($ids);
              $istekloProsleGod = Istice::getIstekloProsleGodine($ids); 
              $isticeOveGod = Istice::getIsticeOveGodine($ids);
              $isticeSledeceGod = Istice::getIsticeSledeceGodine($ids);
              $poslednjaUplata = Uplate::getPoslednju($ids);
              $istice2017 = Istice::getIstice2017($ids);


              $isticePoslednje = Istice::getPoslednje($ids);
              $danas = time();
              if(isset($isticePoslednje)){
                $istek = strtotime($isticePoslednje->datum);
                $razlika = ceil(($danas - $istek)/60/60/24);
            }else{
              $razlika = 0;
            }


                ?>
               <tr>
<!-- redni broj --><td scope="col"><?php echo $redni_broj;?></td>
                    <td hidden><?=$razlika?></td>

<!-- naziv -->  <?php if($napomena != null){ ?>
                <td id="<?=$s->id?>" ><?=$s->naziv?> - <b><span style="color: red">НАПОМЕНА</span></b></td>
                <?php }else {?>
                <td id="<?=$s->id?>" ><?=$s->naziv?></td>
                <?php } ?>
                <?php if($s->datum_apr != '0000-00-00 00:00:00' && $s->datum_apr != null){ ?>
<!-- datum apr --><td><?=date('d.m.Y', strtotime($s->datum_apr));?></td>
                <?php } else {echo '<td></td>';}?>
                

               
                 <?php if($isticeOveGod != null){ ?>
<!-- istice ove godine --><td><?=date('d.m.Y', strtotime($isticeOveGod->datum));?></td>
                <?php } else {echo '<td></td>';}?>
          
                 <?php if($trenutna_godina != null){ ?>
<!-- placeno ove godine --><td><?=date('d.m.Y', strtotime($trenutna_godina->datum));?></td>
                <?php } else {echo '<td></td>';}?>
                
                 <?php if($isticeSledeceGod != null){ ?>
<!-- istice sledece godine --><td><?=date('d.m.Y', strtotime($isticeSledeceGod->datum));?></td> 
                <?php } else {echo '<td></td>';}?>


<?php $godinaApr = date('Y', strtotime($s->datum_apr)) ?>

<?php 
if($s->datum_apr == null){?>
  <td></td>

<?php 
}else{ 

  if($godinaApr < $godina - 1 && $istekloProsleGod == null){?>
    <td><button type="submit" class="btn btn-secondary mb-1 unesi_isticanje" data-toggle="modal" data-target="#smallmodal_isticanje_prosle" id="<?=$s->id?>">Истекло 2017. год.</button></td>

  <?php }else if ($godinaApr < $godina - 1 && $prethodna_godina == null || $godinaApr == $godina - 1 && $prethodna_godina == null){?>
    <td><button type="submit" class="btn btn-secondary mb-1 unesi_uplatu_prosle" data-toggle="modal" data-target="#smallmodal_uplata_prosla" id="<?=$s->id?>">Уплата за <?=$godina-1?>. год.</button></td>

 <?php }else if($godinaApr < $godina - 1 && $trenutna_godina == null || $godinaApr == $godina - 1 && $trenutna_godina == null || $godinaApr == $godina && $trenutna_godina == null){ ?>
      <td><button type="submit" class="btn btn-secondary mb-1 unesi_uplatu_ove" data-toggle="modal" data-target="#smallmodal_uplata_ove" id="<?=$s->id?>">Уплата за <?=$godina?>. год.</button></td>
  <?php }else{ ?>
      <td><button type="submit" class="btn btn-secondary mb-1 unesi_uplatu_sledece" data-toggle="modal" data-target="#smallmodal_uplata_sledece" id="<?=$s->id?>">Уплата за <?=$poslednjaUplata->za_godinu+1?>. год.</button></td>
  <?php }
    
  }?>
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

<!-- MODAL ZA ISTICANJE -->
<div class="modal fade" id="smallmodal_isticanje_prosle" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel_isticanje_prosle"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                              <form action="inc/isteklo_prosle.php" method="post">
                                
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac_istek_prosle" id="id_suosnivac_istek_prosle" value="">
                                  <label for="datum_uplate_istek_prosle" class="control-label mb-1">Датум истицања 2017. године:</label>
                                  <input id="datum_uplate_istek_prosle" name="datum_uplate_istek_prosle" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                               
                                <button type="submit" class="btn btn-primary" id="unesi_isticanje" name="unesi_isticanje" onClick="this.form.submit(); this.disabled=true;">Унеси</button>
                           </form>
                            </div>
                        </div>
                    </div>
                </div>

  <!-- END MODAL ZA ISTICANJE -->

  <!-- MODAL UPLATA PROSLE -->
<div class="modal fade" id="smallmodal_uplata_prosla" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel_uplata_prosla"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">                               
                              <form action="inc/uplata_prosla_godina.php" method="post">                               
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac_uplata_prosla" id="id_suosnivac_uplata_prosla" value="">
                                  <label for="datum_uplate_prosla" class="control-label mb-1">Датум уплате за <?=$godina-1?> годину</label>
                                  <input id="datum_uplate_prosla" name="datum_uplate_prosla" type="text" class="form-control">
                                </div>                             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>                  
                                <button type="submit" class="btn btn-primary" id="unesi_uplatu_prosle" name="unesi_uplatu_prosle" onClick="this.form.submit(); this.disabled=true;">Унеси</button>
                           </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- END MODAL UPLATA PROSLE -->

  <!-- MODAL UPLATA OVE GODINE-->
<div class="modal fade" id="smallmodal_uplata_ove" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel_uplata_ove"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">                               
                              <form action="inc/uplata_ova_godina.php" method="post">                               
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac_uplata_ove" id="id_suosnivac_uplata_ove" value="">
                                  <label for="datum_uplate_ove" class="control-label mb-1">Датум уплате за <?=$godina?>:</label>
                                  <input id="datum_uplate_ove" name="datum_uplate_ove" type="text" class="form-control">
                                </div>                             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>                  
                                <button type="submit" class="btn btn-primary" id="unesi_uplatu_ove" name="unesi_uplatu_ove" onClick="this.form.submit(); this.disabled=true;">Унеси</button>
                           </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- END MODAL UPLATA OVE GODINE-->

 <!-- MODAL UPLATA SLEDECA GODINA-->
<div class="modal fade" id="smallmodal_uplata_sledece" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel_uplata_sledece"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">                               
                              <form action="inc/uplata_sledece_godine.php" method="post">                               
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac_uplata_sledece" id="id_suosnivac_uplata_sledece" value="">
                                  <label for="datum_uplate_sledece" class="control-label mb-1">Датум уплате за <?=$godina+1?>:</label>
                                  <input id="datum_uplate_sledece" name="datum_uplate_sledece" type="text" class="form-control">
                                </div>                             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>                  
                                <button type="submit" class="btn btn-primary" id="unesi_uplatu_sledece" name="unesi_uplatu_sledece" onClick="this.form.submit(); this.disabled=true;">Унеси</button>
                           </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- END MODAL UPLATA SLEDECA GODINAA-->


<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){

//isteklo prosle
    $("#bootstrap-data-table").on('click','.unesi_isticanje', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac_istek_prosle').val(ids);
      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel_isticanje_prosle').text('Унеси истицање: '+data);   
        }
      });
    });


//uplata prosle godine
$("#bootstrap-data-table").on('click','.unesi_uplatu_prosle', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac_uplata_prosla').val(ids);
      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel_uplata_prosla').text('Унеси уплату: '+data);   
        }
      });
    });

//uplata ove godine
$("#bootstrap-data-table").on('click','.unesi_uplatu_ove', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac_uplata_ove').val(ids);
      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel_uplata_ove').text('Унеси уплату: '+data);   
        }
      });
    });

//uplata sledece godine
$("#bootstrap-data-table").on('click','.unesi_uplatu_sledece', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac_uplata_sledece').val(ids);
      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel_uplata_sledece').text('Унеси уплату: '+data);   
        }
      });
    });


     setTimeout(function(){
       if($('#success_uplata').length > 0){
        $('#success_uplata').remove();
      }else if($('#error_uplata').length > 0){
        $('#error_uplata').remove();
      }
    },3000);

  });
</script>