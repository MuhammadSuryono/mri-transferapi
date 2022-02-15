<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url('dashboard') ?>" class="brand-link">
    <img src="<?php echo base_url(); ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light"><?php echo SITE_NAME ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <!-- <img src="<?php //echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        <i class="fa fa-user img-circle elevation-2" alt="User Image"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata('ses_nama'); ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Query Menu -->
          <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'dashboard' ? 'menu-open': '' ?>">
            <a href="<?php echo base_url('dashboard')?>" class="nav-link <?php echo $this->uri->segment(2) == 'partialnya' ? 'active': '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <?php
              $roleid = $this->session->userdata('ses_role');
              $query_access_menu = "SELECT `menuid` FROM `user_access_menu` WHERE `roleid`='$roleid' GROUP BY `menuid`";
              $menu_access = $this->db->query($query_access_menu)->result_array();
          ?>
              <?php foreach ($menu_access as $ma) :?>
                  <?php
                      $id = $ma['menuid'];
                      $query_menu = "SELECT * FROM `user_menu` WHERE `id`='$id'";
                      $menu = $this->db->query($query_menu)->result_array();
                  ?>
                      <?php foreach ($menu as $m) :?>
                          <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == $m['url'] ? 'menu-open': '' ?>">
                              <a href="<?php echo base_url($m['url'])?>" class="nav-link <?php echo $this->uri->segment(2) == 'partialnya' ? 'active': '' ?>">
                                  <i class="<?php echo $m['icon'];?>"></i>
                                  <p>
                                      <?php echo $m['menu'];?>
                                  <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                                  <?php
                                      $menuid = $m['id'];
                                      $query_sub_menu = "SELECT * FROM `user_access_menu` WHERE `menuid`='$menuid' AND `roleid`='$roleid'";
                                      $submenuid = $this->db->query($query_sub_menu)->result_array();
                                  ?>

                                      <?php foreach ($submenuid as $s) :?>
                                          <?php
                                              $id = $s['submenuid'];
                                              $query_sub_menu_id = "SELECT * FROM `user_sub_menu` WHERE `id`='$id'";
                                              $submenu = $this->db->query($query_sub_menu_id)->result_array();
                                          ?>
                                              <?php foreach ($submenu as $sm) :?>
                                                  <ul class="nav nav-treeview">
                                                    <li class="nav-item">
                                                      <a href="<?php echo base_url($sm['url'])?>" class="nav-link <?php echo $this->uri->segment(2) == $sm['sub_menu'] ? 'active': '' ?>">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p><?php echo ($sm['sub_menu']);?></p>
                                                      </a>
                                                    </li>
                                                  </ul>
                                              <?php endforeach; ?>
                                      <?php endforeach; ?>
                          </li>
                      <?php endforeach; ?>
              <?php endforeach; ?>
       
      </ul>
    </nav>


  </div>
  <!-- /.sidebar -->
</aside>
