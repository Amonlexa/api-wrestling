<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class NewsCommentsList extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('newsComments','news_comments');
    }

	public function index() 
    {
        $dt = $this->getParameters();
        $id = $dt['requests']['news_id'];
        $dt['response']['comments'] = $this->news_comments->getByNewsId($id);
        $this->load->view('message', $dt);
    }
    
}