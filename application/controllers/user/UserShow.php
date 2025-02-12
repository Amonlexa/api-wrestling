<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class UserShow extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

    public function index()
    {
        $dt = $this->getParameters();
        if ($dt['response']['auth']) {
            $dt['response']['user'] = $dt['user'];
        }
        $this->load->view('message', $dt);
    }

}