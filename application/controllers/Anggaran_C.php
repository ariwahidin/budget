<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran_C extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['budget_m', 'anggaran_m']);
	}

	public function showModalSetNewBudget()
	{
		$brand = $this->anggaran_m->getBrand();
		$data = [
			'brand' => $brand,
		];
		$this->load->view('anggaran/modal/modal_set_budget',$data);
	}

	public function checkBudget(){
		// var_dump($_POST);
		$code_brand = $_POST['code_brand'];
		$start_periode = date_create($_POST['start_date']);
		$start_periode = date_format($start_periode,"Y-m-d");
		$end_periode = date_create($_POST['end_date']);
		$end_periode = date_format($end_periode,"Y-m-d");
		$get_purchase = $this->anggaran_m->get_purchase($code_brand, $start_periode, $end_periode);
		if($get_purchase->num_rows() > 0 ){
			$params = [
				'success' => true,
				'purchase' => $get_purchase->result(),
			];
		}else{
			$params = [
				'success' => false,
			];
		}
		echo json_encode($params);
	}

	public function showModalSetBudgetFromPurchase(){
		// var_dump($_POST);
		
		$data = [
			// 'purchase' => $_POST['purchase'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'code_brand' => $_POST['code_brand'],
			'periode_budget' => $_POST['periode_budget'],
		];
		$this->load->view('anggaran/modal/modal_set_budget_from_purchase', $data);
	}

	public function showSetBudgetActivity(){
		$activity = $this->anggaran_m->getActivity();
		$purchaseAmount = $_POST['purchase_amount'];
		$budgetAnp = $_POST['budget_set'];
		$totalPurchaseAmount = 0;
		$totalAnp = 0;
		foreach($purchaseAmount as $key => $v){
			$val = str_replace( ',', '', $v );
			$totalPurchaseAmount += (float)$val;

			$anp = str_replace( ',', '', $budgetAnp[$key] );
			$totalAnp += (float)$anp;
		}
		// var_dump($totalPurchaseAmount);
		// var_dump($totalAnp);
		// var_dump($purchaseAmount);
		$data = [
			'activity' => $activity,
			'data' => $_POST,
			'data_purchase' => $_POST,
			'total_purchase' => $totalPurchaseAmount,
			'total_anp' => $totalAnp,
		];
		$this->load->view('anggaran/ajax/ajax_set_budget_activity', $data);
	}

	public function simpanAnggaran(){
		// var_dump($_POST);
		$this->anggaran_m->insertBudget($_POST);
		if($this->db->affected_rows() > 0){
			$params = [ 'success' => true ];
		}else{
			$params = [ 'success' => false ];
		}
		echo json_encode($params);
	}

	public function lihatAnggaran($brandCode,$yearBudget,$codeAnggaran){
		$activity = $this->getActivity($brandCode,$yearBudget,$codeAnggaran);
		$month = $this->getMonth($brandCode,$yearBudget,$codeAnggaran);
		$anpValue = $this->anggaran_m->getAnpActual($codeAnggaran);
		$actualPurchase = $this->anggaran_m->getPurchaseActual($codeAnggaran);
		$sumTotalAnp = $this->anggaran_m->getSumAnpActual($codeAnggaran);
		$sumTotalpurchase = $this->anggaran_m->getSumActualPurchase($codeAnggaran);
		$presentasePurchase = $this->anggaran_m->getPresentasePurchase($codeAnggaran);
		$data = [
			'brand_code' => $brandCode,
			'year_budget' => $yearBudget,
			'activity' => $activity,
			'month' => $month,
			'code_anggaran' => $codeAnggaran,
			'actual_purchase' => $actualPurchase,
			'anp_value' => $anpValue,
			'sum_anp' => $sumTotalAnp,
			'sum_purchase' => $sumTotalpurchase,
			'presentase_purchase' => $presentasePurchase,
		];
		$this->template->load('template', 'anggaran/anggaran_data_detail', $data);
	}

	public function getActivity($brandCode,$yearBudget,$codeAnggaran){
		$sql = "SELECT DISTINCT activity, presentaseBudget FROM t_budgetActivity
				--WHERE brandCode = '$brandCode' AND budgetYear = '$yearBudget'
				WHERE codeAnggaran = '$codeAnggaran'";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function getMonth($brandCode,$yearBudget,$codeAnggaran){
		$sql = "SELECT DISTINCT [month], [year] FROM t_budgetActivity 
				--WHERE brandCode = '$brandCode' AND budgetYear = '$yearBudget'
				WHERE codeAnggaran = '$codeAnggaran'
				ORDER BY  [year], [month] ASC";
		$query = $this->db->query($sql);
		return $query;
	}

	public function deleteAnggaran($codeAnggaran){
		$sql = "DELETE t_budgetActivity WHERE codeAnggaran = '$codeAnggaran'";
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
			echo "<script>window.location='".site_url('anggaran')."'</script>";
		}else{
			echo "<script>alert('Gagal dihapus');</script>";
		}
	}

	public function checkBudgetSetted(){
		// var_dump($_POST);
		$code_brand = $_POST['code_brand'];
		$startPurchaseDate = $_POST['startPurchaseDate'];
		$endPurchaseDate = $_POST['endPurchaseDate'];
		$sql = "SELECT * FROM t_budgetActivity
				WHERE brandCode = '$code_brand' 
				AND month([month]) IN(month('$startPurchaseDate'), month('$endPurchaseDate'))
				AND year([year]) IN(year('$startPurchaseDate'), year('$endPurchaseDate'))";
		$query = $this->db->query($sql);
		// var_dump($query->result());
		// var_dump($sql);
		// var_dump($query->num_rows());
		if($query->num_rows() > 0){
			$params = ['budget_setted' => true];
		}else{
			$params = ['budget_setted' => false];
		}
		// var_dump(json_encode($params));
		echo json_encode($params);
	}
}