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

    public function getOffsetNews($dt) 
    {
        $offset = $dt['requests']['offset'] ?? 0;
        $limit = 20;
        return $this->db->from("news")
            ->order_by("news.id", "DESC")
            ->limit((int)$limit,(int) $offset)
            ->get()->result_array();
    }


    public function getFullNews($id) {
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

    public function add()
    {
        $this->db->insert('news', array('id' => null));
		return $this->db->insert_id();
    }

    public function setById($dt)
    {
        return $this->db->where("news.id =", $dt['id'])->update('news', $dt);
    }

    public function getTopHeadlines() {
        $page = 0;
        $limit = 5;
        return $this->db->from("news")
            ->order_by("news.id", "DESC")
            ->limit((int)$limit, (int)$limit * (int)$page)
            ->get()->result_array();
    }

    public function isDuplicateNewsLink($link) 
    {
        $size = $this->db->from("news")
            ->where("news.link =", $link)
            ->get()
            ->result_array();
        if (count($size) == 0) {
            return true;
        }
        return false;
    }

    public function getCountNews() {
        $size = $this->db->from("news")
            ->get()
            ->result_array();
        return count($size);
    }
}