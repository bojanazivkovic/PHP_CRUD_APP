    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Suosnivac.php';
    require_once __DIR__.'/../klase/Predstavnik.php';

    $suosnivaci = Suosnivac::getAll();
    
    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Промени овлашћено лице</h1> 
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
      <div class="animated fadeIn">
        
        <div class="col-lg-12">
          <div class="card">
          <div class="card-header">
            <strong class="card-title"></strong>
              <?php if(isset($_GET['success'])) {?>
              <span id="success">Успешна промена овлашћења!</span>
              <?php } 
              if(isset($_GET['postoji'])) {?>
              <span id="unos">Већ постоји <?=$_GET['postoji']?> представника са истим именом и презименом!!! (<?=$_GET['ime']?>)</span>
              <?php }?>
            </div>
          <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  <th scope="col">Матични број</th>
                  <th scope="col">Место</th>
                  <th scope="col">Овлашћени представник</th>
                  <th scope="col"></th>
                  
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($suosnivaci as $s){ 
                $id = $s->id;
                $predstavnik = Predstavnik::getPredstavnik($id);
                ?> 
               
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$s->naziv?></td>
                <td><?=$s->maticni?></td>
                <td><?=$s->mesto?></td>
                <td><?=$predstavnik->ime_prezime?></td>
                <td><button type="submit" class="izmeni" name="submit" id='<?= $s->id ?>'>Измени</button></td>
                
              </tr>
              
              <?php $redni_broj++;}?>
            </tbody>
          </table>
          <div id="podaci"></div>
        </div>
      </div>
    </div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->
<script type="text/javascript">

  $(document).ready(function(){

    $("#bootstrap-data-table").on('click','.izmeni', function(){
      var ids = $(this).attr("id");
              //console.log(ids);
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/promena_ovlascenog.php',
                data: {id : ids},
                success: function(data) {
                  $("#podaci").html(data);
                  
                  $('.page-title h1').html('<a href="ovlasceni_izmena.php"><i class="fa fa-hand-o-left"></i> назад</a>');
                    //console.log(idSU);
                  }
                });
              $('#bootstrap-data-table_wrapper').hide();
            });

  });



  $(document).ready(function(){

      setTimeout(function(){
       if($('#success').length > 0){
        $('#success').remove();
      }

    },3000);
    });


</script>


    
<?php include 'inc/footer.inc.php'; ?> 