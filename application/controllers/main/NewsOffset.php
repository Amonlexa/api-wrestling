<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class NewsOffset extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('news');
    }

	public function index() 
    {
        $dt = $this->getParameters();
        $dt['response']['total_count']= $this->news->getCountNews();
        $dt['response']['next_offset']= "20";
        $dt['response']['result_count']= count($this->news->getOffsetNews($dt));
        $dt['response']['news'] = $this->getSortNews($this->news->getOffsetNews($dt));
        $this->load->view('message', $dt);
    }

}