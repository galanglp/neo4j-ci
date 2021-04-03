<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('login_model');
	}

	public function index($message = '')
	{

		$result = array(
			'action' => 'login/cek',
			'message' => $message
		);
		$this->load->view('login',$result);
	}

	public function cek()
	{
		$data = array(
                    'user' => $this->input->post('user'),
                'password' => $this->input->post('password')
            );
		$user = $this->login_model->cek_model($data);
		$userSiswa = $this->login_model->getUserSiswa($data);
		if ($user[0]['count'] == null) {
			redirect('login/index/gagal');
		}elseif ($user[0]['akses'] == "Admin") {
			$sess = array(
				'user' => $user[0]['user'],
				'akses' => $user[0]['akses'],
			);
			$this->session->set_userdata($sess);
			redirect('main');
		}elseif ($user[0]['akses'] == "Siswa") {
			$sess = array(
				'idSiswa' => $userSiswa[0]['idSiswa'],
				'user' => $userSiswa[0]['user'],
				'akses' => $userSiswa[0]['akses'],
			);
			$this->session->set_userdata($sess);
			redirect('condatadiri');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}