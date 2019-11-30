<?php
require_once __DIR__.'/Tabela.php';

class Prisustvokonferenciji extends Tabela {
	public $id;
	public $id_konferencija;
	public $id_suosnivac;

	public static function getPrisustvokonferenciji($id, $ids) {
		$db = Database::getInstance();

		$query = "SELECT * FROM prisustvokonferenciji WHERE id_konferencija = :id AND id_suosnivac = :ids";
		$params = [
			':id' => $id,
			':ids'=> $ids
		];
		$records = $db->select('Prisustvokonferenciji', $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}

	public static function countPrisustvokonferenciji($id) {
		$db = Database::getInstance();

		$query = "SELECT COUNT(*) AS prisustvovao FROM prisustvokonferenciji WHERE id_konferencija = :id";
		$params = [
			':id' => $id
		];
		$records = $db->select('Prisustvokonferenciji', $query, $params);
		foreach($records as $record){
			return $record;
		}
		return null;
	}


	public static function insertPrisustvo($konferencija, $prisutan){
			$db = Database::getInstance();
			$query = 'INSERT INTO prisustvokonferenciji (id_konferencija, id_suosnivac) VALUES (:idk,:ids)';
			$params = [
				':idk'=>$konferencija,
				':ids'=>$prisutan
			];
			try{
			$db->insert('Prisustvokonferenciji', $query, $params);
				}catch(Exception $e){
					echo $e->getMessage();
					die();
				}
				return $db->lastInsertId();
			
	}

	public static function getAllPrisustvo($id) {
		$db = Database::getInstance();

		$query = "SELECT * FROM prisustvokonferenciji WHERE id_konferencija = :id";
		$params = [
			':id' => $id
		];
		return $db->select('Prisustvokonferenciji', $query, $params);
		
	}

	public static function updatePrisustvo($konferencija, $prisutan){
		
		$db = Database::getInstance();
		$query = 'UPDATE prisustvokonferenciji SET id_konferencija = :idk WHERE id_suosnivac = :ids AND id_konferencija = :idk';
		
		$params = [
				':idk'=>$konferencija,
				':ids'=>$prisutan
			];
		try{
			$db->update('Prisustvokonferenciji', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}

	public static function obrisiPrisustvo($konferencija, $ids){		
		$db = Database::getInstance();
		$query = 'DELETE FROM prisustvokonferenciji WHERE id_konferencija = :idk AND id_suosnivac = :ids';
		$params = [
				':idk'=>$konferencija,
				':ids'=>$ids
			];
		$db->delete($query, $params);

	}

	
	public static function obrisiSvoPrisustvo($konferencija){		
		$db = Database::getInstance();
		$query = 'DELETE FROM prisustvokonferenciji WHERE id_konferencija = :idk';
		$params = [
				':idk'=>$konferencija
			];
		$db->delete($query, $params);

	}

	public static function countPrisustvoSuosnivaca($ids) {
		$db = Database::getInstance();

		$query = "SELECT prisustvokonferenciji.id_suosnivac, COUNT(prisustvokonferenciji.id_konferencija) AS prisustvo FROM prisustvokonferenciji LEFT JOIN konferencija ON konferencija.id = prisustvokonferenciji.id_konferencija WHERE konferencija.datum >= DATE_SUB(curdate(), INTERVAL 1 YEAR) and prisustvokonferenciji.id_suosnivac = :id GROUP BY 1";
		$params = [
			':id' => $ids
		];
		$records = $db->select('Prisustvokonferenciji', $query, $params);
		foreach($records as $record){
			return $record->prisustvo;
		}
		return null;
	}




}