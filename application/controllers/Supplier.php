<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model('supplier_m');
	}

	public function index()
	{
		$data['row'] = $this->supplier_m->get();
		$this->template->load('template','supplier/supplier_data',$data);
	}

	public function add()
	{

		$supplier = new stdClass();
		$supplier->sid = null;
		$supplier->supplier_code = null;
		$supplier->supplier_name = null;
		$supplier->telephone = null;
		$supplier->address_1 = null;
		$supplier->address_2 = null;
		$supplier->npwp = null;
		$supplier->email = null;
		$supplier->telephone_1 = null;
		$supplier->term = null;
		$data = array(
			'page' => 'add',
			'row' => $supplier
		);
		$this->template->load('template','supplier/supplier_form',$data);
	}

	public function edit($id)
	{
		$query = $this->supplier_m->get($id);
		if($query->num_rows() > 0)
		{
			$supplier = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $supplier
			);
			$this->template->load('template','supplier/supplier_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('supplier')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add']))
		{
			// if($this->item_m->check_supplier_code($post['supplier_code'])->num_rows() > 0)
            // {
            //     $this->session->set_flashdata('error',"Kode suplier $post[item_barcode] sudah dipakai, ganti yang lain");
            //     redirect('supplier/supplier_form');
            // }

			$this->supplier_m->add($post);
		}else if(isset($_POST['edit']))
		{
			$this->supplier_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
			echo "<script>window.location='".site_url('supplier')."';</script>";
	}

	public function del($id)
	{
		$this->supplier_m->del($id);
		$error = $this->db->error();

		if($error['code'] != 0 )
		{
			echo "<script>alert('Data tidak dapat dihapus (sudah berelasi)');</script>";
		}
		else
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('supplier')."'</script>";

	}
}
