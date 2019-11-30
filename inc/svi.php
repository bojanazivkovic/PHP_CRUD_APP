<?php 
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Glasanje.php';
require_once __DIR__.'/../klase/Predracuni.php';

$id = $_POST['id'];

$suosnivac = Suosnivac::getSuosnivac($id);
$predstavnik = Predstavnik::getPredstavnik($id);
$uplate = Uplate::getUplatu($id);
$predracuni = Predracuni::getAllZaSuosnivaca($id);

?>
<div class="row">
 <div class="col-lg-6">
          <div class="card">
          <div class="card-header">
            <strong class="card-title">Суоснивач: <?=$suosnivac->naziv?></strong>
          </div>
          <div class="card-body">
          	<b>Адреса:</b> <?=$suosnivac->adresa?>,<br>
            <b>Поштански број и место:</b> <?=$suosnivac->postanski_broj?> <?=$suosnivac->mesto?><br>
          	<b>ПАК:</b> <?=$suosnivac->pak?> <br>
          	<b>Матични број:</b> <?=$suosnivac->maticni?><br>
          	<b>ПИБ:</b> <?=$suosnivac->pib?><br><br>
            <b>Напомена:</b> <?=$suosnivac->napomena?><br><br>
          	
          </div><!-- card-body -->
      </div>
  </div>

  <div class="col-lg-6">
          <div class="card">
          <div class="card-header">
            <strong class="card-title">Представник: <?=$predstavnik->ime_prezime?></strong>
          </div>
          <div class="card-body">
          	<b>Тел:</b> <?=$predstavnik->mobilni?><br>
          	<b>Емаил:</b> <?=$predstavnik->email?><br>  
          </div><!-- card-body -->
      </div>     
  </div>
</div>

<div class="row">

  <div class="col-lg-6">
    <div class="card">
        <div class="card-header">
    <strong class="card-title">Датум потписивања:</strong> 
  </div>
  <div class="card-body">
      <?php if($suosnivac->datum_potpisivanja != null) {
                ?>
            <?=date('d.m.Y', strtotime($suosnivac->datum_potpisivanja))?>
            <?php } ?>
            <br>
            <b>Датум АПР:</b> 
            <?php if($suosnivac->datum_apr != null) {
                ?>
            <?=date('d.m.Y', strtotime($suosnivac->datum_apr))?>
            <?php } ?>
            <br>
            <b>Уговор:</b> <a href="<?=$suosnivac->ugovor?>" target="_blank"><?=$suosnivac->ugovor?></a><br>
            <b>Приступница:</b> <a href="<?=$suosnivac->pristupnica?>" target="_blank"><?=$suosnivac->pristupnica?></a><br>
            <b>Овлашћење:</b> <a href="<?=$suosnivac->ovlascenje?>" target="_blank"><?=$suosnivac->ovlascenje?></a><br>
            <b>Право гласа:</b> <?=Glasanje::getGlasanje($suosnivac->id_glasanje)->pravo?><br>
</div>
</div>

  </div>

  <div class="col-lg-6">
          <div class="card">
          <div class="card-header">
            <strong class="card-title">Уплате</strong>
          </div>
          <div class="card-body">
          	<table id="svi_uplate">
              <tr>
                <td>датум уплате:</td>
                <td></td>
                <td>за годину:</td>
              </tr>
          		<?php foreach ($uplate as $uplata) { 
          			if($uplata->datum != null) {
          			?>
          		<tr>
          			<td><?=date('d.m.Y', strtotime($uplata->datum))?></td>
                <td>&nbsp;</td>
                <td><?=$uplata->za_godinu?></td>
          		</tr>

          		<?php } }?>
          	</table>
          </div><!-- card-body -->
      </div>
  </div>

  </div>


<div class="row">
 <div class="col-lg-12">
          <div class="card">
          <div class="card-header">
            <strong class="card-title">Генерисани предрачуни:</strong>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                <th scope="col">Датум предрачуна</th>
                <th scope="col">Број предрачуна</th>
                <th scope="col">Послат дана</th>
                <th scope="col">Линк</th>
              </tr>
              </thead>
              <tbody>
            <?php 
            foreach ($predracuni as $predrac) {
              $datum_predracuna = date('d.m.Y.', strtotime($predrac->datum_predracuna));
              $broj_predracuna = $predrac->broj_predracuna;
              $urlpredrac = explode('/',trim($predrac->generisan_url));
              $url = $urlpredrac[1];
              
              $poslat = date('d.m.Y.', strtotime($predrac->datum_slanja));
              echo '<tr><td>';
              echo $datum_predracuna.'</td><td>'.$broj_predracuna.'</td><td>'.$poslat.'</td><td>';
              
              ?>
              <a target="_blank" href='/inc/pdfs/<?=$url?>'><?=$url?></a>
              <?php
              echo '</td></tr>';
            }
            ?>
              
            </tbody>
            </table>
          </div><!-- card-body -->
      </div>
  </div>

</div>





</div>
<br><br>


<script>
  $(document).ready(function(){

     setTimeout(function(){
       if($('#success_uplata').length > 0){
        $('#success_uplata').remove();
      }else if($('#error_uplata').length > 0){
        $('#error_uplata').remove();
      }
    },3000);



  });
</script>

	