<?php

require_once __DIR__.'/Tabela.php';

class Predstavnik extends Tabela{
	public $id;
	public $ime_prezime;
	public $mobilni;
	public $email;
	public $id_suosnivac;

	public static function insertPredstavnik($ime_prezime, $mobilni, $email, $id_suosnivac){
			$db = Database::getInstance();
			$query = 'INSERT INTO predstavnik (ime_prezime, mobilni, email, id_suosnivac) VALUES (:ip,:m,:e,:ids)';
			$params = [
				':ip'=>$ime_prezime,
				':m'=>$mobilni,
				':e'=>$email,
				':ids'=>$id_suosnivac
			];
			try{
			$db->insert('Predstavnik', $query, $params);
				}catch(Exception $e){
					echo $e->getMessage();
					die();
				}
				return $db->lastInsertId();
			
	}


	public static function getAll(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predstavnik';
		return $db->select('Predstavnik', $query);
	}

	public static function getPredstavnik($id){
		$db = Database::getInstance();

		$query = 'SELECT * FROM predstavnik WHERE id_suosnivac = :id';
		$params = [
			':id'=>$id
		];
		
		$predstavnici = $db->select('Predstavnik', $query, $params);

		foreach ($predstavnici as $predstavnik) {
			return $predstavnik;
		} return null;
	}

	public static function updatePredstavnik($ime_prezime, $mobilni, $email, $id){

	$db = Database::getInstance();
		$query = 'UPDATE predstavnik SET ime_prezime = :ip, mobilni = :m, email = :e WHERE id_suosnivac = :id';
		$params = [
			':ip'=>$ime_prezime,
			':m'=>$mobilni,
			':e'=>$email,
			':id'=>$id
		];

		try{
			$db->update('Predstavnik', $query, $params);
		}catch(Exception $e){
			return false;
			//echo $e->getMessage();
		}

	}




	public static function updateOvlascenoLice($ime_prezime, $mobilni, $email, $id){

	$db = Database::getInstance();
		$query = 'UPDATE predstavnik SET ime_prezime = :ip, mobilni = :m, email = :e WHERE id_suosnivac = :id';
		$params = [
			':ip'=>$ime_prezime,
			':m'=>$mobilni,
			':e'=>$email,
			':id'=>$id
		];

		try{
			$db->update('Predstavnik', $query, $params);
		}catch(Exception $e){
			return false;
			//echo $e->getMessage();
		}

	}

	public static function countPredstavnika($ime_prezime){
		$db = Database::getInstance();
		$query = 'SELECT * FROM predstavnik WHERE ime_prezime = :ip';
		$params = [':ip'=>$ime_prezime];
		$row = $db->select('Predstavnik', $query, $params);
		$x = count($row);
		return $x;
	}

	


	
	


}