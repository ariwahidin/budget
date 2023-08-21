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
            'customer' => $this->kam_model->getCustomerProposal($number),
            'total_costing' => $this->kam_model->getTotalCostingByNumberProposal($number)

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
        $cek_skp = $this->kam_model->getSKP($number);

        if ($cek_skp->num_rows() > 0) {
            $action = 'update';
        } else {
            $action = 'simpan';
        }

        $data = array(
            'number' => $number,
            'group' => $this->kam_model->getProposalSKP($number),
            'action' => $action
        );
        $this->load->view('proposal/modal_input_skp', $data);
    }

    public function loadImageSkp()
    {
        $id = $this->input->post('id');
        $image = null;
        if ($id != null) {
            $image = 'uploads/img/skp/' . $this->kam_model->getSKPById($id)->row()->Img;
        }

        $data = array(
            'image' => $image
        );

        $this->load->view('proposal/modal_image_skp', $data);
    }

    public function simpanSkp()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $dataArray = json_decode(file_get_contents("php://input"), true);

            // var_dump($dataArray);
            // die;

            if ($dataArray['action'] == 'update') {
                $this->kam_model->update_skp($dataArray);
            } else if ($dataArray['action'] == 'simpan') {
                $this->kam_model->insert_skp($dataArray);
            }

            if ($this->db->affected_rows() > 0) {
                $response = array("status" => "success", "message" => "Data berhasil diterima dan diproses.");
            } else {
                $response = array("status" => "error", "message" => "Gagal simpan data");
            }

            echo json_encode($response);
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo "Metode HTTP tidak diizinkan.";
        }
    }
}
