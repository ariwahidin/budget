<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['product_m','brand_m']);
	}

	public function index()
	{
		$data['row'] = $this->product_m->get()->result();
		$this->template->load('template','produk/product_data',$data);
	}


	public function add()
	{
		$product = new stdClass();
		$product->BrandCode = null;
		$product->Barcode = null;
		$product->ItemId = null;
		$product->ItemName = null;
		$product->BrandName = null;
		$data = array(
			'page' => 'add',
			'row' => $product,
			'brand' => $this->brand_m->get(),
		);
		$this->template->load('template','produk/product_form',$data);
	}



	public function edit($id)
	{
		$query = $this->product_m->get($id);
		if($query->num_rows() > 0)
		{
			$product = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $product,
				'brand' => $this->brand_m->get()
			);
			
			$this->template->load('template','produk/product_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('product')."';
			</script>";
		}
	}



	public function process()
	{
		$post = $this->input->post(null, TRUE);
		
		if(isset($post['add_product']))
		{
			$this->product_m->add($post);
			
			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}
		
		
		if(isset($post['edit_product']))
		{
			$this->product_m->edit($post);

			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}
		
	}

	public function del($id)
	{
		$this->product_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('product')."'</script>";

	}

	public function refreshItem(){
		$refresh = $this->product_m->refreshItem_m();
		if($refresh == true){
			echo "<script>alert('Data Item Sudah di Update');</script>";
		}
		echo "<script>window.location='".site_url('product')."'</script>";
	}
}
