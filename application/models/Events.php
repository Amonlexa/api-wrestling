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
}