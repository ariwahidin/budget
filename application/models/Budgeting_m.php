<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budgeting_m extends CI_Model {

    public function simpanBudgetingTransaksi($post, $transaction_code)
    {

        $no_proposal = substr(getBrandName($post['budget_brand_code']),0,3).$transaction_code;
        $no_anggaran = $post['budget_no_anggaran_used'];
        $total_costing = $this->getTotalCosting($no_proposal);
        $month_budget_used = $post['budget_month_used'];
        $year_budget_used = $post['budget_year_used'];
        $budget_activity = $post['budget_activity'];
        $brand_code = $post['budget_brand_code'];
        $month_budget_value_used = $this->getMonthBudgetValueUsed($no_anggaran, $brand_code, $budget_activity, $month_budget_used, $year_budget_used);
        $costing_saldo = ($total_costing - $month_budget_value_used);

        $params = [
            'no_proposal' => $no_proposal,
            'no_anggaran' => $no_anggaran,
            'brand_code' => $brand_code,
            'total_costing' => $total_costing,
            'month_budget' => $month_budget_used,
            'month_budget_value' => $month_budget_value_used,
            'costing_saldo' => $costing_saldo,
        ];
        $query = $this->db->insert('t_budgeting', $params);
        return $query;
        // var_dump($query);
    }
    
    public function getTotalCosting($no_proposal){
        $sql = "SELECT sum(costing_value) as total_costing FROM t_transaction_detail WHERE code_transaksi = '$no_proposal'";
        $query = $this->db->query($sql);
        return $query->row()->total_costing;
    }

    public function getMonthBudgetValueUsed($no_anggaran, $brand_code, $activity, $month, $start_year){

        $sql = "SELECT nominal FROM t_budget_activity 
                WHERE no_anggaran = $no_anggaran 
                AND brand_code = $brand_code 
                AND activity = $activity 
                AND [month] = $month
                AND start_year = $start_year";

        $query = $this->db->query($sql);
        return $query->row()->nominal;
    }

    public function getTotalCostingFromTableBudgeting($no_proposal, $no_anggaran, $month_budget_used){
    $sql = "SELECT total_costing FROM t_budgeting 
            WHERE no_proposal = '$no_proposal' 
            AND no_anggaran = '$no_anggaran' 
            AND month_budget = '$month_budget_used'";
    $query = $this->db->query($sql);
    return $query->row()->total_costing;
    }

    public function getNominalBudgetUsed($no_anggaran, $brand_code, $budget_activity, $month_budget_used, $year_budget_used){
    $sql = "SELECT * FROM t_budget_activity 
            WHERE no_anggaran = '$no_anggaran' 
            AND brand_code = '$brand_code' 
            AND activity = '$budget_activity'
            AND [month] = '$month_budget_used'
            AND tahun = '$year_budget_used'";
    $query = $this->db->query($sql);
    // var_dump($sql);
    // var_dump($query->result());
    // die;
    return $query;
    }

    public function updateBudgetActivityUsed($post, $transaction_code){
        $no_proposal = substr(getBrandName($post['budget_brand_code']),0,3).$transaction_code;
        $no_anggaran = $post['budget_no_anggaran_used'];
        $month_budget_used = $post['budget_month_used'];
        $brand_code = $post['budget_brand_code'];
        $budget_activity = $post['budget_activity'];
        $year_budget_used = $post['budget_year_used'];
        $total_costing = $this->getTotalCostingFromTableBudgeting($no_proposal, $no_anggaran, $month_budget_used);
        $nominal_budget = $this->getNominalBudgetUsed($no_anggaran, $brand_code, $budget_activity, $month_budget_used, $year_budget_used);

        $sql = "UPDATE t_budget_activity SET nominal = $nominal_budget - $total_costing
                WHERE no_anggaran = '$no_anggaran' 
                AND brand_code = '$brand_code' 
                AND activity = '$budget_activity' 
                AND [month] = '$month_budget_used'
                AND start_year = '$year_budget_used'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgeting($id){
        $sql = "SELECT * FROM t_budgeting WHERE id = $id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanBudgetingTransaksiSaldo($post, $transaction_code, $sisaSaldo, $bulanTambahan)
    {

        $no_proposal = substr(getBrandName($post['budget_brand_code']),0,3).$transaction_code;
        $no_anggaran = $post['budget_no_anggaran_used'];
        $total_costing = $sisaSaldo;
        $month_budget_used = $bulanTambahan;
        $year_budget_used = $post['budget_year_used'];
        $budget_activity = $post['budget_activity'];
        $brand_code = $post['budget_brand_code'];
        $month_budget_value_used = $this->getMonthBudgetValueUsed($no_anggaran, $brand_code, $budget_activity, $month_budget_used, $year_budget_used);
        $costing_saldo = ($total_costing - $month_budget_value_used);

        $params = [
            'no_proposal' => $no_proposal,
            'no_anggaran' => $no_anggaran,
            'brand_code' => $brand_code,
            'total_costing' => $total_costing,
            'month_budget' => $month_budget_used,
            'month_budget_value' => $month_budget_value_used,
            'costing_saldo' => $costing_saldo,
        ];

        var_dump($params);
        die;
        $query = $this->db->insert('t_budgeting', $params);
        return $query;
    }

    public function updateBudgetActivityUsedSaldo($nominal, $no_anggaran, $brand_code, $activity, $month, $year){
        $sql = "UPDATE t_budget_activity SET nominal = '$nominal'
                WHERE no_anggaran = '$no_anggaran' 
                AND brand_code = '$brand_code' 
                AND activity = '$activity' 
                AND [month] = '$month'
                AND tahun = '$year'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetingPrepare($no_proposal){
        $sql = "SELECT * FROM t_budgeting 
                WHERE no_proposal = '$no_proposal'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function prosesBudgeting($post){

       
        $no_proposal = $post['no_proposal'];
        // var_dump($no_proposal);
        // die;
        // $no_anggaran = $post['budget_no_anggaran_used'];
        $brand_code = $post['budget_brand_code'];
        $activity = $post['budget_activity'];
        $month_used = $post['month_used'];
        $start_year = $post['budget_year_used'];
        $total_costing = $this->getTotalCosting($post['no_proposal']);
        $sisa_budget = 0;

        // var_dump($total_costing);
        // die;

        for($i = 0; $i < count($month_used); $i++){
            $code_budget = $brand_code.$start_year.$activity.$month_used[$i];
            $no_anggaran = $this->getNoAnggaran($code_budget);
            $budget = $this->getNominalBudgetUsed($no_anggaran, $brand_code, $activity, $month_used[$i], $start_year)->row();
            $nominal_budget = $budget->nominal;
            $costing_saldo = ($total_costing - $nominal_budget);

            $sisa_budget = ($nominal_budget - $total_costing);

            if($sisa_budget < 0 ){
                $sisa_budget = 0;
            }

            $budget_used = $nominal_budget - $sisa_budget;

            $params = [
                'no_proposal' => $no_proposal,
                'no_anggaran' => $no_anggaran,
                'code_budget' => $code_budget,
                'brand_code' => $brand_code,
                'activity' => $activity,
                'total_costing' => $total_costing,
                'month_budget' => $month_used[$i],
                'month_budget_value' => $nominal_budget,
                'sisa_budget' => $sisa_budget,
                'budget_used' => $budget_used,
                'costing_saldo' => $costing_saldo,
            ];

            // var_dump($params);
            // die;

            $this->db->insert('t_budgeting', $params);
            $id = $this->db->insert_id();
            $budgeting = $this->getBudgeting($id)->row();
            $costingSaldo = $budgeting->costing_saldo;
            $total_costing = $costingSaldo;
            $id_budgeting = $budgeting->id;
            $no_proposalBGT = $budgeting->no_proposal;
            $no_anggaranBGT = $budgeting->no_anggaran;
            $monthBGT = $budgeting->month_budget;
            $nominalBGT = $this->getNominalBudgetUsed($no_anggaranBGT, $brand_code, $activity, $monthBGT, $start_year)->row()->nominal;
            $totalCosting = $budgeting->total_costing;
            $nominalBGT = $sisa_budget;
            $start_yearBGT = $start_year;
            $update_budget_activity = $this->updateBudgetActivityUsedSaldo($nominalBGT, $no_anggaranBGT, $brand_code, $activity, $month_used[$i], $start_yearBGT);
        }
        
    }

    public function getPemakaianAnggaran($no_anggaran, $activity){
        // $sql = "SELECT no_proposal, SUM(budget_used) as budget_used 
        //         FROM t_budgeting 
        //         WHERE no_anggaran = '$no_anggaran'
        //         AND activity = $activity
        //         GROUP BY no_proposal";
        $no_anggaran_activty = $no_anggaran.$activity;
        $sql = "SELECT * FROM 
                (SELECT CAST(no_anggaran AS VARCHAR) + CAST (activity AS VARCHAR) AS no_anggaran_activity, 
                * FROM t_budgeting) AS bb
                WHERE no_anggaran_activity = '$no_anggaran_activty'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getDetailPemakaian($post){
        $no_proposal = $post['no_proposal'];
        $sql = "SELECT * FROM t_budgeting WHERE no_proposal = '$no_proposal'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getNoAnggaran($code_budget){
        $sql = "SELECT no_anggaran FROM t_budget_activity WHERE code_budget LIKE '%$code_budget%'";
        $query = $this->db->query($sql);
        return $query->row()->no_anggaran;
    }
}