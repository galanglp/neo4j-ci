<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		$this->load->view('upload');
	}

	public function create()
	{
		$data = array(
                    'name' => $this->input->post('firstname'),
                'teman' => $this->input->post('lastname'),
                'selama' => '2 tahun'
            );
        // $error = $this->neo->add_node('nama',$this->input->post('username'));
        // $error = $this->neo->insert('MOVIE',$data);
        $queryString = 'create (n:Orang{name:{name}})-[r:Friends{selama:{selama}}]->(d:Orang{name:{teman}})';
        $tes = 'match (start:event{nama:"start"}),(end:event{nama:"end"}), n= allShortestPaths((start)-[*]->(end)) return n';
        $this->neo->execute_query($tes,$data);
	}
}
