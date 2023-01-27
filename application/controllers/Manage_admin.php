<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Manage_admin_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $manage_admin = $this->Manage_admin_model->get_all();
        $data = array(
            'manage_admin_data' => $manage_admin,
        );
        $this->template->load('template','manage_admin/tbl_admin_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Manage_admin_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
				
		'id' => $row->id,
		'username' => $row->username,
		'password' => $row->password,
		'level' => $row->level,
		'photo' => $row->photo,
	    );
            $this->template->load('template','manage_admin/tbl_admin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manage_admin'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('manage_admin/create_action'),
			'id' => set_value('id'),
			'username' => set_value('username'),
			'password' => set_value('password'),
			'level' => set_value('level'),
			'photo' => set_value('photo'),
		);
        $this->template->load('template','manage_admin/tbl_admin_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'username' => $this->input->post('username',TRUE),
				'password' => $this->input->post('password',TRUE),
				'level' => $this->input->post('level',TRUE),
				'photo' => $this->input->post('photo',TRUE),
	    	);

			$photo = 'default.jpg';

			if(!empty($_FILES['foto']['name']))
			{
				$config['upload_path']      = './assets/assets/img/user';
				$config['allowed_types']    = 'jpg|png|jpeg';
				$config['max_size']         = 10048;
				$config['file_name']        = 'File-' . date('ymd') . '-' . substr(sha1(rand()), 0, 10);
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload("foto");
				$dataphoto = $this->upload->data();
				$photo = $dataphoto['file_name'];
				$data['photo'] = $photo;
			}


            $this->Manage_admin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('manage_admin'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Manage_admin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('manage_admin/update_action'),
		'id' => set_value('id', $row->id),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'level' => set_value('level', $row->level),
		'photo' => set_value('photo', $row->photo),
	    );
            $this->template->load('template','manage_admin/tbl_admin_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manage_admin'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
			$this->update(encrypt_url($this->input->post('id', TRUE)));
        } else {
            $data = array(
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
		'level' => $this->input->post('level',TRUE),
		'photo' => $this->input->post('photo',TRUE),
	    );

            $this->Manage_admin_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('manage_admin'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Manage_admin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Manage_admin_model->delete(decrypt_url($id));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('manage_admin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manage_admin'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('level', 'level', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Manage_admin.php */
/* Location: ./application/controllers/Manage_admin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-01-27 03:32:46 */
/* http://harviacode.com */
