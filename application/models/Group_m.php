<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_m extends CI_Model {

    public function get($id = null,$code = null)
    {
        $this->db->select('*');
        $this->db->from('m_group');
        if($id != null)
        {
            $this->db->where('m_group.id',$id);
        }
        if($code != null)
        {
            $this->db->where('m_group.GroupCode',$code);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'GroupCode'=>$post['group_code'],
            'GroupName' => strtoupper($post['group_name']),
            'GroupType' => null,
            'created_by'=>$post['user_id'],
        ];
        $this->db->insert('m_group',$params);
    }

    public function edit($post)
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        
        $params = [
            'GroupName' => strtoupper($post['group_name']),
            'updated_by' => $post['user_id'],
            'updated_date' => $date->format('Y-m-d H:i:s')
        ];
        $this->db->where('id',$post['group_id']);
        $this->db->update('m_group',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_group');
    }
    
}