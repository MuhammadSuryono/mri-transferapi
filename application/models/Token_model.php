<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Token_model extends CI_Model
{

  public function gettoken()
  {
    $query = $this->db->query("SELECT * FROM token");
    return $query;
  }

  public function add($userid)
  {
    $option = ['cost' => 10];
    $token = $this->input->post('token', true);
    $client_id = $this->input->post('client_id', true);
    $client_secret = $this->input->post('client_secret', true);
    $api_secret = $this->input->post('api_secret', true);
    $corporate_id = $this->input->post('corporate_id', true);
    $account_number = $this->input->post('account_number', true);
    $channel_id = $this->input->post('channel_id', true);
    $options = [
      'cost' => 5
    ];

    $data = array(

      "token" => password_hash($token, PASSWORD_DEFAULT, $options),
      "api_secret" => password_hash($api_secret, PASSWORD_DEFAULT, $options),
      "client_id" =>  password_hash($client_id, PASSWORD_DEFAULT, $options),
      "client_secret" =>  password_hash($client_secret, PASSWORD_DEFAULT, $options),
      "corporate_id" => $corporate_id,
      "account_number" => $account_number,
      "channel_id" => $channel_id,
      "user_id" => $userid,
    );

    $this->db->insert('token', $data);
  }

  public function delete()
  {
    $this->db->truncate('token');
  }
}
