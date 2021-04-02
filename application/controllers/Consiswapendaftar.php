<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consiswapendaftar extends CI_Controller {

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

	public function index()
	{
		$this->mylib->load_view('Siswa pendaftar','siswapendaftar');
	}

	public function save(){
		if ($this->input->post('method') == "save") {

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
		}elseif($this->input->post('method') == "edit"){
			$id = (int) $this->input->post('id-siswa');
			$idAyah = (int) $this->input->post('id-ayah');
			$idIbu = (int) $this->input->post('id-ibu');
			$idUser = (int) $this->input->post('id-user');
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

			$this->siswa_model->setIdSiswa($id);
			$this->siswa_model->setIdAyah($idAyah);
			$this->siswa_model->setIdIbu($idIbu);

			$this->siswa_model->edit($id, $dataSiswa);
			$this->siswa_model->edit($idUser, $dataUser);
			$this->siswa_model->edit($idAyah, array('nama' => $this->input->post('ayah')));
			$this->siswa_model->edit($idIbu, array('nama' => $this->input->post('ibu')));

			$this->siswa_model->delete_relation($this->input->post('id-kelamin'));
			$this->siswa_model->delete_relation($this->input->post('id-tanggalLahir'));
			$this->siswa_model->delete_relation($this->input->post('id-agama'));
			$this->siswa_model->delete_relation($this->input->post('id-alamat'));
			$this->siswa_model->delete_relation($this->input->post('id-profesiAyah'));
			$this->siswa_model->delete_relation($this->input->post('id-profesiIbu'));
			$this->siswa_model->delete_relation($this->input->post('id-status'));

			$this->siswa_model->saveKelamin(array('jenisKelamin' => $this->input->post('jenisKelamin')));
			$this->siswa_model->saveTempatLahir(array('namaKota' => $this->input->post('tempatLahir')), $this->input->post('tanggalLahir'));
			$this->siswa_model->saveAgama(array('agama' => $this->input->post('agama')));
            $this->siswa_model->saveAlamat(array('namaKota' => $this->input->post('kota')), $this->input->post('alamat'));
            $this->siswa_model->savePekerjaanAyah(array('profesi' => $this->input->post('pekerjaanAyah')));
            $this->siswa_model->savePekerjaanIbu(array('profesi' => $this->input->post('pekerjaanIbu')));

            $this->siswa_model->saveStatus(array('status' => $this->input->post('status')));

            $this->siswa_model->addRelation();
		}
        redirect('consiswapendaftar');
	}

	public function delete($id,$idAyah,$idIbu,$idUser){
		$this->siswa_model->delete($id,'siswa');
		$this->siswa_model->delete($idAyah,'ayah');
		$this->siswa_model->delete($idIbu,'ibu');
		$this->siswa_model->delete($idUser,'user');
		redirect('consiswa');
	}

	public function ajax_list(){

		$query = $this->siswa_model->read(array('Pendaftar','Belum Lolos'));
		$data = array();
		$no = 0;
		foreach ($query as $key => $value) {
			$row = array();

			$row[] = ++$no;
			$row[] = $value['nama'];
			$row[] = $value['kelamin'];
			$row[] = $value['tempatLahir'];
			$row[] = $value['tanggalLahir'];
			$row[] = $value['agama'];
			$row[] = "Anak Ke - ".$value['anakKe']." dari ".$value['dari']." bersaudara";
			$row[] = $value['alamat'];
			$row[] = $value['kota'];
			$row[] = $value['telepon'];
			$row[] = $value['email'];
			$row[] = $value['ayah'];
			$row[] = $value['ibu'];
			$row[] = $value['alamatOrtu'];
			$row[] = $value['teleponOrtu'];
			$row[] = $value['profesiAyah'];
			$row[] = $value['profesiIbu'];
			$row[] = ($value['status']=="Belum Lolos") ? '<span class="label label-danger">'.$value['status'].'</span>' : '<span class="label label-warning">'.$value['status'].'</span>';

			$aksi_edit = ' <button class="btn btn-warning rounded" data-idsiswa="'.$value['idSiswa'].'" data-nama="'.$value['nama'].'" data-kelamin="'.$value['kelamin'].'" data-idkelamin="'.$value['idRKelamin'].'" data-tempat="'.$value['tempatLahir'].'" data-idtanggallahir="'.$value['idRTanggal'].'" data-tanggal="'.$value['tanggalLahir'].'" data-idagama="'.$value['idRAgama'].'" data-agama="'.$value['agama'].'" data-anakke="'.$value['anakKe'].'" data-dari="'.$value['dari'].'" data-idalamat="'.$value['idRAlamat'].'" data-alamat="'.$value['alamat'].'" data-kota="'.$value['kota'].'" data-telepon="'.$value['telepon'].'" data-email="'.$value['email'].'" data-idayah="'.$value['idAyah'].'" data-ayah="'.$value['ayah'].'" data-idibu="'.$value['idIbu'].'" data-ibu="'.$value['ibu'].'" data-alamatortu="'.$value['alamatOrtu'].'" data-teleponortu="'.$value['teleponOrtu'].'" data-idprofesiayah="'.$value['idRProfesiAyah'].'" data-pekerjaanayah="'.$value['profesiAyah'].'" data-idprofesiibu="'.$value['idRProfesiIbu'].'" data-pekerjaanibu="'.$value['profesiIbu'].'" data-idstatus="'.$value['idRStatus'].'" data-status="'.$value['status'].'" data-iduser="'.$value['idUser'].'" data-user="'.$value['user'].'" data-password="'.$value['password'].'" onclick="edit_siswa(this)"> <i class="fa fa-pencil"></i></i></button>';
			$aksi_hapus = ' <a class="btn btn-danger rounded" href="'.base_url("consiswa/delete/").$value['idSiswa'].'/'.$value['idAyah'].'/'.$value['idIbu'].'/'.$value['idUser'].'"><i class="fa fa-trash"></i></a>';
			$row[] = $aksi_edit.$aksi_hapus;

			$data[] = $row;
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->siswa_model->count_all(array('Pendaftar','Belum Lolos')),
                        "recordsFiltered" => $this->siswa_model->count_filtered(array('Pendaftar','Belum Lolos')),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
}
