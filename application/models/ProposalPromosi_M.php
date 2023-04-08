<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposalPromosi_M extends CI_Model {
    public function get_item($code_brand = null){
        
        $sql = "SELECT * FROM m_item";
        if($code_brand != null){
            $sql .= " WHERE BrandCode = '$code_brand'";
        }

        if (!empty($_POST['item_code'])){
            $item_code = $_POST['item_code'];
            $item_code = implode("','", $item_code);
            $sql .= " AND ItemCode NOT IN('$item_code')";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_brand($code_brand = null){
        $sql = "SELECT * FROM m_brand";
        if($code_brand != null){
            $sql .= " WHERE BrandCode = '$code_brand'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_activity(){
        $sql = "SELECT * FROM m_promo";
        $query = $this->db->query($sql);
        return $query;
    }

    public function checkBudget($brand, $activity, $budget_year){
        $sql = "SELECT * FROM t_budgetActivity WHERE brandCode = '$brand' AND activity = '$activity' AND budgetYear = '$budget_year' ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomer($customer_code = null){
        $sql = "SELECT CardCode, CustomerName, GroupCode FROM m_customer";
        if($customer_code != null){
            $customer_code = implode("','", $customer_code);
            $sql .= " WHERE CardCode IN('$customer_code')";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanProposal($post){
        $no_proposal = $post['no_proposal'];
        $brand_code = $post['brand_code'];
        $unit = $post['unit'];
        $activity_code = $post['activity_code'];
        $start_periode = $post['start_periode'];
        $end_periode = $post['end_periode'];
        $total_target = $post['total_target'];
        $total_costing = $post['total_costing'];
        $data_item_target = $post['dataItemTarget'];
        $data_item_add = $post['dataAdd'];
        $data_customer = $post['customerCode'];
        $data_budgeting = $post['dataBudgeting'];

        // var_dump($post);
        
        $simpan_item = $this->simpanItemTarget($no_proposal, $brand_code, $activity_code, $start_periode, $end_periode, $total_target, $total_costing, $data_item_target, $unit);
        // if($simpan_item == true){
            $simpan_customer = $this->simpanCustomer($no_proposal, $data_customer);
        // }
        // if($simpan_budget == true){
            
        // }
        $simpan_item_add = $this->simpanBudgeting($no_proposal, $data_budgeting);
    }

    public function simpanItemTarget($no_proposal, $brand_code, $activity_code, $start_periode, $end_periode, $total_target, $total_costing, $data_item_target, $unit){
        // var_dump($data_item_target);
        foreach($data_item_target['item_code'] as $key => $data){
            // var_dump($key);
            $params = [
                'no_proposal' => $no_proposal,
                'brand_code' => $brand_code,
                'start_periode' => $start_periode,
                'end_periode' => $end_periode,
                'item_code' => $data_item_target['item_code'][$key],
                'activity' => $activity_code,
                'price' => $data_item_target['item_price'][$key],
                'unit' => $unit,
                'quantity_target' => $data_item_target['quantity_target'][$key],
                'target_value' => $data_item_target['target_value'][$key],
                'promo_value' => $data_item_target['promo_value'][$key],
                'promo' => $data_item_target['promo'][$key],
                'total_target' => $total_target,
                'costing_value' => $data_item_target['costing_value'][$key],
                'total_costing' => $total_costing,
                'cost_ratio' => $data_item_target['cost_ratio'],
                'created_by' => $this->fungsi->user_login()->user_code,
            ];
            $query = $this->db->insert('t_proposal', $params);
        }

        if($this->db->affected_rows() > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function simpanCustomer($no_proposal, $data_customer){
        foreach($data_customer as $data){
            $params = [
                'no_proposal' => $no_proposal,
                'customer_code' => $data
            ];
            $query = $this->db->insert('t_proposal_customer_selected', $params);
        }

        if($this->db->affected_rows() > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function simpanBudgeting($no_proposal, $data_budgeting){
        for($i = 0; $i< count($data_budgeting['budgetCode']); $i++){
            $params = [
                'no_proposal' => $no_proposal,
                'budget_code' => $data_budgeting['budgetCode'][$i],
                'budget_value' => $data_budgeting['budgetValue'][$i],
                'cost' => $data_budgeting['cost'][$i],
                'saldo_budget' => $data_budgeting['saldoBudget'][$i],
                'budget_used' => $data_budgeting['budgetUsed'][$i],
                'created_by' => $this->fungsi->user_login()->user_code,
            ];
            $query = $this->db->insert('t_proposal_budgeting', $params);
        }
    }

    public function transaction_no()
    {
        $sql2 = "SELECT MAX(SUBSTRING(no_proposal,10,4)) AS no_proposal 
        FROM t_proposal 
        WHERE SUBSTRING(no_proposal,4,6) = convert(varchar, getdate(), 12)";

        $query = $this->db->query($sql2);
        // var_dump($query->row());
        // die;
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->no_proposal) + 1;
            $no = sprintf("%'.04d", $n); 
        }else{
            $no = "0001";
        }
        $transaction = date('ymd').$no;
        return $transaction;
    }

    public function getProposal(){
        $sql = "SELECT DISTINCT T1.no_proposal, brand_code, T1.created_by, start_periode, end_periode, T1.is_approve FROM t_proposal T0
                INNER JOIN t_proposal_budgeting T1 ON T0.no_proposal = T1.no_proposal";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalDataHeader($no_proposal){
        $sql = "SELECT DISTINCT ss.no_proposal, brand_code, start_periode, end_periode, activity, total_costing, created_by, is_approve, total_target, total_costing FROM
                (SELECT T0.*,T1.is_approve FROM t_proposal T0
                INNER JOIN t_proposal_budgeting T1 ON T0.no_proposal = T1.no_proposal
                WHERE T0.no_proposal = '$no_proposal')ss";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalTargetItem($no_proposal){
        $sql = "SELECT T0.*, T1.ItemName, T1.FrgnName AS Barcode FROM t_proposal T0
        INNER JOIN m_item T1 ON T0.item_code = T1.ItemCode 
        WHERE no_proposal = '$no_proposal'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerSelected($no_proposal){
        $sql = "SELECT T0.*, T1.CustomerName FROM t_proposal_customer_selected T0
        INNER JOIN m_customer T1 ON T0.customer_code = T1.CardCode
        WHERE T0.no_proposal = '$no_proposal'";
        $query = $this->db->query($sql);
        return $query;
    }
}