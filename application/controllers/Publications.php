<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publications extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('medium');
	}

	public function index()
	{
		$publications = json_decode($this->medium->get_publications());
		print_r($publications);
	}
}
