<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['auth_model']);
    }

    public function index(){
        redirect(base_url('auth/login'));
    }

    public function login()
    {
        $this->load->view('index_v');
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        $login = $this->auth_model->cek_user($post);

        if ($login->num_rows() > 0) {
            $usercode = $login->row()->user_code;
            $username = $login->row()->username;
            $fullname = $login->row()->fullname;
            $page = $login->row()->page;
            $access_role = $login->row()->access_role;
            $level = $login->row()->level;
            $params = array(
                'user_code' => $usercode,
                'username' => $username,
                'fullname' => $fullname,
                'page' => $page,
                'access_role' => $access_role,
                'level' => $level
            );

            $this->session->set_userdata($params);
            $toPage = decrypt($this->input->post('page'));

            if ($toPage == "") {
                $toPage = $page;
            }

            $response = array(
                'success' => true,
                'page' => $toPage
            );
        } else {
            $response = array(
                'success' => false
            );
        }

        echo json_encode($response);
    }

    public function logout()
    {
        $params = array('user_code', 'username', 'fullname', 'page', 'access_role', 'level');
        $this->session->unset_userdata($params);
        redirect('auth/login');
    }
}
