<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="col-md-2 d-none d-md-block sidebar" id="nav">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link <?php if ($page_name == "home"){?>active<?php } ?>" data-title="Dashboard" href="<?= base_url()?>admin/">
            <i class="fas fa-home"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($page_name == "urls"){?>active<?php } ?>" data-title="Urls" href="<?= base_url()?>admin/urls">
            <i class="fas fa-link"></i>
            URLs
          </a>
        </li>
          <li class="nav-item">
              <a class="nav-link <?php if ($page_name == "users"){?>active<?php } ?>" data-title="Users" href="<?= base_url()?>admin/users">
                  <i class="fas fa-user"></i>
                  Users
              </a>
          </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($page_name == "settings"){?>active<?php } ?>" data-title="Settings" href="<?= base_url()?>admin/settings">
            <i class="fas fa-cog"></i>
            Settings
          </a>
        </li>
        
      </ul>

    </div>
</nav>

<script type="text/javascript">
    
    $(document).ready(function(){
        $("#nav a").on('click',function(e){

            e.preventDefault();

            var url = $(this).attr("href");
            $("#nav").find("a").removeClass("active");
            $(this).addClass("active");

            window.history.pushState("", "", url);
            set_page(url);
        });
    });

</script>