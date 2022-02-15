<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Sendemail extends CI_Controller {
    
    function index() {
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "192.168.8.3";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "admin.web@mri-research-ind.com";
        $config['smtp_pass'] = "w3bminMRI";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $ci->email->initialize($config);
        $ci->email->from('admin.web@mri-research-ind.com', 'Admin Web');
        
        $ci->email->to('hendra.dp.mri@gmail.com,hendra@mri-research-ind.com');
        $ci->email->subject('Test');
        $ci->email->message('Test');
        if ($this->email->send()) {
            echo 'Email sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
}