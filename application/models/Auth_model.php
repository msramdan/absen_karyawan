 <?php defined('BASEPATH') or exit('No direct script access allowed');

	class Auth_model extends CI_Model
	{
		public function login($post)
		{
			$datakaryawan = $this->db->get_where('tbl_users', ['username' => $post['username'], 'password' => sha1($post['password'])]);

			if($datakaryawan->num_rows() > 0) {
				// add new data to $query
				return $datakaryawan;
			} else {
				$dataadmin = $this->db->select('*')->from('tbl_admin')->where('username', $post['username'])->where('password', sha1($post['password']));
				return $dataadmin->get();
			}
		}

		public function get($id = null, $level = null)
		{
			$this->db->select('tbl_admin.*');
			$this->db->from('tbl_admin');
			if ($id != null) {
				$this->db->where('id', $id);
				$this->db->where('level', $level);
			}
			
			$query = $this->db->get();
			return $query;
		}

		public function get_user($id = null)
		{
			$this->db->select('tbl_users.*');
			$this->db->from('tbl_users');
			if ($id != null) {
				$this->db->where('id', $id);
			}
			
			$query = $this->db->get();
			return $query;
		}

		public function ubah_data($data, $id)
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_admin', $data);
		}

		public function user_token($user_token)
		{
			$this->db->insert('user_token', $user_token);
		}
	}
