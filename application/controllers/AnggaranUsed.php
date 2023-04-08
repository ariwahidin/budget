<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnggaranUsed extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['anggaran_m', 'budgeting_m']);
	}

	public function getData($no_anggaran, $activity)
	{
        $budget_used = $this->budgeting_m->getPemakaianAnggaran($no_anggaran, $activity);
        $data = [
            'budget_used' => $budget_used,
            'activity' => $activity,
        ];
		$this->template->load('template','anggaran/activity/activity_anggaran_data', $data);
	}

    public function getPemakaianAnggaranActivity(){
        $detail = $this->budgeting_m->getDetailPemakaian($_POST);
        $data = [
            'detail' => $detail,
        ];
        $this->load->view('anggaran/activity/ajax/modal_pemakaian_anggaran_activity', $data);
    }

}
