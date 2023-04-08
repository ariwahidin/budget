<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposalData extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['laporan_m','brand_m','promotion_m']);
	}

    public function index(){
        $brand = $this->brand_m->get();
        $activity = $this->promotion_m->get();
        $data = [
            'brand' => $brand,
            'activity' => $activity,
        ];
		$this->template->load('template','transaction/proposal_data/proposal_data', $data);
    }

    public function getTransaksi($no_doc = null, $brand = null){
        if($no_doc == 'null'){
            $no_doc = null;
        }
        if($no_doc != null){
            $transaksi = $this->laporan_m->getTransaksi($no_doc);
        }else if($brand != null){
            $transaksi = $this->laporan_m->getTransaksi(null, $brand);
        }else{
            $transaksi = $this->laporan_m->getTransaksi();
        }
        $data = [
            'transaksi' => $transaksi,
        ];
        $this->load->view('transaction/proposal_data/ajax/ajax_proposal_data',$data);
    }

    public function getTransactionDetail($no_doc){
        $transaksi = $this->laporan_m->getTransaksi($no_doc)->row();
        $customer = $this->laporan_m->getCustomer($no_doc);
        $objective = $this->laporan_m->getObjective($no_doc);
        $mechanism = $this->laporan_m->getMechanism($no_doc);
        $detail = $this->laporan_m->getTransactionDetail($no_doc)->result();
        $totalTarget = $this->laporan_m->getTotalTarget($no_doc)->row();
        $totalCosting = $this->laporan_m->getTotalCosting($no_doc)->row();
        $data = [
            'transaksi' => $transaksi,
            'customer' => $customer,
            'objective' => $objective,
            'mechanism' => $mechanism,
            'detail' => $detail,
            'totalTarget' => $totalTarget,
            'totalCosting' => $totalCosting,
        ];
        $this->template->load('template','transaction/proposal_data/proposal_lihat', $data);
    }

    public function cetakProposalDetail($no_doc){
        $transaksi = $this->laporan_m->getTransaksi($no_doc)->row();
        $customer = $this->laporan_m->getCustomer($no_doc);
        $objective = $this->laporan_m->getObjective($no_doc);
        $mechanism = $this->laporan_m->getMechanism($no_doc);
        $detail = $this->laporan_m->getTransactionDetail($no_doc)->result();
        $totalTarget = $this->laporan_m->getTotalTarget($no_doc)->row();
        $totalCosting = $this->laporan_m->getTotalCosting($no_doc)->row();
        // var_dump($detail);
        // die;
        $data = [
            'transaksi' => $transaksi,
            'customer' => $customer,
            'objective' => $objective,
            'mechanism' => $mechanism,
            'detail' => $detail,
            'totalTarget' => $totalTarget,
            'totalCosting' => $totalCosting,
        ];
        $this->load->view('transaction/proposal_data/cetak_proposal_data_detail', $data);
    }

    public function hapusProposal($no_doc){
        $this->laporan_m->hapusProposal($no_doc);
    }

}
