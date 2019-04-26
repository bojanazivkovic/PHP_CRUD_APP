<?php  
include 'inc/header.inc.php';
include 'inc/sidebar.inc.php'; 

require_once __DIR__.'/klase/Tabela.php';
require_once __DIR__.'/klase/Suosnivac.php';
require_once __DIR__.'/klase/Uplate.php';
require_once __DIR__.'/klase/Istice.php';
require_once __DIR__.'/klase/Predracuni.php';

$predracuni = Predracuni::getAllPredracune();
?>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="col-lg-12 tabela">
        <div class="card">
          <div class="card-header">
              <strong class="card-title">Издати предрачуни</strong>
          </div>
          <div class="card-body">
            <div class="col-lg-3"><input type="text" name="from_date" id="from_date" placeholder="Од датума" class="form-control" autocomplete="off"/> </div>
            <div class="col-lg-3"><input type="text" name="to_date" id="to_date" placeholder="До датума" class="form-control" autocomplete="off"/> </div>
            <div class="col-lg-3"> <input type="button" name="filter" id="filter" value="Изабери" class="btn btn-info" /></div>
            <div class="col-lg-3"></div>  
          </div>

          <div class="card-body" id="order_table">
            <table class="table table-striped table-bordered" id="tabela_predracuni">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив суоснивача</th> 
                  <th scope="col">Датум креирања предрачуна</th>
                  <th scope="col">Послат дана</th>  
                  <th scope="col">Предрачун</th>                
                </tr>
              </thead>
              <tbody>
                <?php 
                $rb = 1;
                foreach ($predracuni as $pred) {
                $suosnivac = Suosnivac::getSuosnivac($pred->id_suosnivac);
                $urlpredrac = explode('/',trim($pred->generisan_url));
                $url = $urlpredrac[1];
                 ?>
                <tr>
                  <td scope="col"><?=$rb?></td>
                  <td scope="col"><?=$suosnivac->naziv?></td> 
                  <td scope="col"><?=date('d.m.Y.', strtotime($pred->datum_predracuna))?></td>
                  <td scope="col"><?=date('d.m.Y.', strtotime($pred->datum_slanja))?></td>  
                  <td scope="col"><a target="_blank" href='/inc/pdfs/<?=$url?>'><?=$url?></a></td>
                </tr>
                <?php $rb+=1; }  ?>
              </tbody>
            </table>
          </div>
        </div>
    </div> <!-- col-lg-12 tabela -->
  </div>
</div>

<?php include 'inc/footer.inc.php'; ?> 

<script>  
      $(document).ready(function(){
           $.datepicker.setDefaults({  
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                minDate: new Date(2018,8,12)
            });
           
           $(function(){  
                $("#from_date").datepicker();  
                $("#to_date").datepicker();  
           });

           $('#filter').click(function(){  
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val();  
                //console.log(from_date);
                if(from_date != '' && to_date != '')  
                {  
                     $.ajax({  
                          url:"inc/filter_predracuni.php",  
                          method:"POST",  
                          data:{from_date:from_date, to_date:to_date},  
                          success:function(data)  
                          {  
                               $('#order_table').html(data);  
                          }  
                     });  
                }  
                else  
                {  
                     alert("Морате да изаберете датум!");  
                }  
           });  
      });  
 </script>