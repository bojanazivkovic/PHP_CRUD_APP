    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 

    require_once __DIR__.'/klase/Suosnivac.php';
    require_once __DIR__.'/klase/Predstavnik.php';
    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Glasanje.php';
    require_once __DIR__.'/klase/Konferencija.php';

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
        
          <div class="page-title">

            <div id="dugme-otvori">
                    <button id="unesi-konferenciju-btn" type="submit" class="btn btn-danger">
                      <i class="fa fa-mouse-pointer fa-lg"></i>&nbsp;
                      <span id="unesi-konferenciju-btn">Унеси конференцију</span>
                      <span id="unesi-konferenciju-btn-sending" style="display:none;">Унос…</span>
                    </button>
                  </div>
          
          </div>
     
      </div>


    </div>

    <div class="content mt-3">
      <div class="animated fadeIn">
        
        <div class="col-lg-12 tabela">
          <div class="card">

            <div class="card-header">
              <strong class="card-title">Унос конференције и генерисање листе са правом гласа</strong>
              <?php if(isset($_GET['success'])) {?>
              <span id="success">Успешно унета конференција!</span>
              <?php }
              else if(isset($_GET['unos'])) {?>
              <span id="unos">Морате унети назив конференције!</span>
              <?php }?>
            </div>
                  
        <form action="inc/unos_konferencije.php" method="post">
          <div class="card-header" style="display:none; background-color: #F0EEEE">

            <div class="row">

              <div class="col-lg-6">
                <div class="form-group">
                      <label for="konferencija" class="control-label mb-1">Конференција:</label>
                      <input id="konferencija" name="konferencija" type="text" class="form-control" placeholder="Унеси конференцију" required>
                </div>
              </div>

                <div class="col-lg-3">
                  <div class="form-group">
                      <label for="datum" class="control-label mb-1">Датум:</label>
                      <input id="datum" name="datum" type="text" class="form-control" placeholder="Унеси датум" required>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                      <label for="vreme" class="control-label mb-1">Време:</label>
                      <input id="vreme" name="vreme" type="text" class="form-control" placeholder="Унеси време" required>
                  </div>
                </div>

            </div>

              

          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                      <label for="organizator" class="control-label mb-1">Организатор:</label>
                      <input id="organizator" name="organizator" type="text" class="form-control" placeholder="Унеси организатора" required>
                </div>
              </div>

             <div class="col-lg-6">
                <div class="form-group">
                      <label for="lokacija" class="control-label mb-1">Локација:</label>
                      <input id="lokacija" name="lokacija" type="text" class="form-control" placeholder="Унеси локацију" required>
                </div>
              </div>
          </div>
                    <button id="unesi-btn" type="submit" class="btn btn-lg btn-info btn-block">
                      <i class="fa fa-paper-plane-o fa-lg"></i>&nbsp;
                      <span id="unesi-btn">Унеси</span>
                      <span id="unesi-btn-sending" style="display:none;">Унос…</span>
                    </button>

                
            </form>
          </div>




<div class="loading" style="display: none;">Loading&#8230;</div>




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

                <?php if($sve_konf->datum_liste != null || $sve_konf->datum_liste != ''){ ?>
                    <td> 
                    <?php if($sve_konf->url != ''){ ?> 
                    <a href="inc/<?=$sve_konf->url?>" target="_blank">Формална ПДФ</a>            
                    <?php }else if($sve_konf->url == null){ ?>             
                    <button type="submit" class="generisi_listu" name="submit" id='<?=$sve_konf->id?>'>Формална</button>
                    <?php } ?>
                    </td>
                    <td>
                    <?php if($sve_konf->neformalna_url != ''){ ?> 
                    <a href="inc/<?=$sve_konf->neformalna_url?>" target="_blank">Неформална ПДФ</a>
                    <?php }else if($sve_konf->neformalna_url == null){ ?>           
                    <button type="submit" class="generisi_neformalnulistu" name="submit" id='<?=$sve_konf->id?>'>Неформална</button>
                    <?php } ?>                
                    </td>
                <?php }else{ ?>
                    <td>              
                    <button type="submit" class="upisi_datum_liste" name="submit" data-toggle="modal" data-target="#smallmodal" id='<?=$sve_konf->id?>'>Датум листе</button>
                    </td>
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
                                
                              <form action="inc/upisi_datum_liste.php" method="post">
                                <div class="col-4">
                                <div class="form-group">
                                  <input type="hidden" name="id_konf" id="id_konf" value="">
                                  <label for="datum_liste" class="control-label mb-1">Упиши датум листе:</label>
                                  <input id="datum_liste" name="datum_liste" type="text" class="form-control">
                                </div>
                              </div>                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Откажи</button>
                               
                                <button type="submit" class="btn btn-primary" id="unesi_datum" name="unesi_datum">Унеси</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


<?php include 'inc/footer.inc.php'; ?> 

<script>
  $(document).ready(function(){
    $(".loading").hide();

    $("#unesi-konferenciju-btn").click(function(){
        $(".card-header").toggle();
    });
    setTimeout(function(){
       if($('#success').length > 0){
        $('#success').remove();
      }else if($('#unos').length > 0){
        $('#unos').remove();
      }

    },3000);

  });

    var d = new Date();
   function formatDateToString(date){
   // 01, 02, 03, ... 29, 30, 31
   var dd = (date.getDate() < 10 ? '0' : '') + date.getDate();
   // 01, 02, 03, ... 10, 11, 12
   var MM = ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);
   // 1970, 1971, ... 2015, 2016, ...
   var yyyy = date.getFullYear();

   // create the format you want
   return (yyyy + "-" + MM + "-" + dd);
}


  function open_in_tab(url) {
   var win = window.open(url, '_blank');
   win.focus();
  }

    $("#bootstrap-data-table").on('click','.generisi_listu', function(e){
      e.preventDefault();
      $(".loading").show();
      var idk = $(this).attr('id');
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/generisi_listu.php',
        data: {id:idk},

        success: function(data){       
          open_in_tab('inc/liste/'+data+'-pravo-glasa-'+formatDateToString(d)+'.pdf','_blank');
          
          location.reload();
          //console.log(data)
        }
      });

    });   


    $("#bootstrap-data-table").on('click','.generisi_neformalnulistu', function(e){
      e.preventDefault();
      $(".loading").show();
      var idk = $(this).attr('id');
     
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/generisi_neformalnulistu.php',
        data: {id:idk},

        success: function(data){       
          open_in_tab('inc/liste/'+data+'-neformalna-lista.pdf','_blank');
          
          location.reload();
          //console.log(data)
        }
      });

    });   





    $("#bootstrap-data-table").on('click','.upisi_datum_liste', function(e){
      e.preventDefault();
      var idk = $(this).attr('id');
      $('#id_konf').val(idk);

      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'inc/upisi_datum_liste.php',
        data: {id:idk},

        success: function(data){
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
  
</script>