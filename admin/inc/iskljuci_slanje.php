    <?php 
    require_once __DIR__.'/../../klase/Suosnivac.php';
    require_once __DIR__.'/../../klase/Predracuni.php';
    require_once __DIR__.'/../../klase/Istice.php';
    
    $ids=$_POST['id'];
    
    $s = Suosnivac::getSuosnivac($ids);
    $predracuni = Predracuni::getPoslednjiPredracunPoUplati($ids);
    //print_r($predracuni);die();

    
foreach ($predracuni as $pred) {

  $poslat = $pred->poslat;
  $id_predracuna = $pred->id;
  $id_uplate = $pred->id_uplate;
  $poslat_15_pre =  $pred->poslat_petnaest_dana_pre;
  $poslat_1_pre = $pred->poslat_dan_pre;
  $poslat_1_posle =$pred->poslat_dan_posle;
  $poslat_15_posle =$pred->poslat_petnaest_posle;
  $poslat_1_pre_brisanja =$pred->poslat_mesec_posle;

}

if(isset($poslat)){

    ?> 
<form action="inc/iskljuci_slanje_predracuna.php" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Искључи слање рачуна за <?=$s->naziv?></strong>
                            
                        </div>
                        <div class="card-body card-block">
                          
                              <div class="card-body">
                                  <div class="col-6">
                                    <input name="suosnivac_id" type="text" value="<?=$ids?>" hidden>
                                    <input name="predracun_id" type="text" value="<?=$id_predracuna?>" hidden>
                                    <input name="uplata_id" type="text" value="<?=$id_uplate?>" hidden>
                                        
                                        <input type="checkbox" class="<?=$poslat_15_pre?>" name="slanje[]" value="petnaest_pre"> Слање 15 дана пре истека<br>                                        
                                        <input type="checkbox" class="<?=$poslat_1_pre?>" name="slanje[]" value="dan_pre"> Слање дан пре истека<br>
                                        <input type="checkbox" class="<?=$poslat_1_posle?>" name="slanje[]" value="dan_posle"> Слање дан после истека<br>
                                        <input type="checkbox" class="<?=$poslat_15_posle?>" name="slanje[]" value="petnaest_posle"> Слање 15 дана после истека<br>
                                        <input type="checkbox" class="<?=$poslat_1_pre_brisanja?>" name="slanje[]" value="dan_pre_brisanja"> Слање дан пре брисања суоснивача<br><br>
                                        <input type="submit" name="dugme" value="Искључи">
                                  </div>
                                 
                                      <div>  
                                                                            
                                  </div>                                 
                              </div>
                        </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
            </div>
      
            </div>

             </div> <!-- /row -->
</form>
<?php
}else{
  echo 'Нема генерисаног предрачуна за слање';
}
?>

<script>
  $(document).ready(function(){

    $.each($(':checkbox'), function(){
      //console.log($(this).attr('class'));
      if($(this).hasClass('1')){
        $(this).attr("checked","checked");
        $(this).attr("disabled","disabled");
      }
      
    });

  });

</script>