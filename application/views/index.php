<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=2, maximum-scale=2"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'/>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/thickbox.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/thickbox.js"></script>
        <title>Codeigniter Basic Login</title>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.slide').each(function(){
                        var url = $(this).attr('href') + '?TB_iframe=true&height=180&width=400px';

                        $(this).attr('href', url);
                });        
            });
        </script>
    </head>
    <body>
        <div id="login_container">
            <h1>Login</h1>
            
                <?php if($this->session->flashdata('Success')) { ?>
                    <div class="align_div_success"><span class="success"><?php echo $this->session->flashdata('Success');?></span></div>
                <?php } ?>

                <?php if($this->session->flashdata('error')) { ?>
                    <div class="align_div_error"><?php echo $this->session->flashdata('error');?></div>
                <?php } ?>
            
            
                
            <form action="<?= site_url('login/login_user')?>" method="POST">
                <div class="form_row">
                    <label>Username</label>
                    <div class="text_holder">
                        <input type="text" name="username" id="username" required="required" value="<?php echo $this->input->cookie('username', TRUE); ?>"/>
                    </div>
                </div> 
                <div class="form_row">
                    <label>Password</label>
                    <div class="text_holder">
                        <input type="password" name="password" id="password" required="required" value="<?php echo $this->input->cookie('password_hash', TRUE);  ?>" />
                    </div>
                </div>
                
                <div class="form_row">
                    <input type="checkbox" name="remember" id="signin_remember" />
                    <label class="remember">Remember me</label>
                </div>
                
                <div class="form_row">
                    <a class="thickbox slide" style="float: right;"  href="<?= site_url('login/forgotpassword') ?>" name="<strong>Forgot Password:</strong>" id="forgot">Forgot Password ?</a>
                </div>
                
                <div class="form_row">
                    <input class="btn btn-green" type="submit" value="Login" />
                </div>
                
            </form>
            <div class="clear"></div>
        </div>
    </body>
</html>