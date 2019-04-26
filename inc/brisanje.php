<?php

$id = $_POST['id'];
require_once __DIR__.'/../klase/Suosnivac.php';
Suosnivac::obrisi($id);
header('Location: ../suosnivaci_izmena.php');