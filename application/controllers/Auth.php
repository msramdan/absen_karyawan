<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function index()
	{
		check_already_login();
		$this->load->view('login');
	}


	public function profile()
	{
		$this->template->load('template', 'profile');
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if (isset($post['login'])) {
			$this->load->model('Auth_model');
			$query = $this->Auth_model->login($post);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$params = array(
					'userid' => $row->id,
					'level' => isset($row->level) ?? 4
				);
				
				$this->load->helper('fungsi');
				$levelusernya = levelUser($params['level']);

				if($levelusernya == 'karyawan') {
					$params['lapangan_id'] = cek_asal_lapangan($params['userid']);
				}

				$this->session->set_userdata($params);
				echo "<script>window.location='". site_url($levelusernya.'/dashboard') ."'</script>";
			} else {
				$this->session->set_flashdata('gagal', 'Login gagal, username atau password salah');
				redirect(site_url('auth'));
			}
		}
	}

	public function logout()
	{
		$params = array('userid', 'level');
		$this->session->unset_userdata($params);
		redirect('auth');
	}

	public function edit_profil($id)
	{
		$data = array(
			'name'            => $this->input->post('name', true),
			'address'         => $this->input->post('address', true),
			'email'         => $this->input->post('email', true),
		);
		$this->Auth_model->ubah_data($data, $id);
		echo "<script> alert('Data Berhasil diupdate')</script>";
		echo "<script>window.location='" . site_url('auth/profile') . "'</script>";
	}

	public function edit_password($id)
	{
		if (sha1($this->input->post('lama')) == $this->fungsi->user_login()->password) {
			$data = array(
				'password'          => sha1($this->input->post('password', true)),
			);
			$this->Auth_model->ubah_data($data, $id);
			echo "<script> alert('Data Password Berhasil diupdate')</script>";
			echo "<script>window.location='" . site_url('auth/logout') . "'</script>";
		} else {
			echo "<script> alert('Password Lama Salah')</script>";
			echo "<script>window.location='" . site_url('auth/profile') . "'</script>";
		}
	}
}
