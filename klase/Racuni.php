<?php
require_once __DIR__.'/Tabela.php';

class Racuni extends Tabela {
	public $id;
	public $broj_racuna;
	public $id_suosnivac;
	public $id_uplate;
	public $generisan_url;
	public $poslat;
	public $uneo;


	public static function insertBrojRacuna($broj_racuna, $id_suosnivac, $id_uplate, $uneo){
		$db = Database::getInstance();
		$query = 'INSERT INTO racuni (broj_racuna, id_suosnivac, id_uplate, uneo) VALUES (:br, :ids, :idup, :un)';
		$params = [
			':br'=>$broj_racuna,
			':ids'=>$id_suosnivac,
			':idup'=>$id_uplate,
			':un'=>$uneo
		];
		
		try{
			$db->insert('Racuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
		return $id_racun = $db->lastInsertId();

	}


	public static function getAll($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni WHERE id_uplate = :id';
		$params = [':id'=>$id];
		return $db->select('Racuni', $query, $params);
		
		
	}

	public static function getAllZaSuosnivaca($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni WHERE id_suosnivac = :id';
		$params = [':id'=>$id];
		return $db->select('Racuni', $query, $params);		
	}



	public static function getAllPoBrojuRacuna($br){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni WHERE broj_racuna = :brr';
		$params = [':brr'=>$br];
		$racuni = $db->select('Racuni', $query, $params);
		foreach($racuni as $racun){
			return $racun;
		}
		return null;
		
	}


	public static function updatePoslat($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE racuni SET poslat = 1, datum_slanja = Date(now()) WHERE id_uplate = :idupl';		
		$params = [
			':idupl'=>$id_uplate
		];
		try{
			$db->update('Racuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}

	public static function updateGenerisanRacun($url, $id_uplata){
		$db = Database::getInstance();
		$query = 'UPDATE racuni SET generisan_url = :uri WHERE id_uplate = :idupl';		
		$params = [
			':uri'=>$url,
			':idupl'=>$id_uplata
		];
		try{
			$db->update('Racuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}

	public static function getAllRacune(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni JOIN uplate ON uplate.id = racuni.id_uplate ORDER BY uplate.datum DESC';
		$params = [];
		return $db->select('Racuni', $query, $params);
	}

	public static function getRacunePoFilteru($od,$do){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni JOIN uplate ON uplate.id = racuni.id_uplate WHERE uplate.datum >= :odDatuma and uplate.datum <= :doDatuma ORDER BY uplate.datum ASC';
		$params = [
			':odDatuma'=>$od,
			':doDatuma'=>$do
		];
		return $db->select('Racuni',$query, $params);
	}

	public static function getRacunePoslednjihMesecDana(){

		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni JOIN uplate ON uplate.id = racuni.id_uplate WHERE uplate.datum >= DATE(NOW()) - INTERVAL 1 MONTH and uplate.datum < DATE(NOW()) ORDER BY uplate.datum ASC';
		$params = [];
			return $db->select('Racuni',$query,$params);
			
	}

	public static function getSveRacune(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM racuni ORDER BY broj_racuna DESC';
		$params = [];
		return $db->select('Predracuni', $query, $params);
		
	}

	public static function obrisiRacun($id){
		$db = Database::getInstance();
		$query = 'DELETE FROM racuni WHERE id = :id';
		$params = [
			':id'=>$id,
		];
		$db->delete($query, $params);
	}


	public static function poslatRacun($broj_racuna, $id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE racuni SET poslat = 1, datum_slanja = Date(now()) WHERE id_uplate = :idu and broj_racuna = :brr';		
		$params = [
			':brr'=>$broj_racuna,
			':idu'=>$id_uplate
		];
		try{
			$db->update('Racuni', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}
	

		

	

	
}