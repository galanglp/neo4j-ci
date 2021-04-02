<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ahp extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('ahp');
	}

	public function index() {
		$this->load->view('upload');
	}
	
	
}