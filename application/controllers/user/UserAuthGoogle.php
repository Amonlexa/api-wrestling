<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");


class UserAuthGoogle extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
        $this->load->library('Googleauth');
    }


    public function index()
    {
        $dt = $this->getParameters();
        $token = $dt['requests']['token'];
        $payload = $this->googleauth->verifyToken($token);

        // if (!$payload) {
        //     $this->output
        //         ->set_status_header(401)
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode(['error' => 'Invalid token']));
        //     return;
        // }

        $user = $this->users->getUserByGoogleId($payload['sub']);
        //Новый пользователь
        if($user == null) {
            $id = $this->users->add();
            $newUser = [
                'id' => $id,
                'token' => $this->getGenerationToken(),
                'phone_number' => "google_auth",
                'creation_date_time' => $dt['response']['current_time'],
                'last_visit' => $dt['response']['current_time'],
                'avatars' => $payload['picture'],
                'first_name' => $payload['given_name'],
                'last_name' => $payload['family_name'],
                'email' => $payload['email'] ?? null,
                'google_id' => $payload['sub'],
            ];
            $this->users->updateUserById($newUser);
            $user = $this->users->getUserById($id);
        }

        $this->users->updateUserById($user);
        $dt['response']['user'] = $user;
        $this->load->view('message', $dt);
    }
}