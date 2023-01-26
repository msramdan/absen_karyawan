 <?php defined('BASEPATH') or exit('No direct script access allowed');

	class User_m extends CI_Model
	{
		public function login($post)
		{
			$this->db->select('*');
			$this->db->from('tbl_users');
			$this->db->where('username', $post['username']);
			$this->db->where('password', sha1($post['password']));
			$query = $this->db->get();
			return $query;
		}

		public function get($id = null)
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
			$this->db->update('tbl_users', $data);
		}

		public function user_token($user_token)
		{
			$this->db->insert('user_token', $user_token);
		}
	}
