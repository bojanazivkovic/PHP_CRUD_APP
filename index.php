    <?php 
    include 'inc/header.inc.php';
    include 'inc/sidebar.inc.php'; 
    require_once __DIR__.'/klase/Suosnivac.php';
    $ukupnoSuosnivaca = Suosnivac::prebroji();
    $svi = Suosnivac::getAllZaChart();

    require_once __DIR__.'/klase/Uplate.php';
    require_once __DIR__.'/klase/Istice.php';
    require_once __DIR__.'/klase/Predracuni.php';

    $suosnivaci = Suosnivac::getAll();
    
    ?> 

    <div class="breadcrumbs">
        <div class="col-sm-3">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Почетна страна</h1>
                </div>
            </div>
        </div>

      <div class="col-sm-6">
            <div class="page-header">
                <div class="page-title" id="postoji_predracun_index"">
                 <h1><?php if(isset($_GET['postoji_predracun_index'])) {?>           
              Већ постоји предрачун са бројем <?=$_GET['postoji_predracun_index']; ?>!             
              <?php }?></h1>             
            </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="page-header float-right">
                <div class="page-title">
                    <h1>Укупно суоснивача: <span class="count"><?php echo $ukupnoSuosnivaca; ?></span></h1>
                </div>
            </div>
        </div>
    </div>

       <div class="content mt-3">
            <div class="animated fadeIn">

                <div class="row">
                    <div class="col-md-4 col-lg-4">
                     <canvas id="myChart"height="150"></canvas>
                    </div>
                    <div class="col-md-4 col-lg-4"></div>
                    <div class="col-md-4 col-lg-4"></div>
                    
                
                </div><!--/.row-->

          <div class="row">
             <div class="card-body">
                <div class="card-header tabela">
                    <strong class="card-title">Истичу у наредних два месеца</strong>
                  </div> 

             
             <table class="table table-striped table-bordered" id="tabela">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Назив</th>
                  <th scope="col">Истиче</th>
                  <th scope="col">Дана до истека</th>
                  <th>Предрачун</th> 
                  <th></th>     
                              
                </tr>
              </thead>
              <tbody>
               <?php $redni_broj = 1;  
                foreach($suosnivaci as $s){ 
                  $napomena = $s->napomena;

                $ids = $s->id;
                $isticePoslednje = Istice::getPoslednjihMesecDanaISledecihDvaMeseca($ids);
               
                foreach ($isticePoslednje as $isticeee) {

                  $predracuni = Predracuni::getAll($isticeee->id_uplate);  
                  $danas = time();

                  if(isset($isticeee->datum)){
                    
                  $istek = strtotime($isticeee->datum);                  
                  $razlika = ceil(($istek - $danas)/60/60/24);


                 //var_dump($razlika);

               foreach ($predracuni as $predrac) {
                  //echo $predrac->poslat.', ';
                }
                ?>
                  <tr>
<!-- redni broj --> <td scope="col"><?php echo $redni_broj;?></td>
    <!-- naziv -->  <?php if($napomena != null){ ?>
                    <td id="<?=$s->id?>" ><?=$s->naziv?> - <b><span style="color: red">НАПОМЕНА</span></b></td>
                    <?php }else {?>
                    <td id="<?=$s->id?>" ><?=$s->naziv?></td>
                    <?php } ?>
                      <td><?=date('d.m.Y', strtotime ($isticeee->datum))?></td>
                      <td class="razlikaDana"><?=$razlika?></td> 
                    

                    <?php if(!empty($predrac) && $isticeee->id_uplate == $predrac->id_uplate && $predrac->poslat == 1){ 
                      $datum_slanja = date('d.m.Y', strtotime($predrac->datum_slanja));
                      ?>
                      <td>послат дана: <?=$datum_slanja?></td>
                        <td></td>
                       
                      <?php }else {?>
                         <td>није послат</td>
                        <td><a href="posalji_predracun.php#<?=$s->id?>">Пошаљи предрачун</a></td>

                        
                    <?php }?>  
                    

                 </tr>            
              <?php $redni_broj++;}}}?>
            </tbody>
          </table>

        </div>
</div></div></div>
<?php 
$nizGodina = array();
foreach ($svi as $s) {
    $year = new DateTime($s->datum_apr);
    $year = $year->format('Y');
    $labels = json_encode($year).',';
    array_push($nizGodina, $labels);
}
$niz = array_count_values($nizGodina);

?>

    
    
 <!--  Chart js -->
    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
  <!--  <script src="assets/js/utils.js"></script> -->
   
<script>

    // Counter Number
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });



    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php foreach ($niz as $key => $value) {echo $key;} ?>],
        datasets: [{
            label: 'Suosnivaci',
            data: [<?php foreach ($niz as $key => $value) {echo $value.',';} ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                 'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                 'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


   






//za sortiranje tabele, posto sam stavila u datatables init da sortira, ovo mi sad ne treba
//zakomentarisala sam samo pozivanje sortTable() funkcije dole

function sortTable(){
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("tabela");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[3];
      y = rows[i + 1].getElementsByTagName("TD")[3];
      //check if the two rows should switch place:
      if (Number(x.innerHTML) > Number(y.innerHTML)) {
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

//sortTable();
</script>




<?php include 'inc/footer.inc.php'; ?> 
