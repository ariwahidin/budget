<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model('brand_m');
	}

	public function index()
	{
		$data['row'] = $this->brand_m->get();
		$this->template->load('template','brand/brand_data',$data);
	}

	

	public function add()
	{
		$this->db->select('MAX(BrandCode) AS BrandCode');
		$this->db->from('m_brand');
		$BrandCode = $this->db->get()->row()->BrandCode;
		$BrandCode = $BrandCode + 1;
		$brand = new stdClass();
        $brand->id = null;
		$brand->BrandName = null;
		$data = array(
			'page' => 'add',
			'row' => $brand,
			'brand_code' => $BrandCode
		);
		$this->template->load('template','brand/brand_form',$data);
	}

	public function edit($id)
	{
		$query = $this->brand_m->get($id);
		if($query->num_rows() > 0)
		{
			$brand = $query->row();
			$BrandCode =  $query->row()->BrandCode;
			$data = array(
				'page' => 'edit',
				'row' => $brand,
				'brand_code' => $BrandCode
			);
			$this->template->load('template','brand/brand_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('brand')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);

		if(isset($_POST['add']))
		{
			$this->brand_m->add($post);
		}
		else if(isset($_POST['edit']))
		{
			$this->brand_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		echo "<script>window.location='".site_url('brand')."';</script>";
	}

	public function del($id)
	{
		$this->brand_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('brand')."'</script>";

	}
}
