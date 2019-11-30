<?php

require_once __DIR__.'/Tabela.php';

class Direktor extends Tabela {
	public $id;
	public $ime_prezime;
	

	public static function updateDirektor($id, $ime_prezime, $funkcija){
		$db = Database::getInstance();
		$query = 'UPDATE direktor SET ime_prezime = :ip, funkcija = :f WHERE id = :id';
		$params = [
			':ip'=>$ime_prezime,
			':f'=>$funkcija,
			'id'=>$id
		];

		try{
			$db->update('Direktor', $query, $params);
		}catch(Exception $e){
			return false;
		}
		
	}


	public static function getAll(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM direktor';
		$params = [];
		return $db->select('Direktor', $query, $params);
		
		
	}




}