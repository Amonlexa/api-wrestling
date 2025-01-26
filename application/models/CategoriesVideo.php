<?php
class CategoriesVideo extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function get() 
    {
        return $this->db->select("ct.id, ct.name")
        ->from("categories_video ct")
        ->where("ct.status =", 1)
        ->order_by("ct.level", "ASC")
        ->get()
        ->result_array();
    }
}