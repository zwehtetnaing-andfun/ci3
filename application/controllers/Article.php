<?php
class Article extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_model','Article'); // load model and name as Article
		$this->load->helper('url_helper'); // load url_helper function to use codeigniter url
		$this->load->helper('form'); // load form helper function to use form
	}

	public function index()
	{
		$data['page_title'] = 'Article'; // to send header for title
		$data['articles'] = $this->Article->get_all_articles(); // get all articles through model
		
        $this->load->view('layouts/header',$data); // load header view and passing data
        $this->load->view('articles/index',$data); // load article index view and passing data
        $this->load->view('layouts/footer'); // load footer view
	}

	public function create()
	{
		$data['page_title'] = 'Create new article';
        $this->load->view('layouts/header',$data);
        $this->load->view('articles/create');
        $this->load->view('layouts/footer');
	}

	public function store()
	{
		
		$data['title'] = $this->input->post('title'); // get data from post method
		$data['content'] = $this->input->post('content');
		$this->Article->insert_article($data); // insert data to database through model
		redirect('/article'); // redirect to article index page
	}

	public function edit($id)
	{
		$data['page_title'] = 'Create new article';
		$data['article'] = $this->Article->get_article_by_id($id); // get specific data through model
        $this->load->view('layouts/header',$data);
        $this->load->view('articles/edit',$data);
        $this->load->view('layouts/footer');
	}

	public function update($id)
	{
		echo "hello";
		$data['id'] = $id;
		$data['title'] = $this->input->post('title');
		$data['content'] = $this->input->post('content');
		$this->Article->update_article($data);
		redirect('/article');
	}

	public function delete($id)
	{
		$this->Article->delete_article($id); // delete specific data through model
		redirect('/article');
	}
}
