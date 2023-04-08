<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model('group_m');
	}

	public function index()
	{
		$data['row'] = $this->group_m->get();
		$this->template->load('template','group_store/group_store_data',$data);
	}

	public function add()
	{
		$this->db->select('MAX(GroupCode) as GroupCodeMax');
		$this->db->from('m_group');
		$MaxGroupCode = $this->db->get()->row();
		$group_store = new stdClass();
		$group_store->id = null;
		$group_store->GroupName = null;
		$data = array(
			'page' => 'add',
			'row' => $group_store,
			'GroupCode' => $MaxGroupCode->GroupCodeMax + 1,
		);
		$this->template->load('template','group_store/group_store_form',$data);
	}

	public function edit($id)
	{
		$query = $this->group_m->get($id);
		if($query->num_rows() > 0)
		{
			$group_store = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $group_store,
				'GroupCode' => $group_store->GroupCode
			);
			$this->template->load('template','group_store/group_store_form',$data);
		}
		else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('group_store')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add']))
		{
			$this->group_m->add($post);
		}
		else if(isset($_POST['edit']))
		{
			$this->group_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		echo "<script>window.location='".site_url('group')."';</script>";
	}

	public function del($id)
	{
		$this->group_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('group')."'</script>";

	}
}
