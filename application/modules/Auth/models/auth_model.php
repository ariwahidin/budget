<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function cek_user($post)
    {   
        $username = $post['username'];
        $password = $post['password'];
        $sql = "SELECT * FROM master_user WHERE username = '$username' AND [password] = '$password'";
        $query = $this->db->query($sql);
        return $query;
    }
}
