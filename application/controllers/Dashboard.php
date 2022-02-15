<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Dashboard_model');
    $this->load->model('Transfer_model');
    $this->load->model('Token_model');
    $this->load->library('Api_Bca');
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $saldo = $this->Transfer_model->getinfobal();
    if ($saldo) {
      $data['infobal'] = $saldo;
    }
    $summary = $this->Transfer_model->summarydatatrf();
    if ($summary) {
      $data['sumdatatrf'] = $summary;
    }
    $list = $this->Transfer_model->antridatatrfdashboard();
    if ($list) {
      $data['listantri'] = $list;
    }
    $rekening = $this->Transfer_model->getRekening();
    if ($rekening) {
      $data['rekening'] = $rekening;
    }
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('dashboard/index', $data);
    $this->load->view('template/footer');
  }

  public function getinfobal()
  {
    $apikey = $this->session->userdata('token');
    $api_secret = $this->session->userdata('api_secret');
    $client_id = $this->session->userdata('client_id');
    $client_secret = $this->session->userdata('client_secret');
    $d = $this->Token_model->gettoken();
    foreach ($d->result() as $d) {
      $tokendb = $d->token;
      $api_secret_db = $d->api_secret;
      $client_id_db = $d->client_id;
      $client_secret_db = $d->client_secret;
      $corporate_id = $d->corporate_id;
      // $account_number = $d->account_number;
    }
    if (password_verify($apikey, $tokendb) && password_verify($api_secret, $api_secret_db) && password_verify($client_id, $client_id_db) && password_verify($client_secret, $client_secret_db)) {
      $this->load->library('Api_Bca');
      $rekening = $this->Transfer_model->getRekening();
      foreach ($rekening as $item) {
        $decode = $this->api_bca->getToken($client_id, $client_secret);
        $saldo = $this->api_bca->getInfobal($decode, $apikey, $api_secret, $corporate_id, $item['rekening']);
      }
      redirect('dashboard');
    } else {
      $this->session->set_flashdata('flash', 'Key BCA Is Not Valid');
      redirect('token/sessionkey');
    }
    redirect('dashboard');
  }
}
