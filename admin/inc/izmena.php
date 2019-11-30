    <?php 
    require_once __DIR__.'/../../klase/Suosnivac.php';
    require_once __DIR__.'/../../klase/Predstavnik.php';
    $ids=$_POST['id'];
    
    $s = Suosnivac::getSuosnivac($ids);
    $p = Predstavnik::getPredstavnik($ids);
    $format = new Tabela;
    ?> 
<form action="inc/izmeni_podatke.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Подаци о правном лицу или предузетнику:</strong>
                            
                        </div>
                        <div class="card-body card-block">
                          <!-- pravno lice ili preduzetnik -->
                              <div class="card-body">

                                  <div class="col-6">
                                      <div class="form-group">
                                        <input type="hidden" name="ids" id="ids" value="<?=$s->id?>">
                                          <label for="naziv" class="control-label mb-1">Пословни назив:</label>
                                          <input id="naziv" name="naziv" type="text" class="form-control" value="<?=$s->naziv?>" placeholder="Унеси пословни назив">
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="adresa" class="control-label mb-1">Адреса седишта:</label>
                                          <input id="adresa" name="adresa" type="text" class="form-control" value="<?=$s->adresa?>" placeholder="Унеси адресу">
                                      </div>
                                  </div>
                                     
                                          <div class="col-4">
                                            <div class="form-group">
                                              <label for="postanski_broj" class="control-label mb-1">Поштански број:</label>
                                              <input id="postanski_broj" name="postanski_broj" type="text" class="form-control" value="<?=$s->postanski_broj?>" placeholder="Унеси поштански број">
                                            </div>
                                          </div>
                                          <div class="col-4">
                                            <div class="form-group">
                                              <label for="mesto" class="control-label mb-1">Град:</label>
                                              <input id="mesto" name="mesto" type="text" class="form-control" value="<?=$s->mesto?>" placeholder="Унеси град">
                                            </div>
                                          </div>
                                       
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="pak" class="control-label mb-1">ПАК:</label>
                                                  <input id="pak" name="pak" type="text" class="form-control" value="<?=$s->pak?>"placeholder="Унеси ПАК">
                                              </div>
                                          </div>
                                     
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="maticni_broj" class="control-label mb-1">Матични број:</label>
                                                  <input id="maticni_broj" name="maticni_broj" type="text" class="form-control" value="<?=$s->maticni?>" placeholder="Унеси матични број">
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="pib" class="control-label mb-1">ПИБ:</label>
                                                  <input id="pib" name="pib" type="text" class="form-control" value="<?=$s->pib?>" placeholder="Унеси ПИБ">
                                              </div>
                                          </div>

                                          <div class="col-4">
                                              <div class="form-group">
                                                <?php
                                                      if($s->datum_potpisivanja == '0000-00-00 00:00:00'){
                                                        $datpot = '';
                                                      }else{
                                                        $datpot = date('d.m.Y', strtotime($s->datum_potpisivanja));
                                                      }
                                                 ?>
                                                  <label for="datum_potpisivanja">Датум потписивања:</label>
                                                  <input id="stari_datum_potpisivanja" name="stari_datum_potpisivanja" type="text" class="form-control" value="<?=$s->datum_potpisivanja?>" hidden>
                                                  <input id="datum_potpisivanja" name="datum_potpisivanja" type="text" class="form-control" value="<?=$datpot;?>">
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                <?php
                                                      if($s->datum_apr == '0000-00-00 00:00:00'){
                                                        $datapr = '';
                                                      }else{
                                                        $datapr = date('d.m.Y', strtotime($s->datum_apr));
                                                      }
                                                 ?>
                                                  <label for="datum_apr" class="control-label mb-1">Датум АПР:</label>
                                                  <input id="stari_datum_apr" name="stari_datum_apr" type="text" class="form-control" value="<?=$s->datum_apr?>" hidden>
                                                  <input id="datum_apr" name="datum_apr" type="text" class="form-control" value="<?=$datapr?>">
                                              </div>
                                          </div>  
                                           <div class="col-4">
                                              <div class="form-group">
                                                  <label for="pravo_glasa" class="control-label mb-1">Право гласа:</label><br>
                                        
                                                  <input id="provera_glasa" type="text" value="<?=$s->id_glasanje?>" hidden="hidden">

                                                  <input id="1" name="pravo_glasa" type="radio" value="1"> <label for="1" class="control-label mb-1"> Има </label>  

                                                  <input id="2" name="pravo_glasa" type="radio" value="2"> <label for="2" class="control-label mb-1"> Делимично </label> 

                                                  <input id="3" name="pravo_glasa" type="radio" value="3"> <label for="3" class="control-label mb-1"> Нема </label>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="napomena" class="control-label mb-1">Напомена:</label>
                                                  <input id="napomena" name="napomena" type="text" class="form-control" value="<?=$s->napomena?>" placeholder="Унеси напомену">
                                              </div>
                                          </div>


                                      <div>                                        
                                  </div>                                 
                              </div>
                        </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
            </div>


            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body card-block">
                    <div class="card-body">
                      <div class="col-4">
                        <div class="form-group">
                          <label for="stari_ugovor" class="control-label mb-1">Стари уговор:</label>
                          <input id="stari_ugovor" name="stari_ugovor" type="text" class="form-control" value="<?=$s->ugovor?>" hidden>
                          <br><a href="../<?=$s->ugovor?>" target="_blank"><?=$s->ugovor?></a><br><br>
                          <label for="novi_ugovor" class="control-label mb-1">Промени уговор:</label>
                          <input id="novi_ugovor" name="novi_ugovor" type="file" class="form-control">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="stara_pristupnica" class="control-label mb-1">Стара приступница:</label>
                           <input id="stara_pristupnica" name="stara_pristupnica" type="text" class="form-control" value="<?=$s->pristupnica?>" hidden>
                          <br><a href="../<?=$s->pristupnica?>" target="_blank" ><?=$s->pristupnica?></a><br><br>
                          <label for="nova_pristupnica" class="control-label mb-1">Промени приступницу:</label>
                          <input id="nova_pristupnica" name="nova_pristupnica" type="file" class="form-control">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="staro_ovlascenje" class="control-label mb-1">Старо овлашћење:</label>
                          <input id="staro_ovlascenje" name="staro_ovlascenje" type="text" class="form-control" value="<?=$s->ovlascenje?>" hidden>
                          <br><a href="../<?=$s->ovlascenje?>" target="_blank"><?=$s->ovlascenje?></a><br><br>
                          <label for="novo_ovlascenje" class="control-label mb-1">Промени овлашћење:</label>
                          <input id="novo_ovlascenje" name="novo_ovlascenje" type="file" class="form-control">
                        </div>
                      </div>                                              
                    </div>
                  </div>
                </div>
              </div>
            </div>





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
                                          <input id="ime_prezime" name="ime_prezime" type="text" class="form-control" value="<?=$p->ime_prezime?>">
                                      </div></div>
                                       <div class="col-4">
                                      <div class="form-group">
                                          <label for="mobilni" class="control-label mb-1">Број мобилног телефона:</label>
                                          <input id="mobilni" name="mobilni" type="text" class="form-control" data-val="true"  value="<?=$p->mobilni?>">
                                          
                                      </div></div>
                                      
                                           <div class="col-4">
                                              <div class="form-group">
                                                  <label for="email" class="control-label mb-1">Емаил адреса:</label>
                                                  <input id="email" name="email" type="text" class="form-control" value="<?=$p->email?>">
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

                              </div>
                    </div>
                  </div>
            </div>
             </div> <!-- /row -->
