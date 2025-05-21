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
      
        $payload = $this->googleauth->verify_token($token);
        if (!$payload) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Invalid token']));
            return;
        }

        $id = $this->users->add();
        $newUser = [
            'id' => $id,
            'token' => $this->getGenerationToken(),
            'phone_number' => "google_auth",
            'creation_date_time' => $dt['response']['current_time'],
            'last_visit' => $dt['response']['current_time'],
            'first_name' => $payload['given_name'],
            'last_name' => $payload['last_name'],
            'email' => $payload['email'],
            'google_id' => $payload['sub'],
        ];
        $user = $this->users->updateUserById($newUser);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'user' => $user
            ]));
        $this->load->view('message', $dt);

    }
   
}