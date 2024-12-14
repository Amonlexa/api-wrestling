<?php

class Cities extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }


    public function add()
    {
        $this->db->insert('cities', array('id' => null));
		return $this->db->insert_id();
    }

    public function setById($dt)
    {
        return $this->db->where("cities.id =", $dt['id'])->update('cities', $dt);
    }


    public function isDuplicateCity($guid) 
    {
        $size = $this->db->from("cities")
            ->where("cities.guid =", $guid)
            ->get()
            ->result_array();
        if (count($size) == 0) {
            return true;
        }
        return false;
    }

    public function getCountNews() {
        $size = $this->db->from("cities")
            ->get()
            ->result_array();
        return count($size);
    }
}