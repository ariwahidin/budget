<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['budget_m','anggaran_m','employee_m', 'brand_m', 'promotion_m']);
	}

	public function index()
	{
		// $check = $this->anggaran_m->budgetActivityHasBeenSet();
		$anggaran = $this->anggaran_m->getSummaryBudget();
		$data = [
			'anggaran' => $anggaran,
		];
		$this->template->load('template','anggaran/anggaran_data', $data);
	}


	public function add()
	{   
        $no_anggaran = $this->anggaran_m->anggaran_code();
        $pic = $this->employee_m->get();
        $budget = $this->budget_m->get();
		$data = array(
			'page' => 'add',
			'budget' => $budget,
            'no_anggaran' => $no_anggaran,
            'pic' => $pic,
		);
		$this->template->load('template','anggaran/anggaran_form', $data);
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add']))
		{	
			$this->addDetailAnggaran($post);
		}
		
	}

    public function addDetailAnggaran($post){
		$data = [
			'anggaran' => $post,
			'brand' => $this->brand_m->get(),
		];
        $this->template->load('template','anggaran/anggaran_form_detail', $data);
    }

	public function simpanAnggaran(){

		$this->anggaran_m->simpanAnggaran(str_replace(',', '', $_POST));

		if($this->db->affected_rows() > 0){
			$params = array("success" => true);
		} else {
			$params = array("success" => false);
		}
		echo json_encode($params);
	}

	public function tambahActivity($no_anggaran){
		$anggaranDetail = $this->anggaran_m->getAnggaranDetail($no_anggaran);
		$activity = $this->promotion_m->get();
		$data = [
			'anggaranDetail' => $anggaranDetail,
			'activity'=>$activity,
		];
		$this->template->load('template', 'anggaran/anggaran_form_activity', $data);
	}

	public function simpanAnggaranActivity(){
		// var_dump($_POST);
		// die;
		$this->anggaran_m->simpanAnggaranActivity($_POST);
		if($this->db->affected_rows() > 0){
			$params = array(
				'success' => true,
			);
		}else{
			$params = array(
				'success' =>false,
			);
		}
		echo json_encode($params);
	}

	public function lihatAnggaranActivity($no_anggaran){
		$monthAnggaran = $this->anggaran_m->getMonthAnggaranActivity($no_anggaran);
		$anggaranActivity = $this->anggaran_m->getAnggaranActivity($no_anggaran);
		$data = [
			'monthAnggaran' => $monthAnggaran,
			'anggaranActivity' => $anggaranActivity,
			'activity' => $this->anggaran_m->getActivityFromAnggaranActivity($no_anggaran),
			'presentase' => $this->anggaran_m->getPresentaseActivityFromAnggaranActivity($no_anggaran),
		];
		
		$this->template->load('template', 'anggaran/anggaran_activity_data',$data);
	}

	public function deleteAnggaran($no_anggaran){
		$this->anggaran_m->deleteAnggaran($no_anggaran);
	}

}
