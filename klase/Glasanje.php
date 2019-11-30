<?php
require_once __DIR__.'/Tabela.php';

class Glasanje extends Tabela {
	public $id;
	public $pravo;

	public function getGlasanje($id) {
		$db = Database::getInstance();

		$query = "SELECT * FROM glasanje WHERE id = :id";
		$params = [
			':id' => $id
		];
		$records = $db->select('Glasanje', $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}



}