</form>
<!-- <script type="text/javascript">

    $(document).ready(function(){

      $(".izmeni-btn").click(function(){
              var ids = $(this).attr("id");
              var naz = $('#naziv').val();
              var adr = $('#adresa').val();
              var mes = $('#mesto').val();
              var p = $('#pak').val();
              var mat = $('#maticni_broj').val();
              var pi = $('#pib').val();
              var datp = $('#datum_potpisivanja').val();
              var datuma = $('#datum_apr').val();
              var glas = $('input[name = pravo_glasa]:checked').val();

              var novi_u = $('#novi_ugovor').val();
              console.log(novi_u);
              //var nova_p = $('#nova_pristupnica')[0].files[0].name;
              //var novo_o = $('#novo_ovlascenje')[0].files[0].name;

              
              var imep = $('#ime_prezime').val();
              var mob = $('#mobilni').val();
              var em = $('#email').val();
              //console.log(naziv);
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/izmeni_podatke.php',
                mimeTypes:"multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                data: {
                  id : ids,
                  naziv : naz,
                  adresa : adr,
                  mesto : mes,
                  pak : p,
                  maticni_broj : mat,
                  pib : pi,
                  datum_potpisivanja : datp,
                  datum_apr : datuma,
                  ugovor : novi_u,
                  //pristupnica : nova_p,
                  //ovlascenje : novo_o,
                  id_glasanje : glas,
                  ime_prezime : imep,
                  mobilni : mob,
                  email : em
                },
                success: function(data){
                  window.location = 'suosnivaci_izmena.php';
                  alert(data);
                  }
            });
            
      });


  });

    </script> -->
