<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['auth_model']);
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

            if (isset($_POST['urlProposalForKam'])) {
                if ($_POST['urlProposalForKam'] != "") {
                    redirect(base_url($_POST['urlProposalForKam']));
                } else {
                    redirect(base_url($page));
                }
            } else {
                redirect(base_url($page));
            }
        } else {

?>
            <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css">
            <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/animate.min.css">
            <style>
                body {
                    font-family: "Helvetica Neue", Helvetica, Arial, Helvetica, sans-serif;
                    font-size: 1.124em;
                    font-weight: normal;
                }
            </style>

            <body></body>
            <?php

            ?>


            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location = "<?= site_url('auth/login') ?>"
                })
            </script>


<?php
        }
    }

    public function logout()
    {
        $params = array('user_code', 'username', 'fullname', 'page', 'access_role', 'level');
        $this->session->unset_userdata($params);
        redirect('auth/login');
    }
}
