<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends EASY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('model_authentication');
		date_default_timezone_set('Asia/Jakarta');
	}

	function index(){
		$this->auth->restrict(TRUE);
		$this->load->view('authentication/vauthentication');
	}

	function plogin(){
		$this->auth->restrict(TRUE);

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$username = strtolower($username);
		$password = sha1(md5(sha1('2021'.$password.'easyco')));

		$confirm = TRUE;

		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');

		if($this->form_validation->run() == FALSE){
			$result = array(
				'status' => 'failed',
				'message' => validation_errors()
			);
		}

		if($confirm == TRUE){
			// CHECK ACCOUNT
			$check = $this->model_authentication->getloginbypass($username,$password);

			$count = count($check);

			if($count > 0){
				$id_user = $check['id_user'];
				$id_group = $check['id_group'];
				$name = $check['nama_pgw'];
				$occupation = $check['jabatan'];
				$email = $check['email'];
				$username = $check['nama_user'];
				$photo = $check['photo'];
				$branch_code = $check['kode_cabang'];
				$branch_name = $check['nama_cabang'];
	
				$this->session->set_userdata('islogged',TRUE);
				$this->session->set_userdata('id',$id_user);
				$this->session->set_userdata('id_group',$id_group);
				$this->session->set_userdata('name',$name);
				$this->session->set_userdata('occupation',$occupation);
				$this->session->set_userdata('email',$email);
				$this->session->set_userdata('username',$username);
				$this->session->set_userdata('photo',$photo);
				$this->session->set_userdata('branch_code',$branch_code);
				$this->session->set_userdata('branch_name',$branch_name);

				$result = array(
					'status' => 'success',
					'message' => 'Login Sukses! Selamat Datang'
				);
			} else {
				$result = array(
					'status' => 'failed',
					'message' => 'Username dan Password tidak ditemukan'
				);
			}
		}

		echo json_encode($result);
	}

	function logout(){
		$this->auth->restrict();

		$this->session->sess_destroy();

		redirect(base_url());
	}
}
