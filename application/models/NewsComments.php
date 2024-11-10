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
        return $this->db->where("news_comments.id =", $dt['commentId'])->update('news_comments', $dt['comment']);
    }

    public function getByNewsId($dt) {
        $this->db->select("nc.id,nc.creation_date_time,nc.text, nc.news_id, nc.status")
            ->select("us.first_name,us.avatars, nc.user_id")
            ->from("news_comments nc")
            ->where("nc.status =", 1)
            ->where("nc.news_id", $dt['requests']['id'])
            ->join("users us", "us.id = nc.user_id", "inner")
            ->order_by("nc.id", "ASC");
        return $this->db->get()->result_array();
    }

    public function getCountByNewsId($id) {
        $this->db->select('count(*) as count');
        $this->db->where("nc.news_id", $id);
        $this->db->from("news_comments nc");
        $query = $this->db->get();
        return $query->row()->count;
    }

}