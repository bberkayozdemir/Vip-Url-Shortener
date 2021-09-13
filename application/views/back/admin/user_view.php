<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table>
    <tbody>
        <tr>
            <td><b>Name</b></td>
            <td> : </td>
            <td><?=$user_data->name?></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td> : </td>
            <td><?=$user_data->email?></td>
        </tr>
        <tr>
            <td><b>Register Date</b></td>
            <td> : </td>
            <td><?=date("m/d/Y", strtotime($user_data->register_date));?></td>
        </tr>
        <tr>
            <td><b>Account Status</b></td>
            <td> : </td>
            <td><?php
                if ($user_data->status == 1)
                    echo "Enabled";
                else
                    echo "Disabled";
                ?></td>
        </tr>
    </tbody>
</table>