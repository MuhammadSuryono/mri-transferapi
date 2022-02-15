<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Auth_model');
    $this->load->library('session');
    //Codeigniter : Write Less Do More
  }

  public function index()
  {
    $this->load->view('auth/login');
  }

  public function auth(){
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $cekuser = $this->Auth_model->cekusernya($username,$password);

    if($cekuser->num_rows() == 1){
      $data = $cekuser->row_array();
      $this->session->set_userdata('masuk', TRUE);
      $this->session->set_userdata('ses_userid', $data['id']);
      $this->session->set_userdata('ses_username', $data['username']);
      $this->session->set_userdata('ses_email', $data['user_login']);
      $this->session->set_userdata('ses_nama', $data['nama']);
      $this->session->set_userdata('ses_role', $data['roleid']);
      redirect(base_url('dashboard'));
    }
    else{
      $url=base_url();
      echo $this->session->set_flashdata('flash', 'Username atau password salah !!');
      redirect($url);
    }
  }

  public function logout(){
    $this->session->unset_userdata('masuk');
    $this->session->unset_userdata('ses_userid');
    $this->session->unset_userdata('ses_username');
    $this->session->unset_userdata('ses_email');
    $this->session->unset_userdata('ses_nama');
    $this->session->unset_userdata('ses_role');
    $url=base_url();
    redirect($url);
  }

  public function forgot_pass(){

      if(!isset($_POST['email'])){
          $this->load->view('auth/forgot_pass');

      }else{

          $email = $this->input->post('email');
          $cek_email = $this->Auth_model->cekemail($email);

          if($cek_email){
              $rand = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"),0,25);
              $token = base64_encode($rand);
              date_default_timezone_set("Asia/Jakarta");
              $time = date('H:i:s');
              $user_token = [
                  'email' => $email,
                  'token' => $token,
                  'date_created' => $time
              ]; 
              $this->Auth_model->ins_token($user_token);

              $message = 'Click this link to reset your password : <a href ="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) .'">Reset Password</a>';

              $ci = get_instance();
              $ci->load->library('email');
              $config['protocol'] = "smtp";
              $config['smtp_host'] = "192.168.8.3";
              $config['smtp_port'] = "25";
              $config['smtp_user'] = "admin.web@mri-research-ind.com";//ganti dengan email pengirim
              $config['smtp_pass'] = "w3bminMRI";//ganti dengan password pengirim
              $config['charset'] = "utf-8";
              $config['mailtype'] = "html";
              $config['newline'] = "\r\n";
              $ci->email->initialize($config);
              $ci->email->from('admin.web@mri-research-ind.com', 'Admin Web');//ganti dengan email pengirim
              $ci->email->to($email);
              $ci->email->subject('MRI Transfer : Reset Password');
              $ci->email->message($message);

              if ($this->email->send()) {
                    $this->session->set_flashdata('flash', 'Please check your email to reset your password!');
                    redirect('auth/forgot_pass');
              }else{
                  echo $this->email->print_debugger();
                  die;
              }             

          }else{

              $this->session->set_flashdata('flash', 'Email is not registered!');
              redirect('auth/forgot_pass');

          }

      }
    
  }

  public function resetpassword(){

      $email = $this->input->get('email');
      $token = $this->input->get('token');

      $cek_email = $this->Auth_model->cekemail($email);

      if($cek_email){

          $user_token = $this->Auth_model->cektoken($token);

          if($user_token){

              $this->session->set_userdata('reset_email', $email);
              $this->changepassword();

          } else {

              $this->session->set_flashdata('flash', 'Reset password failed! Wrong token');
              redirect('auth');

          }

      } else {

          $this->session->set_flashdata('flash', 'Reset password failed! Wrong email');
          redirect('auth');

      }
  }

  public function changepassword(){

      if(!$this->session->userdata('reset_email')){

          redirect('auth');

      }else{


          if(!isset($_POST['password1'])){

              $this->load->view('auth/change_pass');

          }else{

              $password1 = $this->input->post('password1');
              $password2 = $this->input->post('password2');

              if($password1 == $password2){

                  $password = md5($password1);
                  $email = $this->session->userdata('reset_email');

                  $this->Auth_model->updatepass($password, $email);

                  $this->Auth_model->delete_token($email);

                  $this->session->unset_userdata('reset_email');

                  $this->session->set_flashdata('flash', 'Password has been changed');
                  redirect('auth');

              }else{

                  $this->session->set_flashdata('flash', 'Password not matches');
                  redirect('auth/changepassword');

              }


          }

      }

      

  }


}
