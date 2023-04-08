<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model('employee_m');
	}

	public function index()
	{
		$data['row'] = $this->employee_m->get();
		$this->template->load('template','employee/employee_data',$data);
	}

	

	public function add()
	{
		$employee = new stdClass();
        $employee->id = null;
		$employee->namakaryawan = null;
		$employee->nik = null;
		$data = array(
			'page' => 'add',
			'row' => $employee,
		);
		$this->template->load('template','employee/employee_form',$data);
	}

	public function edit($id)
	{
		$query = $this->employee_m->get($id);
		if($query->num_rows() > 0)
		{
			$employee = $query->row();
			$employeeCode =  $query->row()->nik;
			$data = array(
				'page' => 'edit',
				'row' => $employee,
				'nik' => $employeeCode
			);
			$this->template->load('template','employee/employee_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('employee')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);

		if(isset($_POST['add']))
		{
			$this->employee_m->add($post);
		}
		else if(isset($_POST['edit']))
		{
			$this->employee_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		echo "<script>window.location='".site_url('employee')."';</script>";
	}

	public function del($id)
	{
		$this->employee_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('employee')."'</script>";

	}
}
