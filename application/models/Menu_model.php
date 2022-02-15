<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model{

	public function getmenu(){
	    $query = $this->db->query("SELECT * FROM user_menu ORDER BY id ASC")->result_array();
	    return $query;
  	}

  	
  	public function addmenu()
		{
		   	$data = array(
		       	"menu" => htmlspecialchars($this->input->post('menu', true)),
		       	"url" => htmlspecialchars($this->input->post('url', true)),
		       	"icon" => htmlspecialchars($this->input->post('icon', true)),
		       	"is_active" => htmlspecialchars($this->input->post('is_active', true)),
		   	);

		   	$this->db->insert('user_menu', $data);
		}

	public function getsubmenu(){
	    $query = $this->db->query("SELECT * FROM `user_sub_menu` JOIN `user_menu` 
	    						   ON `user_sub_menu`.`menu_id` = `user_menu`.`id` 
	    						   ORDER BY `user_sub_menu`.`id` ASC")->result_array();
	    return $query;
  	}


  
}