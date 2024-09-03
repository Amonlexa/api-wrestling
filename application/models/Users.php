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

    public function updateUserById($dt) {
        return $this->db->where("users.id =", $dt['id'])->update('users',$dt);
    }

    public function getUserByToken($token) 
    {
        return $this->db->from("users us")->where("us.token =", $token)->get()->row_array();
    }


    public function getUserById($userId) 
    {
        return $this->db->from("users us")->where("us.id =", $userId)->get()->row_array();
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