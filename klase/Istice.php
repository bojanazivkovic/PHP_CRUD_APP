<?php
require_once __DIR__.'/Tabela.php';

class Istice extends Tabela {
	public $id;
	public $datum;
	public $id_uplate;
	public $id_suosnivac;


	public static function insertIstice($datum_isticanja, $id_uplate, $id_suosnivac){
		$db = Database::getInstance();
		$query = 'INSERT INTO istice (datum, id_uplate, id_suosnivac) VALUES (:di, :idu, :ids)';
		$params = [
			':di'=>$datum_isticanja,
			':idu'=>$id_uplate,
			':ids'=>$id_suosnivac
		];
		//$test = $datum.', '.$iznos.', '.$id_suosnivac;
		//echo $test;
		//die();
		try{
			$db->insert('Istice', $query, $params);
		}catch(Exception $e){
			return false;
			/*echo $e->getMessage();
					die();*/
		}
		return $id_istice = $db->lastInsertId();

	}

	public function getIstice($id) {
		$db = Database::getInstance();

		$query = "SELECT * FROM istice WHERE id_uplate = :id";
		$params = [
			':id' => $id
		];
		$records = $db->select('Istice', $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}


	public static function getIstekloProsleGodine($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and YEAR(datum) = YEAR(NOW())-1';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Istice', $query,$params);
			
		foreach($records as $record){
			return $record;
		}
		return null;
		
	}

	public static function getIsticeOveGodine($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and YEAR(datum) = YEAR(NOW())';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Istice', $query,$params);
			
		foreach($records as $record){
			return $record;
		}
		return null;
		
	}

	public static function getPoslednjeIsticanjeZaPredracun($id){

		$db = Database::getInstance();
		//$query = 'SELECT datum FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id)';

		$query = 'SELECT * FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id) and datum > DATE(NOW()) - INTERVAL 1 MONTH and datum < DATE(NOW()) + INTERVAL 2 MONTH ORDER BY datum DESC';
		$params = [
			':id'=>$id
			];
			return $db->select('Istice', $query,$params);
	}

	public static function getPoslednjeIsticanjeZaRacun($id){

		$db = Database::getInstance();
		$query = 'SELECT datum FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id)';

		//$query = 'SELECT * FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id) and datum > DATE(NOW()) - INTERVAL 1 MONTH and datum < DATE(NOW()) + INTERVAL 2 MONTH ORDER BY datum DESC';
		$params = [
			':id'=>$id
			];
			return $db->select('Istice', $query,$params);
	}



	public static function getIsticeSledeceGodine($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and YEAR(datum) = YEAR(NOW())+1';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Istice', $query,$params);
			
		foreach($records as $record){
			return $record;
		}
		return null;
		
	}


	public static function getIsticeNajveci($id){

		$db = Database::getInstance();
		$query = 'SELECT datum FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id)';
		$params = [
			':id'=>$id
		];
		
		$datumist = $db->select('Istice', $query, $params);
		foreach ($datumist as $dat) {
			return $dat->datum;
		} return null;
		
	}

	public static function getPoslednjeIsticanje($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :ids)';
		$params = [
			':ids'=>$id
		];
		
		$datumist = $db->select('Istice', $query, $params);
		foreach ($datumist as $dat) {
			return $dat->datum;
		} return null;
		
	}


	public static function getIstice2017($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and YEAR(datum) = 2017';
		$params = [
			':ids'=>$id
		];
		
		$datumist = $db->select('Istice', $query, $params);
		foreach ($datumist as $dat) {
			return $dat->datum;
		} return null;
		
	}



	public static function getIsticePoslednja($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :ids) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Istice', $query,$params);
			
		foreach($records as $record){
			return $record;
		}
		return null;

		
	}


	public static function insertIstice2017($datum, $id_uplate, $id_suosnivac){
		$db = Database::getInstance();
		$query = 'INSERT INTO istice (datum, id_uplate, id_suosnivac) VALUES (:di, :idu, :ids)';
		$params = [
			':di'=>$datum,
			':idu'=>$id_uplate,
			':ids'=>$id_suosnivac
		];
		
		try{
			$db->insert('Istice', $query, $params);
		}catch(Exception $e){
			return false;
			
		}
		

	}


	public static function insertIstekloProsle($datum, $id_uplate, $id_suosnivac){
		$db = Database::getInstance();
		$query = 'INSERT INTO istice (datum, id_uplate, id_suosnivac) VALUES (:di, :idu, :ids)';
		$params = [
			':di'=>$datum,
			':idu'=>$id_uplate,
			':ids'=>$id_suosnivac
		];
		
		try{
			$db->insert('Istice', $query, $params);
		}catch(Exception $e){
			return false;
			
		}
		

	}


	public static function getIsticeNajveciZaNeaktivne($id){

		$db = Database::getInstance();
		$query = 'SELECT * FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id GROUP BY id_suosnivac)';
		$params = [
			':id'=>$id
		];
		
		return $db->select('Istice', $query, $params);
		
		
	}


	public static function getPoslednje($id){

		$db = Database::getInstance();
		$query = 'SELECT id, datum, id_uplate, id_suosnivac FROM istice WHERE id_suosnivac = :ids and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :ids) GROUP BY id_suosnivac';
		$params = [
			':ids'=>$id
			];
			$records = $db->select('Istice', $query,$params);
			foreach($records as $record){
				return $record;
			}
			return null;
	}

	public static function getPoslednjihMesecDanaISledecihDvaMeseca($id){

		$db = Database::getInstance();
		$query = 'SELECT * FROM istice WHERE id_suosnivac = :id and datum = (SELECT MAX(datum) FROM istice WHERE id_suosnivac = :id) and datum > DATE(NOW()- INTERVAL 1 DAY) - INTERVAL 1 MONTH and datum < DATE(NOW()) + INTERVAL 2 MONTH';
		$params = [
			':id'=>$id
			];
			return $db->select('Istice', $query,$params);
			
	}
	

	
}
