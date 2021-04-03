<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conuser extends CI_Controller {

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
		$this->load->model('user_model');
	}

	public function index()
	{
		// $data['data'] = $this->ajax_list();
		$this->mylib->load_view('User','user');
	}

	public function save(){
		if ($this->input->post('method') == "save") {
			$data = array(
                'user' => $this->input->post('user'),
                'password' => $this->input->post('password')
            );

            $this->user_model->saveUser('user',$data);
            $this->user_model->saveAkses('akses',array('akses' => "Admin"));

            $this->user_model->addRelation();
		}elseif($this->input->post('method') == "edit"){
			$id = (int) $this->input->post('id');
			$data = array(
                'user' => $this->input->post('user'),
                'password' => $this->input->post('password')
            );
            
			$this->user_model->edit($id,$data);
		}
        redirect('conuser');
	}

	public function delete($id){
		$this->user_model->delete($id,'user');
		redirect('conuser');
	}

	public function ajax_list(){

		$query = $this->user_model->read();
		$data = array();
		$no = 1;
		foreach ($query as $key => $value) {
			$row = array();

			$row[] = $no++;
			$row[] = $value['user'];
			$row[] = $value['akses'];

			$aksi_edit = ' <button class="btn btn-warning rounded" data-id="'.$value['idUser'].'" data-user="'.$value['user'].'" data-password="'.$value['password'].'" onclick="edit_user(this)"> <i class="fa fa-pencil"></i></i></button>';
			$aksi_hapus = ' <a class="btn btn-danger rounded" href="'.base_url("conuser/delete/").$value['idUser'].'"><i class="fa fa-trash"></i></a>';
			$row[] = $aksi_edit.$aksi_hapus;

			$data[] = $row;
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->user_model->count_all(),
                        "recordsFiltered" => $this->user_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
}
