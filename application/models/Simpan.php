<?php
class Simpan extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function simpan_act($data){
		$queryString = "CREATE (a:activity{unik:{Id},nama:{Name}}) Return ID(a) as id, a.unik as unik";
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_desk($data){
		$queryString = "CREATE (a:deskripsi{unik:{unik},judul:{judul},penulis:{penulis},versi:{versi}})-[r:DIBUAT{tgl_dibuat:{tgl_dibuat},tgl_modifikasi:{tgl_modifikasi}}]->(e:event{unik:{Id},nama:{Name}}) RETURN ID(e) as id, e.unik as unik";
		return $this->neo->execute_query($queryString,$data);
	}

	public function count_desk(){
		$queryString = 'Match (d:deskripsi) return count(d)+1 as jumlah';
		return $this->neo->execute_query($queryString);
	}

	public function simpan_dibuat($data){
		$queryString = 'MATCH (a:deskripsi),(b) WHERE a.unik = {unik} AND b.unik = {Id}
		CREATE (a)-[r:DIBUAT{tgl_dibuat:{tgl_dibuat},tgl_modifikasi:{tgl_modifikasi}}]->(b)';
		$this->neo->execute_query($queryString,$data);
	}

	public function simpan_act_art($data){
		$queryString = 'CREATE (a:activity{unik:{Id},nama:{Name},art:{ArtifactId}}) Return ID(a) as id, a.unik as unik';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_event($data){
		$queryString = 'CREATE (e:event{unik:{Id},nama:{Name}}) Return ID(e) as id, e.unik as unik ';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_gate($data){
		$queryString = 'CREATE (g:gateway{unik:{Id},nama:{Name}}) Return ID(g) as id, g.unik as unik';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_dataObj($data){
		$queryString = 'CREATE (a:dataObjek{unik:{Id},nama:{Name}}) Return ID(a) as id, a.unik as unik ';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_dataStore($data){
		$queryString = 'CREATE (a:dataStore{unik:{Id},nama:{Name}}) Return ID(a) as id, a.unik as unik ';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_sequence($data){
		$queryString = 'MATCH (a),(b)
		WHERE ID(a) = {From} AND ID(b) = {To}
		CREATE (a)-[r:SEQUENCE{unik:{Id}}]->(b)
		RETURN type(r)';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_messageFlow($data){
		$queryString = 'MATCH (a),(b)
		WHERE a.unik = {Source} AND b.unik = {Target}
		CREATE (a)-[r:MESSAGE{unik:{Id}}]->(b)
		RETURN type(r)';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_asc($data){
		$queryString = 'MATCH (a),(b)
		WHERE a.unik = {Source} AND b.unik = {Target}
		CREATE (a)-[r:ASSOCIATION{unik:{Id}}]->(b)
		RETURN type(r) ';
		return $this->neo->execute_query($queryString,$data);
	}

	public function simpan_dataAsc($data){
		$queryString = 'MATCH (a),(b)
		WHERE a.unik = {From} AND b.art = {To}
		CREATE (a)-[r:DATA_ASC{unik:{Id}}]->(b)
		RETURN type(r) ';
		return $this->neo->execute_query($queryString,$data);
	}
}
?>