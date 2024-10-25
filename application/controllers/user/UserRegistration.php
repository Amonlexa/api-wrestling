<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");

class UserRegistration extends Parameters {


	public function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }


    #deprecated function
	public function index()
	{
        $dt = $this->getParameters();
        $email = $dt['requests']['email'] ?? null;
        $password = $dt['requests']['password'] ?? null;
        
        if (strlen($password) < 8) {
            $dt['response']['auth'] = false;
            $dt['response']['message'] = "Ваш пароль слишком короткий";
            $this->load->view('message', $dt);
            return;
        } else {
            // Проверка наличия кириллицы в пароле
            if (preg_match('/[\p{Cyrillic}]/u', $password)) {
               $dt['response']['auth'] = false;
               $dt['response']['message'] = "Пожалуйста используйте латиницу";
               $this->load->view('message', $dt);
               return;
            } else {
                // Проверка валидности email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $dt['response']['auth'] = false;
                    $dt['response']['message'] = "Пожалуйста введите настоящий email";
                    $this->load->view('message', $dt);
                    return;
                } else {
                    // Проверка существования пользователя с данным email
                    if (!$this->users->checkEmails($email)) {
                        $dt['response']['auth'] = false;
                        $dt['response']['message'] = "Уже есть пользователь с такой почтой";
                        $this->load->view('message', $dt);
                        return;
                    } else {
                        // Создание нового пользователя
                        $newUser = [
                            'id' => $this->users->add(),
                            'token' => $this->generationToken(),
                            'email' => $email,
                            'creation_date_time' => $dt['response']['current_time'],
                            'last_visit' => $dt['response']['current_time'],
                            'status' => "0",
                            'password' => md5($password),
                        ];
        
                        // Сохранение нового пользователя и формирование результата
                        $this->users->updateUserById($newUser);
                        $dt['response']['auth']=true;
                        $dt['response']['message']= "Success";
                        $dt['response']['user'] = $newUser;
                    }
                }
            }
        }
        
        // Вывод результата в формате JSON
        $this->load->view('message', $dt);

	}

    public function generationToken($length = 73)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }

    public function isLatin($str)
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            return false;
        } else {
            return true;
        }
    }





}