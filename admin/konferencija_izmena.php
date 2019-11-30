    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Suosnivac.php';
    require_once __DIR__.'/../klase/Predstavnik.php';
    require_once __DIR__.'/../klase/Uplate.php';
    require_once __DIR__.'/../klase/Istice.php';
    require_once __DIR__.'/../klase/Glasanje.php';
    require_once __DIR__.'/../klase/Konferencija.php';

    $sve_konferencije = Konferencija::getSve();
    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Конференције - измена</h1> 
            
          </div>
        </div>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-4"></div>


    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12 tabela">
          <div class="card">

            <div class="card-header">
              <strong class="card-title">Измена конференције</strong>
              <?php if(isset($_GET['success'])) {?>
              <span id="success">Успешно измењена конференција!</span>
              <?php }?>
              
            </div>
                  
        <form action="inc/izmena_konferencije.php" method="post">

          <div class="card-header" style="display:none; background-color: #F0EEEE">

            <div class="row">

              <div class="col-lg-6">
                <div class="form-group">
                  <input id="idkonf" name="idkonf" value="" hidden>
                      <label for="konferencija" class="control-label mb-1">Конференција:</label>
                      <input id="konferencija" name="konferencija" type="text" class="form-control" value="">
                </div>
              </div>

                <div class="col-lg-3">
                  <div class="form-group">
                      <label for="datum" class="control-label mb-1">Датум:</label>
                      <input id="datum" name="datum" type="text" class="form-control" value="">
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                      <label for="vreme" class="control-label mb-1">Време:</label>
                      <input id="vreme" name="vreme" type="text" class="form-control" value="">
                  </div>
                </div>

            </div>

              

          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                      <label for="organizator" class="control-label mb-1">Организатор:</label>
                      <input id="organizator" name="organizator" type="text" class="form-control" value="">
                </div>
              </div>

             <div class="col-lg-6">
                <div class="form-group">
                      <label for="lokacija" class="control-label mb-1">Локација:</label>
                      <input id="lokacija" name="lokacija" type="text" class="form-control" value="">
                </div>
              </div>
          </div>
                    <button id="unesi-btn" type="submit" class="btn btn-lg btn-info btn-block">
                      <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                      <span id="unesi-btn">Измени</span>
                    </button>

                
            </form>
          </div>

          <div class="card-body">
             <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Конференција</th>
                  <th scope="col">Датум</th>
                  <th scope="col">Време</th>
                  <th scope="col">Организатор</th>
                  <th scope="col">Локација</th>
                  <th scope="col"></th>   
                  <th hidden></th>               
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($sve_konferencije as $sve_konf){ 
                
              ?>              
               <tr>
                <td scope="col"><?php echo $redni_broj;?></td>
                <td id="<?=$sve_konf->id?>" ><?=$sve_konf->naziv?></td>
                <td><?=date('d.m.Y', strtotime($sve_konf->datum));?></td>
                <td><?=$sve_konf->vreme;?></td>
                <td><?=$sve_konf->organizator;?></td>
                <td><?=$sve_konf->lokacija?></td>
                <td hidden><?=$sve_konf->id?></td>
               
                <td>              
                  <button type="submit" class="dugme-otvori" name="submit" id='<?=$sve_konf->id?>'>Измени</button>
                </td>                
              </tr>            
              <?php $redni_broj++;}?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- col-lg-12 -->


  </div>
</div> <!--content mt-3-->

</div><!-- right -->

  
<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){

    $("#minus").click(function(){
      $(".card-header").toggle();
    });

    $(".dugme-otvori").click(function(e){
      e.preventDefault();
      var idk = $(this).attr('id');
      $(".card-header").show();

        $(this).parent().parent().each(function() {
          if (!this.rowIndex) return;

          var id = $(this).find("td").eq(6).html();
          if(idk === id){
            var naziv = $(this).find("td").eq(1).html();
            var datum = $(this).find("td").eq(2).html();  
            var vreme = $(this).find("td").eq(3).html();  
            var organizator = $(this).find("td").eq(4).html(); 
            var lokacija = $(this).find("td").eq(5).html();  
            
            $("#idkonf").val(id);
            $("#konferencija").val(naziv);
            $("#datum").val(datum);
            $("#vreme").val(vreme);
            $("#organizator").val(organizator);
            $("#lokacija").val(lokacija);
          }

        }); 

        
        
    });


    setTimeout(function(){
       if($('#success').length > 0){
        $('#success').remove();
      }

    },3000);

  });
  
</script>