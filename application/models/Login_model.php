<?php
class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function cek_model($data){
		$queryString = 'MATCH (u:user)-->(a:akses) WHERE u.user={user} AND u.password={password} RETURN count(u) as count, a.akses as akses, u.user as user';
        return $this->neo->execute_query($queryString,$data);
	}

	public function getUserSiswa($data)
	{
		$queryString = 'match (n:siswa)-->(u:user)-->(a:akses) WHERE u.user={user} AND u.password={password} return count(n) as count, ID(n) as idSiswa, a.akses as akses, u.user as user';
        return $this->neo->execute_query($queryString,$data);
	}

}
?>