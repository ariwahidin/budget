<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

	public function login($post)
    {
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username',$post['username']);
        $this->db->where('password',$post['password']);
        $query = $this->db->get();
        return $query;
    }

    // public function checkStatusLogin($post){
    //     $id_user = $post->row()->id;
    //     $sql = "SELECT * FROM t_login WHERE id_user = '$id_user' AND [status] = '1'";
    //     $query = $this->db->query($sql);
    //     $login = false;
    //     if ($query->num_rows() == 0){
    //         $params = [
    //             'id_user' => $id_user,
    //             'status' => 1,
    //         ];
    //         $login = $this->db->insert('t_login', $params);
    //     }
    //     return $login;
    // }

    public function get($user_code = null)
    {   
        $this->db->from('master_user');
        if($user_code != null){
            $this->db->where('user_code',$user_code);
        }
        $query = $this->db->get();
        return $query;
    }
	
    // public function add($post)
    // {
    //     $brand = implode(',',$post['brand']);
    //     $params['nik'] = "";
    //     $params['nama'] = $post['fullname'];
    //     $params['username'] = $post['username'];
    //     $params['password'] = md5($post['password']);
    //     // $params['alamat'] = $post['address'] != "" ? $post['address'] : null;
    //     $params['telepon'] = "";
    //     $params['level'] = $post['level'];
    //     $params['user_brand'] = $brand;
    //     $params['foto'] = "";

    //     // var_dump($params);
    //     // die;
        
    //     $this->db->insert('users',$params);
    // }

    // public function edit($post)
    // {
    //     $params['nik'] = "";
    //     $params['nama'] = $post['fullname'];
    //     $params['username'] = $post['username'];
    //     if(!empty($post['password']))
    //     {
    //         $params['password'] = md5($post['password']);
    //     }
    //     $params['alamat'] = $post['address'] != "" ? $post['address'] : null;
    //     $params['telepon'] = "";
    //     $params['level'] = $post['level'];
    //     $params['foto'] = "";
    //     $this->db->where('id', $post['user_id']);
    //     $this->db->update('users',$params);
    // }

    // public function del($id)
    // {
    //  $this->db->where('id',$id);
    //  $this->db->delete('users');   
    // }


    public function insertUser($post){
        $user_code = $this->getUserCode();
        $params = [
            'user_code' => $user_code,
            'username' => $post['username'],
            'fullname' => $post['fullname'],
            'password' => $post['password'],
            'level' => $post['level'],
        ];
        $this->db->insert('master_user', $params);
        // var_dump($params);
    }

    public function getUserCode(){
        $sql = "SELECT SUBSTRING(MAX(user_code), 3, 3) as user_code FROM master_user";
        $query = $this->db->query($sql);
        if($query -> num_rows() > 0){
            $n = $query->row()->user_code;
            $n = (int)$n + 1;
            $no = sprintf("%'.03d", $n);
        }else{
            $no = '001';
        }
        $user_code = 'PK'.$no;
        return $user_code;
    }
}
