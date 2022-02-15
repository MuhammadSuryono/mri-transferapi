<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

  public function getinfobal()
	{
		$this->db->select('*');
	   	$this->db->from('saldo');
	   	$this->db->order_by('datetime', 'desc');
	   	$this->db->limit('1');
	   	return $this->db->get()->result_array();
	}

}
