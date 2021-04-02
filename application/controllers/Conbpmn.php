<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conbpmn extends CI_Controller {

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
		$this->load->model('bpmn_model');
	}

	var $result = array();
	var $transisi = array();
	var $act = array();

	public function index()
	{
		// $data['data'] = $this->bpmn_model->read();
		$this->mylib->load_view('BPMN','bpmn');
	}

	public function get_bpmn(){
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$result['activity'] = $this->get_act($start,$end);
		$result['transisi'] = $this->get_transisi($start,$end);

		echo json_encode($result);
	}

	public function get_transisi($start,$end){
		$bpmn = $this->bpmn_model->read($start,$end);
		$from = array();
		$to = array();
		$relation = array();
		for ($i=0; $i < count($bpmn); $i++) {
			for ($k=0; $k < count($bpmn[$i][3]); $k++) { 
				if ($i != 0) {
					if ($k != 0) {
						if ($k < count($bpmn[$i-1][3])) {
							if($bpmn[$i][3][$k] != $bpmn[$i-1][3][$k]){
								$from[] = $bpmn[$i][3][$k-1];
								$to[] = $bpmn[$i][3][$k];
							}
						}else{
							$from[] = $bpmn[$i][3][$k-1];
							$to[] = $bpmn[$i][3][$k];
						}
					}
				}else{
					if ($k != 0) {
						$from[] = $bpmn[$i][3][$k-1];
						$to[] = $bpmn[$i][3][$k];
					}
				}
			}

			for ($j=0; $j < count($bpmn[$i][1]); $j++) {
				if ($i != 0) {
					if ($j != 0) {
						if ($j < count($bpmn[$i-1][3])) {
							if($bpmn[$i][3][$j] != $bpmn[$i-1][3][$j]){
								$relation[] = $bpmn[$i][1][$j];
							}
						}else{
							$relation[] = $bpmn[$i][1][$j];
						}
					}else{
						$relation[] = $bpmn[$i][1][$j];
					}
				}else{
					if ($j != 0) {
						$relation[] = $bpmn[$i][1][$j];
					}else{
						$relation[] = $bpmn[$i][1][$j];
					}
				}
			}
		}

		for ($i=0; $i < count($from); $i++) { 
			$this->transisi[] = array(
				'from' => $from[$i],
				'to' => $to[$i],
				'relation' => $relation[$i]
			);
		}

		return $this->transisi;
	}

	public function get_act($start,$end){
		$bpmn = $this->bpmn_model->read($start,$end);
		$act_tmp;
		for ($i=0; $i < count($bpmn); $i++) {
			for ($k=0; $k < count($bpmn[$i][0]); $k++) { 
				if ($i == 0) {
					$act_tmp['nama'] = $bpmn[$i][0][$k];
					$act_tmp['bentuk'] = $this->get_tipe($bpmn[$i][2][$k][0]);
					$act_tmp['color'] = $this->get_color($bpmn[$i][2][$k][0],$bpmn[$i][0][$k]);
					$act_tmp['key'] = $bpmn[$i][3][$k];
					$act_tmp['width'] = $this->get_width($bpmn[$i][2][$k][0]);
					$this->act[] = $act_tmp;
				}else{
					if ($this->cek_act($bpmn[$i][0][$k],$bpmn[$i][3][$k])) {
						$act_tmp['nama'] = $bpmn[$i][0][$k];
						$act_tmp['bentuk'] = $this->get_tipe($bpmn[$i][2][$k][0]);
						$act_tmp['color'] = $this->get_color($bpmn[$i][2][$k][0],$bpmn[$i][0][$k]);
						$act_tmp['key'] = $bpmn[$i][3][$k];
						$act_tmp['width'] = $this->get_width($bpmn[$i][2][$k][0]);
						$this->act[] = $act_tmp;
					}
				}
			}
		}

		return $this->act;
	}

	public function get_width($tipe){
		switch ($tipe) {
			case 'event':
				return 30;
				break;
			case 'activity':
				return 90;
				break;
			case 'gateway':
				return 30;
				break;
			
			default:
				# code...
				break;
		}
	}

	public function get_tipe($tipe){
		switch ($tipe) {
			case 'event':
				return "Circle";
				break;
			case 'activity':
				return "RoundedRectangle";
				break;
			case 'gateway':
				return "Diamond";
				break;
			
			default:
				# code...
				break;
		}
	}

	public function get_color($color,$activity){
		switch ($color) {
			case 'event':
				if ($activity == "start") {
					return "lightgreen";
				}else{
					return "red";
				}
				break;
			case 'activity':
				return "lightblue";
				break;
			case 'gateway':
				return "yellow";
				break;
			
			default:
				# code...
				break;
		}
	}

	public function cek_act($activity,$key){
		for ($i=0; $i < count($this->act); $i++) { 
			if ($activity == $this->act[$i]['nama'] && $key == $this->act[$i]['key'] ) {
				return false;
			}
		}
		 return true;
	}
}