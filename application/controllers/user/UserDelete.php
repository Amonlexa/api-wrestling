<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class UserDelete extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

   public function index() {
    $dt = $this->getParameters();
    $dt['response']['is_set'] = false;
    if ($dt['response']['auth']) {
        $dt['response']['is_set'] = true;
        $user = ['id' => $dt['user']['id'], 'status' => 0];
        $this->users->updateUserById($user);
    }
    $this->load->view('message', $dt);
   }

}