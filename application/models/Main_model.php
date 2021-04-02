<?php
class Main_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private $query = '';
	private $column_where = array('d.judul','d.penulis','r.tgl_dibuat','r.tgl_modifikasi');
	private $column_order = array('id','judul','penulis','tgl_dibuat','tgl_modifikasi');

	public function edit($id,$data){
        return $this->neo->update($id,$data);
	}

	public function delete($unik){
		$queryString = 'MATCH (a:deskripsi {unik:{unik}}) DETACH DELETE a';
        return $this->neo->execute_query($queryString,$unik);
	}

	public function read($vdx){
		if ($vdx == null) {
			$this->query .= 'MATCH (d:deskripsi)-[r:DIBUAT]->(e1:event)-[r1*..]->(e2:event) ';
		}else {
			$this->query .= $vdx;
		}

		$i = 0;

		if ($_POST['search']['value'] != null) {
			if ($vdx == null) {
				$this->query .= 'WHERE ';
			}
			
			foreach ($this->column_where as $item)
			{
				if ($_POST['search']['value']) {
					$this->query .= ($i===0) ? $item.' =~ "(?i)'.$_POST['search']['value'].'.*" ' : ' OR '.$item.' =~ "(?i)'.$_POST['search']['value'].'.*" ';
				}

				$i++;
			}
		}

		$this->query .= ' RETURN distinct ID(d) as id, d.unik as unik, d.judul as judul, d.penulis as penulis, r.tgl_dibuat as tgl_dibuat, r.tgl_modifikasi as tgl_modifikasi, e1.unik as start, e2.unik as end ';

		if(isset($_POST['order']))
		{
			$this->query .= 'ORDER BY '.$this->column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		}
		else if(isset($this->order))
		{
			$this->query .= 'ORDER BY id ASC';
		}

		if($_POST['length'] != -1){
			$this->query .= ' skip '.$_POST['start'].' limit '.$_POST['length'];
		}
		
        return $this->neo->execute_query($this->query);
	}

	public function count_filtered($vdx)
	{
		$queryString = "";
		if ($vdx == null) {
			$queryString .= 'Match (n:deskripsi)-[r:DIBUAT]->(e:event)-[r1*..]->(e1:event) return count(distinct ID(n)) as count limit '.$_POST['length'];
		}else{
			$queryString .= $vdx;
			$queryString .= " RETURN count(distinct ID(d)) as count limit ".$_POST['length'];
			
		}
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function count_all($vdx)
	{
		$queryString = "";
		if ($vdx == null) {
			$queryString .= 'Match (n:deskripsi)-[r:DIBUAT]->(e:event)-[r1*..]->(e1:event) return count(distinct ID(n)) as count';
		}else{
			$queryString .= $vdx;
			$queryString .= " RETURN count(distinct ID(d)) as count";
		}
		return $this->neo->execute_query($queryString)[0]["count"];
	}

}
?>