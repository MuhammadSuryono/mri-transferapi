<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function index()
  {
    $this->load->view('template/overview');
  }

  public function partialnya()
  {
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('template/footer');
  }

}
