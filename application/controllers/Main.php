<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

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
            redirect('condatadiri');
        }elseif ($this->session->userdata('akses') == "admin") {
        	
        }elseif ($this->session->userdata('akses') == "") {
        	redirect('login');
        }
		
		$this->load->model('main_model');
		$this->load->model('ambil');
		$this->load->model('ambil_vdx');
		$this->load->model('t_cypher');
		$this->load->model('simpan');
	}

	var $end = 0;
	public $node = array();

	public function index($error = null)
	{
		if ($error!=null) {
		 	$error = $this->cek_error($error);
		}
		$data['error'] = $error;
		$this->mylib->load_view('Main','main',$data);
	}

	public function save(){
		if ($this->input->post('method') == "save") {
			$target_dir = "assets/uploads/";
			$target_file = $target_dir . basename($_FILES["fileWorkflow"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {

			}
			// Check if file already exists
			if (file_exists($target_file)) {
				redirect("main/index/0");
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "xpdl") {
				redirect("main/index/2");
				$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				redirect("main/index/3");
			// if everything is ok, try to upload file
			} else {
				if($this->input->post('method') == "save"){
					if (move_uploaded_file($_FILES["fileWorkflow"]["tmp_name"], $target_file)) {
						$xml=simplexml_load_file($target_file);
						$this->save_workflow($xml,$this->input->post('workflow'));
						redirect("main/index/1");
					} else {
						redirect("main/index/4");
					}
				}
			}
		}elseif ($this->input->post('method') == "edit") 
		{
			$id = (int) $this->input->post('id');
			$data = array(
	               'judul' => $this->input->post('workflow'),
	        	);
			$insert = $this->main_model->edit($id,$data);
			redirect("main");
		}
	}

	public function cypher(){
		$target_dir = "assets/uploads/";
			$target_file = $target_dir . basename($_FILES["fileVdx"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {

			}
			// Check if file already exists
			if (file_exists($target_file)) {
				redirect("main/index/0");
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "vdx") {
				redirect("main/index/2");
				$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				redirect("main/index/3");			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileVdx"]["tmp_name"], $target_file)) {

				} else {
					redirect("main/index/4");
				}
			}

			$xml=simplexml_load_file($target_file);

			$query =  array("query" => $this->stack_cypher($xml));
			// echo $this->ajax_list($query);

			unlink($target_file);
			echo json_encode(array("query" => $this->stack_cypher($xml)));
	}

	public function stack_cypher($xml){
		$cypher = "MATCH ";
		$con = $this->ambil_vdx->get_connects($xml);

		$this->t_cypher->start();
		$cypher .= $this->cypher_desk($this->ambil_vdx->get_shapes($xml,$con[0]['From']));

		for ($i=0; $i < count($con); $i++) {
			$shape1 = $this->ambil_vdx->get_shapes($xml,$con[$i]['From']);
			$shape2 = $this->ambil_vdx->get_shapes($xml,$con[$i]['To']);
			$tipe = $this->ambil_vdx->get_shapes($xml,$con[$i]['Tipe']);

			if ($i!=0) {
				if ($con[$i]['From'] == $con[$i-1]['To']) {
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->cyph_shap($xml,$shape2,$con[$i]['To']);
				}elseif ($con[$i]['From'] == $con[$i-1]['From']) {
					$cypher .= ",";
					$cypher .= $this->t_cypher->get_node($shape1,1);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->cyph_shap($xml,$shape2,$con[$i]['To']);
				}elseif ($con[$i]['To'] == $con[$i-1]['To']) {
					$cypher .= ",";
					$cypher .= $this->cyph_shap($xml,$shape1,$con[$i]['From']);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->t_cypher->get_node($shape2,1);
				}else{
					$cypher .= ",";
					$cypher .= $this->cyph_shap($xml,$shape1,$con[$i]['From']);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->t_cypher->get_node($shape2,1);
				}
			}else{
				$cypher .= $this->cyph_shap($xml,$shape1,$con[$i]['From']);
				$cypher .= $this->t_cypher->get_cypher($tipe);
				$cypher .= ">";
				$cypher .= $this->cyph_shap($xml,$shape2,$con[$i]['To']);
			}

			if ($shape1 == "End" || $shape2 == "End") {
				$this->end = 1;
			}
		}

		if($this->end == 0){
			$cypher .= "-[*..]->(e2:event)";
		}

		$cypher .= $this->t_cypher->get_where();

		return $cypher;
	}

	public function cypher_desk($NameU){
		if ($NameU == "Start") {
			return "(d:deskripsi)-[r:DIBUAT]->";
		}else{
			return '(d:deskripsi)-[r:DIBUAT]-(e1:event{nama:"start"})-[*..]->';
		}
	}

	public function cyph_shap($xml,$shape,$id){
		$data = $this->ambil_vdx->get_text_act($xml,$id);
		return $this->t_cypher->get_cypher($shape,$data);
	}

	public function delete($unik){
		$unik = array('unik' => $unik);
		$this->main_model->delete($unik);
		redirect('main');
	}

	public function save_workflow($xml,$judul){
		echo '</br>';
		$this->save_act($this->ambil->get_workflowProcess($xml,"activity"),$this->ambil->get_desk($xml),$judul);
		echo '</br>';
		$this->save_dataObj($this->ambil->get_workflowProcess($xml,"dataObject"));
		echo '</br>';
		$this->save_dataStore($this->ambil->get_dataStore($xml));
		echo '</br>';
		$this->save_sequence($this->ambil->get_workflowProcess($xml,"flow"));
		echo '</br>';
		$this->save_dataAsc($this->ambil->get_workflowProcess($xml,"flowData"));
		echo '</br>';
		$this->save_messageFlow($this->ambil->get_messageFlow($xml));
		echo '</br>';
		$this->save_asc($this->ambil->get_association($xml));
		echo '</br>';
	}

	public function cek_error($error){
		switch ($error) {
			case 0 :
				return "Sorry, file already exists.";
				break;
			case 1 :
				return "The file has been uploaded";
				break;
			case 2 :
				return "Sorry, only XPDL files are allowed.";
				break;
			case 3 :
				return "Sorry, your file was not uploaded.";
				break;
			
			default:
				return "Sorry, there was an error uploading your file.";
				break;
		}
	}

	public function ajax_list(){

		$vdx = $this->input->post("query");
		$query = $this->main_model->read($vdx);
		$data = array();
		$no = 1;
		foreach ($query as $key => $value) {
			$row = array();

			$row[] = $no++;
			$row[] = $value['judul'];
			$row[] = $value['penulis'];
			$row[] = $value['tgl_dibuat'];
			$row[] = $value['tgl_modifikasi'];

			$aksi_view = ' <button class="btn btn-primary rounded" data-toggle="modal" data-judul="'.$value['judul'].'" data-start="'.$value['start'].'" data-end="'.$value['end'].'"  data-target="#view-bpmn"><i class="fa fa-eye"></i></i></button>';
			$aksi_edit = ' <button class="btn btn-warning rounded" data-id="'.$value['id'].'" data-judul="'.$value['judul'].'" data-penulis="'.$value['penulis'].'" data-tgldibuat="'.$value['tgl_dibuat'].'" data-tglmodifikasi="'.$value['tgl_modifikasi'].'" onclick="edit_workflow(this)"> <i class="fa fa-pencil"></i></i></button>';
			$aksi_hapus = ' <a class="btn btn-danger rounded" href="'.base_url("main/delete/").$value['unik'].'"><i class="fa fa-trash"></i></a>';
			$row[] = $aksi_view.$aksi_edit.$aksi_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
                        "recordsTotal" => $this->main_model->count_all($vdx),
                        "recordsFiltered" => $this->main_model->count_filtered($vdx),
                        "data" => $data,
                        "query" => $query,
					);


		echo json_encode($output);
	}
	
	public function save_act($data,$deskripsi,$judul)
	{
		$save;
		for ($i=0; $i < count($data); $i++) {
			$simpan = $data[$i];
			if ($simpan['Name'] == "start" || $simpan['Name'] == "end") {
				echo 'event, ';
				if ($simpan['Name'] == "start") {
					echo 'desk, ';
					$deskripsi['judul'] = $judul;
					$deskripsi['Id'] = $simpan['Id'];
					$deskripsi['unik'] = (string) $this->simpan->count_desk()[0]['jumlah'];
					$deskripsi['Name'] = $simpan['Name'];
					echo json_encode($deskripsi);
					echo $this->simpan->count_desk()[0]['jumlah'];
					$save = $this->simpan->simpan_desk($deskripsi);
					$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
					array_push($this->node, $temp);
				}elseif($simpan['Name'] == "end"){
					echo 'end';
					$save = $this->simpan->simpan_event($simpan);
					$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
					array_push($this->node, $temp);
				}
			}elseif ($simpan['Name'] == "or" || $simpan['Name'] == "and" || $simpan['Name'] == "xor") {
				echo 'gateway, ';
				$save = $this->simpan->simpan_gate($simpan);
				$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
				array_push($this->node, $temp);
			}else{
				if (array_key_exists('ArtifactId', $simpan) != null) {
					echo 'act art, ';
					$save = $this->simpan->simpan_act_art($simpan);
					$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
					array_push($this->node, $temp);
				}else{
					echo 'act, ';
					$save = $this->simpan->simpan_act($simpan);
					$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
					array_push($this->node, $temp);
				}
			}
		}
	}

	public function save_dataObj($data){
		$save;
		for ($i=0; $i < count($data); $i++) {
			$simpan = $data[$i];
			$save = $this->simpan->simpan_dataObj($simpan);
			$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
			array_push($this->node, $temp);
		}
	}

	public function save_dataStore($data){
		$save;
		for ($i=0; $i < count($data); $i++) {
			$simpan = $data[$i];
			$save = $this->simpan->simpan_dataStore($simpan);
			$temp = array(
						"id" => $save[0]['id'],
						"unik" => $save[0]['unik']
					);
			array_push($this->node, $temp);
		}
	}

	public function save_sequence($data){
		$simpan = array();
		$from;
		$to;
		for ($i=0; $i < count($data); $i++) {
			for ($j=0; $j < count($this->node); $j++) { 
				if ($data[$i]["From"] == $this->node[$j]["unik"]) {
					$from = $this->node[$j]["id"];
				}elseif ($data[$i]["To"] == $this->node[$j]["unik"]) {
					$to = $this->node[$j]["id"];
				}
			}
			$simpan = array(
				"Id" => $data[$i]["Id"],
				"From" => $from,
				"To" => $to
			);
			$this->simpan->simpan_sequence($simpan);
			echo json_encode($simpan);
		}
	}

	public function save_dataAsc($data){
		$simpan = array();
		$from;
		$to;
		for ($i=0; $i < count($data); $i++) {
			for ($j=0; $j < count($this->node); $j++) { 
				if ($data[$i]["From"] == $this->node[$j]["unik"]) {
					$from = $this->node[$j]["id"];
				}elseif ($data[$i]["To"] == $this->node[$j]["unik"]) {
					$to = $this->node[$j]["id"];
				}
			}

			$simpan = array(
				"Id" => $data[$i]["Id"],
				"From" => $from,
				"To" => $to
			);

			$this->simpan->simpan_dataAsc($simpan);
			echo json_encode($simpan);
		}
	}

	public function save_messageFlow($data){
		$simpan = array();
		$from;
		$to;
		for ($i=0; $i < count($data); $i++) {
			for ($j=0; $j < count($this->node); $j++) { 
				if ($data[$i]["Source"] == $this->node[$j]["unik"]) {
					$from = $this->node[$j]["id"];
				}elseif ($data[$i]["Target"] == $this->node[$j]["unik"]) {
					$to = $this->node[$j]["id"];
				}
			}
			$simpan = array(
				"Id" => $data[$i]["Id"],
				"Source" => $from,
				"Target" => $to
			);
			$this->simpan->simpan_messageFlow($simpan);
			echo json_encode($simpan);
		}
	}

	public function save_asc($data){
		$simpan = array();
		$from;
		$to;
		for ($i=0; $i < count($data); $i++) {
			for ($j=0; $j < count($this->node); $j++) { 
				if ($data[$i]["Source"] == $this->node[$j]["unik"]) {
					$from = $this->node[$j]["id"];
				}elseif ($data[$i]["Target"] == $this->node[$j]["unik"]) {
					$to = $this->node[$j]["id"];
				}
			}
			$simpan = array(
				"Id" => $data[$i]["Id"],
				"Source" => $from,
				"Target" => $to
			);

			$this->simpan->simpan_asc($simpan);
			echo json_encode($simpan);
		}
	}
}
