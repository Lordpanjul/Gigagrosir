<!-- Sidebar toggle button-->
<ul class="navbar-nav d-block d-md-none">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

<?php
//wajib urut
$this->user_login->proteksi_halaman();
require_once('v_head.php');
require_once('v_header_backend.php');
require_once('v_nav_backend.php');
require_once('v_content.php');
require_once('v_footer_backend.php');
