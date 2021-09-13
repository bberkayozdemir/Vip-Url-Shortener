<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>VIP URL Shortener - Register</title>

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
                    <h5 class="card-title text-center">Register</h5>
                    <form class="form-signin" action="" method="POST">
                        <?php if (isset($error)){ ?> <p style="color:red">All fields are required!</p><?php } ?>
                        <?php if (isset($error0)){ ?> <p style="color:red">Unknown error happened!</p><?php } ?>
                        <?php if (isset($error1)){ ?> <p style="color:red">Email already taken!</p><?php } ?>
                        <?php if (isset($error2)){ ?> <p style="color:red">Wrong email!</p><?php } ?>
                        <?php if (isset($error3)){ ?> <p style="color:red">Passwords doesn't match!</p><?php } ?>
                        <?php if (isset($error4)){ ?> <p style="color:red">Your username has disallowed characters!</p><?php } ?>
                        <?php if (isset($error5)){ ?> <p style="color:red">Your password is too short!</p><?php } ?>
                        <div class="form-label-group">
                            <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus <?php if (isset($name)) { echo ' value="'.$name.'" ' ; } ?>>
                            <label for="inputUsername">Username</label>
                        </div>

                        <div class="form-label-group">
                            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required <?php if (isset($email)) { echo ' value="'.$email.'" ' ; } ?>>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <div class="form-label-group">
                            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <div class="form-label-group">
                            <input name="repeat_password" type="password" id="inputrPassword" class="form-control" placeholder="Repeat Password" required>
                            <label for="inputrPassword">Repeat Password</label>
                        </div>

                        <p>Already have account? <a href="<?=base_url()?>login">Login here</a></p>

                        <button name="register" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>