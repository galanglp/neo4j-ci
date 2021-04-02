<?php
class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function cek_model($data){
		$queryString = 'match (a:user{user:{user},password:{password}}) return count(a) as count, a.akses as akses, a.user as user';
        return $this->neo->execute_query($queryString,$data);
	}

}
?>