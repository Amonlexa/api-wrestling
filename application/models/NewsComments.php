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

}