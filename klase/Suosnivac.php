<?php

require_once __DIR__.'/Tabela.php';


class Suosnivac extends Tabela{
	public $id;
	public $naziv;
	public $adresa;
	public $postanski_broj;
	public $mesto;
	public $pak;
	public $maticni;
	public $pib;
	public $datum_potpisivanja;
	public $datum_apr;
	public $napomena;
	public $ugovor;
	public $pristupnica;
	public $ovlascenje;
	public $id_glasanje;
	public $id_stanje;
	public $id_status;
	public $apr_obrisan;



	public static function insertSuosnivac($naziv, $adresa, $postanski_broj, $mesto, $pak, $maticni_broj, $pib, $datum_potpisivanja, $datum_apr, $napomena, $ugovor, $pristupnica, $ovlascenje, $id_glasanje){
		$db = Database::getInstance();
		$query = 'INSERT INTO suosnivac (naziv, adresa, postanski_broj, mesto, pak, maticni, pib, datum_potpisivanja, datum_apr, napomena, ugovor, pristupnica, ovlascenje, id_glasanje) VALUES (:n, :a, :pb, :m, :pak, :mb, :pib, :dp, :da, :nap, :ug, :pr, :o, :idg)';
		$params = [
			':n'=>$naziv,
			':a'=>$adresa,
			':pb'=>$postanski_broj,
			':m'=>$mesto,
			':pak'=>$pak,
			':mb'=>$maticni_broj,
			':pib'=>$pib,
			':dp'=>$datum_potpisivanja,
			':da'=>$datum_apr,
			':nap'=>$napomena,
			':ug'=>$ugovor,
			':pr'=>$pristupnica,
			':o'=>$ovlascenje,
			':idg'=>$id_glasanje
		];

		try{
			$db->insert('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}
		return $id_suosnivac = $db->lastInsertId();
	}

	public static function getAll(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac WHERE apr_obrisan = 0 ORDER BY datum_apr ASC';
		return $db->select('Suosnivac', $query);
	}

	public static function getSvePoAprRedu(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac WHERE apr_obrisan = 0 ORDER BY datum_apr ASC';
		return $db->select('Suosnivac', $query);
	}

	public static function getSuosnivac($id){
		$db = Database::getInstance();

		$query = 'SELECT * FROM suosnivac WHERE id = :id';
		$params = [
			':id'=>$id
		];
		
		$suosnivaci = $db->select('Suosnivac', $query, $params);

		foreach ($suosnivaci as $suosnivac) {
			return $suosnivac;
		} return null;
	}


	public static function updateSuosnivac($naziv, $adresa, $postanski_broj, $mesto, $pak, $maticni_broj, $pib, $datum_potpisivanja, $datum_apr, $napomena, $ugovor, $pristupnica, $ovlascenje, $id_glasanje, $id){
		
		$db = Database::getInstance();
		$query = 'UPDATE suosnivac SET naziv = :n, adresa = :a, postanski_broj = :pb, mesto = :m, pak = :p, maticni = :mb, pib = :pi, datum_potpisivanja = :dp, datum_apr = :da, napomena = :nap, ugovor = :ug, pristupnica = :pris, ovlascenje = :ovl, id_glasanje = :idgl WHERE id = :id';
		
		$params = [
			':n'=>$naziv,
			':a'=>$adresa,
			':pb'=>$postanski_broj,
			':m'=>$mesto,
			':p'=>$pak,
			':mb'=>$maticni_broj,
			':pi'=>$pib,
			':dp'=>$datum_potpisivanja,
			':da'=>$datum_apr,
			':nap'=>$napomena,
			':ug'=>$ugovor,
			':pris'=>$pristupnica,
			':ovl'=>$ovlascenje,
			':idgl'=>$id_glasanje,
			':id'=>$id
		];
		

		try{
			$db->update('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}



	public static function obrisi($id){
		$db = Database::getInstance();

		$query = 'DELETE FROM suosnivac WHERE id = :id';
		$params = [
			':id'=>$id
		];

		$db->delete($query, $params);
	}



	public static function updateOvlascenje($novo_ovlascenje, $id){
		
		$db = Database::getInstance();

		$query = 'UPDATE suosnivac SET ovlascenje = :o WHERE id = :id';
		$params = [
			':o'=>$novo_ovlascenje,
			'id'=>$id
		];

		try{
			$db->update('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}

	public static function prebroji(){
		$db = Database::getInstance();

		$query = 'SELECT * FROM suosnivac WHERE id_stanje = 1';
		$row = $db->select('Suosnivac', $query);
		$x = count($row);
		return $x;
	}


	public static function getAllByDate(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac GROUP BY datum_potpisivanja ASC';
		return $db->select('Suosnivac', $query);
	}

	public static function getAllZaChart(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac WHERE id_stanje = 1 and apr_obrisan = 0';
		return $db->select('Suosnivac', $query);
	}

	public static function getAllZaListu(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac WHERE apr_obrisan = 0 AND datum_apr IS NOT NULL';
		return $db->select('Suosnivac', $query);
	}




	public static function getDatumApr($id){
		$db = Database::getInstance();

		$query = 'SELECT datum_apr FROM suosnivac WHERE id = :id';
		$params = [
			':id'=>$id
		];
		
		$datum_apr = $db->select('Suosnivac', $query, $params);
		foreach ($datum_apr as $datapr) {
			return $datapr->datum_apr;
		} return null;
	}


	public static function updateStanje($id){
		
		$db = Database::getInstance();

		$query = 'UPDATE suosnivac SET id_stanje = :st, id_glasanje = :ig WHERE id = :id';
		$params = [
			':st'=>2,
			':ig'=>3,
			'id'=>$id
		];

		try{
			$db->update('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}

	public static function getSveNeaktivne(){
		$db = Database::getInstance();
		$query = 'SELECT * FROM suosnivac WHERE id_stanje = 2';
		return $db->select('Suosnivac', $query);
	}


	public static function updatePravoGlasa($id, $pravo_glasa){
		
		$db = Database::getInstance();

		$query = 'UPDATE suosnivac SET id_glasanje = :ig WHERE id = :id';
		$params = [
			':ig'=>$pravo_glasa,
			'id'=>$id
		];

		try{
			$db->update('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}


	public static function updateBrisanjeApr($id){		
		$db = Database::getInstance();
		$query = 'UPDATE suosnivac SET apr_obrisan = 1 WHERE id = :id';
		$params = ['id'=>$id];
		try{
			$db->update('Suosnivac', $query, $params);
		}catch(Exception $e){
			return false;
		}

	}
	



	

}