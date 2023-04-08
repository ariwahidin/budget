<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{	
		check_not_login();
		// $this->template->load('template','dashboard');
		redirect(base_url($_SESSION['page']));
	}
}
