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
        $dt['response']['is_set'] = false;
        if ($dt['response']['auth']) {
            $updateData = [];
    
            // Проверяем каждый параметр и добавляем его в массив обновления, если он не нулевой
            if (!empty($dt['requests']['first_name'])) {
                $updateData['first_name'] = $dt['requests']['first_name'];
            }
            if (!empty($dt['requests']['last_name'])) {
                $updateData['last_name'] = $dt['requests']['last_name'];
            }
            if (!empty($dt['requests']['patronymic'])) {
                $updateData['patronymic'] = $dt['requests']['patronymic'];
            }
            if (!empty($dt['requests']['avatars'])) {
                $updateData['avatars'] = $dt['requests']['avatars'];
            }
            if (!empty($dt['requests']['email'])) {
                $updateData['email'] = $dt['requests']['email'];
            }

            if (!empty($dt['requests']['push_token'])) {
                $updateData['push_token'] = $dt['requests']['push_token'];
            }
    
            // Если есть данные для обновления
            if (!empty($updateData)) {
                // Добавляем id пользователя в массив обновления
                $updateData['id'] = $dt['user']['id']; // предполагается, что ID пользователя хранится в $dt['user']
    
                // Обновляем только переданные данные
                $this->users->updateUserById($updateData);
    
                // Получаем обновленного пользователя
                $dt['response']['user'] = $this->users->getUserById($dt['user']['id']);
                $dt['response']['is_set'] = true; // Успешное обновление
            }
        }
        $this->load->view('message', $dt);
    }

}