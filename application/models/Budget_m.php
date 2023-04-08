<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget_m extends CI_Model {

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('m_budget');
        if($id != null)
        {
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'budget_name' => strtoupper($post['budget_name']),
            'created_by'=>$post['user_id'],
        ];
        $this->db->insert('m_budget',$params);
    }

    public function edit($post)
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);

        $params = [
            'budget_name' => strtoupper($post['budget_name']),
            'updated_by'=>$post['user_id'],
            'updated_date' => $date->format('Y-m-d H:i:s')
        ];
        $this->db->where('id',$post['budget_id']);
        $this->db->update('m_budget',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_budget');
    }

    public function get_budget_used($data){

        // die;

        $params = $data['code_brand'].$data['tahun'].$data['activity'];
        $sql = "SELECT * FROM t_budget_activity WHERE code_budget LIKE  '%$params%' AND nominal != 0";
        if (!empty($data['month'])){
            $month = implode(',',$data['month']);
            $sql .= "AND [month] NOT IN ($month)";
        }
        $query = $this->db->query($sql);
        return $query;
    }
    
}