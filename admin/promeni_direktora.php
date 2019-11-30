    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Direktor.php';

    $direktor = Direktor::getAll();
    foreach ($direktor as $dir) {
      $id = $dir->id;
      $direktor_ime = $dir->ime_prezime;
      $funkcija = $dir->funkcija;
    }

    ?> 

  

<form action="inc/promena_direktor.php" method="post">
            <div class="row">
                  <div class="col-lg-12">
                    <div class="card">                    
                      <div class="card-header"><strong>Подаци о директору</strong></div>
                      <div class="card-body card-block">
                          <!-- pravno lice ili preduzetnik -->
                              <div class="card-body">
                                <div class="col-6">
                                      <div class="form-group">
                                          <label for="ime_prezime" class="control-label mb-1">Тренутни директор:</label>
                                          <input id="ids" name="ids" type="text" class="form-control" value="<?=$id?>" hidden>
                                          <input id="ime_prezime" name="ime_prezime" type="text" class="form-control" value="<?=$direktor_ime?>" disabled>
                                      </div>
                                      <div class="form-group">
                                          <label for="funkcija" class="control-label mb-1">Функција:</label>
                                          <input id="ids" name="ids" type="text" class="form-control" value="<?=$id?>" hidden>
                                          <input id="funkcija" name="funkcija" type="text" class="form-control" value="<?=$funkcija?>" disabled>
                                      </div>
                                    </div>



                                 <div class="col-6">
                                      <div class="form-group">
                                          <label for="novo_ime" class="control-label mb-1">Нови директор:</label>
                                          <input id="novo_ime" name="novo_ime" type="text" class="form-control" value="">
                                      </div>
                                      <div class="form-group">
                                          <label for="nova_funkcija" class="control-label mb-1">Нова функција:</label>
                                          <input id="nova_funkcija" name="nova_funkcija" type="text" class="form-control" value="">
                                      </div>
                                    </div>
                                       
   
                                      </div>

                                      <div>
                                          <button id="<?=$id?>" type="submit" class="btn btn-lg btn-info btn-block izmeni-btn" name="submit">
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
             </div> 




<?php include 'inc/footer.inc.php'; ?> 