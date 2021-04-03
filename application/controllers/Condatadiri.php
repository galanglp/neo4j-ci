<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condatadiri extends CI_Controller {

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
		if ($this->session->userdata('akses') == "Siswa") {
            
        }elseif ($this->session->userdata('akses') == "Admin") {
        	redirect('main');
        }elseif ($this->session->userdata('akses') == "") {
        	redirect('login');
        }

		$this->load->model('siswa_model');
		$this->idSiswa = $this->session->userdata('idSiswa');
	}

	private $idSiswa;

	public function index($message = 'tes')
	{

		$data = array('session' => $this->session->userdata('akses'), 'dataDiri' => $this->dataDiri($this->idSiswa));
		$this->mylib->load_view_pendaftar('Data Diri','datadiri',$data);
	}

	public function dataDiri($idSiswa)
	{
		return $this->siswa_model->getSiswaById($idSiswa);
	}
}