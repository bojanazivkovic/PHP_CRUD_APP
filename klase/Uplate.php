<?php 

require_once __DIR__.'/Tabela.php';
require_once __DIR__.'/Suosnivac.php';
require_once __DIR__.'/Istice.php';


class Uplate extends Tabela{
	public $id;
	public $datum;
	public $iznos;
	public $id_suosnivac;
	public $za_godinu;
	public $obavestenje;

	public static function insertUplatu($datum, $iznos, $id_suosnivac, $za_godinu){
		$db = Database::getInstance();
		$query = 'INSERT INTO uplate (datum, iznos, id_suosnivac, za_godinu) VALUES (:du, :i, :ids, :za)';
		$params = [
			':du'=>$datum,
			':i'=>$iznos,
			':ids'=>$id_suosnivac,
			':za'=>$za_godinu
		];
		
		try{
			$db->insert('Uplate', $query, $params);
		}catch(Exception $e){
			return false;
		}
		return $id_uplate = $db->lastInsertId();

	}


	public static function getUplatePoDatumu($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and datum = (SELECT MAX(datum) FROM uplate WHERE id_suosnivac = :ids) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			return $db->select('Uplate', $query,$params);

		
	}
	public static function getUplatePrethodnaGodina($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and za_godinu = YEAR (DATE(NOW())- INTERVAL 1 YEAR) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Uplate', $query,$params);
		foreach($records as $record){
			return $record;
		}
		return null;
		
	}
	public static function getUplateTrenutnaGodina($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and za_godinu = YEAR (DATE(NOW())) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Uplate', $query,$params);
		foreach($records as $record){
			return $record;
		}
		return null;

		
	}
	public static function getUplateZa2017($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and za_godinu = 2017';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Uplate', $query,$params);
		foreach($records as $record){
			return $record;
		}
		return null;

		
	}

	public static function getUplatePreDveGodine($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and za_godinu = YEAR (DATE(NOW())- INTERVAL 2 YEAR) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Uplate', $query,$params);
		foreach($records as $record){
			return $record;
		}
		return null;		
	}

	public static function getPoslednju($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, iznos, id_suosnivac, za_godinu FROM uplate WHERE id_suosnivac = :ids and za_godinu = (SELECT MAX(za_godinu) FROM uplate WHERE id_suosnivac = :ids) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Uplate', $query,$params);
			foreach($records as $record){
				return $record;
			}
			return null;
	}

	public static function getUplatu($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM uplate WHERE id_suosnivac = :id ORDER BY datum DESC';
		$params = [':id'=>$id];
		return $db->select('Uplate', $query, $params);
	}

	public static function getSveUplate($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM uplate WHERE id_suosnivac = :id and za_godinu > YEAR (DATE(NOW())- INTERVAL 1 YEAR) GROUP BY datum ASC';
		$params = [':id'=>$id];
		return $db->select('Uplate', $query,$params);
			
	}	

	public static function getSveUplateZaIndex($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM uplate WHERE id_suosnivac = :id';
		$params = [':id'=>$id];
		return $db->select('Uplate', $query,$params);
			
	}
	public static function getCountSvihUplata($id){
		$db = Database::getInstance();
		$query = 'SELECT COUNT(*) AS koliko  FROM uplate WHERE id_suosnivac = :id';
		$params = [':id'=>$id];
		$records = $db->select('Uplate', $query,$params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}



	public static function updateUplatu($id, $datum){
		$db = Database::getInstance();
		$query = 'UPDATE uplate SET datum = :d WHERE id = :id';
		$params = [
			':d'=>$datum,
			'id'=>$id
		];

		try{
			$db->update('Uplate', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}

	public static function getUplatuPoId($id){
		$db = Database::getInstance();
		$query = 'SELECT * FROM uplate WHERE id = :id';
		$params = [':id'=>$id];
		$records = $db->select('Uplate', $query,$params);
			foreach($records as $record){
				return $record;
			}
			return null;
	}

	public static function obrisiUplatu($id){		
		$db = Database::getInstance();
		$query = 'DELETE FROM uplate WHERE id = :id';
		$params = ['id'=>$id];
		$db->delete($query, $params);

	}

	public static function updateObavestenje($id_uplate){
		$db = Database::getInstance();
		$query = 'UPDATE uplate SET obavestenje = 1 WHERE id = :id';
		$params = ['id'=>$id_uplate];

		try{
			$db->update('Uplate', $query, $params);
		}catch(Exception $e){
			return false;
		}
	}






}