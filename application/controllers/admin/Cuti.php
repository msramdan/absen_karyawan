<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuti extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_cuti_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $cuti = $this->Tbl_cuti_model->get_all();
        $data = array(
            'cuti_data' => $cuti,
        );
        $this->template->load('template','pengguna_berlevel/cuti/tbl_cuti_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tbl_cuti_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
				
		'id' => $row->id,
		'users_id' => $row->users_id,
		'tanggal_mulai' => $row->tanggal_mulai,
		'tanggal_akhir' => $row->tanggal_akhir,
		'alasan' => $row->alasan,
		'status' => $row->status,
	    );
            $this->template->load('template','pengguna_berlevel/cuti/tbl_cuti_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(levelUser($this->session->userdata('level')).'cuti'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => 'create_action',
	    'id' => set_value('id'),
	    'users_id' => set_value('users_id'),
	    'tanggal_mulai' => set_value('tanggal_mulai'),
	    'tanggal_akhir' => set_value('tanggal_akhir'),
	    'alasan' => set_value('alasan'),
	);
        $this->template->load('template','pengguna_berlevel/cuti/tbl_cuti_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'users_id' => $this->input->post('users_id',TRUE),
				'tanggal_mulai' => $this->input->post('tanggal_mulai',TRUE),
				'tanggal_akhir' => $this->input->post('tanggal_akhir',TRUE),
				'alasan' => $this->input->post('alasan',TRUE),
				'status' => null,
			);

            $this->Tbl_cuti_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(levelUser($this->session->userdata('level')).'/cuti');
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_cuti_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => levelUser($this->session->userdata('level')).'/cuti/update_action',
				'id' => set_value('id', $row->id),
				'users_id' => set_value('users_id', $row->users_id),
				'tanggal_mulai' => set_value('tanggal_mulai', $row->tanggal_mulai),
				'tanggal_akhir' => set_value('tanggal_akhir', $row->tanggal_akhir),
				'alasan' => set_value('alasan', $row->alasan),
	    );
            $this->template->load('template','pengguna_berlevel/cuti/tbl_cuti_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(levelUser($this->session->userdata('level')).'cuti');
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
			$this->update(encrypt_url($this->input->post('id', TRUE)));
        } else {
            $data = array(
				'users_id' => $this->input->post('users_id',TRUE),
				'tanggal_mulai' => $this->input->post('tanggal_mulai',TRUE),
				'tanggal_akhir' => $this->input->post('tanggal_akhir',TRUE),
				'alasan' => $this->input->post('alasan',TRUE),
	    	);

            $this->Tbl_cuti_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(levelUser($this->session->userdata('level')).'/cuti');
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_cuti_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Tbl_cuti_model->delete(decrypt_url($id));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(levelUser($this->session->userdata('level')).'cuti');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(levelUser($this->session->userdata('level')).'cuti');
        }
    }

	public function get_user_by_name_or_username() {
		$keyword = $this->input->get('q');
		$data = $this->Tbl_cuti_model->get_user_by_name_or_username($keyword);

		$output = [
			'data' => [],
			'more' => false,
		];

		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$output['data'][] = [
					'id' => $value->id,
					'text' => $value->nama_lengkap . ' - ' . $value->username,
				];
			}
		}

		echo json_encode($output);
	}

    public function _rules() 
    {
	$this->form_validation->set_rules('users_id', 'users id', 'trim|required');
	$this->form_validation->set_rules('tanggal_mulai', 'tanggal mulai', 'trim|required');
	$this->form_validation->set_rules('tanggal_akhir', 'tanggal akhir', 'trim|required');
	$this->form_validation->set_rules('alasan', 'alasan', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Cuti.php */
/* Location: ./application/controllers/Cuti.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-01-31 10:12:53 */
/* http://harviacode.com */
