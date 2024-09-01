<?php
class User extends CI_Model {

    public function __construct()
	{
		$this->load->database();
    }
    
    public function add()
    {
        $this->db->insert('users', array('id' => null));
		return $this->db->insert_id();
    }

    public function setUserById($dt) {
        return $this->db->where("users.id=", $dt['id'])->update('users',$dt);
    }

}