<?php
class Users extends CI_Model {

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

    public function updateUser($dt) {
        // return $this->db->where("users.id =", $dt['id'])->update('users', $dt);
        return $this->db->where("users.id =", $dt['id'])->update('users',$dt);
    }

    public function checkEmails($email) {
        $emails = $this->db->query("SELECT * FROM `users` `us` WHERE `us`.`email` = ?", array($email))->result_array();
        if (count($emails) == 0) {
            return true;
        }else{
            return false;
        }
    }

}