<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class UserShow extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

    public function index() {
        $dt = $this->getParameters();
        $dt = $this->users->
        $this->load->view('message', $dt);
    }

}