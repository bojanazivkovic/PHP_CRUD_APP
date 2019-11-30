    <?php 
    require_once __DIR__.'/../../klase/Suosnivac.php';
    require_once __DIR__.'/../../klase/Predstavnik.php';
    $ids = $_POST['id'];
    $s = Suosnivac::getSuosnivac($ids);
    $p = Predstavnik::getPredstavnik($ids);
    $staro_ovlascenje = $s->ovlascenje;
    
    
    ?> 
<form action="inc/promeni_ovlascenog.php" method="post" enctype="multipart/form-data">
            <div class="row">
                  <div class="col-lg-12">
                    <div class="card">                    
                      <div class="card-header"><strong>Подаци о овлашћеном представнику</strong></div>
                      <div class="card-body card-block">
                          <!-- pravno lice ili preduzetnik -->
                              <div class="card-body">
                                 <div class="col-4">
                                      <div class="form-group">
                                          <label for="ime_prezime" class="control-label mb-1">Име и презиме:</label>
                                          <input id="ids" name="ids" type="hidden" value="<?php echo $ids;?>">
                                          <input id="staro_ime" name="staro_ime" type="hidden" value="<?=$p->ime_prezime?>">
                                          <input id="ime_prezime" name="ime_prezime" type="text" class="form-control" value="<?=$p->ime_prezime?>">
                                      </div></div>
                                       <div class="col-4">
                                      <div class="form-group">
                                          <label for="mobilni" class="control-label mb-1">Број мобилног телефона:</label>
                                          <input id="stari_mobilni" name="stari_mobilni" type="hidden" value="<?=$p->mobilni?>">
                                          <input id="mobilni" name="mobilni" type="text" class="form-control" data-val="true"  value="<?=$p->mobilni?>">
                                          
                                      </div></div>
                                      
                                           <div class="col-4">
                                              <div class="form-group">
                                                  <label for="email" class="control-label mb-1">Емаил адреса:</label>
                                                  <input id="stari_email" name="stari_email" type="hidden" value="<?=$p->email?>">
                                                  <input id="email" name="email" type="text" class="form-control" value="<?=$p->email?>">
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="staro_ovlascenje" class="control-label mb-1">Старо овлашћење:</label>
                                                  <input id="staro_ovlascenje" name="staro_ovlascenje" type="hidden" value="<?php echo $staro_ovlascenje;?>">
                                                  <br><a href="../<?=$s->ovlascenje?>" target="_blank" id="staro_ovlascenje"><?=$s->ovlascenje?></a>
                                              </div>
                                          </div>

                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="novo_ovlascenje" class="control-label mb-1">Изабери ново овлашћење:</label>
                                                  <input id="novo_ovlascenje" name="novo_ovlascenje" type="file" class="form-control">
                                              </div>
                                          </div>


                                      </div>

                                      <div>
                                          <button id="<?=$p->id_suosnivac?>" type="submit" class="btn btn-lg btn-info btn-block izmeni-btn" name="submit">
                                              <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                                              <span id="izmena-btn">Измени</span>
                                              <span id="izmena-btn-sending" style="display:none;">Измена...</span>
                                          </button>
                                      </div>
                                  </form>
                              </div>
                    </div>
                  </div>
            </div>
             </div> <!-- /row -->

<!-- <script type="text/javascript">

    $(document).ready(function(){

      $(".izmeni-btn").click(function(){
              var ids = $(this).attr("id");
              var imep = $('#ime_prezime').val();
              var mob = $('#mobilni').val();
              var em = $('#email').val();
              var novo_ovl = $('#novo_ovlascenje').val();
              console.log(novo_ovl);
              
              var s_ime = $('#staro_ime').val();
              var s_mobilni = $('#stari_mobilni').val();
              var s_email = $('#stari_email').val();
              var staro_ovl = $().attr('href');
              console.log(staro_ovl);

              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/promeni_ovlascenog.php',
                data: {
                  id : ids,
                  ime_prezime : imep,
                  mobilni : mob,
                  email : em
                },
                success: function(data){
                  window.location = 'ovlasceni_izmena.php';
                  }
            });
            
      });


  });

    </script> -->