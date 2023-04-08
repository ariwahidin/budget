<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_m extends CI_Model {
    
    public function getCodeTransaction($code_brand, $no_doc){
        $sql = "SELECT SUBSTRING(REPLACE(BrandName,' ',''),1,3) + '$no_doc' as code_transaksi FROM m_brand WHERE BrandCode = $code_brand";
        $query = $this->db->query($sql);
        return $query->row()->code_transaksi;
    }

    public function simpanTransaksiDetail($no_doc)
    {
        $code_transaksi = $this->getCodeTransaction($_POST['code_brand'], $no_doc);
        $user_id = $this->fungsi->user_login()->id;
        $sql = "INSERT INTO t_transaction_detail (code_transaksi, item_id, item_price, sales_qty, target_qty, target_value, promo, promo_value, costing_value, [user_id])
        SELECT '$code_transaksi', item_id, item_price, item_avg_sales_qty, item_target_qty_display, item_target_total, item_costing_discount, item_costing_value, item_costing_total, created_by
        FROM t_transaction_cart WHERE created_by = $user_id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanTransaksi($transaction_code)
    {
        // var_dump($_POST);
        // die;
        $from_sales = $_POST['from_sales'];
        $employee = $_POST['employee'];
        $department = $_POST['department'];
        $code_brand = $_POST['code_brand'];
        $budget_type = $_POST['budget_type'];
        $promo_type = $_POST['promo_type'];
        $start_date = date ('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date ('Y-m-d', strtotime($_POST['end_date']));
        $jenis_sales = $_POST['jenis_sales'];
        $multiple_target = $_POST['multiple_target'];
        $comment = $_POST['comment'];
        $user_id = $this->fungsi->user_login()->id;
        $no_code_transaksi = $this->getCodeTransaction($code_brand, $transaction_code);
        $sql = "INSERT INTO t_transaction (no_transaction, pic_code, department_id, brand_code, budget_type, promo_type, [start_date], end_date, jenis_sales, multiple_target, comment, from_sales, created_by)
                VALUES ('$no_code_transaksi', '$employee', $department, '$code_brand', $budget_type, $promo_type,'$start_date','$end_date','$jenis_sales', $multiple_target, '$comment', '$from_sales', $user_id)";
        $query = $this->db->query($sql);
        // var_dump($this->db->error());
        return $query;
    }

    public function simpanCustomer($no_doc, $customer){
        $user_id = $this->fungsi->user_login()->id;
        $code_transaksi = $this->getCodeTransaction($_POST['code_brand'], $no_doc);
        for($i=0; $i<count($customer); $i++){
            $params = [
                'code_transaksi' => $code_transaksi,
                'customer_id' => $customer[$i],
                'created_by' => $user_id,
            ];
            $this->db->insert('t_transaction_customer', $params);
        }
    }

    public function simpanObjective($post, $no_doc){
        $user_id = $this->fungsi->user_login()->id;
        $code_transaksi = $this->getCodeTransaction($_POST['code_brand'], $no_doc);
        foreach($post['objective'] as $obj){
            $sql = "INSERT INTO t_transaction_objective (code_transaction, objective, created_by)
            VALUES ('$code_transaksi', '$obj', $user_id)";
            $query = $this->db->query($sql);
        }
    }

    public function simpanMechanism($post, $no_doc){
        $user_id = $this->fungsi->user_login()->id;
        $code_transaksi = $this->getCodeTransaction($_POST['code_brand'], $no_doc);
        foreach($post['mechanism'] as $mech){
            $sql = "INSERT INTO t_transaction_mechanism (code_transaction, mechanism, created_by)
            VALUES ('$code_transaksi', '$mech', $user_id)";
            $query = $this->db->query($sql);
        }
    }

    public function dellCustomerSelected(){
        $user_id = $this->fungsi->user_login()->id;
        $this->db->where('user_id',$user_id);
        $this->db->delete('t_customer_selected'); 
    }

    public function dellAllCartItem(){
        $user_id = $this->fungsi->user_login()->id;
        $this->db->where('created_by',$user_id);
        $this->db->delete('t_transaction_cart'); 
    }
    
}