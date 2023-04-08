<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class import_m extends CI_Model{

    function addData($data){
        // var_dump($data);
        for($i = 0 ; $i < count($data); $i++){
            $params = [
                'noinduk' => $data[$i][0],
                'nama' => $data[$i][1],
                'hobi' => $data[$i][2],
                'alamat' => $data[$i][3],
            ];
            // var_dump($params);
            $this->db->insert('t_siswa', $params);
        }
    }

}