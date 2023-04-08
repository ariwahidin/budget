<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet_m extends CI_Model {

    public function get($id = null)
    {
        $this->db->from('t_outlet_selected');
        if($id != null)
        {
            $this->db->where('id',$id);
        }
        $query = $this->db->get();
        return $query;
    }
}