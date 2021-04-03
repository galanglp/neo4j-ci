<?php
class Siswa_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private $relation = array();
	private $siswa = array();
	private $kelamin = array();
	private $kota = array();
	private $agama = array();
	private $ayah = array();
	private $ibu = array();
	private $pekerjaanAyah = array();
	private $pekerjaanIbu = array();
	private $user = array();
	private $akses = array();
	private $status = array();
	private $query = '';
	private $column_where = array('n.nip','n.nama','k1.kelamin','k2.namaKota','r2.tanggalLahir','k4.agama','n.anakKe','n.dari','r3.alamat','k3.namaKota','n.telepon','n.email','k5.nama','k6.nama','n.alamatOrtu','n.teleponOrtu','k7.profesi','k8.profesi','k9.status');
	private $column_order = array('idSiswa','nama','kelamin','tempatLahir','tanggalLahir','agama','anakKe','alamat','kota','telepon','email','ayah','ibu','alamatOrtu','teleponOrtu','profesiAyah','profesiIbu','status');

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

	public function saveUser($data)
	{
		$id = $this->saveNode('user',$data);
		$this->user = array(
			'id' => $id
		);

		$relationUser = array(
			'name' => 'user',
			'from' => $this->siswa['id'],
			'to' => $this->user['id']
		);
		array_push($this->relation, (object) $relationUser);
	}

	public function saveAkses($data)
	{
		$akses = $this->getIdNode($data['akses'], 'akses', 'akses');

		if(isset($akses[0]['id'])) {
			$this->akses = array(
				'id' => $akses[0]['id']
			);
		} else {
			$id = $this->saveNode('akses',$data);
			$this->akses = array(
				'id' => $id
			);
		}

		$relationAkses = array(
			'name' => 'akses',
			'from' => $this->user['id'],
			'to' => $this->akses['id']
		);
		array_push($this->relation, (object) $relationAkses);
	}

	public function saveSiswa($data)
	{
		$id = $this->saveNode('siswa',$data);
		$this->siswa = array(
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
			'from' => $this->siswa['id'],
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
			'from' => $this->siswa['id'],
			'to' => $this->kota['id'],
			'property' => array('tanggalLahir' => $tanggal),
		);
		array_push($this->relation, (object) $relationTempatLahir);
	}

	public function saveAgama($data)
	{
		$agama = $this->getIdNode($data['agama'], 'agama', 'agama');
		if(isset($agama[0]['id'])) {
			$this->agama = array(
				'id' => $agama[0]['id']
			);
		} else {
			$id = $this->saveNode('agama',$data);
			$this->agama = array(
				'id' => $id
			);
		}

		$relationAgama = array(
			'name' => 'agama',
			'from' => $this->siswa['id'],
			'to' => $this->agama['id'],
		);
		array_push($this->relation, (object) $relationAgama);
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
			'from' => $this->siswa['id'],
			'to' => $this->kota['id'],
			'property' => array('alamat' => $alamat),
		);
		array_push($this->relation, (object) $relationAlamat);
	}

	public function saveAyah($data)
	{
		$id = $this->saveNode('ayah',$data);
		$this->ayah = array(
			'id' => $id
		);

		$relationAyah = array(
			'name' => 'ayah',
			'from' => $this->siswa['id'],
			'to' => $this->ayah['id'],
		);
		array_push($this->relation, (object) $relationAyah);
	}

	public function saveIbu($data)
	{
		$id = $this->saveNode('ibu',$data);
		$this->ibu = array(
			'id' => $id
		);

		$relationIbu = array(
			'name' => 'ibu',
			'from' => $this->siswa['id'],
			'to' => $this->ibu['id'],
		);
		array_push($this->relation, (object) $relationIbu);
	}

	public function savePekerjaanAyah($data)
	{
		$pekerjaanAyah = $this->getIdNode($data['profesi'], 'profesi', 'profesi');
		if(isset($pekerjaanAyah[0]['id'])) {
			$this->pekerjaanAyah = array(
				'id' => $pekerjaanAyah[0]['id']
			);
		} else {
			$id = $this->saveNode('profesi',$data);
			$this->pekerjaanAyah = array(
				'id' => $id
			);
		}

		$relationPekerjaanAyah = array(
			'name' => 'profesi',
			'from' => $this->ayah['id'],
			'to' => $this->pekerjaanAyah['id'],
		);
		array_push($this->relation, (object) $relationPekerjaanAyah);
	}

	public function savePekerjaanIbu($data)
	{
		$pekerjaanIbu = $this->getIdNode($data['profesi'], 'profesi', 'profesi');
		if(isset($pekerjaanIbu[0]['id'])) {
			$this->pekerjaanIbu = array(
				'id' => $pekerjaanIbu[0]['id']
			);
		} else {
			$id = $this->saveNode('profesi',$data);
			$this->pekerjaanIbu = array(
				'id' => $id
			);
		}

		$relationPekerjaanIbu = array(
			'name' => 'profesi',
			'from' => $this->ibu['id'],
			'to' => $this->pekerjaanIbu['id'],
		);
		array_push($this->relation, (object) $relationPekerjaanIbu);
	}

	public function saveStatus($data)
	{
		$status = $this->getIdNode($data['status'], 'status', 'status');
		if(isset($status[0]['id'])) {
			$this->status = array(
				'id' => $status[0]['id']
			);
		} else {
			$id = $this->saveNode('status',$data);
			$this->status = array(
				'id' => $id
			);
		}

		$relationStatus = array(
			'name' => 'status',
			'from' => $this->siswa['id'],
			'to' => $this->status['id'],
		);
		array_push($this->relation, (object) $relationStatus);
	}

	public function setIdSiswa($id)
	{
		$this->siswa = array(
			'id' => $id
		);
	}

	public function setIdAyah($id)
	{
		$this->ayah = array(
			'id' => $id
		);
	}

	public function setIdIbu($id)
	{
		$this->ibu = array(
			'id' => $id
		);
	}

	public function getSiswaById($id)
	{
		$this->query .= 'MATCH (n:siswa)-[r9:status]->(k9:status), (n)-[r1:kelamin]->(k1:kelamin), (n)-[r2:tempatLahir]->(k2:kota), (n)-[r3:alamat]->(k3:kota), (n)-[r4:agama]->(k4:agama), (n)-[r5:ayah]->(k5:ayah), (n)-[r6:ibu]->(k6:ibu), (k5)-[r7:profesi]->(k7:profesi), (k6)-[r8:profesi]->(k8:profesi) ';
		$this->query .= 'WHERE ID(n)='.$id.' ';
		$this->query .= ' RETURN ID(n) as idSiswa, n.nama as nama, n.anakKe as anakKe, n.dari as dari, n.telepon as telepon, n.email as email, n.alamatOrtu as alamatOrtu, n.teleponOrtu as teleponOrtu, k1.jenisKelamin as kelamin, k2.namaKota as tempatLahir, r2.tanggalLahir as tanggalLahir, k3.namaKota as kota, r3.alamat as alamat, k4.agama as agama, k5.nama as ayah, k6.nama as ibu, k7.profesi as profesiAyah, k8.profesi as profesiIbu, k9.status as status ';
		return $this->neo->execute_query($this->query);
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

	public function count_filtered($status)
	{
		$queryString = 'match (n:siswa)-->(k:status) ';
		$queryString .= 'WHERE (';

		$i = 0;

		foreach ($status as $stat) {
			$queryString .= ($i===0) ? 'k.status="'.$stat.'" ' : ' OR k.status="'.$stat.'"';
			$i++;
		}

		$queryString .= ')';
		$queryString .= ' RETURN count(distinct ID(n)) as count limit '.$_POST['length'];
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function count_all($status)
	{
		$queryString = 'match (n:siswa)-->(k:status) ';
		$queryString .= 'WHERE (';

		$i = 0;

		foreach ($status as $stat) {
			$queryString .= ($i===0) ? 'k.status="'.$stat.'" ' : ' OR k.status="'.$stat.'"';
			$i++;
		}

		$queryString .= ')';
		$queryString .= ' RETURN count(distinct ID(n)) as count';
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function read($status)
	{
		$this->query .= 'MATCH (n:siswa)-[r9:status]->(k9:status), (n)-[r1:kelamin]->(k1:kelamin), (n)-[r2:tempatLahir]->(k2:kota), (n)-[r3:alamat]->(k3:kota), (n)-[r4:agama]->(k4:agama), (n)-[r5:ayah]->(k5:ayah), (n)-[r6:ibu]->(k6:ibu), (k5)-[r7:profesi]->(k7:profesi), (k6)-[r8:profesi]->(k8:profesi), (n)-->(u:user) ';

		$i = 0;

		if ($_POST['search']['value'] != null) {
			$this->query .= 'WHERE (';

			foreach ($status as $stat) {
				$this->query .= ($i===0) ? 'k9.status="'.$stat.'" ' : ' OR k9.status="'.$stat.'"';
				$i++;
			}

			$i = 0;

			$this->query .= ') AND (';

			foreach ($this->column_where as $item)
			{
				if ($_POST['search']['value']) {
					$this->query .= ($i===0) ? $item.' =~ "(?i)'.$_POST['search']['value'].'.*" ' : ' OR '.$item.' =~ "(?i)'.$_POST['search']['value'].'.*" ';
				}

				$i++;
			}

			$this->query .= ') ';
		}else {
			$this->query .= 'WHERE (';

			foreach ($status as $stat) {
				$this->query .= ($i===0) ? 'k9.status="'.$stat.'" ' : ' OR k9.status="'.$stat.'"';
				$i++;
			}
			
			$this->query .= ')';
		}

		$this->query .= ' RETURN ID(n) as idSiswa, n.nama as nama, n.anakKe as anakKe, n.dari as dari, n.telepon as telepon, n.email as email, n.alamatOrtu as alamatOrtu, n.teleponOrtu as teleponOrtu, ID(r1) as idRKelamin, k1.jenisKelamin as kelamin, ID(r2) as idRTanggal, k2.namaKota as tempatLahir, r2.tanggalLahir as tanggalLahir, ID(r3) as idRAlamat, k3.namaKota as kota, r3.alamat as alamat, ID(r4) as idRAgama, k4.agama as agama, ID(k5) as idAyah, k5.nama as ayah, ID(k6) as idIbu, k6.nama as ibu, ID(r7) as idRProfesiAyah,  k7.profesi as profesiAyah, ID(r8) as idRProfesiIbu, k8.profesi as profesiIbu, ID(r9) as idRStatus, k9.status as status, ID(u) as idUser, u.user as user, u.password as password ';

		if(isset($_POST['order']))
		{
			$this->query .= 'ORDER BY '.$this->column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		}
		else if(isset($this->order))
		{
			$this->query .= 'ORDER BY idSiswa ASC';
		}

		if($_POST['length'] != -1){
			$this->query .= ' skip '.$_POST['start'].' limit '.$_POST['length'];
		}

		return $this->neo->execute_query($this->query);
	}

}
?>