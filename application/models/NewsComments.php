<?php
class NewsComments extends CI_Model {

    public function __construct()
	{
		$this->load->database();
    }

    public function add()
    {
        $this->db->insert('news_comments', ['id' => null]);
		return $this->db->insert_id();
    }

    public function setById($dt)
    {
        return $this->db->where("news_comments.id =", $dt['id'])->update('news_comments', $dt);
    }

    public function getByNewsId($id) {
        $this->db->select("nc.id,nc.creation_date_time,nc.text")
            ->select("us.id,us.first_name,us.avatars")
            ->from("news_comments nc")
            ->where("nc.status =", 1)
            ->where("nc.news_id", $id)
            ->join("users us", "us.id = nc.user_id", "inner")
            ->order_by("nc.id", "DESC");
        return $this->db->get()->result_array();
    }

}