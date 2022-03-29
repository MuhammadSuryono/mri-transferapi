<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends CI_Controller{
	public function __construct(){
        parent::__construct();
		$this->load->library('session');
    }

	public function mutasi_keluar()
  {
	  $this->load->model("Mutasi_model");
	  $this->load->helper ('form');
	$saldo = $this->Mutasi_model->getinfobal();
	if($saldo){
		$data['infobal'] = $saldo;
	}

	$saldo = $this->Mutasi_model->mutasi_keluar();
	if($saldo){
		$data['getalltransfer'] = $saldo;
	}

	$this->load->view('template/header');
	$this->load->view('template/sidebar');
	$this->load->view('mutasi/mutasi_keluar', $data);
	$this->load->view('template/footer');
  }

	public function bca()
	{
		$this->load->library('Api_Bca');
		$corpoateId = 'h2hauto008';
		$apikey = $this->session->userdata('token');
		$api_secret = $this->session->userdata('api_secret');
		$client_id = $this->session->userdata('client_id');
		$client_secret = $this->session->userdata('client_secret');
		$token = $this->api_bca->getToken($client_id, $client_secret);
//		$this->print_pretty($this->session->userdata());
//		$this->print_pretty($token);

		$hasil = $this->api_bca->getMutasi($token, $apikey, $api_secret, $corpoateId, "0613005908");
		$this->print_pretty($hasil);
//		exit();
//
//		$this->load->view('template/header');
//		$this->load->view('template/sidebar');
//		$this->load->view('mutasi/mutasi_bca', array());
//		$this->load->view('template/footer');
	}

	public function print_pretty($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}
