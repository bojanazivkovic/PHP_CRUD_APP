<?php

require_once __DIR__.'/Tabela.php';

class Pravoglasa extends Tabela {
	public $id;
	public $id_suosnivac;
	public $datum;
	public $id_glasanje;


	public static function pravoGlasaInsert($id_suosnivac, $datum, $id_glasanje){
		
		$db = Database::getInstance();
			$query = 'INSERT INTO pravoglasa (id_suosnivac, datum, id_glasanje) VALUES (:ids, :dat, :idg)';
			$params = [
				':ids'=>$id_suosnivac,
				':dat'=>$datum,
				':idg'=>$id_glasanje
			];
			try{
			$db->insert('Pravoglasa', $query, $params);
				}catch(Exception $e){
					echo $e->getMessage();
					die();
				}
				return $db->lastInsertId();
	}

	public function getGlasanje($id,$datum_liste) {
		$db = Database::getInstance();

		$query = "SELECT * FROM pravoglasa WHERE id_suosnivac = :id AND CAST(datum as DATE) = CAST(:dat as DATE)";
		$params = [
			':id' => $id,
			':dat'=> $datum_liste
		];
		$records = $db->select('Glasanje', $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}

	public function getCountGlasanje($datum_liste){
		$db = Database::getInstance();

		$query = "SELECT COUNT(*) as count FROM pravoglasa WHERE datum = :dat GROUP BY id_glasanje";
		$params = [
			':dat'=> $datum_liste
		];
		return $db->select('Glasanje', $query, $params);
	}


	public static function updatePravo($id){
		$db = Database::getInstance();
		$query = 'UPDATE pravoglasa SET id_glasanje = 1 WHERE id = :id';
		$params = [
			'id'=>$id
		];

		try{
			$db->update('Pravoglasa', $query, $params);
		}catch(Exception $e){
			return false;
		}
		
	}

	public static function updatePravoOdDatumaNadalje($id, $dat_liste){
		$db = Database::getInstance();
		$query = 'UPDATE pravoglasa SET id_glasanje = 1 WHERE id_suosnivac = :id and datum > :dat';
		$params = [
			'id'=>$id,
			':dat'=>$dat_liste
		];

		try{
			$db->update('Pravoglasa', $query, $params);
		}catch(Exception $e){
			return false;
		}
		
	}





}