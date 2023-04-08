<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class department_m extends CI_Model {

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('m_department');
        if($id != null)
        {
            $this->db->where('id',$id);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query;
    }

    // public function add($post)
    // {
    //     $params = [
    //         'BrandCode' =>(int)$post['brand_code'],
    //         'Created'=>$post['user_id'],
    //         'BrandName' => strtoupper($post['brand_name']),
    //     ];

    //     // var_dump($this->db->error());
    //     // var_dump($params);
    //     // die;
    //     $this->db->insert('m_brand',$params);
    // }

    // public function edit($post)
    // {
    //     $timezone = new DateTimeZone('Asia/Jakarta');
    //     $date = new DateTime();
    //     $date->setTimeZone($timezone);

    //     $params = [
    //         'BrandName' => strtoupper($post['brand_name']),
    //         'Updated' => $post['user_id'],
    //         'UpdatedDate' => $date->format('Y-m-d H:i:s')
    //     ];
    //     $this->db->where('id',$post['brand_id']);
    //     $this->db->update('m_brand',$params);
    // }

    // public function del($id)
    // {
    //     $this->db->where('id', $id);
    //     $this->db->delete('m_brand');
    // }
    
}