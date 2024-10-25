<?php

class Sms extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function add()
    {
        $this->db->insert('sms', ['id' => null]);
		return $this->db->insert_id();
    }

    public function setSmsById($dt)
    {
        return $this->db->where("sms.id =", $dt['id'])->update('sms', $dt);
    }

    public function getSmsByPhoneNumber($phoneNumber) {
        return $this->db->from("sms sm")->where("sm.phone_number =", $phoneNumber)->get()->row_array();
    }

    public function getSmsByPhoneNumberCode($dt) {
        return $this->db->from("sms sm")->where("sm.phone_number =", $dt['phone_number'])->where("sm.code =", $dt['code'])->get()->row_array();
    }

    public function isDuplicatePhoneNumber($phoneNumber) {
        $quantity = $this->db->from("sms sm")
            ->where("sm.phone_number =", $phoneNumber)
            ->get()
            ->result_array();
        if (count($quantity) != 0) {
            return true;
        }
        return false;
    }

}