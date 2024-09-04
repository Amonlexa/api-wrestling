<?php 
class Ads extends CI_Model {

    public function __construct()
	{
		$this->load->database();
    }

    public function getAdsList() 
    {
        return $this->db->from("ads")->order_by("ads.id", "DESC")->get()->result_array();
    }

}