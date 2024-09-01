<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends Parameters {


	public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
    }


	public function index()
	{

	}



}