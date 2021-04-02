<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('ambil');
		$this->load->model('ambil_vdx');
		$this->load->model('t_cypher');
		$this->load->model('simpan');
	}

	public $node = array();

	public function index() {
		$this->load->view('upload');
	}

	public function ambil(){
		$target_dir = "assets/uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {

		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
// Allow certain file formats
		if($imageFileType != "xpdl") {
			echo "Sorry, only XPDL files are allowed.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				$xml=simplexml_load_file($target_file);
				$this->save_workflow($xml,$this->input->post('workflow'));
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		$xml=simplexml_load_file($target_file);
		echo (string)$xml->Pools->Pool[0]['Name'];
		


		// echo '</br>';
		echo (string)$xml->WorkflowProcesses->WorkflowProcess[1]->Activities->Activity[1]['Name'];
		echo '</br>';
		// echo json_encode($this->ambil->get_activity($xml));
		echo json_encode($this->ambil->get_workflowProcess($xml,"activity"));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_workflowProcess($xml,"dataObject"));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_workflowProcess($xml,"flow"));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_workflowProcess($xml,"flowData"));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_dataStore($xml));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_messageFlow($xml));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_association($xml));
		echo '</br>';
		echo '</br>';
		echo json_encode($this->ambil->get_desk($xml));

		// unlink($target_file);
		echo '</br>';
		echo json_encode($this->node);
		echo '</br>';
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

	public function ambilVdx(){
		$target_dir = "assets/uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {

		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
// Allow certain file formats
		if($imageFileType != "vdx") {
			echo "Sorry, only XPDL files are allowed.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		$xml=simplexml_load_file($target_file);
		echo (string) $xml->Pages->Page->Shapes->Shape[0]['NameU'];
		if (strpos((string) $xml->Pages->Page->Shapes->Shape[2]['NameU'], 'Task/Subtask') !== false) {
			echo 'true';
		}
		if ((string) $xml->Pages->Page->Shapes->Shape[6]['NameU'] == null) {
			echo 'not exist';
		}
		$con = $this->ambil_vdx->get_connects($xml);
		for ($i=0; $i < count($con); $i++) { 
			echo $con[$i]['From'];
			echo $con[$i]['To'];
			echo $con[$i]['Tipe'];
			echo "</br>";
		}
		echo $xml->Pages->Page->Shapes->Shape[6]['Master'];
		echo $this->ambil_vdx->get_NameU($xml,5	);
		echo count(  $xml->Masters->Master);
		echo (string) $this->ambil_vdx->get_shapes($xml,1);
		echo '<br>';
		echo json_encode($this->ambil_vdx->get_connects($xml));
		echo '<br>';
		echo json_encode($this->ambil_vdx->get_text_act($xml,11));
		echo '<br>';
		echo $this->stack_cypher($xml);

		unlink($target_file);

	}

	public function stack_cypher($xml){
		$id_event = 0;
		$id_activiy = 0;
		$id_gateway = 0;
		$id_relation = 0;
		$cypher = "MATCH ";
		$con = $this->ambil_vdx->get_connects($xml);

		$cypher .= $this->cypher_desk($this->ambil_vdx->get_shapes($xml,$con[0]['From']));

		for ($i=0; $i < count($con); $i++) {
			$shape1 = $this->ambil_vdx->get_shapes($xml,$con[$i]['From']);
			$shape2 = $this->ambil_vdx->get_shapes($xml,$con[$i]['To']);
			$tipe = $this->ambil_vdx->get_shapes($xml,$con[$i]['Tipe']);

			if ($i!=0) {
				if ($con[$i]['From'] == $con[$i-1]['To']) {
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->CekNode($xml,$con,$con[$i]['To'],$shape2,$i);
				}elseif ($con[$i]['From'] == $con[$i-1]['From']) {
					$cypher .= ",";
					$cypher .= $this->t_cypher->get_node($shape1,1);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->cyph_shap($xml,$shape2,$con[$i]['To']);
				}elseif ($con[$i]['To'] == $con[$i-1]['To']) {
					$cypher .= ",";
					$cypher .= $this->CekNode($xml,$con,$con[$i]['From'],$shape1,$i);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->CekNode($xml,$con,$con[$i]['To'],$shape2,$i);
				}else{
					$cypher .= ",";
					$cypher .= $this->CekNode($xml,$con,$con[$i]['From'],$shape1,$i);
					$cypher .= $this->t_cypher->get_cypher($tipe);
					$cypher .= ">";
					$cypher .= $this->CekNode($xml,$con,$con[$i]['To'],$shape2,$i);
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
		$cypher .= " RETURN ID(d) as id, d.unik as unik, d.judul as judul, d.penulis as penulis, r.tgl_dibuat as tgl_dibuat, r.tgl_modifikasi as tgl_modifikasi";

		return $cypher;
	}

	public function CekNode($xml,$connection,$NodeFrom,$shape,$posisi){
		for ($i=0; $i < count($connection); $i++) { 
			if ($posisi > $i AND $connection[$i]['From'] == $NodeFrom) {
				$jarak= $this->HitungJarak($posisi,$i);
				return $this->t_cypher->get_node($shape,$jarak);
			}elseif ($posisi > $i AND $connection[$i]['To'] == $NodeFrom) {
				$jarak= $this->HitungJarak($posisi,$i);
				return $this->t_cypher->get_node($shape,$jarak);
			}
		}

		return $this->cyph_shap($xml,$shape,$NodeFrom);
	}

	public function HitungJarak($node1,$node2){
		$jarak = $node1 - $node2;
		if($jarak == 1){
			return 1;
		}elseif ($jarak == 2) {
			return 2;
		}else{
			return $jarak - 1;
		}
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