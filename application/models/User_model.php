<?php
class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private $user = array();
	private $akses = array();
	private $relation = array();
	private $query = '';
	private $column_where = array('n.user','n.password','k.akses');
	private $column_order = array('idUser','user','akses');

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

	public function saveUser($modelName,$data)
	{
		$id = $this->saveNode($modelName,$data);
		$this->user = array(
			'id' => $id
		);
		
	}

	public function saveAkses($modelName,$data)
	{
		$akses = $this->getIdNode($data['akses'], 'akses', $modelName);

		if(isset($akses[0]['id'])) {
			$this->akses = array(
				'id' => $akses[0]['id']
			);
		} else {
			$id = $this->saveNode($modelName,$data);
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

	public function edit($id,$data){
        return $this->neo->update($id,$data);
	}

	public function delete($id,$name){
		$queryString = 'MATCH (n:'.$name.') where ID(n)='.$id.' DETACH DELETE n';
		return $this->neo->execute_query($queryString);
	}

	public function count_filtered()
	{
		$queryString = 'match (n:user) return count(distinct ID(n)) as count limit '.$_POST['length'];
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function count_all()
	{
		$queryString = 'match (n:user) return count(distinct ID(n)) as count';
		return $this->neo->execute_query($queryString)[0]["count"];
	}

	public function read()
	{
		$this->query .= 'MATCH (n:user)-[r:akses]->(k:akses) ';

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

		$this->query .= ' RETURN ID(n) as idUser, n.user as user, n.password as password, ID(r) as idRAkses, k.akses as akses ';

		if(isset($_POST['order']))
		{
			$this->query .= 'ORDER BY '.$this->column_order[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'];
		}
		else if(isset($this->order))
		{
			$this->query .= 'ORDER BY idUser ASC';
		}

		if($_POST['length'] != -1){
			$this->query .= ' skip '.$_POST['start'].' limit '.$_POST['length'];
		}

		return $this->neo->execute_query($this->query);
	}

}
?>