<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class VideoList extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('videos');
        $this->load->model('categoriesVideo','categories_video');
    }

	public function index() 
    {
        $dt = $this->getParameters();
        $dt['response']['categories'] = [];
        $categories = $this->categories_video->get();
        foreach($categories as $value) {
            $dt['requests']['category_id'] = $value['id'];
            $videos['videos'] = $this->videos->get();
            $value['shops'] = $this->getSortVideos($videos);
            $dt['response']['categories'][] = $value;
        }
        
        $this->load->view('message', $dt);
    }

}