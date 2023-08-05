<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model(['administrator_model']);
    }

    public function index()
    {
        $this->load->view('administrator_v');
    }

    public function showActivity()
    {
        $activity = $this->administrator_model->getActivity();
        $data = array(
            'activity' => $activity,
        );
        $this->load->view('activity/activity_v', $data);
    }

    public function showBrand()
    {
        $brand = $this->administrator_model->getBrand();
        $data = array(
            'brand' => $brand,
        );
        $this->load->view('brand/brand_v', $data);
    }

    public function showGroup()
    {
        $group = $this->administrator_model->getGroup();
        $data = array(
            'group' => $group,
        );
        $this->load->view('group/group_v', $data);
    }

    public function showItem()
    {
        $item = $this->administrator_model->getItem();
        $data = array(
            'item' => $item,
        );
        $this->load->view('item/item_v', $data);
    }

    public function showBudget()
    {
        $budget = $this->administrator_model->getBudget();
        $data = array(
            'budget' => $budget,
        );
        $this->load->view('budget/budget_v', $data);
    }

    public function showCustomer()
    {
        $customer = $this->administrator_model->getCustomer();
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('customer/customer_v', $data);
    }

    public function showPurchase()
    {
        $purchase = $this->administrator_model->getPurchase();
        $data = array(
            'purchase' => $purchase,
        );
        $this->load->view('purchase/purchase_v', $data);
    }

    public function showOperating()
    {
        $operating = $this->administrator_model->getOperating();
        $data = array(
            'operating' => $operating,
        );
        $this->load->view('operating/operating_v', $data);
    }

    public function createProposal()
    {
        $brand = $this->administrator_model->getBrandFromBudgetSetted();
        $activity = $this->administrator_model->getActivityFromBudgetSetted();
        $group = $this->administrator_model->getGroup();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
            'group' => $group,
        );
        $this->load->view('proposal/create_proposal_v', $data);
    }

    public function checkData()
    {
        $post = $_POST;
        $params = array();
        $budget_code = $this->administrator_model->getBudgetCode($post);

        if ($budget_code->num_rows() < 1) {
            $params['budget_code'] = false;
            echo json_encode($params);
            return false;
        }

        $budget_code = $budget_code->row()->BudgetCodeActivity;
        $end_date = $post['end_date'];
        $operating_budget = $this->administrator_model->getYTDOperatingBudget($budget_code, $end_date);
        $params['operating'] = $operating_budget;
        $params['success'] = true;
        $params['budget_code'] = $budget_code;
        echo json_encode($params);
    }

    public function createProposal2()
    {
        $budget_code_activity = $_POST['budget_code'];
        $activity_code = $_POST['activity'];
        $budget_code = preg_match_all('#([^/]*)#', $budget_code_activity, $matches);
        $budget_code = $matches[0][0] . '/' . $matches[0][2];
        $operating = $this->administrator_model->getOperatingActivity($budget_code, $activity_code);
        $YTD_purchase_activity = get_ytd_purchase($operating->row()->BrandCode, $operating->row()->StartPeriode) * ($operating->row()->Precentage / 100);
        $BudgetAllocated = $this->administrator_model->getBudgetAllocatedActivity($budget_code_activity);
        $data = [
            'number' => $this->administrator_model->getNumber(),
            'Allocated_budget' => $BudgetAllocated,
            'YTD_purchase_activity' => $YTD_purchase_activity,
        ];
        $this->load->view('proposal/create_proposal2_v', $data);
    }

    public function showModalItem()
    {
        $brand = $_POST['brand'];
        $item = $this->administrator_model->getItem($brand);
        $data = array(
            'item' => $item,
        );
        $this->load->view('proposal/modal_item', $data);
    }

    public function showModalCustomer()
    {
        $group = $_POST['group'];
        $customer = $this->administrator_model->getCustomer($group);
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('proposal/modal_customer', $data);
    }

    public function simpanProposal()
    {
        // var_dump($_POST);
        // die;
        $this->administrator_model->insertProposal($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
        } else {
            $params = array(
                'success' => false
            );
        }
        echo json_encode($params);
    }

    public function showProposal()
    {
        $proposal = $this->administrator_model->getProposal();
        $data = array(
            'proposal' => $proposal,
        );
        $this->load->view('proposal/data_proposal_v', $data);
    }

    public function showProposalDetail($number)
    {
        $proposal = $this->administrator_model->getProposal($number);
        $proposalItem = $this->administrator_model->getProposalItem($number);
        $proposalCustomer = $this->administrator_model->getProposalCustomer($number);
        $operatingProposal = $this->administrator_model->getOperatingProposal($number);
        $data = array(
            'proposal' => $proposal,
            'proposalItem' => $proposalItem,
            'proposalCustomer' => $proposalCustomer,
            'operatingProposal' => $operatingProposal,
        );
        $this->load->view('proposal/data_proposal_detail_v', $data);
    }

    public function deleteProposal($number)
    {
        $this->administrator_model->deleteProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal hapus";
        }
    }

    public function approveProposal($number)
    {
        $this->administrator_model->approveProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal approved";
        }
    }

    public function cancelProposal($number)
    {
        $this->administrator_model->cancelProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal cancel proposal";
        }
    }

    public function createOperating()
    {
        $brand = $this->administrator_model->getBrand();
        $activity = $this->administrator_model->getActivity();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
        );
        $this->load->view('operating/create_operating_v', $data);
    }

    public function createOperating2()
    {
        $brand = $_POST['brand'];
        $start_month = date('Y-m-d', strtotime($_POST['start_month']));
        $end_month = date('Y-m-d', strtotime($_POST['end_month']));
        $begin = new DateTime($start_month);
        $end = new DateTime($end_month);
        $end = $end->modify('+1 month');
        $interval = new DateInterval('P1M');
        $daterange = new DatePeriod($begin, $interval, $end);
        $periode = array();

        $check = $this->administrator_model->checkOperatingAlreadyExist($brand, $start_month, $end_month);

        foreach ($daterange as $date) {
            array_push($periode, $date->format("Y-m-d"));
        }

        // awal validasi
        if ($check->num_rows() > 0) {
            echo "<script>
                alert('Data sudah ada');
            </script>";
            $this->createOperating();
            return false;
        } else if (count($periode) != 12) {
            echo "<script>
                alert('Periode harus 12 bulan');
            </script>";
            $this->createOperating();
            return false;
        }
        // akhir validasi 


        $data = array(
            'brand' => $_POST['brand'],
            'start_month' => $start_month,
            'end_month' => $end_month,
            'periode' => $periode,
        );
        $this->load->view('operating/create_operating2_v', $data);
    }

    public function simpanOperating()
    {
        // var_dump($_POST);
        // die;
        $this->administrator_model->simpanOperating($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
        } else {
            $params = array(
                'success' => false
            );
        }
        echo json_encode($params);
    }

    public function lihatOperatingActivity($brand, $number)
    {
        $budget_code = $brand . '/' . $number;
        $operating_activity = $this->administrator_model->getOperatingActivity($budget_code);
        $data = array(
            'brand' => $brand,
            'budget_code' => $budget_code,
            'operating_activity' => $operating_activity,
        );
        $this->load->view('operating/operating_activity_v', $data);
    }

    public function lihatOperatingActivityDetail($brand, $number, $activity)
    {
        $budget_code = $brand . '/' . $number . '/' . $activity;
        $operating_activity = $this->administrator_model->getOperatingActivityDetail($budget_code);
        $data = array(
            'operating_activity_detail' => $operating_activity,
        );
        $this->load->view('operating/operating_activity_detail_v', $data);
    }

    public function setOperatingActivity($brand, $number)
    {
        $budget_code = $brand . '/' . $number;
        $operating = $this->administrator_model->getOperating($budget_code);
        $activity = $this->administrator_model->getActivity();
        $data = array(
            'brand' => $brand,
            'operating' => $operating,
            'activity' => $activity,
            'budget_code' => $budget_code,
        );
        $this->load->view('operating/set_operating_activity_v', $data);
    }

    public function showFormActivity()
    {
        // var_dump($_POST);
        $budget_code = $_POST['budget_code'];
        $activity_code = $_POST['activity'];
        $operating = $this->administrator_model->getOperating($budget_code);
        $data = array(
            'budget_code' => $budget_code,
            'operating' => $operating,
            'activity' => $activity_code,
        );
        $this->load->view('operating/add_activity', $data);
    }

    public function simpanOperatingActivity()
    {
        $this->administrator_model->simpanOperatingActivity($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array('success' => true);
        } else {
            $params = array('success' => false);
        }
        echo json_encode($params);
    }

    public function checkAlreadyOperating()
    {
        var_dump($_POST);
    }

    public function showBudgetOperatingPurchase()
    {
        $operating_purchase = $this->administrator_model->getOperatingPurchase();
        $data = array(
            'operating_purchase' => $operating_purchase,
        );
        $this->load->view('operating/operating_purchase_v', $data);
    }

    public function deleteBudget($brand, $numberBudget)
    {
        $budgetCode = $brand . '/' . $numberBudget;
        $sql = "DELETE tb_operating WHERE BudgetCode = '$budgetCode'
            DELETE tb_operating_activity WHERE BudgetCode = '$budgetCode'";
        $query = $this->db->query($sql);


        $cek_ontop_exist = $this->db->query("SELECT * FROM tb_budget_on_top WHERE budget_code = '$budgetCode'")->num_rows();
        if ($cek_ontop_exist > 0) {
            $this->db->query("DELETE tb_budget_on_top WHERE budget_code = '$budgetCode'");
        }
        $cek_ontop_activity_exists = $this->db->query("SELECT * FROM tb_budget_on_top_activity WHERE budget_code = '$budgetCode'")->num_rows();
        if ($cek_ontop_activity_exists > 0) {
            $this->db->query("DELETE tb_budget_on_top_activity WHERE budget_code = '$budgetCode'");
        }

        $tb_operating = $this->db->query("SELECT * FROM tb_operating WHERE BudgetCode = '$budgetCode'")->num_rows();
        $tb_operating_proposal = $this->db->query("SELECT * FROM tb_operating_activity WHERE BudgetCode = '$budgetCode'")->num_rows();
        $tb_budget_on_top = $this->db->query("SELECT * FROM tb_budget_on_top WHERE budget_code = '$budgetCode'")->num_rows();
        $tb_budget_on_top_activity = $this->db->query("SELECT * FROM tb_budget_on_top_activity WHERE budget_code = '$budgetCode'")->num_rows();

        if ($tb_operating < 1 &&  $tb_operating_proposal < 1 && $tb_budget_on_top < 1 && $tb_budget_on_top_activity < 1) {
            redirect(base_url($_SESSION['page'] . '/showBudgetOperatingPurchase'));
        } else {
            echo "Gagal hapus";
        }
    }

    public function picBrand()
    {
        $pic = $this->administrator_model->getPicBrand();
        $brand = $this->administrator_model->getBrand();
        $user = $this->administrator_model->getPic();
        $data = array(
            'user' => $user,
            'brand' => $brand,
            'pic' => $pic
        );
        $this->load->view('brand/pic_brand', $data);
    }

    public function addPicBrand()
    {
        $post = $this->input->post();

        $this->administrator_model->addPicBrand($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal simpan data!');
        }
        redirect(base_url() . $_SESSION['page'] . '/picBrand');
    }

    public function loadMasterUser(){
        $user = $this->administrator_model->getAllUsers();
        $data = array(
            'user' => $user
        );
    }
}
