<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('fungsi');
		is_login();
	}

	public function index()
	{
		$this->template->load('template', 'pengguna_berlevel/dashboard');
	}

	public function get_list_location_lapangan_count_users() {
		$query = 'SELECT 
			tbl_lapangan.id as lapangan_id,
			tbl_lapangan.nama_lapangan as nama_lapangan,
			tbl_lapangan.latitude as latitude,
			tbl_lapangan.longitude as longitude,
			(SELECT COUNT(*) FROM tbl_penempatan_karyawan WHERE id_lapangan = tbl_lapangan.id) AS jumlah
			FROM tbl_lapangan';

		$data = $this->db->query($query)->result_array();


		echo json_encode($data);
	}
}
