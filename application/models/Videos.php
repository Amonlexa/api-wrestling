<?php

class Videos extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function get() 
    {
        return $this->db->from("videos")
            ->order_by("videos.id", "DESC")
            ->where("videos.status =", 1)
            ->get()->result_array();
    }

    public function getFullVideo($id) {
        return $this->db->from("videos")->where("videos.id =", $id)->get()->row_array();
    }
}