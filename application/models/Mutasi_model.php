<?php

class Mutasi_model extends CI_model{


	public function mutasi_keluar(){
	   	$this->db->select('*');
	   	$this->db->from('data_transfer');
	   	$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
	   	$this->db->where('hasil_transfer','2');
	   	$this->db->order_by('transfer_id');
	   	return $this->db->get()->result_array();
	}

	public function getinfobal()
	{
		$this->db->select('*');
	   	$this->db->from('saldo');
	   	$this->db->order_by('datetime', 'desc');
	   	$this->db->limit('1');
	   	return $this->db->get()->row_array();
	}





}
?>