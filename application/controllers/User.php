<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model');
    //Codeigniter : Write Less Do More
  }

  function listuser()
  {
    $data['getlistuser'] = $this->User_model->getuser();
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('user/listuser', $data);
    $this->load->view('template/footer');
  }

  public function adduser()
    {
      $data['typerole'] = $this->User_model->typerole();
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('user/adduser', $data);
      $this->load->view('template/footer');
    }

  public function prosesadduser()
    {
      $user_login = $_POST['user_login'];
      $cek_user = $this->User_model->cekuser($user_login);
      if($cek_user->num_rows() > 0){
        $this->session->set_flashdata('flash', 'Email sudah terdaftar, coba email lain!!');
        redirect('user/adduser');
      }
      else{
        $this->User_model->add();
        $this->session->set_flashdata('flash', 'User berhasil Di Tambahkan!!');
        redirect('user/listuser');
      }
    }

  public function edituser($id)
    {
      $data['getallusernya'] = $this->User_model->getid($id);
      $data['typerole'] = $this->User_model->typerole();
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('user/edituser', $data);
      $this->load->view('template/footer');
    }

  public function prosesedituser($id)
    {
      $this->User_model->editid($id);
      $this->session->set_flashdata('flash', 'Edit User berhasil!!');
      redirect('user/listuser');
    }

  public function deleteuser($id)
    {
      $this->User_model->deleteid($id);
      $this->session->set_flashdata('flash', 'Delete User berhasil!!');
      redirect('user/listuser');
    }

}
