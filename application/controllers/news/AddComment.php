<?php
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
defined('BASEPATH') OR exit('No direct script access allowed');
class AddComment extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('newsComments','news_comments');
        #Загрузка модели 1=имя моделя, 2= имя таблицы
    }

    public function index()
    {
        $dt = $this->getParameters();
        $newsId = $dt['requests']['news_id'] ?? null;
        $text = $dt['requests']['text'] ?? null;

        $dt['response']['comment'] = [
            'status' => false,
            'comment' => ""
        ];

        if ($dt['response']['auth']) { 
            if (isset($newsId) && isset($text)) {
                $commentId = $this->news_comments->add();
                $comment = [
                    'id' => $commentId,
                    'status' => 1,
                    'creation_date_time' => $dt['response']['current_time'],
                    'user_id' => $dt['user']['id'],
                    'news_id' => $newsId,
                    'text' => $text,
                ];
                $this->news_comments->setById($comment);
                $dt['response']['comment'] = [
                    'status' => true,
                    'id' => strval($commentId)
                ];
            }
        }
        $this->load->view('message', $dt);
    }

    
}