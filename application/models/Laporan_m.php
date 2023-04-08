<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_m extends CI_Model {

    public function getTransaksi($no_doc = null, $brand_id = null)
    {
        $sql ="SELECT t_transaction.id as transaction_id,
                        t_transaction.no_transaction as no_doc,
                        t_transaction.comment as comment,
                        t_transaction.jenis_sales as sales_type,
                        m_employee.namakaryawan as pic,
                        users.nama as username,
                        m_department.department_name as department_name,
                        m_brand.BrandName as brand_name,
                        m_promo.promo_name as promo_name,
                        m_budget.budget_name as budget_name,
                        t_transaction.created_date as transaction_date,
                        t_transaction.[start_date] as [start_date],
                        t_transaction.end_date as end_date
                FROM t_transaction
                INNER JOIN m_employee ON t_transaction.pic_code = m_employee.nik
                INNER JOIN m_department ON t_transaction.department_id = m_department.id
                INNER JOIN users ON t_transaction.created_by = users.id
                INNER JOIN m_brand ON t_transaction.brand_code = m_brand.BrandCode
                INNER JOIN m_promo ON t_transaction.promo_type = m_promo.id
                INNER JOIN m_budget ON t_transaction.budget_type = m_budget.id";
        if($no_doc != null){
            $sql .= " WHERE t_transaction.no_transaction = '$no_doc'";
        }else if($brand_id != null){
            $sql .= " WHERE t_transaction.brand_code = '$brand_id'";
        }
        $sql .= " ORDER BY t_transaction.id DESC";
        $query = $this->db->query($sql);
        // echo $this->db->last_query();
        return $query;
    }

    public function getCustomer($no_doc = null){

        $sql ="SELECT m_customer.CustomerName as customer_name FROM t_transaction_customer
        INNER JOIN m_customer ON t_transaction_customer.customer_id = m_customer.CardCode";

        if($no_doc != null){
            $sql .= " WHERE code_transaksi = '$no_doc'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function getObjective($no_doc = null){
        $sql = "SELECT * FROM t_transaction_objective";
        if($no_doc != null){
            $sql .= " WHERE code_transaction = '$no_doc'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMechanism($no_doc = null){
        $sql = "SELECT * FROM t_transaction_mechanism";
        if($no_doc != null){
            $sql .= " WHERE code_transaction = '$no_doc'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTransactionDetail($no_doc = null){
        $sql = "SELECT m_item.ItemName as item_name,
                        m_item.FrgnName as barcode,
                        t_transaction_detail.item_price as item_price,
                        t_transaction_detail.sales_qty as sales,
                        t_transaction_detail.target_qty as [target],
                        t_transaction_detail.target_value as target_value,
                        t_transaction_detail.promo as promo,
                        t_transaction_detail.promo_value as promo_value,
                        t_transaction_detail.costing_value as costing_value
                FROM t_transaction_detail
                INNER JOIN m_item ON t_transaction_detail.item_id = m_item.ItemCode";
        if($no_doc != null){
            $sql .= " WHERE t_transaction_detail.code_transaksi = '$no_doc'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTotalTarget($no_doc){
        $sql = "SELECT SUM(t_transaction_detail.target_value) as total_target
                FROM t_transaction_detail
                INNER JOIN m_item ON t_transaction_detail.item_id = m_item.ItemCode
                WHERE t_transaction_detail.code_transaksi = '$no_doc'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTotalCosting($no_doc){
        $sql = "SELECT SUM(t_transaction_detail.costing_value) as total_costing
                FROM t_transaction_detail
                INNER JOIN m_item ON t_transaction_detail.item_id = m_item.ItemCode
                WHERE t_transaction_detail.code_transaksi = '$no_doc'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function hapusProposal($no_doc){
        $this->db->where('no_transaction', $no_doc);
        $this->db->delete('t_transaction');
        
        if($this->db->affected_rows() > 0){
            $this->db->where('code_transaksi', $no_doc);
            $this->db->delete('t_transaction_customer');

            if($this->db->affected_rows() > 0){
                $this->db->where('code_transaksi', $no_doc);
                $this->db->delete('t_transaction_detail');
                if($this->db->affected_rows() > 0){
                    $this->db->where('code_transaction', $no_doc);
                    $this->db->delete('t_transaction_mechanism');
                    if($this->db->affected_rows() > 0){
                        $this->db->where('code_transaction', $no_doc);
                        $this->db->delete('t_transaction_objective');
                        if($this->db->affected_rows() > 0){
                            echo "<script>window.location='".site_url('proposalData')."';</script>";
                        }
                    }
                }
            }
        }
    }
    
}