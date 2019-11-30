<?php  
include 'inc/header.inc.php';
include 'inc/sidebar.inc.php'; 

require_once __DIR__.'/klase/Tabela.php';
require_once __DIR__.'/klase/Suosnivac.php';
require_once __DIR__.'/klase/Uplate.php';
require_once __DIR__.'/klase/Istice.php';
require_once __DIR__.'/klase/Racuni.php';

$racuni = Racuni::getAllRacune();
?>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="col-lg-12 tabela">
        <div class="card">
          <div class="card-header">
              <strong class="card-title">Издати рачуни</strong>
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
                  <th scope="col">Датум креирања рачуна</th>
                  <th scope="col">Послат дана</th>  
                  <th scope="col">Рачун</th>                
                </tr>
              </thead>
              <tbody>
                <?php 
                $rb = 1;
                foreach ($racuni as $rac) {
                $suosnivac = Suosnivac::getSuosnivac($rac->id_suosnivac);
                $datum_uplate = Uplate::getUplatuPoId($rac->id_uplate)->datum;
                $urlrac = explode('/',trim($rac->generisan_url));
                $url = $urlrac[1];
                 ?>
                <tr>
                  <td scope="col"><?=$rb?></td>
                  <td scope="col"><?=$suosnivac->naziv?></td> 
                  <td scope="col"><?=date('d.m.Y.', strtotime($datum_uplate))?></td>
                  <td scope="col"><?=date('d.m.Y.', strtotime($rac->datum_slanja))?></td>  
                  <td scope="col"><a target="_blank" href='/inc/racuni/<?=$url?>'><?=$url?></a></td>
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
                          url:"inc/filter_racuni.php",  
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