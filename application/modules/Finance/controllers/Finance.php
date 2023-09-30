<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model(['finance_model']);
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
        $data = array(
            'brand' => $this->finance_model->getBrandProposal(),
            'group' => $this->finance_model->getGroupProposal(),
            'activity' => $this->finance_model->getActivityProposal(),
        );
        $this->render('proposal/proposal_data', $data);
    }

    public function loadTableProposal()
    {
        $params = array();

        if (isset($_POST['brand'])) {
            if (count($_POST['brand']) > 0) {
                $params['brand'] = $_POST['brand'];
            }
        }

        if (isset($_POST['group']) > 0) {
            if (count($_POST['group']) > 0) {
                $params['group'] = $_POST['group'];
            }
        }

        if (isset($_POST['activity']) > 0) {
            if (count($_POST['activity']) > 0) {
                $params['activity'] = $_POST['activity'];
            }
        }

        if (isset($_POST['activity']) > 0) {
            if (count($_POST['activity']) > 0) {
                $params['activity'] = $_POST['activity'];
            }
        }

        if(isset($_POST['start_date'])){
            if($_POST['start_date'] != ''){
                $params['start_date'] = $_POST['start_date'];
            }
        }

        if(isset($_POST['end_date'])){
            if($_POST['end_date'] != ''){
                $params['end_date'] = $_POST['end_date'];
            }
        }

        $proposal = $this->finance_model->getProposalApproved($params);
        $data = array(
            'proposal' => $proposal
        );
        
        $this->load->view('proposal/table_proposal', $data);
    }

    public function detailProposal($number)
    {
        $params['number'] = $number;
        $data = array(
            'number' => $number,
            'proposal' => $this->finance_model->getProposalApproved($params)->row(),
            'item' => $this->finance_model->getItemProposal($number),
            'objective' => $this->finance_model->getObjectiveProposal($number),
            'mechanism' => $this->finance_model->getMechanismProposal($number),
            'comment' => $this->finance_model->getCommentProposal($number),
            'other' => $this->finance_model->getCostingOther($number),
            'group' => $this->finance_model->getProposalGroup($number),
            'customer' => $this->finance_model->getCustomerProposal($number),
            'total_costing' => $this->finance_model->getTotalCostingByNumberProposal($number)

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
        $this->finance_model->changePassword($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal ubah password');
        }
        redirect(base_url($_SESSION['page'] . '/changePasswordPage'));
    }


    public function tambahskpb()
    {
        $number = $this->input->post('number');
        $cek_skp = $this->finance_model->getSKP($number);

        if ($cek_skp->num_rows() > 0) {
            $action = 'update';
        } else {
            $action = 'simpan';
        }

        $data = array(
            'number' => $number,
            'group' => $this->finance_model->getProposalSKP($number),
            'action' => $action
        );
        $this->load->view('proposal/tambahskpb', $data);
    }

    public function loadImageSkp()
    {
        $id = $this->input->post('id');
        $image = null;
        if ($id != null) {
            $image = 'uploads/img/skp/' . $this->finance_model->getSKPById($id)->row()->Img;
        }

        $data = array(
            'image' => $image
        );

        $this->load->view('proposal/modal_image_skp', $data);
    }

    public function loadModalInputSKP()
    {
        $number = $this->input->post('number');
        $cek_skp = $this->finance_model->getSKP($number);

        if ($cek_skp->num_rows() > 0) {
            $action = 'update';
        } else {
            $action = 'simpan';
        }

        $data = array(
            'number' => $number,
            'group' => $this->finance_model->getProposalSKP($number),
            'action' => $action
        );
        $this->load->view('proposal/modal_input_skp', $data);
    }

    public function simpanSkp()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $dataArray = json_decode(file_get_contents("php://input"), true);

            if ($dataArray['action'] == 'update') {
                $this->finance_model->update_skp($dataArray);
            } else if ($dataArray['action'] == 'simpan') {
                $this->finance_model->insert_skp($dataArray);
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

    public function simpanskpb()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $dataArray = json_decode(file_get_contents("php://input"), true);
            if ($dataArray['action'] == 'update') {
                $this->finance_model->update_skp($dataArray);
            } else if ($dataArray['action'] == 'simpan') {
                $this->finance_model->insert_skp($dataArray);
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

    public function showSkp()
    {
        $data = array(
            'skp' => $this->finance_model->getDataSkp()
        );
        $this->render('proposal/data_skp', $data);
    }

    public function loadCustomerBySkp()
    {
        $skp = $this->input->post('skp');
        $data = array(
            'customer' => $this->finance_model->getCustomerBySkp($skp)
        );
        $this->load->view('proposal/modal_customer_by_skp', $data);
    }
}
