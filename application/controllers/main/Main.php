<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class Main extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
    }

	public function index() 
    {
        $dt = $this->getParameters();
        $dt['response']['news_list'] = $this->getSortNews($this->news->getNewsList($dt));
        $dt['response']['ads_list'] = $this->getSortNews($this->news->getNewsList($dt));
        $this->load->view('message', $dt);
    }

}