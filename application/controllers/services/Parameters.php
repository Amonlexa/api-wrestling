<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Yakutsk');
class Parameters extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
    }

    public function getContents() 
    {
        $receive = file_get_contents('php://input');
        return json_decode($receive, true);
    }

    public function getDefaultResponse($auth = false) 
    {
        return [
            'auth' =>  $auth,
            'message' => (!$auth) ? 'INVALID_TOKEN' : 'VALID_TOKEN',
            'current_time' => date('Y-m-d H:i:s'),
            'time_zone' => date_default_timezone_get(),
            'time_format' => "+09:00"
        ];
    }

    public function getParameters($checkToken = true)
	{
        // Получить все запросы
        $requests = $this->getContents();
        // Присваиваем дефолтные параметры
        $dt = array(
            'user' => null,
            'response' => $this->getDefaultResponse(false),
            'requests' => $requests ?? null,
        );
        // Проверяем токен
        // if ($checkToken) {
        //     $token = $dt['requests']['token'] ?? null;
        //     if ($token != null && $token != "") {
        //         $user = $this->users->getUserByToken($token);
        //         if ($user) {
        //             // Обновляем время посящения
        //             $user['last_visit'] = $dt['response']['current_time'];
        //             $this->users->setUserById($user);
                    
        //             $dt['user'] = $user;
        //             $dt['response'] = $this->getDefaultResponse(true);
        //         }
        //     }
        // }
        return $dt;
	}

    public function getSortNews($list) {
        $sortedList=[];
        foreach($list as $item) {
            $sortedList[] = [
                "id" => $item['id'],
                "title" => $item['title'],
                "images" => $item['images'],
                "date_added"=> $item['date_added']
            ];
        }
        return $sortedList;
    }

}