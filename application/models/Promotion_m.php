<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_m extends CI_Model {

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('m_promo');
        if($id != null){
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post){
        $params = array(
            'promo_name' => ucwords($post['promo_name']),
            'created_by' => $post['user_id'],
        );
        $this->db->insert('m_promo',$params);
    }

    public function edit($post)
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $params = [
            'promo_name' => ucwords($post['promo_name']),
            'updated_by' => $post['user_id'],
            'updated_date' => $date->format('Y-m-d H:i:s')
        ];
        $this->db->where('id',$post['promo_id']);
        $this->db->update('m_promo',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_promo');
    }

    // public function addPromoSelected($post)
	// {
    //     foreach($post as $value){
    //         $data = array(
    //             'sale_id' => $value['sale_id'],
    //             'promo_id' => $value['promo_id'],
    //             'created_by' =>$this->session->userdata('user_id')
    //         );
    //         $this->db->insert('t_promo_selected', $data);
    //     }
    // }


    
    // public function add_selected_promo($post)
    // {
    //     $params = [
    //                 'promo_id'=>$post['promo_id'],
    //                 'promo_name' => $post['promo_name'],
    //                 'user_id' => $this->session->userdata('user_id')
    //             ];
    //             $this->db->insert('t_promo_selected',$params);
    // }

    // public function get_promo_selected()
    // {
    //     $this->db->select('*');
    //     $this->db->from('t_promo_selected');
    //     $this->db->where('user_id', $this->session->userdata('user_id'));
    //     $query = $this->db->get();
    //     return $query;
    // }

    // public function del_promo_selected($params = null)
    // {
    //     if($params != null){
    //         $this->db->where('sid',$params);
    //     }
    //     $this->db->delete('t_promo_selected');
    // }

    
		
		// if($this->db->affected_rows() > 0){
		// 	echo "berhasil";
		// }else{
		// 	echo "gagal";
		// }
	// }




    
}