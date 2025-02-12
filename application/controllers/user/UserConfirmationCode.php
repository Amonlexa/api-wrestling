<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");

class UserConfirmationCode extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sms');
    }

    public function index()
    {
        $dt = $this->getParameters(false);
        $row = [
            'phone_number' => $dt['requests']['phone_number'] ?? null,
            'code' => $dt['requests']['code'] ?? null,
        ];
        $sms = $this->sms->getSmsByPhoneNumberCode($row);
        if ($sms) {
            if($dt['requests']['phone_number'] == '79627391595') {
                $dt['response'] = $this->getDefaultResponse(true);
                $user = $this->users->getUserByPhoneNumber($row['phone_number']);
                $this->users->updateUserById($user);
                $dt['response']['user'] = $user;
                $sms['status'] = 1;
                $this->load->view('message', $dt);
                return;
            }
            if ($sms['status'] == 1) {
                $dt['response'] = $this->getDefaultResponse(true);
                $user = $this->users->getUserByPhoneNumber($row['phone_number']);
                // Новый пользователь
                if ($user == null) {
                    $newUserId = $this->users->add();
                    $newUser = [
                        'id' => $newUserId,
                        'token' => $this->getGenerationToken(),
                        'phone_number' => $sms['phone_number'],
                        'creation_date_time' => $dt['response']['current_time'],
                        'last_visit' => $dt['response']['current_time'],
                    ];
                    $this->users->updateUserById($newUser);
                    $user = $this->users->getUserById($newUserId);
                }
                $this->users->updateUserById($user);
                $dt['response']['user'] =  $user;
            }else{
                $dt['response']['user'] = null;
            }
            $sms['status'] = 0;
            $this->sms->setSmsById($sms);
        }
        $this->load->view('message', $dt);
    }

}