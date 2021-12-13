<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('medium');
	}

	public function index()
	{
		if ($this->input->get('title') != "" && $this->input->get('title') != "") {
			$title = $this->input->get('title');
			$description = $this->input->get('description');
			$post = json_decode($this->medium->post_post($title, $description));
			print_r($post);
		} else {
			echo "please input title and description";
		}
	}
}
