<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kam extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model(['kam_model']);
    }

    public function render($view, array $data = NULL)
    {
        $this->load->view('header');
        $this->load->view($view, $data);
        $this->load->view('footer');
    }

    public function index()
    {
        $this->render('kam_v');
    }

    public function showProposal()
    {
        $proposal = $this->kam_model->getProposalApproved();
        $data = array(
            'proposal' => $proposal
        );
        $this->render('proposal/proposal_data', $data);
    }

    public function detailProposal($number)
    {
        $data = array(
            'number' => $number,
            'proposal' => $this->kam_model->getProposalApproved($number)->row(),
            'item' => $this->kam_model->getItemProposal($number),
            'objective' => $this->kam_model->getObjectiveProposal($number),
            'mechanism' => $this->kam_model->getMechanismProposal($number),
            'comment' => $this->kam_model->getCommentProposal($number),
            'other' => $this->kam_model->getCostingOther($number),
            'group' => $this->kam_model->getProposalGroup($number),
            'customer' => $this->kam_model->getCustomerProposal($number)

        );
        $this->render('proposal/detail_proposal', $data);
    }


    public function changePasswordPage()
    {
        $data = array();
        $this->load->view('settings/changePasswordPage', $data);
    }

    public function changePassword()
    {
        $post = $this->input->post();
        $this->kam_model->changePassword($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal ubah password');
        }
        redirect(base_url($_SESSION['page'] . '/changePasswordPage'));
    }

    public function loadModalInputSKP()
    {
        $number = $this->input->post('number');
        $data = array(
            'number' => $number,
            'group' => $this->kam_model->getProposalGroup($number)
        );
        $this->load->view('proposal/modal_input_skp', $data);
    }
}
