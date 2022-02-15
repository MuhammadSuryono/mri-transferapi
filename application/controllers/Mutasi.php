<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends CI_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->model("Mutasi_model");
        $this->load->helper ('form');
        $this->load->library('session');
    }

	public function mutasi_keluar()
		  {
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



}