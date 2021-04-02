<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($error = NULL) {
        
        $data = array(
            'action' => 'create/login',
            'error' => $error
        );
        $this->load->view('create',$data);
    }

    public function login() {

        // $this->load->model('Model_Auth','model');
        // $login = $this->model->login($this->input->post('username'), md5($this->input->post('password')), $this->input->post('role'));
        //Get the DB object by calling the get_db function from our neo4j library.
        //Since the neo4j library has been loaded by the controller, we can access it
        //by just calling $this->neo4j.
        // $db = $this->neo4j->get_db();

        // //Write your cypher query
        // $query = "match (n:item_list{name:'$list'})-[:sublist*]->(sublist:item_list) sublist.name as list";

        // //Run your query
        // $result = $db->run($query);

        // //Return the result. In this case, i call a function (extract_result_g)
        // //that will neatly transform the response into a nice array.
        // return $this->extract_results_g($result);
        $data = array(
                    'tittle' => $this->input->post('movie'),
                'name' => $this->input->post('penulis'),
                'released' => $this->input->post('tahun'),
                'tahun' => $this->input->post('tahun')
            );
        // $error = $this->neo->add_node('nama',$this->input->post('username'));
        // $error = $this->neo->insert('MOVIE',$data);
        $queryString = 'CREATE (a:MOVIE{tittle:{tittle},released:{released}})-[r:PENULIS { tahun: {tahun}}]->(b:Person{name:{name}}) Return a ';
        $tes = 'match (start:event{nama:"start"}),(end:event{nama:"end"}), n= allShortestPaths((start)-[*]->(end)) return n';
        $error = json_encode($this->neo->execute_query($tes));
        // $error = $this->neo->get_label_nodes('MOVIE');
        // foreach ($getLabelNode as $key => $value) {
        //     if($value['tittle']==$this->input->post('username')){
        //         $error = $value['tittle'];
        //     }else{
        //         $error = 'not found';
        //     }
        // }

//         if ($login == 1) {
// //          ambil detail data
//             $row = $this->model->data_login($this->input->post('username'), md5($this->input->post('password')),$this->input->post('role'));

// //          daftarkan session
//             $data = array(
//                 'sidol' => TRUE,
//                 'nama' => $row->nama,
//                 'username' => $row->username,
//                 'role' => $row->role
//             );
//             $this->session->set_userdata($data);

// //            redirect ke halaman sukses
//             if($row->role=="guru"){
//                 redirect(site_url('guru/Con_Profile_Guru'));
//             }
//             if($row->role=="akademik"){
//                 redirect(site_url('akademik/Con_Dasbor_Akademik'));
//             }
//             if($row->role=="kesiswaan"){
//                 redirect(site_url('kesiswaan/Con_Dashboard_Kesiswaan'));
//             }
//             if($row->role=="sms"){
//                 redirect(site_url('sms/Con_Dashboard'));
//             }
//             if($row->role=="keuangan"){
//                 redirect(site_url('keuangan/Con_Dasboard_Keuangan'));
//             }
//             if($row->role=="perpus"){
//                 redirect(site_url('perpus/Con_Dasboard_Perpus'));
//             }
//             if ($this->session->userdata('role')=='bk') {
//             redirect(site_url('bk/Con_Master_Bk'));
//             } 
//         } else {
//            tampilkan pesan error
            // $error = '<div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">&times;</button>
            //                 <strong><center>Warning!</center></strong><center>Masukkan ada yang kurang tepat!</center></div>';
            $this->index($error);
        // }
    }
//     function logout() {
//        destroy session
//         $this->session->sess_destroy();
        
//        redirect ke halaman login
//         redirect(site_url('Con_Auth'));
//     }
}
