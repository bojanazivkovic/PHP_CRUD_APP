    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Glasanje.php';
    require_once __DIR__.'/klase/Konferencija.php';
    require_once __DIR__.'/klase/Prisustvokonferenciji.php';

    $sve_konferencije = Konferencija::getSve();

    ?> 



    <div class="breadcrumbs">
      <div class="col-sm-4">
        <div class="page-header float-left">
          <div class="page-title">
            <h1>Присуство на конференцији</h1> 
            
          </div>
        </div>
      </div>
      
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12 tabela">
          <div class="card">

            <div class="card-header">
              <strong class="card-title">Конференције</strong>
            </div>
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
                  <th scope="col">Присуствовало</th> 
                  <th scope="col"></th>  
                  <th scope="col"></th>                
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($sve_konferencije as $sve_konf){ 
                $count = Prisustvokonferenciji::countPrisustvokonferenciji($sve_konf->id);
                 
              ?>              
               <tr id="generisi">
                <td scope="col"><?php echo $redni_broj;?></td>
                <td id="<?=$sve_konf->id?>" ><?=$sve_konf->naziv?></td>

                <?php if($sve_konf->datum != null && $sve_konf->datum != '0000-00-00 00:00:00'){?>
                <td><?=date('d.m.Y', strtotime($sve_konf->datum));?></td>
                <?php }else {?>
                <td></td>
                <?php }?>
                <td><?=$sve_konf->vreme;?></td>
                <td><?=$sve_konf->organizator;?></td>
                <td><?=$sve_konf->lokacija?></td>
                <td><?=$count->prisustvovao.' суоснивача'?></td>
                <td>
                  <button type="submit" class="upisi_prisustvo" name="submit" id='<?=$sve_konf->id?>'>Види</button>
                </td>
                <td>
                  <a href="inc/prisustvo_txt.php?id=<?=$sve_konf->id?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                </td>
              </tr>            
              <?php $redni_broj++;}?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- col-lg-12 -->
    <div id="podaci"></div>
  </div>
</div> <!--content mt-3-->

</div><!-- right -->



<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){
    
    $("#bootstrap-data-table").on('click','.upisi_prisustvo', function(){
      var ids = $(this).attr("id");
              $.ajax({
                type: 'POST',
                dataType : "html",
                url: 'inc/upisi_prisustvo.php',
                data: {id : ids},
                
                success: function(data) {
                $("#podaci").html(data);
                  $('.page-title h1').html('<a href="prisustvo_konferencija.php"><i class="fa fa-hand-o-left"></i> назад</a>');
                 }
                });
              $('.tabela').hide();
            });
  });


  //sorting conference date from new to old
    function convertDate(d){
      var datum = d.split(".");
      return +(datum[2]+datum[1]+datum[0]);
    }
    function sortByDate() {
      var tbody = document.querySelector("#bootstrap-data-table tbody");
      // get trs as array for ease of use
      var rows = [].slice.call(tbody.querySelectorAll("tr"));
      
      rows.sort(function(a,b) {
        return convertDate(a.cells[2].innerHTML) - convertDate(b.cells[2].innerHTML);
      });
      rows.reverse();
      
      rows.forEach(function(v) {
        tbody.appendChild(v); // note that .appendChild() *moves* elements
      });
  }
  sortByDate();

  
</script>