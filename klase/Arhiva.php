<?php

require_once __DIR__.'/Tabela.php';

class Arhiva extends Tabela {
	public $id;
	public $staro_ime;
	public $stari_mobilni;
	public $stari_email;
	public $staro_ovlascenje;
	public $id_suosnivac;


	public static function arhivaInsert($staro_ime, $stari_mobilni, $stari_email, $staro_ovlascenje, $id){
		
		$db = Database::getInstance();
			$query = 'INSERT INTO arhiva (staro_ime, stari_mobilni, stari_email, staro_ovlascenje, id_suosnivac) VALUES (:si,:sm,:se, :so, :ids)';
			$params = [
				':si'=>$staro_ime,
				':sm'=>$stari_mobilni,
				':se'=>$stari_email,
				':so'=>$staro_ovlascenje,
				':ids'=>$id
			];
			try{
			$db->insert('Arhiva', $query, $params);
				}catch(Exception $e){
					echo $e->getMessage();
					die();
				}
				return $db->lastInsertId();
	}





}