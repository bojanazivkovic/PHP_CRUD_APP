    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Clanarina.php';

    $iznos = Clanarina::getClanarinu()->iznos;
    $idc = Clanarina::getClanarinu()->id;
    
    ?> 

<form action="inc/promena_clanarine.php" method="post">
            <div class="row">
                  <div class="col-lg-12">
                    <div class="card">                    
                      <div class="card-header"><strong>Износ чланарине</strong></div>
                      <div class="card-body card-block">
                          <!-- pravno lice ili preduzetnik -->
                              <div class="card-body">
                                <div class="col-4">
                                      <div class="form-group">
                                          <label for="iznos" class="control-label mb-1">Тренутни износ:</label>
                                          <input id="idc" name="idc" type="text" class="form-control" value="<?=$idc?>" hidden>
                                          <input id="iznos" name="iznos" type="text" class="form-control" value="<?=$iznos?>" disabled>
                                      </div>
                                    </div>



                                 <div class="col-4">
                                      <div class="form-group">
                                          <label for="novi_iznos" class="control-label mb-1">Нови износ:</label>
                                          <input id="novi_iznos" name="novi_iznos" type="text" class="form-control" value="">
                                      </div>
                                    </div>
                                       
   
                                      </div>

                                      <div>
                                          <button id="<?=$idc?>" type="submit" class="btn btn-lg btn-info btn-block izmeni-btn" name="submit">
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