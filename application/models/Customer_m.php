<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_m extends CI_Model {

    // start datatables
    var $column_order = array('m_customer.id','m_customer.CustomerName','m_group.GroupName'); //set column field database for datatable orderable
    var $column_search = array('CustomerName','GroupName'); //set column field database for datatable searchable
    var $order = array('m_customer.id' => 'desc'); // default order 
    
    private function _get_datatables_query() {
        $this->db->select('*,m_customer.id as CustomerId, m_customer.CustomerName as CustomerName, m_group.GroupName as GroupName, m_group.GroupCode as GroupCode');
        $this->db->from('m_customer');
        $this->db->join('m_group', 'm_group.GroupCode = m_customer.GroupCode');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if(@$_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
            
        if(isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $this->db->from('m_customer');
        return $this->db->count_all_results();
    }

    public function get($id = null, $code_customer = null)
    {
        $sql = "SELECT *, T1.id as CustomerId, T2.GroupName as GroupName FROM m_customer T1
                INNER JOIN m_group T2 ON T1.GroupCode = T2.GroupCode";
        if($id != null)
        {
            $sql .= " WHERE T1.id = '$id'";
        }

        if($code_customer != null){
            $code_customer = implode(',', $code_customer);
            $code_customer = str_replace(",","','", $code_customer);
            $sql .= " WHERE T1.CardCode NOT IN('$code_customer')"; 
        }
        
        $query = $this->db->query($sql);
        return $query;
    }

    public function add($post)
    {
        $params = [
            'GroupCode' => $post['group_code'],
            'CustomerName' => ucwords($post['customer_name']),
            'created_by' => $post['user_id'],                               
        ];
        $this->db->insert('m_customer',$params);
    }

    public function edit($post){
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $params = [
            'GroupCode' => $post['group_code'],
            'CustomerName' => ucwords($post['customer_name']),
            'updated_by' => $post['user_id'],                               
            'updated_date' => $date->format('Y-m-d H:i:s'),                               
        ];
        $this->db->where('id',$post['customer_id']);
        $this->db->update('m_customer',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_customer');
    }
    
}