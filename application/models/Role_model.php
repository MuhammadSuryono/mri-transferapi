<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model{

	public function getrole(){
	    $query = $this->db->query("SELECT * FROM role ORDER BY roleid ASC")->result_array();
	    return $query;
	}

  	public function add()
		{
		   $data = array(
		       "role" => htmlspecialchars($this->input->post('role', true)),
		       "level" => htmlspecialchars($this->input->post('level', true)),
		   );

		   $this->db->insert('role', $data);
		}

	public function ceklevel()
	  {
	   $level = $_POST['level'];
	   $query = $this->db->query("SELECT * FROM role WHERE level='$level'");
	   return $query;
	  }

	public function getid($id)
	 {
	   return $this->db->get_where('role', array('roleid' => $id))->row_array();
	 }

	public function editid($id)
	{
		$data = array(
		    "role" => htmlspecialchars($this->input->post('role', true)),
		    "level" => htmlspecialchars($this->input->post('level', true)),
		);
		$this->db->where('roleid', $id);
		$this->db->update('role', $data);
	}

	public function deleteid($id)
	{
	  	$this->db->delete('role', array('roleid' => $id));
	}

	public function getmenu(){
		$query = $this->db->query("SELECT 
	    								`user_menu`.`id` AS menuid, 
	    								`user_sub_menu`.`id` AS submenuid, 
	    								`user_menu`.`menu`,
	    								`user_sub_menu`.`sub_menu`
	    						   FROM `user_menu` LEFT JOIN`user_sub_menu` 
	    						   ON `user_menu`.`id`  = `user_sub_menu`.`menu_id` 
	    						   WHERE `user_sub_menu`.`id` != '2'
	    						   ORDER BY `user_sub_menu`.`id` ASC")->result_array();
	    return $query;
  	}


	public function roleakses($role_id){
		$this->db->select('*');
	   	$this->db->from('role');
	   	$this->db->where('roleid', $role_id);
	   	return $this->db->get()->row_array();
	}

	

}
