<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pic extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model(['pic_model']);
    }

    public function index()
    {
        redirect(base_url($_SESSION['page']) . '/showProposal');
    }

    public function showActivity()
    {
        $activity = $this->pic_model->getActivity();
        $data = array(
            'activity' => $activity,
        );
        $this->load->view('activity/activity_v', $data);
    }

    public function showBrand()
    {
        $this->load->view('brand/brand_v');
    }

    public function getListBrand()
    {
        $data = array();
        $brand = $this->pic_model->getRows($_POST);
        $i = $_POST['start'];

        foreach ($brand as $member_brand) {
            $i++;
            $data[] = array(
                $i,
                $member_brand->BrandCode,
                $member_brand->BrandName,
            );
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->pic_model->countAll(),
            'recordsFiltered' => $this->pic_model->countFiltered($_POST),
            'data' => $data,
        );

        echo json_encode($output);
    }

    public function getListCustomer()
    {
        $data = array();
        $customer = $this->pic_model->getRowsCustomer($_POST);
        $i = $_POST['start'];

        foreach ($customer as $member_customer) {
            $i++;
            $data[] = array(
                $i,
                $member_customer->CardCode,
                $member_customer->GroupName,
                $member_customer->CustomerName,
                $member_customer->GroupCode,
            );
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->pic_model->countAllCustomer(),
            'recordsFiltered' => $this->pic_model->countFilteredCustomer($_POST),
            'data' => $data,
        );

        echo json_encode($output);
    }




    public function showGroup()
    {
        $group = $this->pic_model->getGroup();
        $data = array(
            'group' => $group,
        );
        $this->load->view('group/group_v', $data);
    }

    public function showItem()
    {
        $item = $this->pic_model->getItem();
        $data = array(
            'item' => $item,
        );
        $this->load->view('item/item_v', $data);
    }

    public function showBudget()
    {
        $budget = $this->pic_model->getBudget();
        $data = array(
            'budget' => $budget,
        );
        $this->load->view('budget/budget_v', $data);
    }

    public function showCustomer()
    {
        $customer = $this->pic_model->getCustomer();
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('customer/customer_v', $data);
    }

    public function showPurchase()
    {
        $purchase = $this->pic_model->getPurchase();
        $data = array(
            'purchase' => $purchase,
        );
        $this->load->view('purchase/purchase_v', $data);
    }

    public function showOperating()
    {
        $params['user_code'] = $_SESSION['user_code'];
        $operating = $this->pic_model->getOperating($params);
        $data = array(
            'operating' => $operating,
        );
        $this->load->view('operating/operating_v', $data);
    }

    public function createProposal()
    {
        // $brand = $this->pic_model->getBrandFromBudgetSetted();
        $brand = $this->pic_model->getBrandPic($_SESSION['user_code']);
        $activity = $this->pic_model->getActivityFromBudgetSetted();
        $group = $this->pic_model->getGroup();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
            'group' => $group,
        );
        $this->load->view('proposal/create_proposal_v', $data);
    }

    public function show_create_form()
    {
        // var_dump($_POST);
        // die;
        // $prefix = $this->pic_model->getPrefix();
        $noref = substr($this->pic_model->getNumber(), -8);
        $brand = $this->pic_model->getBrandPic($_SESSION['user_code']);
        $activity = $this->pic_model->getActivityFromBudgetSeteed();
        $group = $this->pic_model->getGroupMaster();
        $data = array(
            'noref' => $noref,
            'brand' => $brand,
            'activity' => $activity,
            'group' => $group,
        );
        $this->load->view('proposal/create_form_v', $data);
    }

    public function show_form_proposal_from_sales()
    {
        // var_dump($_POST);
        // die;

        $json_group = $_POST['json_group'];
        $array_group = json_decode($json_group, true);

        $json_customer = $_POST['json_customer'];
        $array_customer = json_decode($json_customer, true);

        $customer = $this->pic_model->getCustomerByCardCode($array_customer);
        $delete_cart = $this->pic_model->delete_cart_item();

        if ($_POST['budget_source'] == 'on_top') {
            $budget_source = $_POST['budget_source'];
        } else if ($_POST['budget_source'] == 'anp') {
            $budget_source = empty($_POST['ims']) ? 'operating' : 'ims';
        }

        $noref = substr($this->pic_model->getNumber(), -8);
        $group_customer = array_values(array_unique($array_group));
        $group_customer = implode(",", $group_customer);
        $group_customer = $this->pic_model->getGroupCustomer($group_customer);

        $data = [
            'group_customer' => $group_customer,
            'no_doc' => $_POST['brand'] . '/' . $noref,
            'number' => $this->pic_model->getNumber(),
            'budget_code_activity' => $_POST['budget_code_activity'],
            'budget_type' => $budget_source,
            'item_cart' => $this->pic_model->get_item_cart(),
            'customer' => $customer,
        ];

        $this->load->view('proposal/form_proposal_from_sales_v_rev', $data);
    }

    public function cekNoDoc()
    {
        // var_dump($_POST);
        $post = $this->input->post();
        $noDoc = $post['no_doc'];
        $result = $this->pic_model->getNoDoc($noDoc);
        $response = array();

        if ($result->num_rows() > 0) {
            $response = array(
                'success' => true
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }

    public function set_cart_item()
    {
        $salesByGroup = $this->pic_model->set_cart_item($_POST);
        $data = array(
            'sales_detail' => $salesByGroup
        );
        $this->load->view('proposal/table_sales_by_group', $data);
    }

    public function get_cart_item()
    {
        $item_cart = $this->pic_model->get_item_cart();
        $data = array(
            'item_cart' => $item_cart
        );
        $this->load->view('proposal/table_cart_item_detail', $data);
    }

    public function get_budget()
    {
        $balance = 0;
        if (!empty($_POST['budget_source'])) {
            if ($_POST['budget_source'] == 'anp') {

                if ($this->pic_model->getBudgetCode($_POST)->num_rows() < 1) {
                    echo json_encode(['budget' => 'not_set']);
                    return false;
                }

                //From Operating
                $budget_code = $this->pic_model->getBudgetCode($_POST)->row()->BudgetCode;
                $budget_code_activity = $budget_code . '/' . $_POST['activity'];
                $budget_activity = $this->pic_model->getBudgetActivity($budget_code_activity, $_POST['end_date']);
                $budget_allocated = $this->pic_model->getBudgetAllocated($budget_code)->row()->budget_total_allocated;
                $budget_used = $this->pic_model->getBudgetUsed($budget_code);
                $budgetActivity_vs_Operating = $this->pic_model->getBudgetActivityVsOperating($budget_code_activity)->row()->activity_vs_operating;
                $actual_budget = $this->pic_model->getYtdBudgetActualActivity($_POST['brand'], $budget_code, $budget_code_activity, $_POST['end_date']);
                $total_budget_activity = $this->pic_model->getBudgetActivityVsOperating($budget_code_activity)->row()->TotalBudgetActivity;
                $total_operating = $this->pic_model->getBudgetActivityVsOperating($budget_code_activity)->row()->OperatingBudget;
                $budget_booked = $this->pic_model->getBudgetBooked($budget_code_activity);
                $ims_value = 0;
                $is_ims = $this->db->query("SELECT DISTINCT is_ims FROM tb_operating WHERE BudgetCode = '$budget_code'")->row()->is_ims;

                $operatingBudget = $this->pic_model->getOperatingBudget($budget_code)->row()->BudgetOperating;

                if ($is_ims == 'Y') {
                    $ims_value = $this->pic_model->get_ytd_ims($_POST['brand'], $budget_code, $_POST['end_date']);
                    $ims_used = $this->pic_model->getImsUsed($budget_code);
                    $ims_value = ((float)$ims_value * (float)$budgetActivity_vs_Operating)  - (float)$ims_used;
                }

                $balance = $operatingBudget - $budget_used;
                $data = array(
                    'budget' => 'ready',
                    'balance' => $balance,
                    'budget_code' => $budget_code,
                    'budget_code_activity' => $budget_code_activity,
                    'budget_allocated' => $budget_allocated - $budget_booked,
                    'budget_booked' => $budget_booked,
                    'actual_budget' => $actual_budget,
                    'budget_activity' => $budget_activity,
                    'total_budget_activity' => $total_budget_activity,
                    'total_operating' => $total_operating,
                    'ims_value' => $ims_value,
                    'operatingBudget' => $operatingBudget,
                    'budget_used' => $budget_used,
                );

                echo json_encode($data);
            }

            if ($_POST['budget_source'] == 'on_top') {


                $budgetCode = $this->pic_model->getBudgetCode($_POST);

                if ($budgetCode->num_rows() < 1) {
                    echo json_encode(['budget' => 'not_set']);
                    return false;
                }

                $budgetOnTop = $this->pic_model->getBudgetOnTop($budgetCode->row()->BudgetCode);
                if ($budgetOnTop->num_rows() < 1) {
                    echo json_encode(['budget_on_top' => 'not_set']);
                    return false;
                }

                $budget_code = $budgetCode->row()->BudgetCode;
                $total_on_top = $this->pic_model->getTotalOnTop($budget_code);
                $total_used_on_top = $this->pic_model->getTotalUsedOnTop($budget_code);
                $balance = $total_on_top - $total_used_on_top;
                $budget_code_activity = $budget_code . '/' . $_POST['activity'];

                $data = array(
                    'budget' => 'ready',
                    'balance' => $balance,
                    'budget_used' => $total_used_on_top,
                    'operatingBudget' => $total_on_top,
                    'budget_code' => $budgetCode->row()->BudgetCode,
                    'budget_code_activity' => $budget_code_activity,
                    'budget_allocated' => $total_used_on_top,
                    'budget_booked' => $total_used_on_top,
                    'actual_budget' => 0,
                    'budget_activity' => 0,
                    'total_budget_activity' => 0,
                    'total_operating' => 0,
                    'ims_value' => 0,
                );

                echo json_encode($data);
            }
        }
    }

    public function checkData()
    {
        $post = $_POST;
        // var_dump($post);
        // die;
        $params = array();
        $budget_code = $this->pic_model->getBudgetCode($post);
        // var_dump($budget_code->row()->BudgetCode);
        // die;

        if ($budget_code->num_rows() < 1) {
            $params['budget_code'] = false;
            echo json_encode($params);
            return false;
        }

        $budget_code_activity = $budget_code->row()->BudgetCodeActivity;
        $brand_code = $post['brand'];
        $end_date = $post['end_date'];
        $total_anp_idr = $this->pic_model->getTotalAnp($budget_code->row()->BudgetCode);
        $total_target_idr = $this->pic_model->getTotalTarget($budget_code->row()->BudgetCode);
        $start_periode_budget = $this->pic_model->getStartPeriodeBudget($budget_code_activity);
        $ytd_actual_budget = $this->pic_model->getYTDActualBudget($brand_code, $start_periode_budget, $end_date);
        $ytd_budget_activity = $this->pic_model->getYTDBudgetActivity($budget_code_activity, $end_date);
        $ytd_operating_budget = $this->pic_model->getYTDOperatingBudget($budget_code_activity, $end_date);
        $ytd_budget_activity_percent = ($ytd_budget_activity / $ytd_operating_budget) * 100;
        $anp_percentage = ($total_anp_idr / $total_target_idr);


        $ytd_allocated_budget = $this->pic_model->getYTDAllocatedBudget($budget_code_activity);
        $params['ytd_operating_budget_activity'] = $ytd_budget_activity;
        $params['ytd_actual_budget'] = ($ytd_actual_budget * $anp_percentage) * ($ytd_budget_activity_percent / 100);
        $params['ytd_operating_budget_activity_percent'] = $ytd_budget_activity_percent;
        $params['ytd_operating_budget'] = $ytd_operating_budget;
        $params['ytd_allocated_budget'] = $ytd_allocated_budget;
        $params['success'] = true;
        $params['budget_code_activity'] = $budget_code_activity;
        echo json_encode($params);
    }

    public function createProposal2()
    {
        // var_dump($_POST);
        // die;
        // $budget_code_activity = $_POST['budget_code'];
        $activity_code = $_POST['activity'];
        // $budget_code = preg_match_all('#([^/]*)#', $budget_code_activity, $matches);
        // $budget_code = $matches[0][0] . '/' . $matches[0][2];
        // $operating = $this->pic_model->getOperatingActivity($budget_code, $activity_code);
        // $YTD_purchase_activity = get_ytd_purchase($operating->row()->BrandCode, $operating->row()->StartPeriode) * ($operating->row()->Precentage / 100);
        // $BudgetAllocated = $this->pic_model->getBudgetAllocatedActivity($budget_code_activity);
        $data = [
            'number' => $this->pic_model->getNumber(),
            // 'Allocated_budget' => $BudgetAllocated,
            // 'YTD_purchase_activity' => $YTD_purchase_activity,
        ];

        if ($activity_code == '20') { //Listing
            $this->load->view('proposal/form_listing_v', $data);
        } else {
            $this->load->view('proposal/create_proposal2_v', $data);
        }
    }

    public function showModalActivity()
    {
        $input_activity = !empty($_POST['activity']) ? implode("','", $_POST['activity']) : '';
        $sql = "SELECT * FROM m_promo";
        if ($input_activity != '') {
            $sql .= " WHERE id NOT IN('$input_activity')";
        }
        $activity = $this->db->query($sql);
        $data = [
            'activity' => $activity,
            'budget_code' => $_POST['budget_code'],
        ];
        $this->load->view('operating/modal_activity', $data);
    }

    public function showModalItem()
    {
        $brand = $_POST['brand'];
        $item = $this->pic_model->getItem($brand);
        $data = array(
            'item' => $item,
        );
        $this->load->view('proposal/modal_item', $data);
    }

    public function showModalItemForListing()
    {
        $brand = $_POST['brand'];
        $item = $this->pic_model->getItem($brand);
        $data = array(
            'item' => $item,
        );
        $this->load->view('proposal/modal_item_listing', $data);
    }

    public function showModalCustomer()
    {
        $group = $_POST['group'];
        if (!empty($_POST['customer'])) {
            $customer = $this->pic_model->getCustomer($group, $_POST['customer']);
        } else {
            $customer = $this->pic_model->getCustomer($group);
        }
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('proposal/modal_customer', $data);
    }

    public function showModalCustomerFromSales()
    {
        $group = $_POST['group'];

        // var_dump($_POST);

        if (!empty($_POST['customer'])) {
            $customer = $this->pic_model->getCustomerFromSales($group, $_POST['customer']);
        } else {
            $customer = $this->pic_model->getCustomerFromSales($group);
        }
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('proposal/modal_customer_from_sales', $data);
    }

    public function showModalCustomerForListing()
    {
        $group = $_POST['group'];
        $customer = $this->pic_model->getCustomer($group);
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('proposal/modal_customer_for_listing', $data);
    }

    // public function simpanProposal()
    // {
    //     $this->pic_model->insertProposal($_POST);
    //     if ($this->db->affected_rows() > 0) {
    //         $params = array(
    //             'success' => true
    //         );
    //     } else {
    //         $params = array(
    //             'success' => false
    //         );
    //     }
    //     echo json_encode($params);
    // }

    public function simpanProposalRev()
    {

        // var_dump($_POST);
        // die;

        // $this->simpanCustomerItems($_POST['customer_items']);
        $this->pic_model->insertProposal($_POST);
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

    public function simpanCustomerItems($json_customer_items)
    {
        $customer_items = json_decode($json_customer_items);
        $params_customer_item = array();

        for ($y = 0; $y < count($customer_items[0]); $y++) {
            $param = array(
                'no_proposal' => $customer_items[0][$y],
                'customer_code' => $customer_items[1][$y],
                'item_code' => $customer_items[2][$y],
                'sales_estimation' => $customer_items[3][$y],
                'avg_sales' => $customer_items[4][$y],
            );
            array_push($params_customer_item, $param);
        }
        $this->pic_model->insert_batch_customer_item($params_customer_item);
    }

    public function loadTableProposal()
    {
        $params['user_code'] = $_SESSION['user_code'];

        // var_dump($_POST);
        if (isset($_POST['brand'])) {
            if (count($_POST['brand']) > 0) {
                $params['brand'] = implode(",", $_POST['brand']);
            }
        }

        if (isset($_POST['activity'])) {
            if (count($_POST['activity']) > 0) {
                $params['activity'] = implode(",", $_POST['activity']);
            }
        }

        if (isset($_POST['status'])) {
            if (count($_POST['status']) > 0) {
                $params['status'] = implode(",", $_POST['status']);
            }
        }

        if (isset($_POST['group'])) {
            if (count($_POST['group']) > 0) {
                $params['group'] = implode(",", $_POST['group']);
            }
        }

        if (isset($_POST['start_date'])) {
            if (($_POST['start_date']) != "") {
                $params['start_date'] = $_POST['start_date'];
            }
        }

        if (isset($_POST['end_date'])) {
            if (($_POST['end_date']) != "") {
                $params['end_date'] = $_POST['end_date'];
            }
        }

        $proposal = $this->pic_model->getProposal($params);
        $data = array(
            'proposal' => $proposal,
        );

        $this->load->view('proposal/table_proposal', $data);
    }

    public function showProposal()
    {
        $data = array(
            'brand' => $this->pic_model->getBrandProposalByPic(),
            'activity' => $this->pic_model->getActivity(),
            'group' => $this->pic_model->getGroupFromProposal()
        );
        $this->load->view('proposal/data_proposal_v', $data);
    }

    public function exportResumeProposalToExcel()
    {
        $post = $this->input->post();
        $proposal = $this->pic_model->getTarikanProposalExcel($post);
        $data = array(
            'proposal' => $proposal
        );
        $this->load->view('report/proposal_excel', $data);
    }

    public function showProposalDetail($number)
    {
        $params['number'] = $number;
        $proposal = $this->pic_model->getProposal($params);
        $proposalItem = $this->pic_model->getProposalItem($number);
        $proposalItemOther = $this->pic_model->getProposalItemOther($number);
        $proposalCustomer = $this->pic_model->getProposalCustomer($number);
        $approvedBy = $this->pic_model->getApprovedBy($number);
        $objective = $this->pic_model->getObjective($number);
        $mechanism = $this->pic_model->getMechanism($number);
        $comment = $this->pic_model->getComment($number);
        $total_costing = $this->pic_model->getTotalCosting($number)->row()->total_costing;
        $itemGroup = $this->pic_model->getProposalItemGroupDetail($number);


        $array_group = [];
        $array_customer = [];
        foreach ($proposalCustomer->result() as $data) {
            array_push($array_group, $data->GroupCustomer);
            array_push($array_customer, $data->CustomerCode);
        };
        $string_group = json_encode($array_group);
        $string_customer = json_encode($array_customer);

        $data = array(
            'proposal' => $proposal,
            'proposalItem' => $proposalItem,
            'proposalItemOther' => $proposalItemOther,
            'proposalCustomer' => $proposalCustomer,
            'approvedBy' => $approvedBy,
            'objective' => $objective,
            'mechanism' => $mechanism,
            'comment' => $comment,
            'total_costing' => $total_costing,
            'itemGroup' => $itemGroup,
            'string_group' => $string_group,
            'string_customer' => $string_customer,
        );

        $this->load->view('proposal/data_proposal_detail_v', $data);
    }

    public function showProposalEdit($number)
    {
        $params['number'] = $number;
        $proposal = $this->pic_model->getProposal($params);
        $proposalItem = $this->pic_model->getProposalItem($number);
        $proposalItemOther = $this->pic_model->getProposalItemOther($number);
        $proposalCustomer = $this->pic_model->getProposalCustomer($number);
        $approvedBy = $this->pic_model->getApprovedBy($number);
        $objective = $this->pic_model->getObjective($number);
        $mechanism = $this->pic_model->getMechanism($number);
        $comment = $this->pic_model->getComment($number);
        $total_costing = $this->pic_model->getTotalCosting($number)->row()->total_costing;
        $itemGroup = $this->pic_model->getProposalItemGroupDetail($number);

        // var_dump($itemGroup->result());


        $array_group = [];
        $array_customer = [];
        foreach ($proposalCustomer->result() as $data) {
            array_push($array_group, $data->GroupCustomer);
            array_push($array_customer, $data->CustomerCode);
        };
        $string_group = json_encode($array_group);
        $string_customer = json_encode($array_customer);

        $data = array(
            'proposal' => $proposal,
            'proposalItem' => $proposalItem,
            'proposalItemOther' => $proposalItemOther,
            'proposalCustomer' => $proposalCustomer,
            'approvedBy' => $approvedBy,
            'objective' => $objective,
            'mechanism' => $mechanism,
            'comment' => $comment,
            'total_costing' => $total_costing,
            'itemGroup' => $itemGroup,
            'string_group' => $string_group,
            'string_customer' => $string_customer,
        );

        $this->load->view('proposal/data_proposal_detail_edit', $data);
    }

    public function prosesNoSk()
    {
        $post = $this->input->post();
        $no_proposal = $post['no_proposal'];
        $this->pic_model->editNoSK($post);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Berhasil edit data');
        } else {
            $this->session->set_flashdata('error', 'Gagal edit data');
        }

        redirect(base_url($_SESSION['page']) . '/showProposalDetail/' . $no_proposal);
    }

    public function deleteProposal($number)
    {
        $this->pic_model->deleteProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal hapus";
        }
    }

    public function approveProposal($number)
    {
        $this->pic_model->approveProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal approved";
        }
    }

    public function cancelProposal()
    {

        $number = $this->input->post('proposal_number');
        // die;
        $this->pic_model->cancelProposal($number);
        if ($this->db->affected_rows() > 0) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function createOperating()
    {
        $brand = $this->pic_model->getBrandPic($_SESSION['user_code']);
        $activity = $this->pic_model->getActivity();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
        );
        $this->load->view('operating/create_operating_v', $data);
    }

    public function check_budget_already()
    {
        // var_dump($_POST);
        // die;
        $brand = str_replace(array(' ', "\t"), '', $_POST['brand']);;
        $start_month = date('Y-m-d', strtotime($_POST['start_month']));
        $end_month = date('Y-m-d', strtotime($_POST['end_month']));
        $begin = new DateTime($start_month);
        $end = new DateTime($end_month);
        $end = $end->modify('+1 month');
        $interval = new DateInterval('P1M');
        $daterange = new DatePeriod($begin, $interval, $end);
        $periode = array();
        $check = $this->pic_model->checkOperatingAlreadyExist($brand, $start_month, $end_month);

        foreach ($daterange as $date) {
            array_push($periode, $date->format("Y-m-d"));
        }

        // var_dump($this->db->last_query());
        // var_dump($check->num_rows());
        // die;

        if ($check->num_rows() > 0) {
            echo json_encode(['budget' => 'budget_already_exists']);
            return false;
        }


        if (count($periode) != 12) {
            echo json_encode(['budget' => 'harus_setahun'.count($periode)]);
            return false;
        }

        echo json_encode(['budget' => 'siap']);
    }

    public function show_form_create_budget()
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

        foreach ($daterange as $date) {
            array_push($periode, $date->format("Y-m-d"));
        }

        $data = array(
            'brand' => $_POST['brand'],
            'start_month' => $start_month,
            'end_month' => $end_month,
            'periode' => $periode,
        );
        // $this->load->view('operating/create_operating2_v', $data);
        $this->load->view('operating/create_operating2_v_rev', $data);
    }

    public function simpanOperating()
    {
        // var_dump($_POST);
        // die;
        $this->pic_model->simpanOperating($_POST);
        if ($this->db->affected_rows() > 0) {
            $id = $this->db->insert_id();
            $budgetCode = $this->db->query("SELECT BudgetCode FROM tb_operating WHERE id = '$id'")->row()->BudgetCode;
            $params = array(
                'success' => true,
                'budget_code' => $budgetCode,
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
        $operating_activity = $this->pic_model->getOperatingActivity($budget_code);
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
        $operating_activity = $this->pic_model->getOperatingActivityDetail($budget_code);
        $data = array(
            'operating_activity_detail' => $operating_activity,
        );
        $this->load->view('operating/operating_activity_detail_v', $data);
    }

    public function setOperatingActivity($brand, $number)
    {
        $budget_code = $brand . '/' . $number;
        $params['budget_code'] = $budget_code;
        $operating = $this->pic_model->getOperating($params);
        $activity = $this->pic_model->getActivity();
        $operatingHeader = $this->pic_model->getHeaderOperating($budget_code);
        $data = array(
            'brand' => $brand,
            'operating' => $operating,
            'activity' => $activity,
            'budget_code' => $budget_code,
            'operating_header' => $operatingHeader,
        );
        // $this->load->view('operating/set_operating_activity_v', $data);
        $this->load->view('operating/set_operating_activity_v_revisi', $data);
    }

    public function showFormActivity()
    {
        $activity_code = $_POST['activity'];
        $params['budget_code'] = $_POST['budget_code'];
        $operating = $this->pic_model->getOperating($params);
        $data = array(
            'budget_code' => $_POST['budget_code'],
            'operating' => $operating,
            'activity' => $activity_code,
        );
        // $this->load->view('operating/add_activity', $data);
        $this->load->view('operating/add_activity_revisi', $data);
    }


    public function simpanOperatingActivity()
    {
        // var_dump($_POST);
        // die;
        $this->pic_model->simpanOperatingActivity($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array('success' => true);
        } else {
            $params = array('success' => false);
        }
        echo json_encode($params);
    }

    public function checkAlreadyOperating()
    {
        // var_dump($_POST);
    }

    public function showBudgetOperatingPurchase()
    {
        $operating_purchase = $this->pic_model->getOperatingPurchase($_SESSION['user_code']);
        $data = array(
            'operating_purchase' => $operating_purchase,
        );
        $this->load->view('operating/operating_purchase_v', $data);
    }

    public function updatePicBrand()
    {
        $sql = "SELECT BrandName FROM tb_pic_brand";
        $query = $this->db->query($sql);
        $brandName = $query->result();

        for ($i = 0; $i < $query->num_rows(); $i++) {
            $brand_name = $brandName[$i]->BrandName;
            $brand_code = $this->db->query("SELECT BrandCode FROM m_brand WHERE BrandName = '$brand_name'")->row()->BrandCode;
            $Update = $this->db->query("UPDATE tb_pic_brand SET BrandCode = '$brand_code' WHERE BrandName ='$brand_name'");
        }
    }

    public function showDetailBudget($brand, $no_urut)
    {
        $budget_code = $brand . '/' . $no_urut;
        $budget_detail = $this->pic_model->get_detail_budget($budget_code);
        $budget_detail_header = $this->pic_model->getHeaderOperating($budget_code);
        $activity = $this->pic_model->getActivityFromTbOperatingActivity($budget_code);
        $ims = $this->pic_model->getActualIMS($brand, $budget_code);
        $is_ims = $ims->row()->ims == 'Y' ? 'Yes' : 'No';
        $ims_percent = $ims->row()->ims == 'Y' ? round($ims->row()->ims_percent * 100) : 0;
        $ims_value = $ims->row()->ims == 'Y' ? round($ims->row()->ims_value) : 0;
        $budget_activity_report = $this->pic_model->getBudgetActivityReport($budget_code);

        // var_dump($ims->result());
        // die;
        $data = array(
            'budget_detail' => $budget_detail,
            'brand_code' => $brand,
            'budget_code' => $budget_code,
            'budget_detail_header' => $budget_detail_header,
            'activity' => $activity,
            'is_ims' => $is_ims,
            'ims_percent' => $ims_percent,
            'ims_value' => $ims_value,
            'budget_activity_report' => $budget_activity_report
        );
        // $this->load->view('operating/detail_budget_v', $data);
        $this->load->view('operating/detail_budget_v_rev', $data);
    }

    public function loadCreateOnTop()
    {
        $budget_code = $this->input->post('budget_code');
        $data = array(
            'month' => $this->pic_model->functionGetMonthBudget($budget_code),
            'budget_code' => $budget_code,
        );
        $this->load->view('operating/modal_create_budget_ontop', $data);
    }

    public function loadModalEditOnTop()
    {
        $id = $this->input->post('id');
        $budget = $this->pic_model->getBudgetOnTopById($id);
        // var_dump($budget->result());
        $data = array(
            'budget' => $budget
        );
        $this->load->view('operating/modal_edit_budget_ontop', $data);
    }

    public function editOnTop()
    {
        $post = $this->input->post();
        $this->pic_model->editOnTop($post);
        if ($this->db->affected_rows() > 0) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function loadTableOnTop()
    {
        $budget_code = $this->input->post('budget_code');
        $budget = $this->pic_model->getBudgetOnTop($budget_code);
        $data = array(
            'budget_code' => $budget_code,
            'budget' => $budget
        );
        $this->load->view('operating/table_budget_ontop', $data);
    }

    public function loadTableOnTopResume()
    {
        // var_dump($_POST);
        $budget_code = $this->input->post('budget_code');
        $total_on_top = $this->pic_model->totalOnTop($budget_code);
        $totalCostingOnTop = $this->pic_model->totalCostingOnTop($budget_code);
        $balanceOnTop = $total_on_top - $totalCostingOnTop;
        $data = array(
            'totalOnTop' => $total_on_top,
            'totalCostingOnTop' => $totalCostingOnTop,
            'balanceOnTop' => $balanceOnTop
        );
        $this->load->view('operating/table_budget_ontop_resume', $data);
    }

    public function getItem()
    {
        $item_code = implode("','", $_POST["item_code"]);
        $item = $this->db->query("SELECT ItemCode,ItemName,FrgnName,Price,Sales FROM m_item WHERE ItemCode IN('$item_code')");
        $params = [
            'item' => $item->result(),
        ];
        echo json_encode($params);
    }

    public function createBudgetOnTop()
    {
        $post = $this->input->post();
        $create = $this->pic_model->createBudgetOnTop($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }

    public function showModalItemFromPenjualan()
    {
        $today = $this->pic_model->getDate();
        // var_dump($today);
        // die;
        // var_dump($_POST);
        $barcode = array();
        if (isset($_POST['barcode'])) {
            $barcode = $_POST['barcode'];
        }

        // die;
        $end = date('Y-m-d', strtotime($today));
        $start = '';
        if ($_POST['avg_sales'] == 'Last 3 Month') {
            $start = date("Y-m-d", strtotime("-3 Months", strtotime($end)));
        } else if ($_POST['avg_sales'] == 'Last Year') {
            $start = date("Y-m-d", strtotime("-12 Months", strtotime($end)));
        }
        $brand = $_POST['brand'];
        $customer = $_POST['customer_code'];
        $item = $this->pic_model->getItemFromPenjualan($brand, $customer, $start, $end, null, $barcode);

        // var_dump($item->result());

        $data = array(
            'item' => $item,
        );
        $this->load->view('proposal/modal_item_from_penjualan', $data);
    }

    public function getItemFromPenjualan()
    {
        $today = $this->pic_model->getDate();

        $end = date('Y-m-d', strtotime($today));
        $start = '';

        if ($_POST['avg_sales'] == 'Last 3 Month') {
            $start = date("Y-m-d", strtotime("-3 Months", strtotime($end)));
        } else if ($_POST['avg_sales'] == 'Last Year') {
            $start = date("Y-m-d", strtotime("-12 Months", strtotime($end)));
        }

        $brand = $_POST['brand'];
        $customer = $_POST['customer'];
        $item = implode(",", $_POST["item_code"]);

        $items = $this->pic_model->getItemFromPenjualan($brand, $customer, $start, $end, $item, null);

        // var_dump($item->result());
        // die;

        $params = [
            'item' => $items->result(),
        ];

        echo json_encode($params);
    }

    public function getCustomer()
    {
        $_POST['customer_code'] = json_decode($_POST['customer_code'], true);
        $customer_code = implode("','", $_POST["customer_code"]);
        // $sql = "SELECT t1.CardCode, t1.CustomerName, t1.GroupCode, t2.GroupName FROM m_customer t1
        // INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode
        // WHERE t1.CardCode IN('$customer_code')";
        $sql = "SELECT t1.CardCode, t1.CustomerName, t1.GroupCode, t2.GroupName FROM CustomerView t1
        INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode
        WHERE t1.CardCode IN('$customer_code')";

        // var_dump($sql);
        // print_r($sql);
        // die;

        $customer = $this->db->query($sql);
        $params = [
            'customer' => $customer->result(),
        ];
        echo json_encode($params);
    }

    public function exportProposalToExcel__2($number)
    {
        $proposal_header = $this->db->query("SELECT * FROM tb_proposal WHERE [Number] = '$number'");

        $proposal_item = $this->db->query("SELECT t1.ProposalNumber, t2.ItemName, t2.FrgnName AS Barcode, 
        t1.Price, t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing FROM tb_proposal_item t1
        INNER JOIN m_item t2 ON t1.ItemCode = t2.ItemCode
        WHERE t1.ProposalNumber = '$number'");

        $data = array(
            'proposal_header' => $proposal_header,
            'proposal_item' => $proposal_item,
        );
        $this->load->view('proposal/export_excel', $data);
    }



    public function exportProposalToExcel($number)
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

        //Data
        $proposal_header = $this->db->query("SELECT * FROM tb_proposal WHERE [Number] = '$number'");

        $proposal_item = $this->db->query("SELECT t1.ProposalNumber, t2.ItemName, t2.FrgnName AS Barcode, 
        t1.Price, t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing FROM tb_proposal_item t1
        INNER JOIN m_item t2 ON t1.ItemCode = t2.ItemCode
        WHERE t1.ProposalNumber = '$number'");

        $proposal_customer = $this->db->query("SELECT t1.ProposalNumber, t1.GroupCustomer, t1.CustomerCode, t2.CustomerName, t3.GroupName FROM tb_proposal_customer t1
        INNER JOIN m_customer t2 ON t1.CustomerCode = t2.CardCode
        INNER JOIN m_group t3 ON t1.GroupCustomer = t3.GroupCode
        WHERE t1.ProposalNumber = '$number'");

        // var_dump($proposal_header->result());
        // // var_dump($proposal_item->result());
        // // var_dump($proposal_customer->result());
        // die;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Pandurasa Kharisma')
            ->setLastModifiedBy('Pandurasa Kharisma')
            ->setTitle("Proposal Promotion " . $number)
            ->setSubject("Proposal Promotion " . $number)
            ->setDescription("Proposal Promotion" . $number)
            ->setKeywords("Proposal Promotion " . $number);
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Proposal Promotion " . $number); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR PROPOSAL"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "ACTIVITY"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "START DATE"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "END DATE"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "PIC"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "PRODUCT DESCRIPTION"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "BARCODE"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "PRICE"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('J3', strtoupper($proposal_header->row()->AvgSales)); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('K3', "QTY"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('L3', "TARGET"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('M3', "PROMO"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('N3', "COSTING"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        // $siswa = $this->SiswaModel->view();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($proposal_item->result() as $data) {

            // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $number);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, getActivityName($proposal_header->row()->Activity));
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, date('Y-m-d', strtotime($proposal_header->row()->StartDatePeriode)));
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, date('Y-m-d', strtotime($proposal_header->row()->EndDatePeriode)));
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, strtoupper($proposal_header->row()->CreatedBy));
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->ItemName);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->Barcode);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->Price);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->AvgSales);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->Qty);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->Target);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->Promo);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->Costing);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        // $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        // $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        // $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        // $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        // $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E

        $excel->setActiveSheetIndex(0)->setCellValue('P3', "CUSTOMER CODE");
        $excel->setActiveSheetIndex(0)->setCellValue('Q3', "CUSTOMER GROUP");
        $excel->setActiveSheetIndex(0)->setCellValue('R3', "CUSTOMER NAME");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($proposal_customer->result() as $data) {

            // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->CustomerCode);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->GroupName);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->CustomerName);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);

            // $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("PROPOSAL " . $number);
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Proposal Promotion ' . $number . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function exportProposalToPdf($number)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        // $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';

        $proposal_header = $this->db->query("SELECT * FROM tb_proposal WHERE [Number] = '$number'");



        $proposal_item = $this->db->query("SELECT t1.ProposalNumber, t2.ItemName, t2.FrgnName AS Barcode, 
        t1.Price, t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing,t1.PromoValue, t1.ListingCost FROM tb_proposal_item t1
        INNER JOIN m_item t2 ON t1.ItemCode = t2.ItemCode
        WHERE t1.ProposalNumber = '$number'");

        $biaya = $this->db->query("SELECT * FROM tb_operating_proposal WHERE ProposalNumber = '$number'");
        $budgetCodeActivity = $this->db->query("SELECT BudgetCodeActivity FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->BudgetCodeActivity;
        $Unbooked = $this->db->query("SELECT SUM(Unbooked) AS TotalUnbooked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budgetCodeActivity'")->row()->TotalUnbooked;
        $AnpBooked = $this->db->query("SELECT SUM(BudgetBooked) AS TotalAnpBooked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budgetCodeActivity'")->row()->TotalAnpBooked;
        $objective = $this->pic_model->getObjective($number);
        $mechanism = $this->pic_model->getMechanism($number);
        $comment = $this->pic_model->getComment($number);
        $customer_item  = $this->pic_model->get_proposal_customer_item($number);
        $customer = $this->pic_model->getCustomerProposal($number);
        $approved = $this->pic_model->getApproved($number);
        $costingOther = $this->pic_model->getProposalItemOther($number);

        $data = array(
            'title_pdf' => 'Proposal Promotion ' . $number,
            'proposal_header' => $proposal_header,
            'proposal_item' => $proposal_item,
            'biaya' => $biaya,
            'Unbooked' => $Unbooked,
            'AnpBooked' => $AnpBooked,
            'objective' => $objective,
            'mechanism' => $mechanism,
            'comment' => $comment,
            'customer_item' => $customer_item,
            'customer' => $customer,
            'approved' => $approved,
            'costing_other' => $costingOther
        );

        // filename dari pdf ketika didownload
        $file_pdf = 'Proposal promosi ' . $number;
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('proposal/proposal_pdf', $data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function showFormAddOnTop($brand, $no)
    {
        $budget_code = $brand . '/' . $no;
        $month = $this->pic_model->getMonthBudget($budget_code);
        $brand = $this->pic_model->getBrandBudget($budget_code);
        $data = array(
            'budget_code' => $budget_code,
            'month' => $month,
            'brand' => $brand,
        );
        $this->load->view('operating/formAddBudgetOnTop_v', $data);
    }

    public function simpanBudgetOnTop()
    {
        $this->pic_model->simpanBudgetOnTop($_POST);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page'] . '/set_on_top_activity/' . $_POST['budget_code']));
        } else {
            echo "Gagal Simpan Data";
        }
    }

    public function set_on_top_activity($brand, $nomor)
    {
        $budget_code = $brand . '/' . $nomor;
        $brand = $this->db->query("SELECT DISTINCT BrandCode FROM tb_operating WHERE BudgetCode = '$budget_code'")->row()->BrandCode;
        $operatingHeader = $this->pic_model->getHeaderOperating($budget_code);
        $budget_on_top = $this->db->query("SELECT * FROM tb_budget_on_top WHERE budget_code = '$budget_code'");
        $activity = $this->pic_model->getActivity();
        $data = array(
            'budget_code' => $budget_code,
            'brand' => $brand,
            'activity' => $activity,
            'budget_on_top' => $budget_on_top
        );
        $this->load->view('operating/set_on_top_activity_v', $data);
    }

    public function simpan_on_top_activity()
    {
        $this->pic_model->simpan_on_top_activity($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array('success' => true);
        } else {
            $params = array('success' => false);
        }
        echo json_encode($params);
    }

    public function update_on_top()
    {
        $new_total_on_top = 0;
        foreach ($_POST['budget_on_top'] as $budget) {
            $new_total_on_top += (float)str_replace(',', '', $budget);
        }
        $budget_code = $_POST['budget_code'][0];
        $total_on_top_exists = $this->db->query("SELECT SUM(budget_on_top) as total_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code'")->row()->total_on_top;

        if ($new_total_on_top < $total_on_top_exists) {
            $params = array(
                'total_on_top' => 'lebih_kecil'
            );
            echo json_encode($params);
            return false;
        }

        $this->pic_model->update_on_top($_POST);
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

    public function edit_proposal($number_proposal)
    {

        $is_sales = $this->db->query("SELECT t2.sales as sales FROM tb_operating_proposal t1 
        INNER JOIN m_promo t2 ON t1.ActivityCode = t2.id
        WHERE t1.ProposalNumber = '$number_proposal'")->row()->sales;
        $budget_code_activity = $this->db->query("SELECT BudgetCodeActivity FROM tb_operating_proposal WHERE ProposalNumber = '$number_proposal'")->row()->BudgetCodeActivity;
        $budget_type = $this->db->query("SELECT Budget_type FROM tb_operating_proposal WHERE ProposalNumber = '$number_proposal'")->row()->Budget_type;
        $data = array(
            'number_proposal' => $number_proposal,
            'budget_code_activity' => $budget_code_activity,
            'budget_type' => $budget_type,
        );

        if ($is_sales == 'N') {
            $this->load->view('proposal/form_edit_proposal_non_sales_v', $data);
        } else {
            $this->load->view('proposal/form_edit_proposal_v', $data);
        }
    }

    function editProposal()
    {
        // var_dump($_POST);
        // die;



        $this->pic_model->update_proposal_item($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_proposal_customer($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_proposal_objective($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_proposal_mechanism($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_proposal_comment($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_tb_proposal($_POST);
        // if ($this->db->affected_rows() < 1) {
        //     echo json_encode(['success' => false]);
        //     return false;
        // }

        $this->pic_model->update_tb_operating_proposal($_POST);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function changePasswordPage()
    {
        $data = array();
        $this->load->view('settings/changePasswordPage', $data);
    }

    public function changePassword()
    {
        $post = $this->input->post();
        $this->pic_model->changePassword($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal ubah password');
        }
        redirect(base_url($_SESSION['page'] . '/changePasswordPage'));
    }


    public function showEditItem()
    {
        $id = $this->input->post('id');
        $data = array(
            'item' => $this->pic_model->getProposalItemGroupDetailById($id),
        );
        $this->load->view('proposal/modal_edit_item_group', $data);
    }

    public function editItemExecute()
    {
        $post = $this->input->post();
        var_dump($post);
    }
}
