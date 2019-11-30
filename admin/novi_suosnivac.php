    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 
    ?> 
    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Унос новог суоснивача</h1> 
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="page-header float-right">
          <div class="page-title">
            <ol class="breadcrumb text-right">
              <!-- <li class="active">Dashboard</li> -->
            </ol>
          </div>
        </div>
      </div>
    </div>


    <div class="content mt-3">    

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <strong class="card-title">Подаци о правном лицу или предузетнику:</strong>
              <?php if(isset($_GET['success'])) {?>
              <span id="success">Успешно унет нови суоснивач!</span>
              <?php }
              else if(isset($_GET['unos'])) {?>
              <span id="unos">Морате унети назив суоснивача!</span>
              <?php }
              if(isset($_GET['postoji'])) {?>
              <span id="unos">Већ постоји <?=$_GET['postoji']?> представника са истим именом и презименом!!! (<?=$_GET['ime']?>)</span>
              <?php }?>
            </div>
            <div class="card-body card-block">
              <!-- pravno lice ili preduzetnik -->
              <div class="card-body">

                <form action="inc/novi.php" method="post" enctype="multipart/form-data">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="naziv" class="control-label mb-1">Пословни назив:</label>
                      <input id="naziv" name="naziv" type="text" class="form-control" placeholder="Унеси пословни назив">
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="adresa" class="control-label mb-1">Адреса седишта:</label>
                      <input id="adresa" name="adresa" type="text" class="form-control" placeholder="Унеси адресу">
                    </div>
                  </div>
                  
                  <div class="col-3">
                    <div class="form-group">
                      <label for="postanski_broj" class="control-label mb-1">Поштански број:</label>
                      <input id="postanski_broj" name="postanski_broj" type="text" class="form-control" placeholder="Унеси поштански број">
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="mesto" class="control-label mb-1">Град:</label>
                      <input id="mesto" name="mesto" type="text" class="form-control" placeholder="Унеси град">
                    </div>
                  </div>
                  
                  <div class="col-4">
                    <div class="form-group">
                      <label for="pak" class="control-label mb-1">ПАК:</label>
                      <input id="pak" name="pak" type="text" class="form-control" placeholder="Унеси ПАК">
                    </div>
                  </div>
                  
                  <div class="col-4">
                    <div class="form-group">
                      <label for="maticni_broj" class="control-label mb-1">Матични број:</label>
                      <input id="maticni_broj" name="maticni_broj" type="text" class="form-control" placeholder="Унеси матични број">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="pib" class="control-label mb-1">ПИБ:</label>
                      <input id="pib" name="pib" type="text" class="form-control" placeholder="Унеси ПИБ">
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="datum_potpisivanja">Датум потписивања:</label>
                      <input id="datum_potpisivanja" name="datum_potpisivanja" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="datum_apr" class="control-label mb-1">Датум АПР:</label>
                      <input id="datum_apr" name="datum_apr" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="napomena" class="control-label mb-1"><b>Напомена:</b></label>
                      <input id="napomena" name="napomena" type="text" class="form-control">
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
              <div class="card-header"><strong>Подаци о овлашћеном представнику</strong></div>
              <div class="card-body card-block">
                <!-- pravno lice ili preduzetnik -->
                <div class="card-body">
                 <div class="col-4">
                  <div class="form-group">
                    <label for="ime_prezime" class="control-label mb-1">Име и презиме:</label>
                    <input id="ime_prezime" name="ime_prezime" type="text" class="form-control" placeholder="Унеси име и презиме">
                  </div></div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="mobilni" class="control-label mb-1">Број мобилног телефона:</label>
                      <input id="mobilni" name="mobilni" type="text" class="form-control" data-val="true"  placeholder="Унеси број мобилног телефона">
                      
                    </div></div>
                    
                    <div class="col-4">
                      <div class="form-group">
                        <label for="email" class="control-label mb-1">Емаил адреса:</label>
                        <input id="email" name="email" type="text" class="form-control" placeholder="Унеси емаил адресу">
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <label for="ugovor">Уговор:</label>
                        <input id="ugovor" name="ugovor" type="file" class="form-control">
                      </div>
                    </div>
                    
                    <div class="col-4">
                      <div class="form-group">
                        <label for="pristupnica">Приступница:</label>
                        <input id="pristupnica" name="pristupnica" type="file" class="form-control">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="ovlascenje">Овлашћење:</label>
                        <input id="ovlascenje" name="ovlascenje" type="file" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div>
                    <button id="unesi-btn" type="submit" class="btn btn-lg btn-info btn-block">
                      <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                      <span id="unesi-btn">Унеси</span>
                      <span id="unesi-btn-sending" style="display:none;">Унос…</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- /row -->
    </div><!-- /content mt-3 -->
    

  </div><!-- right-panel -->

  <script>
    $(document).ready(function(){

      setTimeout(function(){
       if($('#success').length > 0){
        $('#success').remove();
      }

    },3000);
    });

  </script>


  <?php include 'inc/footer.inc.php'; ?> 