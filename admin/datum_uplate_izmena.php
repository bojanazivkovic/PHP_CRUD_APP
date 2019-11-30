    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/../klase/Suosnivac.php';
    require_once __DIR__.'/../klase/Uplate.php';

    $suosnivaci = Suosnivac::getAll();
    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Измени датум уплате</h1> 
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
          <!-- <div class="card-header">
            <strong class="card-title">Суоснивач</strong>
          </div> -->
          <div class="card-body">
             <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  
                  <th scope="col"></th>
                  <!-- <th scope="col"></th> -->
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($suosnivaci as $s){ ?> 
               
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$s->naziv?></td>
                
                <td><button type="submit" class="izmeni_uplate" name="submit" id='<?= $s->id ?>'>Види уплате</button></td>
                <!-- <td><button type="submit" class="obrisi" name="submit" id='<?= $s->id ?>'>Обриши</button></td> -->
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

    $("#bootstrap-data-table").on('click','.izmeni_uplate', function(){
      var ids = $(this).attr("id");
              //console.log(ids);
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/izmeni_uplate.php',
                data: {id : ids},
                success: function(data) {
                  $("#podaci").html(data);
                  
                  $('.page-title h1').html('<a href="datum_uplate_izmena.php"><i class="fa fa-hand-o-left"></i> назад</a>');
                    //console.log(idSU);
                  }
                });
              $('#bootstrap-data-table_wrapper').hide();
            });

  });

</script>

<?php include 'inc/footer.inc.php'; ?> 