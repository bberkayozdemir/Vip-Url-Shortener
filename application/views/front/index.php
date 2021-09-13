<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>VIP URL Shortener</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?=base_url()?>src/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/font-awesome/css/all.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/css/main_style.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>src/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="bg"></div>

    <div class="landing">



        <div class="vip-container ">

            <div class="navbar-container">
                <div class="row">
                    <div class="col-lg-3 col-sm-5 col-xs-12">
                        <a class="logo" href="<?=base_url()?>"><img src="<?=base_url()?>src/img/logo.png" </a>
                    </div>
                    <div class="col-lg-1 col-sm-1 col-xs-12"></div>
                    <div class="col-lg-8 col-sm-6 col-xs-12">
                        <div class="header-buttons">
                            <a class="login-btn" href="<?=base_url()?>login">LOG IN</a>
                            <a class="register-btn" href="<?=base_url()?>register">SIGN UP</a>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="main-title">VIP <span>URL SHORTENER</span></h1>

            <div class="container">
                <div class="shorten-form-group">
                    <form action="" method="POST" id="shorten_url_form">
                        <div class="input-group">
                            <input placeholder="Past a long url" type="text" name="url" class="form-control">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-submit">SHORTEN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <svg  viewBox="0 0 100 15">
            <path d="M0 30 V15 Q30 3 60 15 V30z" fill="#fff" opacity="0.1"></path>
            <path style="fill:#fff" class="wave-fill" d="M0 20 V11 Q30 17 60 12 T100 8 V30z"></path>
        </svg>
    </div>

    <div class="body">

        <div class="container">

            <div class="row marbot75">
                <div class="col-md-6">
                    <div class="hp-ad-title">
                        Monitor your urls performance.
                    </div>
                    <div class="hp-ad-p">
                        Very detailed analytics for your urls, including geo and device information, os, browser, more.
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="<?=base_url()?>/src/img/hp-1.png" class="hp-ad-img"/>
                </div>
            </div>

            <div class="row marbot75">
                <div class="col-md-6">
                    <img src="<?=base_url()?>/src/img/hp-2.png" class="hp-ad-img"/>
                </div>
                <div class="col-md-6">
                    <div class="hp-ad-title">
                        Manage your urls.
                    </div>
                    <div class="hp-ad-p">
                        Control everything from dashboard. Manage your urls details and more.
                    </div>
                </div>
            </div>

        </div>

        <div class="features">

            <div class="container">
                <div class="row">


                    <div class="col-md-4">
                        <i class="fa fa-globe"></i>
                        <h3>Target Customers</h3>
                        <p>Target your users based on their location and device and redirect them to specialized pages to increase your conversion.</p>
                    </div>

                    <div class="col-md-4">
                        <i class="fa fa-key"></i>
                        <h3>Access Restriction</h3>
                        <p>Restrict access to links by setting password or expiration date.</p>
                    </div>

                    <div class="col-md-4">
                        <i class="fa fa-link"></i>
                        <h3>Custom Aliases</h3>
                        <p>You can customize your shorten urls name and get a better look on your link.</p>
                    </div>


                    <div class="col-md-12" style="margin-top:50px">
                        <a class="reg-btn" href="<?=base_url()?>register">Register now to get full access</a>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <div class="row stats">
            <div class="col-md-4">
                <h3>Powering</h3>
                <p><?=$created_urls_all?> Links</p>
            </div>
            <div class="col-md-4">
                <h3>Serving</h3>
                <p><?=$clicks_all?> Clicks</p>
            </div>
            <div class="col-md-4">
                <h3>Trusted By</h3>
                <p><?=$registers_all?> Users</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="cr">2019 © VIP URL Shortener.</div>
        </div>
    </footer>

    <script type="text/javascript">

        var btn_submit_status = "submit";

        $(document).ready(function(){

            $(".btn-submit").click(function(e){
                e.preventDefault();
                if (btn_submit_status == "submit")
                    $("#shorten_url_form").submit();
                else
                {
                    $("#shorten_url_form").find("input[name='url']").select();
                    $("#shorten_url_form").find("input[name='url']")[0].setSelectionRange(0, 99999);
                    document.execCommand("copy");
                    $.notify("Copied to clipboard", "success");
                    $("#shorten_url_form").find("input[name='url']").val("");
                    $(".btn-submit").text("Shorten");
                    btn_submit_status = "submit";

                }
            });

            $("#shorten_url_form").find("input[name='url']").change(function(){
                if (btn_submit_status == "copy")
                {
                    $(".btn-submit").text("Shorten");
                    btn_submit_status = "submit";
                    clear_shorten_form();
                }
            });

            $("#shorten_url_form").submit(function(e){
                e.preventDefault();

                var url = ($("#shorten_url_form").find("input[name='url']").val()).trim();

                if (url == "")
                {
                    $.notify("Please fill the url input", "error");
                    return;
                }

                var form_data = new FormData($(this)[0]);

                $.ajax({
                    url: '<?=base_url()?>',
                    type: 'post',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".btn-submit").text("Loading...");
                        $(".btn-submit").attr("disabled", "");
                    },
                    success: function( data){
                        $(".btn-submit").removeAttr("disabled");
                        process_output_data_shorten(data);
                    },
                    error: function( e ){
                        $(".btn-submit").text("Shorten");
                        $(".btn-submit").removeAttr("disabled");
                        $.notify("Unknown error happened", "error");
                    }
                });
            });
        });

        function process_output_data_shorten(data)
        {
            if (data.substr(0, 7) == "success"){
                $.notify("Url successfully shortened", "success");
                $("#shorten_url_form").find("input[name='url']").val(data.substr(7)).select();
                $(".btn-submit").text("Copy");
                btn_submit_status = "copy";

            }else if (data == "error" || data == "no_data"){
                $.notify("Unknown error happened", "error");
                $(".btn-submit").text("Shorten");
            }else if (data == "bad_url" || data == "no_url"){
                $.notify("Please enter a correct url", "error");
                $(".btn-submit").text("Shorten");
            }else{
                $.notify("Unknown error happened", "error");
                $(".btn-submit").text("Shorten");
            }
        }

    </script>


    <script type="text/javascript" src="<?=base_url()?>src/js/notify.min.js"></script>

</body>
</html>