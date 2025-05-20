<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
class EventsList extends Parameters {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('events');
    }

	public function index() 
    {
        $dt = $this->getParameters();
        $dt['response']['events'] = $this->events->getAllEvents($dt);
        $this->load->view('message', $dt);
    }

}