<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('promotion_m');
	}

	public function index()
	{
		$data['row'] = $this->promotion_m->get()->result();
		$this->template->load('template','promotion/promotion_data',$data);
	}
	
	public function add()
	{
		$promotion = new stdClass();
	    $promotion->id = null;
		$promotion->promo_name = null;
		$data = array(
			'page' => 'add',
			'row' => $promotion
		);
		$this->template->load('template','promotion/promotion_form',$data);
	}

	public function edit($id)
	{
		$query = $this->promotion_m->get($id);
		if($query->num_rows() > 0)
		{
			$promotion = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $promotion
			);
			$this->template->load('template','promotion/promotion_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('promotion')."';
			</script>";
		}
	}
	
	public function process()
	{
		$post = $this->input->post(null, TRUE);

		if(isset($_POST['add']))
		{
			$this->promotion_m->add($post);
		}else if(isset($_POST['edit']))
		{
			$this->promotion_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		echo "<script>window.location='".site_url('promotion')."';</script>";
	}

	public function del($id)
	{
		$this->promotion_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('promotion')."'</script>";

	}


	// public function get_selected_promo()
    // {
		//     $this->db->select('type_promotion.name as promotion_name, t_promo_selected.document_id as doc_id');
		// 	$this->db->from('type_promotion');
		// 	$this->db->join('t_promo_selected', 'type_promotion.sid = t_promo_selected.promo_id');
		// 	$this->db->where('document_id', 'MP2206030018');
	// 	$query = $this->db->get()->result();
	// 	foreach($query as $q => $data){
	// 		echo $data->promotion_name."<br>";
	// 	}
    // }





    // public function select_promo()
    // {
    //     $post = $this->input->post(null, TRUE);
    //     $this->promotion_m->add_selected_promo($post);

    //     if($this->db->affected_rows() > 0){
	// 		$params = array("success" => true);
	// 	} else {
	// 		$params = array("success" => false);
	// 	}
	// 	echo json_encode($params);
    // }


    // public function promo_data(){
	// 	$promo = $this->promotion_m->get_promo_selected();
	// 	$data['promo_selected'] = $promo;
	// 	$this->load->view('transaction/sale/promo_data',$data);
	// }


    // public function promo_selected_del()
	// {
		
    //     $promo_id = $this->input->post('promo_id');
    //     $this->promotion_m->del_promo_selected($promo_id);
		

	// 	if($this->db->affected_rows() > 0){
	// 		$params = array("success" => true);
	// 	} else {
	// 		$params = array("success" => false);
	// 	}
	// 	echo json_encode($params);
	// }


}
