<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 panel_header">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">User Panel</a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?=base_url()."user/logout"?>">Sign out</a>
          <?php if ($this->functions_model->check_admin_login()) { ?>
        <a class="nav-link" style="color:#dc3545;margin-right:10px;" href="<?=base_url()."admin"?>">Admin Panel</a>
          <?php } ?>
      </li>
    </ul>
</nav>