<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model('budget_m');
	}

	public function index()
	{
		$data['row'] = $this->budget_m->get();
		$this->template->load('template','budget/budget_data',$data);
	}

	public function add()
	{
		$budget = new stdClass();
        $budget->id = null;
		$budget->budget_name = null;
		$data = array(
			'page' => 'add',
			'row' => $budget,
		);
		$this->template->load('template','budget/budget_form',$data);
	}

	public function edit($id)
	{
		$query = $this->budget_m->get($id);
		if($query->num_rows() > 0)
		{
			$budget = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $budget,
			);
			$this->template->load('template','budget/budget_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('budget')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);

		if(isset($_POST['add']))
		{
			$this->budget_m->add($post);
		}
		else if(isset($_POST['edit']))
		{
			$this->budget_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		echo "<script>window.location='".site_url('budget')."';</script>";
	}

	public function del($id)
	{
		$this->budget_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('budget')."'</script>";

	}
}
