<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('medium');
	}

	public function index()
	{
		$profile = json_decode($this->medium->get_profile());
		echo "name: " . $profile->data->name;
		echo "<br/>";
		echo "url: " . $profile->data->url;
	}
}
