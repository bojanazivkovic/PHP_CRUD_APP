<?php
require_once __DIR__.'/../klase/Tabela.php';
require_once __DIR__.'/../klase/Suosnivac.php';
require_once __DIR__.'/../klase/Predstavnik.php';
require_once __DIR__.'/../klase/Uplate.php';
require_once __DIR__.'/../klase/Racuni.php';
require_once __DIR__.'/../klase/Direktor.php';
require_once __DIR__.'/../klase/Clanarina.php';


$id = $_POST['id'];
$br_racuna = $_POST['br'];
$suos = $_POST['suos'];
$id_uplata = $_POST['iduplata'];
$iznos = Clanarina::getClanarinu()->iznos;
$datum_uplate = Uplate::getUplatuPoId($id_uplata)->datum;
$suosnivac = Suosnivac::getSuosnivac($id);

$datum_racuna = Racuni::getAll($id_uplata);
foreach ($datum_racuna as $dat) {
	$datum = $dat->datum_racuna;
	$uneo=$dat->uneo;
}

$direktor = Direktor::getAll();
foreach ($direktor as $dir) {
	$direktor_ime = $dir->ime_prezime;
	$funkcija = $dir->funkcija;

}


$za_koju_godinu = Uplate::getUplatuPoId($id_uplata)->za_godinu;
$suos_naziv = $suosnivac->naziv;
$suos_adresa = $suosnivac->adresa;
$suos_postanski_broj = $suosnivac->postanski_broj;
$suos_mesto = $suosnivac->mesto;
$suos_maticni = $suosnivac->maticni;
$suos_pib = $suosnivac->pib;

$id_suosnivac = $suosnivac->id;
$predstavnik = Predstavnik::getPredstavnik($id_suosnivac);
$predstavnik_ime = $predstavnik->ime_prezime;

use Dompdf\Dompdf;
use Dompdf\Options;
require_once('../dompdf/autoload.inc.php');

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);
/*$contxt = stream_context_create([ 
    'ssl' => [ 
        'verify_peer' => FALSE, 
        'verify_peer_name' => FALSE,
        'allow_self_signed'=> TRUE
    ] 
]);
$dompdf->setHttpContext($contxt);
*/

//include template
ob_start();
require_once('../dompdf/racun.php');
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
$url = 'racuni/RNIDS-račun-'.$br_racuna.'-'.$suos.'-cl.pdf';
file_put_contents($url, $dompdf->output());

$generisi = Racuni::updateGenerisanRacun($url, $id_uplata);
//echo $generisi;