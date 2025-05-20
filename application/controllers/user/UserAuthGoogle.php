<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");


class UserSendCode extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

    public function index()
    {
        $dt = $this->getParameters(false);
        $provider = $dt['requests']['provider'] ?? "google";
        $userId = $dt['requests']['token'] ?? null;


        $status = [
            'dispatch_status' => false,
            'is_valid_phone_number' => $this->isValidPhoneNumber($phoneNumber),
            'code' => strval($code),
        ];

        $row = array(
            'status' => 1,
            'creation_date_time' => $dt['response']['current_time'],
            'sender_ip' => $this->getIp(),
            'phone_number' => $phoneNumber,
            'telegram_user_id' => $userId,
            'telegram_user_name' => $userName,
            'telegram_full_name' => $userFullName,
            'code' => $code,
            'message' => $message
        );
        $this->load->view('message', $dt);
    }
}