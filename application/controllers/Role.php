<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Role_model');
    //Codeigniter : Write Less Do More
  }

  public function listrole()
  {
    $data['getlistrole'] = $this->Role_model->getrole();
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('role/listrole', $data);
    $this->load->view('template/footer');
  }

  public function addrole()
    {
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('role/addrole');
      $this->load->view('template/footer');
    }

  public function prosesaddrole()
    {
      $level = $_POST['level'];
      $cek_level = $this->Role_model->ceklevel($level);
      if($cek_level->num_rows() > 0){
        $this->session->set_flashdata('flash', 'Role Level sudah terdaftar!!');
        redirect('role/addrole');
      }
      else{
        $this->Role_model->add();
        $this->session->set_flashdata('flash', 'Role berhasil Di Tambahkan!!');
        redirect('role/listrole');
      }
    }

  public function editrole($id)
    {
      $data['getallrolenya'] = $this->Role_model->getid($id);
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('role/editrole', $data);
      $this->load->view('template/footer');
    }

  public function proseseditrole($id)
    {
      
        $this->Role_model->editid($id);
        $this->session->set_flashdata('flash', 'Edit role berhasil!!');
        redirect('role/listrole');
      
    }

  public function deleterole($id)
    {
      $this->Role_model->deleteid($id);
      $this->session->set_flashdata('flash', 'Hapus role berhasil!!');
      redirect('role/listrole');
    }

  public function aksesrole($role_id)
    {
        $data['listmenu'] = $this->Role_model->getmenu();
        $data['role'] = $this->Role_model->roleakses($role_id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('role/roleakses', $data);
        $this->load->view('template/footer');
    }

  public function changeaccess()
    {
        $roleid = $this->input->post('roleid');
        $menuid = $this->input->post('menuid');
        $submenuid = $this->input->post('submenuid');

        $data = [
            'roleid' => $roleid,
            'menuid' => $menuid,
            'submenuid' => $submenuid
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if($result->num_rows() < 1){
            $this->db->insert('user_access_menu', $data);
        }else{
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('flash', 'Access Changed!!');
    }

}
