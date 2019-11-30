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
            <h1>Конференција и листа</h1> 
            
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <!-- <div id="dugme-azuriraj">
          <button type="submit" class="btn btn-success">Ажурирај право гласа</button>
        </div> -->
      </div>
      <div class="col-sm-4">
          <div class="page-title"></div>
      </div>
    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12 tabela">
          <div class="card">

            <div class="card-header">
              <strong class="card-title">Брисање листе са правом гласа</strong>
              <?php if(isset($_GET['success'])) {?>
              <span id="success">Успешно обрисана листа!</span>
              <?php }?>
              
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
                  <th scope="col"></th>                 
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
               foreach($sve_konferencije as $sve_konf){ 
                
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
               

               <?php if($sve_konf->url != '' && $sve_konf->neformalna_url == null){ ?> 
                <td>              
                  <button type="submit" class="obrisi_formalnulistu" name="submit" id='<?=$sve_konf->id?>'>Обриши формалну</button>
                </td>
                <td></td> 
                <?php }else if($sve_konf->url == null && $sve_konf->neformalna_url != ''){ ?> 
                  <td></td>
                  <td>
                <button type="submit" class="obrisi_neformalnulistu" name="submit" id='<?=$sve_konf->id?>'>Обриши неформалну</button>  
              </td>
                <?php } else if($sve_konf->url != '' && $sve_konf->neformalna_url != ''){ ?> 
                 <td>              
                  <button type="submit" class="obrisi_formalnulistu" name="submit" id='<?=$sve_konf->id?>'>Обриши формалну</button>
                </td>
                <td>
                <button type="submit" class="obrisi_neformalnulistu" name="submit" id='<?=$sve_konf->id?>'>Обриши неформалну</button>  
              </td>


            <?php }else if($sve_konf->datum_liste != null || $sve_konf->datum_liste != ''){ ?> 
                  <td>
                    <button type="submit" class="obrisi_datum_liste btn btn-secondary btn-sm" name="submit" id='<?=$sve_konf->id?>'>Обриши датум листе: <?=date('d.m.Y', strtotime($sve_konf->datum_liste));?></button>  
                  </td>
                <td></td>




                <?php } else{?>   
                <td></td>
                <td></td>   
                <?php } ?> 
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
    
    $("#bootstrap-data-table").on('click','.obrisi_formalnulistu', function(){
      var idk = $(this).attr('id');
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/obrisi_formalnulistu.php',
        data: {id:idk},

        success: function(data){       
         location.reload();
          //console.log(data)
        }
      });
    });   

    $("#bootstrap-data-table").on('click','.obrisi_neformalnulistu', function(){
      var idk = $(this).attr('id');
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/obrisi_neformalnulistu.php',
        data: {id:idk},

        success: function(data){       
         location.reload();
          //console.log(data)
        }
      });
    });  

    $("#bootstrap-data-table").on('click','.obrisi_datum_liste', function(){
      var idk = $(this).attr('id');
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/obrisi_datum_liste.php',
        data: {id:idk},

        success: function(data){       
         location.reload();
          //console.log(data)
        }
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


});   
  
</script>