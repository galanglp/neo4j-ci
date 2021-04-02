<?php
class Guru_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private $guru = array();
	private $kelamin = array();
	private $kota = array();
	private $relation = array();
	private $query = '';
	private $column_where = array('n.nip','n.nama','k1.kelamin','k2.namaKota','r2.tanggalLahir','r3.alamat','k3.namaKota','n.telepon','n.email');
	private $column_order = array('idGuru','nip','nama','kelamin','tempatLahir','tanggalLahir','alamat','kota','telepon','email');

	public function saveNode($modelName,$data){
        return $this->neo->insert($modelName,$data);
	}

	public function getIdNode($data, $where, $node)
	{
		$queryString = 'match (k:'.$node.') where k.'.$where.' = "'.$data.'" return ID(k) as id';
		return $this->neo->execute_query($queryString);
	}

	public function addRelation()
	{
		foreach ($this->relation as $rl) {
			if (isset($rl->property)) {
				$this->neo->add_relation($rl->from, $rl->to, $rl->name, $rl->property);
			}else {
				$this->neo->add_relation($rl->from, $rl->to, $rl->name);
			}
		}
	}

	public function saveGuru($data)
	{
		$id = $this->saveNode('guru',$data);
		$this->guru = array(
			'id' => $id
		);
		
	}

	public function saveKelamin($data)
	{
		$kelamin = $this->getIdNode($data['jenisKelamin'], 'jenisKelamin', 'kelamin');

		if(isset($kelamin[0]['id'])) {
			$this->kelamin = array(
				'id' => $kelamin[0]['id']
			);
		} else {
			$id = $this->saveNode('kelamin',$data);
			$this->kelamin = array(
				'id' => $id
			);
		}

		$relationKelamin = array(
			'name' => 'kelamin',
			'from' => $this->guru['id'],
			'to' => $this->kelamin['id']
		);
		array_push($this->relation, (object) $relationKelamin);
	}

	public function saveTempatLahir($data,$tanggal)
	{
		$tempat = $this->getIdNode($data['namaKota'], 'namaKota', 'kota');
		if(isset($tempat[0]['id'])) {
			$this->kota = array(
				'id' => $tempat[0]['id']
			);
		} else {
			$id = $this->saveNode('kota',$data);
			$this->kota = array(
				'id' => $id
			);
		}

		$relationTempatLahir = array(
			'name' => 'tempatLahir',
			'from' => $this->guru['id'],
			'to' => $this->kota['id'],
			'property' => array('tanggalLahir' => $tanggal),
		);
		array_push($this->relation, (object) $relationTempatLahir);
	}

	public function saveAlamat($data,$alamat)
	{
		$kota = $this->getIdNode($data['namaKota'], 'namaKota', 'kota');
		if(isset($kota[0]['id'])) {
			$this->kota = array(
				'id' => $kota[0]['id']
			);
		} else {
			$id = $this->saveNode('kota',$data);
			$this->kota = array(
				'id' => $id
			);
		}

		$relationAlamat = array(
			'name' => 'alamat',
			'from' => $this->guru['id'],
			'to' => $this->kota['id'],
			'property' => array('alamat' => $alamat),
		);
		array_push($this->relation, (object) $relationAlamat);
	}

	public function edit($id,$data){
        return $this->neo->update($id,$data);
	}

	public function delete_relation($id){
		return $this->neo->delete_relation($id);
	}

	public function delete($id,$name){
		$queryString = 'MATCH (n:'.$name.') where ID(n)='.$id.' DETACH DELETE n';
		return $this->neo->execute_query($queryString);
	}

	public function count_filtered()
	{
		$queryString = 'match (n:guru) return count(distinct ID(n)) as count limit '.$_POST['length'];
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function count_all()
	{
		$queryString = 'match (n:guru) return count(distinct ID(n)) as count';
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function setIdGuru($id)
	{
		$this->guru = array(
			'id' => $id
		);
	}

	public function read()
	{
		$this->query .= 'MATCH (n:guru), (n)-[r1:kelamin]->(k1:kelamin), (n)-[r2:tempatLahir]->(k2:kota), (n)-[r3:alamat]->(k3:kota) ';

		$i = 0;

		if ($_POST['search']['value'] != null) {
			$this->query .= 'WHERE ';

			foreach ($this->column_where as $item)
			{
				if ($_POST['search']['value']) {
					$this->query .= ($i===0) ? $item.' =~ "(?i)'.$_POST['search']['value'].'.*" ' : ' OR '.$item.' =~ "(?i)'.$_POST['search']['value'].'.*" ';
				}

				$i++;
			}
		}

		$this->query .= ' RETURN ID(n) as idGuru, n.nip as nip, n.nama as nama, n.telepon as telepon, n.email as email, ID(r1) as idRKelamin, k1.jenisKelamin as kelamin, ID(r2) as idRTanggal, k2.namaKota as tempatLahir, r2.tanggalLahir as tanggalLahir, ID(r3) as idRAlamat, k3.namaKota as kota, r3.alamat as alamat ';

		if(isset($_POST['order']))
		{
			$this->query .= 'ORDER BY '.$this->column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		}
		else if(isset($this->order))
		{
			$this->query .= 'ORDER BY idGuru ASC';
		}

		if($_POST['length'] != -1){
			$this->query .= ' skip '.$_POST['start'].' limit '.$_POST['length'];
		}

		return $this->neo->execute_query($this->query);
	}

}
?>