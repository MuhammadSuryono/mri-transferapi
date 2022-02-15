<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Token_model');
    $this->load->library('session');
    //Codeigniter : Write Less Do More
  }

  function apikey()
  {
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('token/apikey');
    $this->load->view('template/footer');
  }

  public function prosestoken()
  {
    $cek_token = $this->Token_model->gettoken();
    if ($cek_token->num_rows() > 0) {
      $this->session->set_flashdata('flash', 'Token Sudah di Input');
      redirect('token/apikey');
    } else {
      $userid = $this->session->userdata('ses_userid');
      $this->Token_model->add($userid);
      $this->session->set_flashdata('flash', 'Token Berhasil Di Input!!');
      redirect('token/apikey');
    }
  }

  public function sessionkey()
  {
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('token/sessionkey');
    $this->load->view('template/footer');
  }

  public function getsessiontoken()
  {
    $token = $this->input->post('token', true);
    $api_secret = $this->input->post('api_secret', true);
    $client_id = $this->input->post('client_id', true);
    $client_secret = $this->input->post('client_secret', true);
    $d = $this->Token_model->gettoken();
    foreach ($d->result() as $d) {
      $tokendb = $d->token;
      $api_secret_db = $d->api_secret;
      $client_id_db = $d->client_id;
      $client_secret_db = $d->client_secret;
    }
    // var_dump(password_verify($token, $tokendb) && password_verify($api_secret, $api_secret_db) && password_verify($client_id, $client_id_db) && password_verify($client_secret, $client_secret_db));
    // die;
    if (password_verify($token, $tokendb) && password_verify($api_secret, $api_secret_db) && password_verify($client_id, $client_id_db) && password_verify($client_secret, $client_secret_db)) {
      $this->session->set_userdata('token', $token);
      $this->session->set_userdata('api_secret', $api_secret);
      $this->session->set_userdata('client_id', $client_id);
      $this->session->set_userdata('client_secret', $client_secret);
      $this->session->set_flashdata('flash', 'Session Token Berhasil');
      redirect('token/sessionkey');
    } else {
      $this->session->set_flashdata('flash', 'Session Token Gagal');
      redirect('token/sessionkey');
    }
  }

  public function delete()
  {
    $this->Token_model->delete();
    $this->session->set_flashdata('flash', 'Delete Token berhasil!!');
    redirect('token/apikey');
  }

  public function unseter()
  {
    $this->session->unset_userdata('token');
    $this->session->unset_userdata('api_secret');
    $this->session->unset_userdata('client_id');
    $this->session->unset_userdata('client_secret');
    $this->session->set_flashdata('flash', 'Unset Session berhasil!!');
    redirect('token/sessionkey');
  }
}
