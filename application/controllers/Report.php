<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model(['sale_m','promotion_m']);
	}

	public function sale()
	{
		// $test = $this->sale_m->get_sale()->result();
		// var_dump($test);
		// die;

		// $this->load->model('customer_m');
		// $this->load->library('pagination');
		
		// if(isset($_POST['reset'])){
		// 	$this->session->unset_userdata('search');
		// }
		
		// if(isset($_POST['filter'])){
		// 	$post = $this->input->post(null, TRUE);
		// 	$this->session->set_userdata('search', $post);
		// }else{
		// 	$post = $this->session->userdata('search');
		// }

		
		// $config['base_url'] = site_url('report/sale');
		// $config['total_rows'] = $this->sale_m->get_sale_pagination()->num_rows();
		// $config['per_page'] = 5;
		// $config['uri_segment'] = 3;
		// $config['first_link'] = 'First';
		// $config['last_link'] = 'Last';
		// $config['next_link'] = 'Next';
		// $config['prev_link'] = 'Prev';
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
		// $config['cur_tag_open'] = '<li class="active"><a>';
		// $config['cur_tag_close'] = '</a></li>';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';
		// $config['prev_tag_open'] = '<li>';
		// $config['prev_tag_close'] = '</li>';
		// $config['first_tag_open'] = '<li>';
		// $config['first_tag_close'] = '</li>';
		// $config['last_tag_open'] = '<li>';
		// $config['last_tag_close'] = '</li>';

		// $this->pagination->initialize($config);

		// $data['pagination'] = $this->pagination->create_links();
		// $data['customer'] = $this->customer_m->get()->result();
		// $data['row'] = $this->sale_m->get_sale_pagination($config['per_page'],$this->uri->segment(3));
		// $data['post'] = $post;
		$data['hasil'] = $this->sale_m->get_sale();
		$this->template->load('template','report/sale_report',$data);
	}

    // public function sale_product($sale_id = null)
    // {
    //     $detail = $this->sale_m->get_sale_detail($sale_id)->result();
    //     echo json_encode($detail);
    // }

	public function lihat_report($id){
		$detail = $this->sale_m->get_sale($id)->row();
		$no_doc = $detail->invoice;
		$outlet = $this->sale_m->get_proposal_detail_outlet($no_doc)->result();
		$promo = $this->sale_m->get_proposal_detail_promo($no_doc)->result();
		$target = $this->sale_m->get_proposal_detail_item($no_doc)->result();
		$mechanism = $this->sale_m->get_mechanism($no_doc)->result();
		$objective = $this->sale_m->get_objective($no_doc)->result();
		$comment = $this->sale_m->get_comment($no_doc)->row();
		$data = array(
			'detail' => $detail,
			'outlet' => $outlet,
			'promo' => $promo,
			'target' => $target,
			'mechanism' => $mechanism,
			'objective' => $objective,
			'comment' => $comment, 
		);
		$this->template->load('template','report/detail_report',$data);
	}

	public function cetak($id){
		
		// ob_start();
		$detail = $this->sale_m->get_sale($id)->row();
		$no_doc = $detail->invoice;
		$outlet = $this->sale_m->get_proposal_detail_outlet($no_doc)->result();
		$promo = $this->sale_m->get_proposal_detail_promo($no_doc)->result();
		$target = $this->sale_m->get_proposal_detail_item($no_doc)->result();
		$mechanism = $this->sale_m->get_mechanism($no_doc)->result();
		$objective = $this->sale_m->get_objective($no_doc)->result();
		$comment = $this->sale_m->get_comment($no_doc)->row();
		$data = array(
			'detail' => $detail,
			'outlet' => $outlet,
			'promo' => $promo,
			'target' => $target,
			'mechanism' => $mechanism,
			'objective' => $objective,
			'comment' => $comment, 
		);
		$this->load->view('report/cetak_print.php',$data);

		// $html = ob_get_contents();
        // ob_end_clean();
        
		// require $_SERVER['DOCUMENT_ROOT'].'/anp/assets/html2pdf/autoload.php';
		
		// $pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
		// $pdf->WriteHTML($html);
		// $pdf->Output('proposal_promosi'.date('YmdHis').'.pdf', 'D');
	}

}
