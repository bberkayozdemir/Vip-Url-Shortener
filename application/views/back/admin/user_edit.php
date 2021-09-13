<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form action="<?=base_url()."admin/users/".$user_data->id."/update"?>"method="POST" id="user-edit-form">
    <table style="width:100%">
        <tbody>
            <tr>
                <td><b>Name</b></td>
                <td> : </td>
                <td><input type="text" name="username" class="form-control" value="<?=$user_data->name?>"></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td> : </td>
                <td><input type="text" name="email" class="form-control" value="<?=$user_data->email?>"></td>
            </tr>
            <tr>
                <td><b>Password</b></td>
                <td> : </td>
                <td><input type="text" name="password" class="form-control" value=""></td>
            </tr>
        </tbody>
    </table>

    <input type="hidden" name="user_id" value="<?=$user_data->id?>"
</form>