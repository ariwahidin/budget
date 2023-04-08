<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		check_not_login();
        $this->load->model(['sale_m','promotion_m','brand_m','product_m','outlet_m']);
		
	}

    public function index()
	{

		$this->load->model(['customer_m','item_m','promotion_m']);
		$customer = $this->customer_m->get()->result();
		$item = $this->item_m->get()->result();
		$promotion = $this->promotion_m->get()->result();
		$cart = $this->sale_m->get_cart();
		$brand = $this->brand_m->get();
		$product = $this->product_m->get();
		$claim = $this->sale_m->get_claim();
		// var_dump($product->result());
		// die;
		// $product = $this->product_m->get_product_by_brand();
		$outlet = $this->sale_m->get_outlet_selected();
		
		// var_dump($promotion->result());
		// die;

		

		$data = array(
			'customer' => $customer,
			'item' => $item,
			'promo'=> $promotion,
			'cart' => $cart,
			'invoice' => $this->sale_m->invoice_no(),
			'brand' => $brand,
			'product'=>$product,
			'outlet' => $outlet,
			'claim' => $claim
		);
		$this->template->load('template','transaction/sale/sale_form',$data);
	}

	public function getProduct($id){
		
		$id_brand = $this->input->post('id_brand');
		$product = $this->product_m->get_product_by_brand($id);
		$data = array(
			'product' => $product,
		);
		$this->load->view('transaction/sale/modal_pilih_product',$data);
	
	}

	public function process()
	{
		$data = $this->input->post(null, TRUE);

		if(isset($_POST['add_cart'])){


			foreach($data['isi_product']  as $id){
			 $isi_data = $this->product_m->get($id)->result();			 
				foreach($isi_data as $i){
					$post = array(
						'item_id' => $i->id_product,
						'user_id' => $this->session->userdata('user_id')
					);
					$check = $this->sale_m->get_cart();
					foreach($check->result() as $r){

						$id_product_cart = $r->item_id;
						$id_product_post = $post['item_id'];
						// var_dump($id_product_cart);
						// var_dump($id_product_post);
						if($id_product_cart == $id_product_post ){
							// var_dump("ada yang sama");
							$row = $this->product_m->get($id_product_post)->row()->product_name;
							echo json_encode(array("data_sama" => true, "product" => $row));
							die; // Program berhenti disini bila ada id product yang sama
						}
					}
				}
			}

			foreach($data['isi_product'] as $id){
				$product = $this->product_m->get($id)->result();
					foreach($product as $p){
						$data = array(
							'product_id' => $p->id_product,
							'price' => $p->price
						);
						$this->sale_m->add_cart($data);
					}
			}

			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}


		if(isset($_POST['edit_cart'])){

			$this->sale_m->edit_cart($data);

				if($this->db->affected_rows() > 0){
					$params = array("success" => true);
				} else {
					$params = array("success" => false);
				}
				echo json_encode($params);			
		}

		if(isset($_POST['pilih_outlet'])){

			$check = $this->sale_m->get_outlet_selected(['id_outlet' => $data['outlet_id']])->num_rows();
			// var_dump($check);
			if($check > 0){

			}else{				
				$this->sale_m->pilih_outlet($data);
			}

			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);

		}
		
		if(isset($_POST['process_payment'])){

			$post = $this->input->post();
			$invoice = $this->sale_m->invoice_no();
			$sale_id = $this->sale_m->add_sale($post);

			//Start fungsi simpan promo
			$promo = $post['typePromo'];
			// foreach($promo as $p){
				$params = array(
					'no_doc' => $invoice,
					'id_promo' => $promo,
					'created_by' => $this->session->userdata('user_id')
				);
				$this->db->insert('t_promo_end', $params);
				// var_dump($params);
				// die;
			// }
			//End fungsi simpan promo
			
			//Simpan mechanism
			$mechanism = $this->sale_m->add_mechanism($post['mechanism'],$no_doc = $invoice);
			//Simpan objective
			$objective = $this->sale_m->add_objective($post['objective'],$no_doc = $invoice);
			// Simpan comment
			$comment = $this->sale_m->add_comment($post,$no_doc = $invoice);
			
			//Start fungsi simpan outlet			
			$outlet = $this->sale_m->get_outlet_selected()->result();
			foreach($outlet as $o){
				$ot = $o->id_outlet;
				$params = array(
					'no_doc' => $invoice,
					'id_outlet' => $ot,
					'created_by' => $this->session->userdata('user_id')
				);
				$this->db->insert('t_outlet_end',$params);
			}
			//End fungsi simpan outlet

			//Start fungsi simpan detail transaction
				$item = $this->sale_m->get_cart()->result();
				foreach($item as $i){
					$params = array(
						'no_doc' => $invoice,
						'product_id' => $i->item_id,
						'product_price' => $i->price,
						'last_year' => $i->qty_last_year,
						'last_3_month' => $i->qty_last_3_month,
						'multiple_estimation' => $i->multiple_estimation,
						'estimation' => $i->qty_sales_estimation,
						'value_target_item' => $i->actual_value_estimation,
						'discount' => $i->discount_promo,
						'value_discount' => $i->value_discount,
						'value_costing_item' => $i->total_costing,
						'created_by' => $i->user_id,
					);
					$this->db->insert('t_transaction_detail_end',$params);
				}				
			//End fungsi simpan detail transaction
			// die;

			$this->sale_m->del_cart(['user_id' => $this->session->userdata('user_id')]);
			$this->sale_m->del_outlet(['user_id' => $this->session->userdata('user_id')]);

			if($this->db->affected_rows() > 0){
				$params = array("success" => true,"sale_id" => $sale_id);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);






			

			




			die;

			$p =[];
			foreach($post['typePromo'] as $i => $promo){
				array_push($p,array(
					'sale_id' => $sale_id,
					'promo_id' => $promo
				));
			}

			var_dump($p);
			die;
			$this->promotion_m->addPromoSelected($p);








			// $cart = $this->sale_m->get_cart()->result();
			// $promo = $this->promotion_m->addPromoSelected($data);
			// $row = [];

			// foreach($cart as $c => $value){
			// 	array_push($row,array(
			// 		'sale_id' => $sale_id,
			// 		'item_id' => $value->item_id,
			// 		'price' => $value->price,
			// 		'qty' => $value->qty,
			// 		'discount_item' => $value->discount_item,
			// 		'total' => $value->total
			// 	));
			// }

			// var_dump($row);

			// $this->sale_m->add_sale_detail($row);
			// $this->sale_m->del_cart(['user_id' => $this->session->userdata('user_id')]);

			// if($this->db->affected_rows() > 0){
			// 	$params = array("success" => true,"sale_id" => $sale_id);
			// } else {
			// 	$params = array("success" => false);
			// }
			// echo json_encode($params);
		}

		if(isset($_POST['edit_promo_costing'])){

			$this->sale_m->edit_promo($data);

			if($this->db->affected_rows() > 0){
				$params = array("success" => true);
			} else {
				$params = array("success" => false);
			}
			echo json_encode($params);
		}

		
	}

	function outlet_selected_data(){
		$outlet = $this->sale_m->get_outlet_selected();
		$data['outlet'] = $outlet;
		$this->load->view('transaction/sale/outlet_data',$data);
	}

	public function outlet_del()
	{
		$post = $this->input->post();

		if(isset($_POST['cancel_payment'])){
			$this->sale_m->del_outlet(['user_id' => $this->session->userdata('user_id')]);
		}else{
			$outlet_id = $this->input->post('outlet_id');
			$this->sale_m->del_outlet(['id_outlet' => $outlet_id]);
		}

		if($this->db->affected_rows() > 0){
			$params = array("success" => true);
		} else {
			$params = array("success" => false);
		}
		echo json_encode($params);
	}



	function target_data(){
		$cart = $this->sale_m->get_cart();
		$data['cart'] = $cart;
		$this->load->view('transaction/sale/target_data',$data);
	}
	
	function costing_data(){
		$cart = $this->sale_m->get_cart();
		$data['cart'] = $cart;
		$this->load->view('transaction/sale/costing_data',$data);
	}

	public function cart_del()
	{
		if(isset($_POST['cancel_payment'])){
			$this->sale_m->del_cart(['user_id' => $this->session->userdata('user_id')]);
		}else{
			$cart_id = $this->input->post('cart_id');
			$this->sale_m->del_cart(['cart_id' => $cart_id]);
		}

		if($this->db->affected_rows() > 0){
			$params = array("success" => true);
		} else {
			$params = array("success" => false);
		}
		echo json_encode($params);
	}

	public function cetak($id){

		$data = array(
			'sale' => $this->sale_m->get_sale($id)->row(),
			'sale_detail' => $this->sale_m->get_sale_detail($id)->result(),
		);

		$this->load->view('transaction/sale/receipt_print',$data);
	}

	public function del($id)
	{
		$this->sale_m->del_sale($id);

		if($this->db->affected_rows() > 0){
			echo "<script>alert('Data penjualan berhasil dihapus');
			window.location='".site_url('report/sale')."'</script>";
		} else {
			echo "<script>alert('Data penjualan gagal dihapus');
			window.location='".site_url('report/sale')."'
			</script>";
		}
	}
}