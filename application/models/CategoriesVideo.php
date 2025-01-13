<?php
class CategoriesVideo extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function get() 
    {
        return $this->db->select("ct.id, ct.name")->from("categories_video ct")->get()->result_array();
    }
}