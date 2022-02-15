<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typepay_model extends CI_Model{

  public function gettypepay(){
    $query = $this->db->query("SELECT * FROM jenis_pembayaran ORDER BY jenispembayaranid ASC")->result_array();
    return $query;
  }

  public function add()
	{
	   $data = array(
	       "jenispembayaran" => htmlspecialchars($this->input->post('jenispembayaran', true)),
	       "max_transfer" => htmlspecialchars($this->input->post('max_transfer', true)),
	   );

	   $this->db->insert('jenis_pembayaran', $data);
	}

	public function cekjenispembayaran()
	  {
	   $jenispembayaran = $_POST['jenispembayaran'];
	   $query = $this->db->query("SELECT * FROM jenis_pembayaran WHERE jenispembayaran='$jenispembayaran'");
	   return $query;
	  }

	public function getid($id)
	 {
	   return $this->db->get_where('jenis_pembayaran', array('jenispembayaranid' => $id))->row_array();
	 }

	 public function editid($id)
	 {
	   $data = array(
	       "jenispembayaran" => htmlspecialchars($this->input->post('jenispembayaran', true)),
	       "max_transfer" => htmlspecialchars($this->input->post('max_transfer', true)),
	   );
	   $this->db->where('jenispembayaranid', $id);
	   $this->db->update('jenis_pembayaran', $data);
	 }

	 public function deleteid($id)
	 {
	   $this->db->delete('jenis_pembayaran', array('jenispembayaranid' => $id));
	 }


}
