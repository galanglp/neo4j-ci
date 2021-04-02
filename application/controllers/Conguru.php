<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conguru extends CI_Controller {

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
		$this->load->model('guru_model');
	}

	public function index()
	{
		// $data['data'] = $this->ajax_list();
		$this->mylib->load_view('Guru','guru');
	}

	public function save(){
		if ($this->input->post('method') == "save") {
            $dataGuru = array(
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama'),
				'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email'),
			);

			$this->guru_model->saveGuru($dataGuru);

            $this->guru_model->saveKelamin(array('jenisKelamin' => $this->input->post('jenisKelamin')));

            $this->guru_model->saveTempatLahir(array('namaKota' => $this->input->post('tempatLahir')), $this->input->post('tanggalLahir'));

            $this->guru_model->saveAlamat(array('namaKota' => $this->input->post('kota')), $this->input->post('alamat'));

            $this->guru_model->addRelation();
		}elseif($this->input->post('method') == "edit"){
			$id = (int) $this->input->post('id-guru');
			$data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenisKelamin'),
                'tempat_lahir' => $this->input->post('tempatLahir'),
                'tanggal_lahir' => $this->input->post('tanggalLahir'),
                'alamat' => $this->input->post('alamat'),
                'kota' => $this->input->post('kota'),
                'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email'),
            );

            $dataGuru = array(
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama'),
				'telepon' => $this->input->post('telepon'),
                'email' => $this->input->post('email'),
			);

			$this->guru_model->setIdGuru($id);

			$this->guru_model->edit($id, $dataGuru);

			$this->guru_model->delete_relation($this->input->post('id-kelamin'));
			$this->guru_model->delete_relation($this->input->post('id-tanggalLahir'));
			$this->guru_model->delete_relation($this->input->post('id-alamat'));

			$this->guru_model->saveKelamin(array('jenisKelamin' => $this->input->post('jenisKelamin')));

            $this->guru_model->saveTempatLahir(array('namaKota' => $this->input->post('tempatLahir')), $this->input->post('tanggalLahir'));

            $this->guru_model->saveAlamat(array('namaKota' => $this->input->post('kota')), $this->input->post('alamat'));

            $this->guru_model->addRelation();
		}
        redirect('conguru');
	}

	public function delete($id){
		$this->guru_model->delete($id,'guru');
		redirect('conguru');
	}

	public function ajax_list(){

		$query = $this->guru_model->read();
		$data = array();
		$no = 1;
		foreach ($query as $key => $value) {
			$row = array();

			$row[] = $no++;
			$row[] = $value['nip'];
			$row[] = $value['nama'];
			$row[] = $value['kelamin'];
			$row[] = $value['tempatLahir'];
			$row[] = $value['tanggalLahir'];
			$row[] = $value['alamat'];
			$row[] = $value['kota'];
			$row[] = $value['telepon'];
			$row[] = $value['email'];

			$aksi_edit = ' <button class="btn btn-warning rounded" data-idguru="'.$value['idGuru'].'" data-nip="'.$value['nip'].'" data-nama="'.$value['nama'].'" data-idkelamin="'.$value['idRKelamin'].'" data-kelamin="'.$value['kelamin'].'" data-idtanggallahir="'.$value['idRTanggal'].'" data-tempat="'.$value['tempatLahir'].'" data-tanggal="'.$value['tanggalLahir'].'" data-idalamat="'.$value['idRAlamat'].'" data-alamat="'.$value['alamat'].'" data-kota="'.$value['kota'].'" data-telepon="'.$value['telepon'].'" data-email="'.$value['email'].'" onclick="edit_guru(this)"> <i class="fa fa-pencil"></i></i></button>';
			$aksi_hapus = ' <a class="btn btn-danger rounded" href="'.base_url("conguru/delete/").$value['idGuru'].'"><i class="fa fa-trash"></i></a>';
			$row[] = $aksi_edit.$aksi_hapus;

			$data[] = $row;
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->guru_model->count_all(),
                        "recordsFiltered" => $this->guru_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
}
