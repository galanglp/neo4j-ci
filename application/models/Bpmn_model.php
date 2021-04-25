<?php
class Bpmn_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function save($data){
		$queryString = 'create (a:guru{nip:{nip},nama:{nama},jenis_kelamin:{jenisKelamin},tempat_lahir:{tempatLahir},tanggal_lahir:{tanggalLahir},alamat:{alamat},kota:{kota},telepon:{telepon},email:{email}}) return a';
        return $this->neo->execute_query($queryString,$data);
	}

	public function edit($id,$data){
        return $this->neo->update($id,$data);
	}

	public function delete($id){
		return $this->neo->remove_node($id);
	}

	public function read($start){
		$queryString = 'MATCH (e:event{unik:"'.$start.'"}),(e1:event), p = (e)-[r*..]-(e1) 
			RETURN extract(n in nodes(p) | n.nama) as nama, extract(r in rels(p) | type(r)) as r,extract(n in nodes(p) | labels(n)) as label, extract(n in nodes(p) | n.unik) as unik';
        return $this->neo->execute_query($queryString);
	}

}
?>