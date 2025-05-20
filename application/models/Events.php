<?php

class Events extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function getLastEvents() {
        return $this->db->from("events")
            ->order_by("events.id", "DESC")
            ->limit(5)
            ->get()
            ->result_array();
    }

    public function getAllEvents($dt) 
    {
        $page = $dt['requests']['page'] ?? 0;
        $limit = 10;
        return $this->db->from("events")
            ->order_by("events.id", "DESC")
            ->limit((int)$limit, (int)$limit * (int)$page)
            ->get()
            ->result_array();
    }


}