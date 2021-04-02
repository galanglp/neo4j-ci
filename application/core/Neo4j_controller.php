<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Neo4j_controller extends TNK_Controller{

    //connect to neo4j db on instantiation
    function __construct(){
        parent::__construct();
        //load the neo4j library that we created
        $this->load->library('neo4j');
        //connect to the db
        $this->neo4j->connect();
    }
}