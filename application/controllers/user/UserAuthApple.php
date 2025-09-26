<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");

class UserAuthApple extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
        // $this->load->library('Appleauth');
    }


    public function index()
    {
    print("Дарова");
    }
}