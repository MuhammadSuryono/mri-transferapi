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
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'dashboard' ? 'menu-open': '' ?>">
          <a href="<?php echo base_url('dashboard')?>" class="nav-link <?php echo $this->uri->segment(2) == 'partialnya' ? 'active': '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'user' ? 'menu-open': '' ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('user/listuser')?>" class="nav-link <?php echo $this->uri->segment(2) == 'listuser' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List User</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('role/listrole')?>" class="nav-link <?php echo $this->uri->segment(2) == 'listrole' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List Role</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('typepay/listtypepay')?>" class="nav-link <?php echo $this->uri->segment(2) == 'listtypepay' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Type Payment</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'token' ? 'menu-open': '' ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-key"></i>
            <p>
              Token
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('token/apikey')?>" class="nav-link <?php echo $this->uri->segment(2) == 'apikey' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>API Key</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('token/sessionkey')?>" class="nav-link <?php echo $this->uri->segment(2) == 'sessionkey' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Session Key BCA</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'transfer' ? 'menu-open': '' ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Data Transfer
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('transfer/listtransfer')?>" class="nav-link <?php echo $this->uri->segment(2) == 'listtransfer' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List Transfer Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('transfer/otorisasi')?>" class="nav-link <?php echo $this->uri->segment(2) == 'otorisasi' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transfer Otorisasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('transfer/transfermanual')?>" class="nav-link <?php echo $this->uri->segment(2) == 'transfermanual' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transfer Manual</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('transfer/laporantransfer')?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporantransfer' ? 'active': '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Transfer</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
      <!-- //Menu Sampai Sini-->

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
