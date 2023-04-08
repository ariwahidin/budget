<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['pembelian_m', 'anggaran_m']);
	}

	public function index()
	{   
		$check = $this->anggaran_m->budgetHasBeenSet();
		$brand_year = [];
		$result = $check->result();
		
		for($i = 0; $i < count($result); $i++){
			$brand = $result[$i]->brand_code;
			$tahun = $result[$i]->tahun;
			$brand = preg_replace('/\s+/', '', $brand);
			array_push($brand_year,$brand.$tahun);
		}

		if($brand_year != []){
			$brand_year = implode(',',$brand_year);
			$brand_year = str_replace(",", "','",$brand_year);
		}

        $data = [
            'budget' => $this->pembelian_m->get($brand_year),
        ];

		$this->template->load('template','anggaran/pembelian_data', $data);
	}


	public function set_budget(){
		$data = [
			'pembelian' => $_POST,
		];
		$this->load->view('anggaran/ajax/modal_set_budget', $data);
	}

	public function simpanBudget(){
		
		$post = $_POST;
		$no_anggaran = $this->anggaran_m->anggaran_code();
		$post['no_anggaran'] = $no_anggaran;
		$this->pembelian_m->simpanBudget_m($post);

		if($this->db->affected_rows() > 0){
			$response = ['success' => true];
		}else{
			$response = ['success' => false];
		}
		echo json_encode($response);
	}

	
}
