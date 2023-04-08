<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposalPromosi_C extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		check_not_login();
        $this->load->model(['ProposalPromosi_M','proposal_m']);
		
	}

    public function get_item_for_modal_choose_item(){
        // var_dump($_POST);
        $code_brand = $_POST['code_brand'];
        // $type_proposal = $_POST['data']['type_proposal'];
        // var_dump($type_proposal);
        $item = $this->ProposalPromosi_M->get_item($code_brand);
        $data = [
            'item' => $item,
            // 'type_proposal' =>$type_proposal,
        ];
        $this->load->view('proposalPromosi/modal/modal_choose_item',$data);
    }

    public function getItemForTarget(){
        $item_code = $_POST['code'];
        $item_code = implode("','", $item_code);
        $sql = "SELECT * FROM m_item WHERE ItemCode IN('$item_code')";
        $query = $this->db->query($sql);
        echo json_encode($query->result());
    }

    public function createNewProposal(){
        $brand = $this->ProposalPromosi_M->get_brand();
        $activity = $this->ProposalPromosi_M->get_activity();
        $data = [
            'brand' => $brand,
            'activity' => $activity,
        ];
        $this->load->view('proposalPromosi/modal_create_new', $data);
    }

    public function createProposalRegular(){
        // var_dump($_POST);
        $code_brand = $_POST['brand_code'];
        $activity_code = $_POST['activity_code'];
        $budget_year = $_POST['budget_year'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $type_proposal = $_POST['type_proposal'];
        $no_proposal = $this->ProposalPromosi_M->transaction_no();
        $brand_name = $this->ProposalPromosi_M->get_brand($code_brand)->row()->BrandName;
        $brand_name = preg_replace('/\s+/', '', $brand_name);
        $brand_aka = substr($brand_name,0,3);
        $no_proposal = $brand_aka.$no_proposal;

        $checkBudget = $this->ProposalPromosi_M->checkBudget($code_brand, $activity_code, $budget_year);
        if($checkBudget->num_rows() > 0){

            $actualBudgetValue = 0;
            foreach($checkBudget->result() as $d){
                $actualBudgetValue += (float)$d->budgetAlocated;
            }

            $data = [
                'code_brand' => $code_brand,
                'activity_code' => $activity_code,
                'no_proposal' => $no_proposal,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type_proposal' => $type_proposal,
                'total_actual_budget_value' => $actualBudgetValue,
                'success' => true,
                'budget' => $checkBudget->result(),
            ];
        }else{
            $data = [
                'checkBudget' =>false,
            ];
        }
        echo json_encode($data);
    }

    public function showFormProposalRegular(){
        // var_dump($_POST);
        // var_dump(json_decode($_POST['input_budget'],true));
        $data = [
            'brand_code' => $_POST['brand_code'],
            'no_proposal' => $_POST['no_proposal'],
            'activity_code' => $_POST['activity_code'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'data_budget' => $_POST['input_budget'],
        ];
        $this->template->load('template', 'proposalPromosi/formProposalNonSales/form_proposal', $data);
    }

    public function showModalCustomer(){
        $customer = $this->ProposalPromosi_M->getCustomer();
        $data = [
            'customer' => $customer,
        ];
        $this->load->view('proposalPromosi/modal/modal_choose_customer', $data);
    }

    public function getCustomerSelected(){
        $customer_code = $_POST['customer_code'];
        $customer = $this->ProposalPromosi_M->getCustomer($customer_code);
        echo json_encode($customer->result());
    }

    public function saveProposal(){
        // var_dump($_POST);
        $this->ProposalPromosi_M->simpanProposal($_POST);
    }

    public function proposalData(){
        $proposal = $this->ProposalPromosi_M->getProposal();
        $data = [
            'proposal' => $proposal,
        ];
        $this->template->load('template', 'proposalPromosi/proposalData/proposal_data', $data);
    }

    public function proposalDataDetail($no_proposal){
        $proposalHeader = $this->ProposalPromosi_M->getProposalDataHeader($no_proposal);
        $proposalTargetItem = $this->ProposalPromosi_M->getProposalTargetItem($no_proposal);
        $customerSelected = $this->ProposalPromosi_M->getCustomerSelected($no_proposal);
        $data = [
            'proposalHeader' => $proposalHeader,
            'proposalTargetItem' => $proposalTargetItem,
            'customer' => $customerSelected,
        ];
        $this->template->load('template', 'proposalPromosi/proposalData/proposal_data_detail', $data);
    }

}