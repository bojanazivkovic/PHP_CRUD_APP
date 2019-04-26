    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';

    $suosnivaci = Suosnivac::getAll();

    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Нова уплата</h1> 
            
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        
              <?php if(isset($_GET['error'])){?>
              <span id="error_uplata">Уплата није унета. Дошло је до грешке!</span>
              <?php } ?>
         
        
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
                  <th scope="col">Матични број</th>
                  <th scope="col">Датум приступања</th>
                  <th scope="col">Датум АПР</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($suosnivaci as $s){ ?> 
               
               <tr>
                <th scope="col"><?php echo $redni_broj;?></th>
                <td><?=$s->naziv?></td>
                <td><?=$s->maticni?></td>
                <td><?=date('d.m.Y', strtotime($s->datum_potpisivanja));?></td>
                <td><?=date('d.m.Y', strtotime($s->datum_apr));?></td>
                <td><button type="submit" class="btn btn-secondary mb-1 uplata" data-toggle="modal" data-target="#smallmodal" id="<?=$s->id?>">Уплата</button></td>
              </tr>
              
              <?php $redni_broj++;}?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->

<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                              <form action="inc/nova_uplata.php" method="post">
                                <div class="col-4">
                                <div class="form-group">
                                  <input type="hidden" name="id_suosnivac" id="id_suosnivac" value="">
                                  <label for="datum_uplate" class="control-label mb-1">Датум уплате:</label>
                                  <input id="datum_uplate" name="datum_uplate" type="date" class="form-control">
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="form-group">
                                  <label for="iznos" class="control-label mb-1">Износ:</label>
                                  <input id="iznos" name="iznos" type="text" class="form-control">
                                </div>
                              </div>
                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                               
                                <button type="submit" class="btn btn-primary" id="unesi_uplatu" name="unesi_uplatu"  onClick="this.form.submit(); this.disabled=true;">Унеси</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){

    $("#bootstrap-data-table").on('click','.uplata', function(e){
      e.preventDefault();
      var ids = $(this).attr('id');
      $('#id_suosnivac').val(ids);
      
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/getName.php',
        data: {id:ids},

        success: function(data){
           $('#smallmodalLabel').text('Нова уплата за: '+data);
        }
      });

    });


     setTimeout(function(){
       if($('#success_uplata').length > 0){
        $('#success_uplata').remove();
      }else if($('#error_uplata').length > 0){
        $('#error_uplata').remove();
      }
    },3000);



  });
</script>