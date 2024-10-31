<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class UserEdit extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

    public function index() {
        $dt = $this->getParameters();
        $firstName = $dt['requests']['first_name'] ?? null;
        $lastName = $dt['requests']['last_name'] ?? null;
        $patronymic = $dt['requests']['patronymic'] ?? null;
        $avatars = $dt['requests']['avatars'] ?? null;
        $email = $dt['requests']['email'] ?? null;
        $dt['response']['is_set'] = false;

        if ($dt['response']['auth']) {
            if ($firstName != null && $lastName != null && $patronymic != null) {

                $dt['response']['is_set'] = true;

                $dt['user']['first_name'] = $firstName;
                $dt['user']['last_name'] = $lastName;
                $dt['user']['patronymic'] = $patronymic;
                $dt['user']['status'] = "1";
                $dt['user']['avatars'] = $avatars;
                $dt['user']['email'] = $email;
                $this->users->updateUserById($dt['user']);
                $user = $this->users->getUserById($dt['user']['id']);
                $dt['response']['user'] = $this->getMySortedProfile($user);
            }
        }
        $this->load->view('message', $dt);

    }

}