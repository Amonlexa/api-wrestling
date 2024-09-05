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
        if(!$this->users->checkEmails($dt['requests']['email'])) {
            $dt['response']['message'] = "Ваш пароль неправильный";
            if ($dt['response']['user'] != null) {
                $dt['response']['user'] = $this->getMySortedProfile($dt['response']['user']);
                $dt['response']['message'] = "VALID_PASSWORD";
            }
        }else{
            $dt['response']['message'] = "Не найден пользователь с такой почтой";
        }
       
        $this->load->view('message', $dt);
    }
}