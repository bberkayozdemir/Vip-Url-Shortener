<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include 'includes/includes_top.php'; ?>

<body>
    
    <?php include 'includes/header.php'; ?>
    
    <div class="container-fluid">
      <div class="row">
            <?php include 'includes/navigation.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="page-content">
                <?php include $page_name.'.php'; ?>
            </main>
            <?php include 'includes/footer.php'; ?>
      </div>
    </div>

</body>

<?php include 'includes/includes_bottom.php'; ?>
    
