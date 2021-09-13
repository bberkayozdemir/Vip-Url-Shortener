<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>VIP URL Shortener - Login</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?=base_url()?>src/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/font-awesome/css/all.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/css/login.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>src/js/bootstrap.min.js"></script>
</head>
<body>

<div class="bg"></div>


<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Log In</h5>
                    <form class="form-signin" action="" method="POST">
                        <?php if (isset($error)){ ?> <p style="color:red">Email or password is incorrect!</p><?php } ?>
                        <?php if (isset($error1)){ ?> <p style="color:red">Your account is disabled!</p><?php } ?>
                        <div class="form-label-group">
                            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <div class="form-label-group">
                            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <p>Dont have account? <a href="<?=base_url()?>register">Register here</a></p>

                        <button name="login" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Log in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>