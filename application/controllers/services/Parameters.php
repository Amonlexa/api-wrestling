<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Yakutsk');
class Parameters extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
        $this->load->model('users');
        $this->load->model('videos');
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


    public function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR']; 
    }

     // Генерация ТОКЕНА
     public function getGenerationToken($length = 73)
     {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < $length; $i++) {
             $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         return $randomString;
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
        #Проверяем токен
        if ($checkToken) {
            $token = $dt['requests']['token'] ?? null;
            if ($token != null && $token != "") {
                $user = $this->users->getUserByToken($token);
                if ($user) {
                    // Обновляем время посящения
                    $user['last_visit'] = $dt['response']['current_time'];
                    $this->users->updateUserById($user);
                    
                    $dt['user'] = $user;
                    $dt['response'] = $this->getDefaultResponse(true);
                }
            }
        }
        return $dt;
	}

    public function getSortNews($list) {
        $sortedList=[];
        foreach($list as $item) {
            $sortedList[] = [
                "id" => $item['id'],
                "title" => $item['title'],
                "images" => $item['images'],
                "creation_date_time"=> $item['creation_date_time']
            ];
        }
        return $sortedList;
    }



    public function getSortAds($list) {
        $sortedList=[];
        foreach($list as $item) {
            $sortedList[] = [
                "id" => $item['id'],
                "title" => $item['title'],
                "type" => $item['type'],
                "link"=> $item['link']
            ];
        }
        return $sortedList;
    }

}