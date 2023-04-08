<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login_m');
    }

    public function index()
    {
        $this->load->view('index_v');
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            $cek_username = $this->login_m->cek_username($post);
            $cek_password = $this->login_m->cek_password($post);

            if ($cek_username == false) {
                echo "<script>
                	alert('Login gagal, username salah');
                	window.location='" . site_url('login') . "';
                </script>";
            } else if ($cek_password == false) {
?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location = "<?= site_url('login') ?>"
                    })
                </script>


<?php
            } else {
                $level = $this->cek_level($post);
                redirect(base_url($level));
            }
        } else {
            echo "Tidak ada post";
        }
    }

    public function cek_level($post)
    {
        $level = $this->login_m->cek_level($post);
        return $level;
    }
}
