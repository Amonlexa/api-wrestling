<?php

class News extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }

    public function getNewsList($dt) 
    {
        $page = $dt['requests']['page'] ?? 0;
        $limit = 15;
        return $this->db->from("news")
            ->order_by("news.id", "DESC")
            ->limit((int)$limit, (int)$limit * (int)$page)
            ->get()->result_array();
    }

    public function getFullNews($dt) {
        $id = $dt['requests']['id'] ?? 0;
        return $this->db->from("news")->where("news.id =", $id)->get()->row_array();
    }

    public function getSearchNews($dt) {
        $query = $dt['requests']['query'] ?? "";
        $page = $dt['requests']['page'] ?? 0;
        $limit = 15;
        return $this->db->from("news")
        ->like('news.title', $query, 'both')
        ->limit((int)$limit, (int)$limit * (int)$page)->get()->result_array();
    }

    // public function getComments($id) 
    // {
    //     return $this->db->query("SELECT * FROM comments_news WHERE news_id = ?", array($id))->result_array();
    // }

    // public function add()
    // {
    //     $this->db->insert('users', array('id' => null));
	// 	return $this->db->insert_id();
    // }

    // public function setUserById($dt)
    // {
    //     return $this->db->where("users.id =", $dt['id'])->update('users', $dt);
    // }

    // public function getUserByToken($token) 
    // {
    //     return $this->db->query("SELECT * FROM users WHERE token = ?", array($token))->row_array();
    // }


}