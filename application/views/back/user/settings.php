<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Settings</h1>      
</div>

<div class="row">

	<div class="col-md-6 marbot20">
		<div class="settings-row">
			<div class="card">
				<h5 class="card-header">Update Email or Username</h5>
				<div class="card-body">
					<form action="" method="POST" id="user-info-form">

					  <div class="form-group row">
					    <label class="col-sm-3 col-form-label">Email</label>
					    <div class="col-sm-9">
					      <input type="text" name="email" class="form-control shorten-input" value="<?=$user->email?>" placeholder="Email">
					    </div>
					  </div>

					  <div class="form-group row">
					    <label class="col-sm-3 col-form-label">Username</label>
					    <div class="col-sm-9">
					      <input type="text" name="username" class="form-control shorten-input" value="<?=$user->name?>" placeholder="Username">
					    </div>
					  </div>

					  <button type="submit" id="info-save" class="btn btn-primary">Save changes</button>

					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 marbot20">
		<div class="settings-row">
			<form action="" method="POST" id="user-password-form">
				<div class="card">
					<h5 class="card-header">Update Password</h5>
					<div class="card-body">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Current Password</label>
							<div class="col-sm-9">
								<input type="password" name="cur_pw" class="form-control shorten-input" value="" placeholder="Current Password">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-3 col-form-label">New Password</label>
							<div class="col-sm-9">
								<input type="password" name="new_pw" class="form-control shorten-input" value="" placeholder="New Password">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Confirm New Password</label>
							<div class="col-sm-9">
								<input type="password" name="con_pw" class="form-control shorten-input" value="" placeholder="Confirm New Password">
							</div>
						</div>

						<button type="submit" id="password-save" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>

<script type="text/javascript">
	$(document).ready(function () {

		$("#user-info-form").submit(function(e){
            e.preventDefault();
            
            var form_data = new FormData($(this)[0]);

            $.ajax({
                url: "<?=base_url()?>user/settings",
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("#info-save").text("Loading...");
                    $("#info-save").attr("disabled", "");
                },
                success: function( data){
                    $("#info-save").removeAttr("disabled");
                    $("#info-save").text("Save changes");
                    if (data == "success")
                    {
                		$.notify("Saved!", "success");
                    }else if (data == "bad_email")
                    {
                    	$.notify("Please enter a correct email", "error");
                    }else if (data == "bad_username")
                    {
                    	$.notify("You have disallowed characters in your username", "error");
                    }else if (data == "empty"){
                    	$.notify("All fields are required!", "error");
                	}else if (data == "email_taken"){
                        $.notify("This email already taken by another user!", "error");
                    }else
                    {
                    	$.notify("Unknown error happened", "error");
                    }
                },
                error: function( e ){
                    $("#info-save").text("Save changes");
                    $("#info-save").removeAttr("disabled");
                    console.log( e );
                }
            });
        });

        $("#user-password-form").submit(function(e){
            e.preventDefault();
            
            var form_data = new FormData($(this)[0]);

            $.ajax({
                url: "<?=base_url()?>user/settings",
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("#password-save").text("Loading...");
                    $("#password-save").attr("disabled", "");
                },
                success: function( data){
                    $("#password-save").removeAttr("disabled");
                    $("#password-save").text("Save changes");
                    if (data == "success")
                    {
                		$.notify("Saved!", "success");
                    }else if (data == "bad_cur_pw")
                    {
                    	$.notify("You have entered your current password wrong!", "error");
                    }else if (data == "bad_confirm")
                    {
                    	$.notify("New password and confirmed one doesn't match!", "error");
                    }else if (data == "short"){
                    	$.notify("Your new password is too short!", "error");
                	}else if (data == "empty"){
                    	$.notify("All fields are required!", "error");
                	}else
                    {
                    	$.notify("Unknown error happened", "error");
                    }
                },
                error: function( e ){
                    $("#password-save").text("Save changes");
                    $("#password-save").removeAttr("disabled");
                    console.log( e );
                }
            });
        });

	});
</script>