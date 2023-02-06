<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cuti extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('fungsi');
		is_login();
	}

	public function index()
	{
		$this->template->load('template', 'pengguna_non_level/cuti_form');
	}
}
