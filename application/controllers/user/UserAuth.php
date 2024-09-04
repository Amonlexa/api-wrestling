<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class UserAuth extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }


    public function index()
    {
        $dt = $this->getParameters();
        $dt['response']['user'] = $this->users->getUserByPassword($dt);
        if ($dt['response']['user'] != null) {
            $dt['response']['user'] = $this->getMySortedProfile($dt['response']['user']);
        }else{
            $dt['response']['auth'] = false;
            $dt['response']['message'] = "Ваш логин или пароль неверны";
        }
        $this->load->view('message', $dt);
    }
}