<?php

require_once __DIR__.'/Tabela.php';

class Konferencija extends Tabela {
	public $id;
	public $naziv;
	public $datum;
	public $vreme;
	public $organizator;
	public $lokacija;
	public $datum_liste;


	
	public static function getSve(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM konferencija';
		return $db->select('Konferencija', $query);
		
	}
	
	public static function countSveKonferencijePoDatumuListe($datum_liste){
		$db = Database::getInstance();
		$query = 'SELECT COUNT(*) as ukupno FROM konferencija WHERE datum >= DATE_SUB(curdate(), INTERVAL 1 YEAR) AND datum < :dl';
		$params = [
			':dl'=>$datum_liste
		];
		return $db->select('Konferencija', $query, $params);
	}
	
	public static function countSveKonferencije(){
		$db = Database::getInstance();
		$query = 'SELECT COUNT(*) as ukupno FROM konferencija WHERE datum >= DATE_SUB(curdate(), INTERVAL 1 YEAR) AND datum <= curdate()';
		return $db->select('Konferencija', $query);
	}


	public static function getKonferencijuPoId($id){
		$db = Database::getInstance();

		$query = 'SELECT * FROM konferencija WHERE id = :id';
		$params = [
			':id'=>$id
		];
		
		$koferencije = $db->select('Konferencija', $query, $params);

		foreach ($koferencije as $koferencija) {
			return $koferencija;
		} return null;
	}


	public static function insertKonferenciju($naziv, $datum, $vreme, $organizator, $lokacija){
		$db = Database::getInstance();
		$query = 'INSERT INTO konferencija (naziv, datum, vreme, organizator, lokacija) VALUES (:n, :d, :v, :o, :l)';
		$params = [
			':n'=>$naziv,
			':d'=>$datum,
			':v'=>$vreme,
			':o'=>$organizator,
			':l'=>$lokacija
		];

		try{
			$db->insert('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
		}
		return $id_konferencija = $db->lastInsertId();
	}

	public static function updateGenerisanaLista($url, $id_konferencija){
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET url = :uri WHERE id = :idk';
		$params = [
			':uri'=>$url,
			':idk'=>$id_konferencija
		];

		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
			//echo $e->getMessage();
		}
	}

	public static function updateGenerisanaNeformalna($url, $id_konferencija){
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET neformalna_url = :uri WHERE id = :idk';
		$params = [
			':uri'=>$url,
			':idk'=>$id_konferencija
		];

		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
			//echo $e->getMessage();
		}
	}

	public static function updateKonferenciju($id, $konferencija, $datum, $vreme, $organizator, $lokacija){
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET naziv = :kon, datum = :dat, vreme = :vr, organizator = :org, lokacija = :lok  WHERE id = :idk';
		$params = [
			':idk'=>$id,
			':kon'=>$konferencija,
			':dat' =>$datum,
			':vr'=>$vreme,
			':org'=>$organizator,
			':lok'=>$lokacija
		];

		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
			//echo $e->getMessage();
		}


	}


	public static function insertDatumListe($datum_liste, $id_konferencija){
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET datum_liste = :dl  WHERE id = :idk';
		$params = [
			':idk'=>$id_konferencija,
			':dl'=>$datum_liste
		];

		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
			echo $e->getMessage();
		}


	}


	public static function obrisiFormalnuListu($id){		
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET url = null WHERE id = :id';
		$params = ['id'=>$id];
		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}

	public static function obrisiNeformalnuListu($id){		
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET neformalna_url = null WHERE id = :id';
		$params = ['id'=>$id];
		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}

	public static function obrisiDatumListe($id){		
		$db = Database::getInstance();
		$query = 'UPDATE konferencija SET datum_liste = null WHERE id = :id';
		$params = ['id'=>$id];
		try{
			$db->update('Konferencija', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}



}