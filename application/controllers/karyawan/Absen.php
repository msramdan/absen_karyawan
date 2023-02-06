<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('fungsi');
		is_login();
	}

	public function index()
	{
		$apakahAdaAbsenOrangIniHariIni = $this->db->query("SELECT * FROM tbl_absensi WHERE users_id = '".$this->session->userdata('userid')."' AND DATE(tanggal) = CURDATE()");

		$actionAbsen = null;

		$adaabsenapaenggak = null;

		if($apakahAdaAbsenOrangIniHariIni->num_rows() == false || $apakahAdaAbsenOrangIniHariIni->num_rows() == 0) {
			$adaabsenapaenggak = false;
			$actionAbsen = 'Masuk';
		}

		if($apakahAdaAbsenOrangIniHariIni->num_rows() == 1) {
			$adaabsenapaenggak = true;
			$actionAbsen = 'Keluar';
		}

		if($apakahAdaAbsenOrangIniHariIni->num_rows() >= 2) {
			$adaabsenapaenggak = null;
			$actionAbsen = 'Sudah Absen';
		}

		$data = [
			'lapangan_id' => cek_asal_lapangan($this->session->userdata('userid')),
			'masukataupulang' => $actionAbsen,
		];
		$this->template->load('template', 'pengguna_non_level/absen', $data);
	}

	public function getLapanganRadius() {
		$lapangan_id = $this->input->post('lapangan_id');
		$findLapangan = $this->db->query("SELECT * FROM tbl_lapangan WHERE id = '$lapangan_id'")->row();
		$lat = $findLapangan->latitude;
		$lng = $findLapangan->longitude;
		$radius_diizinkan = $findLapangan->radius_diizinkan;

		$respon = array(
			'lat' => $lat,
			'lng' => $lng,
			'radius_diizinkan' => $radius_diizinkan
		);

		echo json_encode($respon);
	}

	public function act_absen() {
		$dataURL = $_POST["imageDataURL"];
		
		if($dataURL == null) {
			$this->session->set_flashdata('error', 'Wajib mengambil foto terlebih dahulu!');
			redirect('karyawan/absen');
		}

		$apakahAdaAbsenOrangIniHariIni = $this->db->query("SELECT * FROM tbl_absensi WHERE users_id = '".$this->session->userdata('userid')."' AND DATE(tanggal) = CURDATE()");
		$getDataLapangan = $this->db->query("SELECT * FROM tbl_lapangan WHERE id = '".$this->session->userdata('lapangan_id')."'")->row();

		if($apakahAdaAbsenOrangIniHariIni->num_rows() > 2) {
			$this->session->set_flashdata('error', 'Anda sudah absen hari ini!');
			redirect('karyawan/absen');
		}

		$status = null;

		if($apakahAdaAbsenOrangIniHariIni->num_rows() == false || $apakahAdaAbsenOrangIniHariIni->num_rows() == 0) {
			$status = 1; // Masuk
		}

		if($apakahAdaAbsenOrangIniHariIni->num_rows() == 1) {
			$status = 2; // Pulang
		}

		$dataURL = str_replace('data:image/png;base64,', '', $dataURL);
		$dataURL = str_replace(' ', '+', $dataURL);
		$image = base64_decode($dataURL);
		$filename = $this->session->userdata('userid').'-'.date('YmdHis').'.png';
		$filepath = 'assets/assets/img/bukti_absen/';
		$save = file_put_contents($filepath.$filename, $image);	

		$jam = date('H:i:s');

		$data = array(
			'users_id' => $this->session->userdata('userid'),
			'tanggal' => date('Y-m-d'),
			'jam' => $jam,
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'foto' => $filename,
			'ip_address' => $this->input->ip_address(),
			'telat' => $jam > $getDataLapangan->jam_masuk_diizinkan ? 1 : 0,
			'status' => $status
		);

		$this->db->insert('tbl_absensi', $data);

		$this->session->set_flashdata('message', 'Absen berhasil!');
		redirect('karyawan/absen');
	}
}
