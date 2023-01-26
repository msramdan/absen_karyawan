<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('User_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$user = $this->User_model->get_all();
		$data = array(
			'user_data' => $user,
		);
		$this->template->load('template', 'user/user_list', $data);
	}

	public function edit_profile()
	{
		$row = $this->User_model->get_by_id($this->session->userdata('userid'));
		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('user/update_profile'),
				'id' => set_value('id', $row->id),
				'level' => set_value('level', $row->level),
				'username' => set_value('username', $row->username),
				'photo' => set_value('photo', $row->photo),
			);
			$this->template->load('template', 'user/edit_profile', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('dashboard'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('user/create_action'),
			'id' => set_value('id'),
			'username' => set_value('username'),
			'password' => set_value('password'),
			'level' => set_value('level'),
			'photo' => set_value('photo'),
		);
		$this->template->load('template', 'user/user_form', $data);
	}

	public function create_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {

			$config['upload_path']      = './assets/assets/img/user';
			$config['allowed_types']    = 'jpg|png|jpeg';
			$config['max_size']         = 10048;
			$config['file_name']        = 'File-' . date('ymd') . '-' . substr(sha1(rand()), 0, 10);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("photo");
			$data = $this->upload->data();

			$photo = $data['file_name'];


			$data = array(
				'username' => $this->input->post('username', TRUE),
				'password' => sha1($this->input->post('password', TRUE)),
				'level' => $this->input->post('level', TRUE),
				'photo' => $photo,

			);

			$this->User_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('user'));
		}
	}

	public function update($id)
	{
		$row = $this->User_model->get_by_id($id);
		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('user/update_action'),
				'id' => set_value('id', $row->id),
				'username' => set_value('username', $row->username),
				'password' => set_value('password', $row->password),
				'level' => set_value('level', $row->level),
				'photo' => set_value('photo', $row->photo),
			);
			$this->template->load('template', 'user/user_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('user'));
		}
	}

	public function update_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id', TRUE));
		} else {

			$config['upload_path']      = './assets/assets/img/user';
			$config['allowed_types']    = 'jpg|png|jpeg|gif';
			$config['max_size']         = 10048;
			$config['file_name']        = 'File-' . date('ymd') . '-' . substr(sha1(rand()), 0, 10);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload("photo")) {
				$id = $this->input->post('id');
				$row = $this->User_model->get_by_id($id);
				$data = $this->upload->data();
				$photo = $data['file_name'];
				if ($row->photo == null || $row->photo == '') {
				} else {

					$target_file = './assets/assets/img/user/' . $row->photo;
					unlink($target_file);
				}
			} else {
				$photo = $this->input->post('photo_lama');
			}

			if ($this->input->post('password') == '' || $this->input->post('password') == null) {
				$data = array(
					'username' => $this->input->post('username', TRUE),
					'level' => $this->input->post('level', TRUE),
					'photo' => $photo,
				);
			} else {
				$data = array(
					'username' => $this->input->post('username', TRUE),
					'password' => sha1($this->input->post('password', TRUE)),
					'level' => $this->input->post('level', TRUE),
					'photo' => $photo,
				);
			}



			$this->User_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('user'));
		}
	}

	public function delete($id)
	{
		$row = $this->User_model->get_by_id($id);

		if ($row) {
			if ($row->photo == null || $row->photo == '') {
			} else {
				$target_file = './assets/assets/img/user/' . $row->photo;
				unlink($target_file);
			}

			$this->User_model->delete($id);
			$error = $this->db->error();
			if ($error['code'] != 0) {
				$this->session->set_flashdata('error', 'Tidak dapat dihapus data sudah berrelasi');
			} else {
				$this->session->set_flashdata('message', 'Delete Record Success');
			}
			redirect(site_url('user'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('user'));
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		// $this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('level', 'level id', 'trim|required');
		$this->form_validation->set_rules('photo', 'photo', 'trim');
		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	public function download($gambar)
	{
		force_download('assets/assets/img/user/' . $gambar, NULL);
	}


	public function update_profile()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id', TRUE));
		} else {

			$config['upload_path']      = './assets/assets/img/user';
			$config['allowed_types']    = 'jpg|png|jpeg|gif';
			$config['max_size']         = 10048;
			$config['file_name']        = 'File-' . date('ymd') . '-' . substr(sha1(rand()), 0, 10);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload("photo")) {
				$id = $this->input->post('id');
				$row = $this->User_model->get_by_id($id);
				$data = $this->upload->data();
				$photo = $data['file_name'];
				if ($row->photo == null || $row->photo == '') {
				} else {

					$target_file = './assets/assets/img/user/' . $row->photo;
					unlink($target_file);
				}
			} else {
				$photo = $this->input->post('photo_lama');
			}

			if ($this->input->post('password') == '' || $this->input->post('password') == null) {
				$data = array(
					'username' => $this->input->post('username', TRUE),
					'level' => $this->input->post('level', TRUE),
					'photo' => $photo,
				);
			} else {
				$data = array(
					'username' => $this->input->post('username', TRUE),
					'password' => sha1($this->input->post('password', TRUE)),
					'level' => $this->input->post('level', TRUE),
					'photo' => $photo,
				);
			}

			$this->User_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('user/edit_profile'));
		}
	}
}
