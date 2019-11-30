    <?php 
    require_once __DIR__.'/../../klase/Suosnivac.php';
    require_once __DIR__.'/../../klase/Uplate.php';
    $ids = $_POST['id'];
    //echo $ids;
    //die();
    $s = Suosnivac::getSuosnivac($ids);
    $uplate = Uplate::getUplatu($ids);
    ?> 

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Све уплате суоснивача: <?=$s->naziv?></strong>
                            
                        </div>
                        <div class="card-body card-block">
                          <!-- pravno lice ili preduzetnik -->
                              <div class="card-body">
                                <table class="table">
                                  <tr>
                                      <td>Датум уплате:</td>
                                      <td>Уплата за:</td>
                                      <td></td>
                                      <td></td>
                                    </tr>
                                  <?php foreach ($uplate as $u) { ?>   
                                    
                                     <tr>
                                     <td  id="podaci_<?=$u->id?>">
                                       <?=date('d.m.Y.', strtotime($u->datum))?>
                                     </td> 
                                     <td>
                                       <?=$u->za_godinu?>
                                     </td> 
                                     <td class="nestani_<?=$u->id?>"><button id="<?=$u->id?>" class="btn_izmeni" name="izmeni_<?=$u->id?>" type="submit">Измени</button></td> 
                                     <td class="pojavi_se" id="pojavi_se_<?=$u->id?>"></td> 
                                     <td><button id="<?=$u->id?>" class="btn_obrisi" name="obrisi_<?=$u->id?>" type="submit">Обриши</button></td> 
                                     
                                      </tr>    
                                   <?php } ?>    
                                    
                                  </table>
                                      <div>                                        
                                  </div>                                 
                              </div>
                        </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
            </div> <!-- /row -->
<script>
  $(document).ready(function(){

    $('.table').on('click', '.btn_izmeni', function(e){
      e.preventDefault();
       var id_uplate = $(this).attr('id');
       //console.log(id_uplate);

      $('.nestani_'+id_uplate).hide();
      $('#pojavi_se_'+id_uplate).html('<td id="novi">унеси нови датум: <input type="text" id="novi_datum"></td><td id="novi_btn"><button class="snimi">Сними</button></td>');
      $('.snimi').attr("id", id_uplate);
      
    });

    $('.pojavi_se').on('click', '.snimi', function(e){
      e.preventDefault();
    
      var id = $(this).attr('id');
      //console.log(id);
      var novi_datum = $('#novi_datum').val();
      //console.log(novi_datum);

      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/izmena_datuma_uplate.php',
        data: {
          idu : id,
          nd : novi_datum
        },


        success: function(data){
          location.reload();
          //console.log(data)
          //$('#podaci_'+id).load(document.URL + ' #podaci_'+id);
          //$('#pojavi_se_'+id).hide();
          //$('.nestani_'+id).show();
        }
      });
      
    });



    $('.table').on('click', '.btn_obrisi', function(e){
      e.preventDefault();
       var id_uplate = $(this).attr('id');
       //console.log(id_uplate);

      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/brisanje_datuma_uplate.php',
        data: {
          id : id_uplate
        },
        success: function(data){
          location.reload();
        }
      });
      
    });


  });
</script>