<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typepay extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Typepay_model');
    //Codeigniter : Write Less Do More
  }

  function listtypepay()
  {
    $data['getlisttypepay'] = $this->Typepay_model->gettypepay();
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('typepayment/listtypepay', $data);
    $this->load->view('template/footer');
  }

  public function addtypepay()
    {
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('typepayment/addtypepay');
      $this->load->view('template/footer');
    }

  public function prosesaddtypepay()
    {
      $jenispembayaran = $_POST['jenispembayaran'];
      $cek_level = $this->Typepay_model->cekjenispembayaran($jenispembayaran);
      if($cek_level->num_rows() > 0){
        $this->session->set_flashdata('flash', 'Type Payment sudah terdaftar!!');
        redirect('typepay/addtypepay');
      }
      else{
        $this->Typepay_model->add();
        $this->session->set_flashdata('flash', 'Role berhasil Di Tambahkan!!');
        redirect('typepay/listtypepay');
      }
    }

  public function edittypepay($id)
    {
      $data['getalltypepaynya'] = $this->Typepay_model->getid($id);
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('typepayment/edittypepay', $data);
      $this->load->view('template/footer');
    }

  public function prosesedittypepay($id)
    {
      
        $this->Typepay_model->editid($id);
        $this->session->set_flashdata('flash', 'Edit Type Payment berhasil!!');
        redirect('typepay/listtypepay');
      
    }

  public function deletetypepay($id)
    {
      $this->Typepay_model->deleteid($id);
      $this->session->set_flashdata('flash', 'Hapus Type Payment berhasil!!');
      redirect('typepay/listtypepay');
    }

}
