<?php
require_once __DIR__ . '/../klase/Tabela.php';
require_once __DIR__ . '/../klase/Suosnivac.php';
require_once __DIR__ . '/../klase/Konferencija.php';
require_once __DIR__ . '/../klase/Prisustvokonferenciji.php';

$konferencija = $_POST['konferencija'];
$prisutan = $_POST['prisutan'];

if (isset($prisutan)) {
	$prisustvoAll = Prisustvokonferenciji::getAllPrisustvo($konferencija);

	if (!empty($prisustvoAll)) {
		foreach ($prisustvoAll as $all) {
			$niz_prisustvo[] = $all->id_suosnivac;
		}

	} else {
		$niz_prisustvo = array();
	}

	foreach ($prisutan as $pr) {
		$niz_prisutan[] = $pr;
	}

	$razlika = array_diff_assoc($niz_prisustvo, $niz_prisutan);

	foreach ($razlika as $key => $value) {
		Prisustvokonferenciji::obrisiPrisustvo($konferencija, $value);
	}

	foreach ($prisutan as $pris) {
		$upisan = Prisustvokonferenciji::getPrisustvokonferenciji($konferencija, $pris);

		if ($pris === $upisan->id_suosnivac) {
			Prisustvokonferenciji::updatePrisustvo($konferencija, $pris);
		} else {
			Prisustvokonferenciji::insertPrisustvo($konferencija, $pris);
		}
	}

	//header('Location:../prisustvo_konferencija.php?success=uspesno');

} else {
	Prisustvokonferenciji::obrisiSvoPrisustvo($konferencija);
	//header('Location:../prisustvo_konferencija.php');
}
