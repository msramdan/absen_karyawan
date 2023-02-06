<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Izin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_izin_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $izin = $this->Tbl_izin_model->get_all();
        $data = array(
            'izin_data' => $izin,
        );
        $this->template->load('template','pengguna_berlevel/izin/tbl_izin_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tbl_izin_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
				
		'id' => $row->id,
		'users_id' => $row->users_id,
		'tanggal' => $row->tanggal,
		'alasan' => $row->alasan,
		'status' => $row->status,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
	    );
            $this->template->load('template','pengguna_berlevel/izin/tbl_izin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(levelUser($this->session->userdata('level')).'/izin'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(levelUser($this->session->userdata('level')).'/izin/create_action'),
	    'id' => set_value('id'),
	    'users_id' => set_value('users_id'),
	    'tanggal' => set_value('tanggal'),
	    'alasan' => set_value('alasan'),
	    'status' => set_value('status'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	);
        $this->template->load('template','pengguna_berlevel/izin/tbl_izin_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
			$user_id = $this->input->post('users_id',TRUE);
			$tanggal = date('Y-m-d', strtotime($this->input->post('tanggal',TRUE)));
			
			$apakahAdaDataDitanggalSegitu = apakahDataIzinAda($tanggal, $user_id);
			if ($apakahAdaDataDitanggalSegitu == 'ada') {
				$this->session->set_flashdata('error', 'Tidak dapat menyimpan pada tanggal tersebut karena Data Izin/Absen Sudah Ada');
				$this->create();
				return;
			}

            $data = array(
				'users_id' => $this->input->post('users_id',TRUE),
				'tanggal' => date('Y-m-d', strtotime($tanggal)),
				'alasan' => $this->input->post('alasan',TRUE),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

            $this->Tbl_izin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(levelUser($this->session->userdata('level')).'/izin');
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_izin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(levelUser($this->session->userdata('level')).'/izin/update_action'),
		'id' => set_value('id', $row->id),
		'users_id' => set_value('users_id', $row->users_id),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'alasan' => set_value('alasan', $row->alasan),
		'status' => set_value('status', $row->status),
		'created_at' => set_value('created_at', $row->created_at),
		'updated_at' => set_value('updated_at', $row->updated_at),
	    );
            $this->template->load('template','pengguna_berlevel/izin/tbl_izin_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(levelUser($this->session->userdata('level')).'/izin');
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
			$this->update(encrypt_url($this->input->post('id', TRUE)));
        } else {
			$user_id = $this->input->post('users_id',TRUE);
			$tanggal = date('Y-m-d', strtotime($this->input->post('tanggal',TRUE)));
			
			$apakahAdaDataDitanggalSegitu = apakahDataIzinAda($tanggal, $user_id);
			if ($apakahAdaDataDitanggalSegitu == 'ada') {
				$this->session->set_flashdata('error', 'Tidak dapat menyimpan pada tanggal tersebut karena Data Izin/Absen Sudah Ada');
				$this->create();
				return;
			}

            $data = array(
				'users_id' => $this->input->post('users_id',TRUE),
				'tanggal' => date('Y-m-d', strtotime($tanggal)),
				'alasan' => $this->input->post('alasan',TRUE),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

            $this->Tbl_izin_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(levelUser($this->session->userdata('level')).'/izin');
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_izin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Tbl_izin_model->delete(decrypt_url($id));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(levelUser($this->session->userdata('level')).'/izin');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(levelUser($this->session->userdata('level')).'/izin');
        }
    }

	public function update_status($id_users, $status) {

		$data = [
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
		];

		$this->Tbl_izin_model->update($id_users, $data);

		$this->session->set_flashdata('message', 'Update Record Success');
		redirect(levelUser($this->session->userdata('level')).'/izin');
	}

    public function _rules() 
    {
	$this->form_validation->set_rules('users_id', 'users id', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('alasan', 'alasan', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Izin.php */
/* Location: ./application/controllers/Izin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-02-03 09:11:05 */
/* http://harviacode.com */