<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model{

  public function cekusernya($username,$password){
    $query = $this->db->query("SELECT * FROM user WHERE username='$username' AND user_password=MD5('$password') LIMIT 1");
    return $query;
  }

  public function cekemail($email){
    $query = $this->db->get_where('user', ['user_login' => $email])->row_array();
    return $query;
  }

  public function cekemailtoken($email){
    $query = $this->db->get_where('user_token', ['email' => $email])->row_array();
    return $query;
  }

  public function cektoken($token){
    $query = $this->db->get_where('user_token', ['token' => $token])->row_array();
    return $query;
  }

  public function ins_token($user_token){
    $this->db->insert('user_token', $user_token);
  }

  public function updatepass($password, $email){
  	$this->db->set('user_password', $password);
  	$this->db->where('user_login', $email);
    $this->db->update('user');
  }

  public function delete_token($email){
    $this->db->where('email', $email);
    $this->db->delete('user_token');
  }


}
