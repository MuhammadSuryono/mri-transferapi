<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	public function getuser()
	{
		$query = $this->db->query("SELECT * FROM user ORDER BY nama ASC")->result_array();
		return $query;
	}

	public function add()
	{
		$data = array(
			"username" => htmlspecialchars($this->input->post('username', true)),
			"nama" => ucwords($this->input->post('username', true)),
			"user_login" => htmlspecialchars($this->input->post('user_login', true)),
			"user_password" => md5($this->input->post('user_password', true)),
			"roleid" => htmlspecialchars($this->input->post('roleid', true)),
		);

		$this->db->insert('user', $data);
	}

	public function typerole()
	{
		$this->db->select('*');
		$this->db->from('role');
		$this->db->order_by('roleid', 'ASC');
		return $this->db->get()->result_array();
	}

	public function cekuser()
	{
		$user_login = $_POST['user_login'];
		$query = $this->db->query("SELECT * FROM user WHERE user_login='$user_login'");
		return $query;
	}

	public function getid($id)
	{
		return $this->db->get_where('user', array('id' => $id))->row_array();
	}

	public function editid($id)
	{
		$data = array(
			"username" => htmlspecialchars($this->input->post('username', true)),
			"nama" => ucwords($this->input->post('username', true)),
			"user_login" => htmlspecialchars($this->input->post('user_login', true)),
			"roleid" => htmlspecialchars($this->input->post('roleid', true)),
		);
		$this->db->where('id', $id);
		$this->db->update('user', $data);
	}

	public function deleteid($id)
	{
		$this->db->delete('user', array('id' => $id));
	}

	public function getUserBpuEmail($id)
	{

		$db_budget = $this->load->database('db_budget', TRUE);
		return $db_budget->get_where('bpu', array('noid' => $id))->row_array();
	}
}
