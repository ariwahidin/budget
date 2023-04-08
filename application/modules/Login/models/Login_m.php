<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {

    public function cek_username($post){
        $username = $post['username'];
        $sql = "SELECT * FROM master_user where username = '$username'";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function cek_password($post){
        $password = $post['password'];
        $sql = "SELECT * FROM master_user where [password] = '$password'";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function cek_level($post){
        $username = $post['username'];
        $password = $post['password'];
        $sql = "SELECT t1.username as username, t2.[level] as [level] FROM [master_user] t1 
                INNER JOIN [master_level] t2 ON t1.[level] = t2.[id] 
                WHERE t1.username = '$username' AND t1.[password] = '$password'";
        $query = $this->db->query($sql)->row()->level;
        return $query;
    }

}