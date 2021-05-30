<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mylib {
    protected $ci;
    public function __construct() 
    {
        $this->ci =& get_instance();
    }

    public function load_view($page_title, $view_file, $data=false)
    {
        $this->ci->load->view('header/Header', array('title'=>$this->set_title($page_title)));
        $this->ci->load->view('menu/Menu');
        if ($data) {
            $this->ci->load->view($view_file, $data);
        }else{
            $this->ci->load->view($view_file);
        }
        $this->ci->load->view('footer/footer');
    }
    public function load_view_pendaftar($page_title, $view_file, $data=false)
    {
        $this->ci->load->view('header/Header', array('title'=>$this->set_title($page_title)));
        if ($data) {
            $this->ci->load->view($view_file, $data);
        }else{
            $this->ci->load->view($view_file);
        }
        $this->ci->load->view('footer/footer');
    }
    public function set_title($value)
    {
        $site_name = $this->get_site_title();
        $page_title = $value." | ".$site_name;
        return $page_title;
    }
    public function get_site_title()
    {
        $site_name = "Workflow Repository With Neo4j";
        return $site_name;
    }
}