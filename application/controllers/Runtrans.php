<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Runtrans extends CI_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->model("Transfer_model");
		$this->load->model("Token_model");
        $this->load->helper ('form');
        $this->load->library('../controllers/transfer');
 		$this->transfer->gettransfer()
    }

 ?>   