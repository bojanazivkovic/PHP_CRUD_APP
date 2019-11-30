<?php
//prvo azuriramo pravo glasa
//require '../cronjob/pravo_glasa.php';

//onda se generise lista
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';
require_once __DIR__.'/../klase/Istice.php';
require_once __DIR__.'/../klase/Konferencija.php';
require_once __DIR__.'/../klase/Glasanje.php';
require_once __DIR__.'/../klase/Pravoglasa.php';
require_once __DIR__.'/../klase/Prisustvokonferenciji.php';

$id_konferencija = $_POST['id'];
$konf = Konferencija::getKonferencijuPoId($id_konferencija);
$datum_liste = $konf->datum_liste;
$ukupno_konferencije = Konferencija::countSveKonferencijePoDatumuListe($datum_liste);

foreach ($ukupno_konferencije as $ukupno) {
	$countKonferencije = $ukupno->ukupno;
}

$naziv = $konf->naziv;
$datum_konferencije = date('d.m.Y', strtotime($konf->datum)); 
$vreme = $konf->vreme;
$organizator = $konf->organizator;
$lokacija = $konf->lokacija;


$suosnivac = Suosnivac::getAllZaListu();

$danasnji_datum = date("Y-m-d");

use Dompdf\Dompdf;
use Dompdf\Options;
require_once('../dompdf/autoload.inc.php');

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);

//include template
ob_start();
require_once('../dompdf/formalna_lista.php');
$template = ob_get_clean();

//$dompdf = new Dompdf();
$dompdf->loadHtml($template);
//set paper size
$dompdf->setPaper('A4', 'portrait');

//render the html to pdf
$dompdf->render();

//output to browser
//$dompdf->stream('invoice-'.$id);

//write pdf to folder
$url = 'liste/'.$datum_konferencije.'-pravo-glasa-'.$danasnji_datum.'.pdf';
file_put_contents($url, $dompdf->output());

$generisi = Konferencija::updateGenerisanaLista($url, $id_konferencija);
echo $datum_konferencije;