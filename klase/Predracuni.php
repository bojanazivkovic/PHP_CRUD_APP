<?php
require_once __DIR__.'/Tabela.php';

class Predracuni extends Tabela {
	public $id;
	public $datum_predracuna;
	public $broj_predracuna;
	public $id_suosnivac;
	public $id_uplate;
	public $generisan_url;
	public $poslat;
	public $datum_slanja;
	public $uneo;
	public $poslat_petnaest_dana_pre;
	public $datum_slanja_petnaest_pre;
	public $poslat_dan_pre;
	public $datum_slanja_dan_pre;
	public $poslat_dan_posle;
	public $datum_slanja_dan_posle;
	public $poslat_petnaest_posle;
	public $datum_slanja_petnaest_posle;
	public $poslat_mesec_posle;
	public $datum_slanja_mesec_posle;


	public static function insertBrojPredracuna($datum_predracuna, $broj_predracuna, $id_suosnivac, $id_uplate, $uneo){
		$db = Database::getInstance();
		$query = 'INSERT INTO predracuni (datum_predracuna, broj_predracuna, id_suosnivac, id_uplate, uneo) VALUES (:dr, :br, :ids, :idup, :un)';
		$params = [
			':dr'=>$datum_predracuna,
			':br'=>$broj_predracuna,
			':ids'=>$id_suosnivac,
			':idup'=>$id_uplate,
			':un'=>$uneo
		];
		
		try{
			$db->insert('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
		return $id_racun = $db->lastInsertId();

	}

	public static function getAllPoGodini($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE id_suosnivac = :id and YEAR(datum_predracuna) = YEAR(now())';
		$params = [':id'=>$id];
		$predracuni = $db->select('Predracuni', $query, $params);
		foreach($predracuni as $predracun){
			return $predracun;
		}
		return null;
		
	}


	public static function getAll($iduplate){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE id_uplate = :id';
		$params = [':id'=>$iduplate];
		return $db->select('Predracuni', $query, $params);
		
		
	}

	public static function getAllPredracune(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni ORDER BY datum_slanja DESC';
		$params = [];
		return $db->select('Predracuni', $query, $params);
		
		
	}
	public static function getPredracunePoFilteru($od,$do){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE datum_predracuna >= :odDatuma and datum_predracuna <= :doDatuma ORDER BY datum_predracuna ASC';
		$params = [
			':odDatuma'=>$od,
			':doDatuma'=>$do
		];
		return $db->select('Predracuni', $query, $params);
		
		
	}

	public static function getAllZaSuosnivaca($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE id_suosnivac = :id';
		$params = [':id'=>$id];
		return $db->select('Predracuni', $query, $params);		
	}



	public static function getAllPoBrojuPredracuna($br){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE broj_predracuna = :brr';
		$params = [':brr'=>$br];
		$predracuni = $db->select('Predracuni', $query, $params);
		foreach($predracuni as $predracun){
			return $predracun;
		}
		return null;
		
	}


	public static function updatePoslat($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat = 1, datum_slanja = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}

	public static function updateGenerisanPredracun($url, $id_uplata){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET generisan_url = :uri WHERE id_uplate = :idupl';		
		$params = [
			':uri'=>$url,
			':idupl'=>$id_uplata
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}


	public static function getPoslednjiPredracunPoUplati($id){

		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE id_suosnivac = :id and datum_slanja = (SELECT MAX(datum_slanja) FROM predracuni WHERE id_suosnivac = :id GROUP BY id_suosnivac)';
		$params = [
			':id'=>$id
		];
		
		return $db->select('Predracuni', $query, $params);
	}


	public static function updatePoslatPetnaestDanaPre($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat_petnaest_dana_pre = 1, datum_slanja_petnaest_pre = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}

	public static function updatePoslatDanPre($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat_dan_pre = 1, datum_slanja_dan_pre = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}


	public static function updatePoslatDanNakonIsteka($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat_dan_posle = 1, datum_slanja_dan_posle = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}



	public static function updatePoslatPetnaestDanaNakonIsteka($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat_petnaest_posle = 1, datum_slanja_petnaest_posle = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}


	public static function updateMesecDanaNakonIsteka($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE predracuni SET poslat_mesec_posle = 1, datum_slanja_mesec_posle = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Predracuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}


	public static function getPredracunePoslednjihMesecDana(){

		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni WHERE datum_predracuna >= DATE(NOW()) - INTERVAL 1 MONTH and datum_predracuna < DATE(NOW()) ORDER BY datum_predracuna ASC';
		$params = [];
			return $db->select('Predracuni', $query,$params);
			
	}

	public static function getSvePredracune(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predracuni ORDER BY broj_predracuna DESC';
		$params = [];
		return $db->select('Predracuni', $query, $params);
		
	}
	
	public static function obrisiPredracun($id){
		$db = Database::getInstance();
		$query = 'DELETE FROM predracuni WHERE id = :id';
		$params = [
			':id'=>$id,
		];
		$db->delete($query, $params);
	}


	

	
}