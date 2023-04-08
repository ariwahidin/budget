<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		check_not_login();
        $this->load->model(['customer_m','product_m','promotion_m','brand_m','budget_m','proposal_m','cart_m', 'transaction_m', 'department_m', 'employee_m','anggaran_m', 'budgeting_m','budget_m']);
		
	}

	public function buatProposal(){
		// var_dump($_POST['from_sales']);
		// die;
		if($_POST['from_sales'] == 'true'){

			$check_table_sales = $this->proposal_m->check_table_sales_m($_POST);

			if($check_table_sales->num_rows() > 0){
				$this->proposal_m->setTableSales($_POST);
				$response = ['check' => true];
			}else{
				$response = ['check' => false];
				echo json_encode($response);
				die;
			}
		}

		$anggaran_used = $this->anggaran_m->getAnggaranPerActivity($_POST)->num_rows();
		if($anggaran_used == 0){
			$response = [ 'success' => false];
		}else{
			$response = [ 'success' => true];
		}
		echo json_encode($response);	
	}

    public function formProposal($code_brand = null, $activity = null, $start_date = null, $end_date = null, $from_sales = null, $sales_avg = null)
	{
		// var_dump($from_sales);
		// die;
		$employee = $this->employee_m->get();
		$department = $this->department_m->get();
		$item = $this->product_m->get()->result();
		$promotion = $this->promotion_m->get()->result();
		$brand = $this->brand_m->get()->result();
		$budget = $this->budget_m->get()->result();
		$no_transaction = $this->proposal_m->transaction_no();
		$cart = $this->cart_m->getCartTransaction();
		$sumTotalTarget = $this->cart_m->getSumTotalTarget();
		$sumTotalCosting = $this->cart_m->getSumTotalCosting();
		$data = array(
			'sales_avg' => $sales_avg,
			'from_sales' => $from_sales,
			'code_brand' => $code_brand,
			'activity' => $activity,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'employee' => $employee,
			'department' => $department,
			'item' => $item,
			'promo'=> $promotion,
			'brand' => $brand,
			'budget' => $budget,
			'no_transaction' => $no_transaction,
			'cart' => $cart,
			'sum_target'=> $sumTotalTarget,
			'sum_costing'=> $sumTotalCosting,
		);
		$this->template->load('template','transaction/proposal/proposal_form',$data);
	}

	public function process()
	{
		$data = $this->input->post(null, TRUE);

		if(isset($_POST['del_customer_selected'])){

			$this->proposal_m->customer_selected_del($data);

			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			}else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}

		if(isset($_POST['choose_item'])){
			$item = $this->product_m->get(null,$_POST['code_brand']);

			$data = [
				'item' => $item,
			];

			if($item->num_rows() > 0){
				$params = array(
					'ada_data' => true,
					'data' => $item->result(),
				);
			}else{
				$params = array('ada_data' => false);
			}
			echo json_encode($params);					 
		}
	}

	public function add_customer_selected(){
		
		$this->proposal_m->add_customer_selected($_POST);
		
		if($this->db->affected_rows() > 0)
			{
				$params = array("success" => true);
			}else {
				$params = array("success" => false);
			}
			echo json_encode($params);
	}

	public function get_customer_modal(){

		if($_POST['from_sales'] == 'false'){
			$code_customer = null;
			if(!empty($_POST['code_customer'])){
				$code_customer = $_POST['code_customer'];
			};
			$customer = $this->customer_m->get(null, $code_customer)->result();
		}else {
			$code_customer = null;
			if(!empty($_POST['code_customer'])){
				$code_customer = $_POST['code_customer'];
			};
			$customer = $this->proposal_m->getCustomerFromSales($code_customer)->result();
		}

		$data = [
			'customer' => $customer,
		];



		$this->load->view('transaction/proposal/ajax/customer_data',$data);
	}

	public function get_customer_selected(){
		$customer = $this->proposal_m->get_customer_selected($this->fungsi->user_login()->id);
		$data = array(
			'customer' => $customer,
		);
		$this->load->view('transaction/proposal/ajax/customer_selected_data',$data);
	}

	public function getItemByBrand($codeBrand){
		$item = $this->product_m->get(null,$codeBrand);
		// var_dump($item->result());
		// die;
		$data = array(
			'product' => $item,
		);
		$this->load->view('transaction/proposal/ajax/item_data',$data);
	}

	public function getItemFromSalesTemp(){
		$item = $this->proposal_m->getItemFromSalesTemp();
		$data = array(
			'product' => $item,
		);
		$this->load->view('transaction/proposal/ajax/item_data',$data);
	}

	public function get_customer_ajax(){
		$list = $this->customer_m->get_datatables();
		$data = [];
		$no = @$_POST['start'];
		foreach($list as $customer){
			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $customer->GroupName;
			$row[] = $customer->CustomerName;
			$data[] = $row;
		}
		$output = [
			'draw' => @$_POST['draw'],
			'recordsTotal' => $this->customer_m->count_all(),
			'recordsFiltered' => $this->customer_m->count_filtered(),
			'data' => $data
		];
		echo json_encode($output);
	}


	public function addCartItem(){
		$post = $this->input->post(null, TRUE);
		$this->cart_m->addCartTransaction($post);

		if($this->db->affected_rows() > 0){
			$sumTotalTarget = $this->cart_m->getSumTotalTarget();
			$sumTotalCosting = $this->cart_m->getSumTotalCosting();
			$params = array(
				'success' => true,
				'sum_target' => $sumTotalTarget,
				'sum_costing' => $sumTotalCosting,
			);
		}else{
			$params = array('success' => false);
		}
		echo json_encode($params);
	}

	public function getCartItem(){
		$cart = $this->cart_m->getCartTransaction();
		$data = array(
			'cart' => $cart,
		);
		$this->load->view('transaction/proposal/ajax/target_item_data',$data);
	}

	public function getSumTotalTarget(){
		$sum = $this->cart_m->getSumTotalTarget();
		var_dump($sum);
		echo $sum[0]['sum_total_target'];
	}

	public function delCartItem(){

		$post = $this->input->post();
		$this->cart_m->delCart($post);
		$sumTotalTarget = $this->cart_m->getSumTotalTarget();
		$sumTotalCosting = $this->cart_m->getSumTotalCosting();
		if($this->db->affected_rows() > 0){
			$params = array(
				'success' => true,
				'sum_target' => $sumTotalTarget,
				'sum_costing' => $sumTotalCosting,
			);
			}else{
			$params = array(
				'success' => false,
				'sum_target' => $sumTotalTarget,
				'sum_costing' => $sumTotalCosting,
			);
		}
		echo json_encode($params);
	}

	public function edit_cart(){
		$post = $this->input->post();
		$this->cart_m->edit_cart($post);
		if($this->db->affected_rows() > 0){
			$sumTotalTarget = $this->cart_m->getSumTotalTarget();
			$sumTotalCosting = $this->cart_m->getSumTotalCosting();
			$params = array(
				'success' => true,
				'sum_target' => $sumTotalTarget,
				'sum_costing' => $sumTotalCosting,
			);
		}else{
			$params = array('success' => false);
		}
		echo json_encode($params);
	}

	public function UpdateCartWhenMultipleTargetChanged(){
		$post = $this->input->post();
		$this->cart_m->UpdateCartWhenMultipleChanged($post['multiple_target']);
		
		if($this->db->affected_rows() > 0){
			$sumTotalTarget = $this->cart_m->getSumTotalTarget();
			$sumTotalCosting = $this->cart_m->getSumTotalCosting();
			$params = array(
				'success' => true,
				'sum_target' => $sumTotalTarget,
				'sum_costing' => $sumTotalCosting,
			);
		}else{
			$params = array('success' => false);
		}
		echo json_encode($params);
	}

	public function proses_simpan_transaksi(){
		$tambahan = (int)$_POST['bulan_budget_tambahan'];
		$transaction_code = $this->proposal_m->transaction_no();
		$transaksi = $this->transaction_m->simpanTransaksi($transaction_code);
		$transaksi_detail = $this->transaction_m->simpanTransaksiDetail($transaction_code);
		$transaksi_customer = $this->transaction_m->simpanCustomer($transaction_code, $_POST['customer']);
		$simpan_objective = $this->transaction_m->simpanObjective($_POST, $transaction_code);
		$simpan_mechanism = $this->transaction_m->simpanMechanism($_POST, $transaction_code);
		
		if($transaksi_detail == true){
			$this->prosesBudgeting($_POST);
		}

		if($this->db->affected_rows() > 0){
			$params = array('success' => true);
		}else{
			$params = array('success' => false);
		}
		echo json_encode($params);
	}

	public function HapusAllCart(){
		$salesTemp = $this->proposal_m->dellSalesTemp();
		if($salesTemp == true){
			$cartItem = $this->transaction_m->dellAllCartItem();
		}
		if($this->db->affected_rows() > 0){
			$params = array('dell_cart_success' => true);
		}else{
			$params = array('dell_cart_success' => false);
		}
		echo json_encode($params);
	}

	public function budgetTambahan($bulan, $nominal){
		$data = [
			'bulan_tambahan' => $bulan,
			'nominal' => $nominal,
		];
		$this->load->view('transaction/proposal/ajax/budget_tambahan', $data);
	}

	public function tampilBudgetTambahan(){
		$result = $this->anggaran_m->getAnggaranUsed($_POST);
		$data = [
			'anggaran' => $result,
		]; 
		$this->load->view('transaction/proposal/ajax/modal_budget_tambahan', $data);
	}

	public function prosesBudgeting(){
		$this->budgeting_m->prosesBudgeting($_POST);
	}

	public function get_modal_budget(){
		$budget = $this->budget_m->get_budget_used($_POST);
		$data = [
			'budget' => $budget,
		];
		$this->load->view('transaction/proposal/ajax/modal_budget', $data);
	}

	public function getItemSales(){
		var_dump($_POST);

		$brand = $_POST['code_brand'];
		$tahun = $_POST['tahun'];
		$bulan = $_POST['bulan'];
		$sales_avg = $POST['sales_avg'];
		
		$sql = "asa";
	}

	public function cariCustomer(){
		// var_dump($_POST);
		// die;
		$brand = $_POST['brand'];
		$tahun = $_POST['tahun'];
		$customer = $this->proposal_m->getCustomerSales($brand, $tahun);
		$data = [
			'customer' => $customer,
		]; 
		$this->load->view('transaction/proposal_data/ajax/modal_cari_customer', $data);
	}
	
}