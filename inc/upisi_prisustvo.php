<?php 
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';
require_once __DIR__.'/../klase/Konferencija.php';
require_once __DIR__.'/../klase/Prisustvokonferenciji.php';

$id_konf = $_POST['id'];
$suosnivaci = Suosnivac::getAll();
$sve_konferencije = Konferencija::getKonferencijuPoId($id_konf);
$cirilLatin = new Tabela;            
?>
<div class="row">
   <div class="col-lg-12">
            <div class="card">
            <div class="card-header"><b>Обележити присутне на "<?=$sve_konferencije->naziv?>" одржаној <?=date('d.m.Y', strtotime($sve_konferencije->datum))?>. у <?=$sve_konferencije->lokacija?></b></div>
           <div class="col-lg-6"> 
            <div class="card-body">

          <form method="post" action="inc/prisustvo_upis.php">
              <table class="table table-striped table-bordered table-hover" id="data-table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  <th scope="col"></th> 
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               
               foreach($suosnivaci as $s){ 
                $ids = $s->id;
                $sva_prisustva = Prisustvokonferenciji::getPrisustvokonferenciji($id_konf, $ids);
                if($sva_prisustva !== null){
                  $prisutan = $sva_prisustva->id_suosnivac;
                }else {
                  $prisutan = 0;
                }
              ?>              
               <tr>
                <td scope="col"><?php echo $redni_broj;?></td>
                <td id="<?=$ids?>" ><label for="prisutan_<?=$ids?>" class="label-prisutan"><?=$cirilLatin->cirilLatin($s->naziv)?></label></td> 
                <td>
                  <?php if($ids === $prisutan){?>
                  <input type="checkbox" name="prisutan[]" id="prisutan_<?=$ids?>" value="<?=$ids?>" checked>
                <?php }else{?>
                  <input type="checkbox" name="prisutan[]" id="prisutan_<?=$ids?>" value="<?=$ids?>">
               <?php  } ?> 
              </td>
               
                <td hidden="hidden"><input type="text" name="id_konferencija" value="<?=$id_konf?>"></td>        
              </tr>            
              <?php $redni_broj++;} ?>
            </tbody>
          </table>
          <button type="submit" class="btn btn-lg btn-info btn-block izmeni-btn" name="submit">
           <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;<span id="izmena-btn">Сними</span>
         </button>

      </form>
            </div><!-- card-body -->
          </div>
        </div>
    </div>

</div>

</div>
<br><br>
<script>
  $(document).ready(function(){
    
    $('#data-table').on('click', 'td', function() {
       $(this).css('background-color', '#ccc');
    });

  });


 //za sortiranje tabele, posto sam stavila u datatables init da sortira, ovo mi sad ne treba
//zakomentarisala sam samo pozivanje sortTable() funkcije dole

function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("data-table");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("LABEL")[0];
      y = rows[i + 1].getElementsByTagName("LABEL")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

sortTable();
  

</script>