<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardPandurasa extends CI_Controller {

    public function index(){
        $this->template->load('template', 'dashboard/dashboard_pandurasa');
    }
}