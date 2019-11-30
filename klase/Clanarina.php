<?php
require_once __DIR__.'/Tabela.php';

class Clanarina extends Tabela {
	public $id_clanarina;
	public $iznos;

	public function getClanarinu() {
		$db = Database::getInstance();
		$query = "SELECT * FROM clanarina";
		$records = $db->select('Clanarina', $query);
		foreach($records as $record){
			return $record;
		}
		return null;
	}

	public static function updateClanarinu($id, $iznos){
		$db = Database::getInstance();
		$query = 'UPDATE clanarina SET iznos = :iz WHERE id = :id';
		$params = [
			':iz'=>$iznos,
			'id'=>$id
		];

		try{
			$db->update('Clanarina', $query, $params);
		}catch(Exception $e){
			return false;
		}
		
	}




}