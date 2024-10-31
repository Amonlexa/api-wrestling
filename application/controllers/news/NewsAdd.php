<?php
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
defined('BASEPATH') OR exit('No direct script access allowed');
class NewsAdd extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
    }

    public function index()
    {
        $dt = $this->getParameters();
        $title = $dt['requests']['title'] ?? null;
        $text = $dt['requests']['text'] ?? null;
        $link = $dt['requests']['link'] ?? null;
        $images = $dt['requests']['images'] ?? null;
        $key = $dt['requests']['key'] ?? null;

        $dt['response']['add'] = [
            'message' => "Есть новость с такой ссылкой",
            'id' => "Не отправлено"
        ];

        if($this->news->isDuplicateNewsLink($link)) {
            if (isset($title) && isset($text) && isset($link)) {
                $newsId = $this->news->add();
                $data = [
                    'id' => $newsId,
                    'status' => "1",
                    'creation_date_time' => $dt['response']['current_time'],
                    'title'=> $title,
                    'link'=> $link,
                    'key'=> $key,
                    'author' => "Спорт Якутии",
                    'description' => $text,
                    'images' => $images,
                ];
                $this->news->setById($data);
                $dt['response']['add'] = [
                    'message' => "Успешно добавлен",
                    'id' => strval($newsId)
                ];
            }
    }
    $this->load->view('message', $dt);
}

    
}