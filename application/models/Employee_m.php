<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_m extends CI_Model {

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('m_employee');
        if($id != null)
        {
            $this->db->where('id',$id);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'created_by'=>$post['user_id'],
            'namakaryawan' => strtoupper($post['employee_name']),
        ];

        // var_dump($this->db->error());
        // var_dump($params);
        // die;
        $this->db->insert('m_employee',$params);
    }

    public function edit($post)
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);

        $params = [
            'namakaryawan' => strtoupper($post['employee_name']),
            'last_modified_by' => $post['user_id'],
            'last_modified_date' => $date->format('Y-m-d H:i:s')
        ];
        $this->db->where('id',$post['employee_id']);
        $this->db->update('m_employee',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_employee');
    }
    
}