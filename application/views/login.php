<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport"><!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta content="" name="description">
    <meta content="" name="author">
    <title>Login</title><!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.customise.css" rel="stylesheet" type="text/css">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo text-danger">
            <b>My Todo App</b>
        </div>
        <div class="login-box-body">
            <?php
                if (!empty($authUrl)) {
                    echo '<a href="'.$authUrl.'"><img src="'.base_url().'assets/images/flogin.png" alt=""/></a>';
                } 
            ?>
        </div>
    </div>
</body>
</html>