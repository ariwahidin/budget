<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardpo extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model(['customer_m','group_m']);
	}

	public function index()
	{	
		$query2 = $this->db->select('*');
		$query2 = $this->db->from('t_po_sj_dummy');
		$query2 = $this->db->get();

		// amount
		$amount = $this->db->select('*');
		$amount = $this->db->from('t_amount_po_sj_dummy');
		$amount = $this->db->get();

		$data = [
			'po_sj' => $query2,
			'amount' =>$amount,
		];	
		$this->template->load('template','po/dashboardpo_data',$data);
		
	}

	public function LineChart(){
		// po summary
		$summaryPo = $this->db->select('*');
		$summaryPo = $this->db->from('t_po_summary_dummy');
		$summaryPo = $this->db->get();

		$data = [
			'summary' => $summaryPo
		];
		// var_dump($data);	

		$this->load->view('po/line_chart',$data);
	}

	public function BarChart(){
		$query2 = $this->db->select('*');
		$query2 = $this->db->from('t_po_sj_dummy');
		$query2 = $this->db->get();

		$data = [
			'po_sj' => $query2,
		];

		$this->template->load('template','po/bar_chart',$data);
	}
}
