<?php

class Article_model extends CI_Model {

	public $title;
	public $content;
	public $created_at;
	public $updated_at;

	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_articles()
	{
		$query = $this->db->get('articles');
		return $query->result_array();
		
	}

	public function get_article_by_id($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('articles');
		return $query->row_array();
	}

	public function insert_article($data)
	{
		$this->title = $data['title'];
		$this->content = $data['content'];

		$this->db->insert('articles',$this);
	}

	public function update_article($data)
	{
		$this->title = $data['title'];
		$this->content = $data['content'];

		$this->db->update('articles', $this, array('id' => $data['id']));
	}

	public function delete_article($id)
	{
		$this->db->delete('articles', array('id' => $id));
	}


}


// CREATE TABLE IF NOT EXISTS articles(
//     id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
//     title VARCHAR(50) NOT NULL,
//     content TEXT,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// );
