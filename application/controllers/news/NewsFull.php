<?php
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
defined('BASEPATH') OR exit('No direct script access allowed');
class NewsFull extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
        $this->load->model('newsComments','news_comments');
    }

    public function index()
    {
        $dt = $this->getParameters();
        $id = $dt['requests']['id'] ?? null;
        if($id != null && $id !="") {
            $commentsCount = $this->news_comments->getCountByNewsId($id);
            $full = $this->news->getFullNews($id);
            $dt['response']['full'] = [
                "id" => $full['id'],
                "title" => $full['title'],
                "images" => $full['images'],
                "description" => $full['description'],
                "creation_date_time	" => $full['creation_date_time'],
                "status" => $full['status'],
                "link" => $full['link'],
                "key" =>  $full['key'],
                "author" =>  $full['author'],
                "comments_count" => $commentsCount,
            ];
        }
        $this->load->view('message', $dt);
     }
}