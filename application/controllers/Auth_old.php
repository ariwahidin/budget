<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

		public function login()
	{
		check_already_login();
		$this->load->view('login');
	}

	public function process(){
		$post = $this->input->post(null, TRUE);
		if(isset($post['login'])){
			$this->load->model('user_m');
			$query = $this->user_m->login($post);
			if($query->num_rows()>0){
				$row = $query->row();
				$params = array(
					'user_code' => $row->user_code,
					'level' => $row->level
				);
				$this->session->set_userdata($params);
				echo "<script>
					alert('Selamat, login berhasil');
					window.location='".site_url('dashboard')."';
				</script>";
			}else {
				echo "<script>
				alert('Login gagal, username/password salah');
				window.location='".site_url('auth/login')."';
			</script>";
			}
		}else{
			echo "Tidak ada post";
		}
	}

	public function logout()
	{
		$params = array('user_code','level');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}
