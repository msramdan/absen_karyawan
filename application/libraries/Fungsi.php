<?php
Class Fungsi{
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function user_login(){
        $this->ci->load->model('Auth_model');
        $user_id = $this->ci->session->userdata('userid');
		$level = $this->ci->session->userdata('level');

		if ($level == 1 || $level == 2 || $level == 3) {
			$user_data = $this->ci->Auth_model->get($user_id, $level)->row();
			return $user_data;
		} else {
			$user_data = $this->ci->Auth_model->get_user($user_id)->row();
			return $user_data;
		}

    }

}
