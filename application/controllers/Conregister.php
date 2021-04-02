<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conregister extends CI_Controller {

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
		$this->load->model('siswa_model');
	}

	public function index($message = 'tes')
	{

		$result = array(
			'action' => 'conregister/save',
			'message' => $message
		);
		$this->load->view('register',$result);
	}

	public function save(){
		$dataSiswa = array(
			'nama' => $this->input->post('nama'),
			'anakKe' => $this->input->post('anakKe'),
			'dari' => $this->input->post('dari'),
			'telepon' => $this->input->post('telepon'),
			'email' => $this->input->post('email'),
			'alamatOrtu' => $this->input->post('alamatOrtu'),
			'teleponOrtu' => $this->input->post('teleponOrtu'),
		);

		$dataUser = array(
                'user' => $this->input->post('user'),
                'password' => $this->input->post('password')
            );
		$this->siswa_model->saveSiswa($dataSiswa);

        $this->siswa_model->saveUser($dataUser);
        $this->siswa_model->saveAkses(array('akses' => "Siswa"));

		$this->siswa_model->saveKelamin(array('jenisKelamin' => $this->input->post('jenisKelamin')));

		$this->siswa_model->saveTempatLahir(array('namaKota' => $this->input->post('tempatLahir')), $this->input->post('tanggalLahir'));

		$this->siswa_model->saveAgama(array('agama' => $this->input->post('agama')));

		$this->siswa_model->saveAlamat(array('namaKota' => $this->input->post('kota')), $this->input->post('alamat'));

		$this->siswa_model->saveAyah(array('nama' => $this->input->post('ayah')));

		$this->siswa_model->saveIbu(array('nama' => $this->input->post('ibu')));

		$this->siswa_model->savePekerjaanAyah(array('profesi' => $this->input->post('pekerjaanAyah')));

		$this->siswa_model->savePekerjaanIbu(array('profesi' => $this->input->post('pekerjaanIbu')));

		$this->siswa_model->saveStatus(array('status' => "Pendaftar"));

		$this->siswa_model->addRelation();
		redirect('conpendaftar');
	}
}