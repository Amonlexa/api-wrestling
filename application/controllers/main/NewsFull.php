<?php
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
defined('BASEPATH') OR exit('No direct script access allowed');
class NewsFull extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
    }

    public function index()
    {
        $dt = $this->getParameters();
        $id = $dt['requests']['id'] ?? null;
        if($id != null && $id !="") {
            $dt['response']['full'] = $this->news->getFullNews($dt);
        }
        $this->load->view('message', $dt);
     }
}