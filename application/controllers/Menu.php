<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller{

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('Menu_model');
	}


	function listmenu()
  	{
	    $data['listmenu'] = $this->Menu_model->getmenu();
	    $this->load->view('template/header');
	    $this->load->view('template/sidebar');
	    $this->load->view('menu/listmenu', $data);
	    $this->load->view('template/footer');
  	}

  	public function prosesaddmenu()
    {
	    $this->Menu_model->addmenu();
	    $this->session->set_flashdata('flash', 'Add Menu berhasil Di Tambahkan!!');
	    redirect('menu/listmenu');
	     
    }

    function listsubmenu()
  	{
	    $data['listsubmenu'] = $this->Menu_model->getsubmenu();
	    $this->load->view('template/header');
	    $this->load->view('template/sidebar');
	    $this->load->view('menu/listsubmenu', $data);
	    $this->load->view('template/footer');
  	}
}