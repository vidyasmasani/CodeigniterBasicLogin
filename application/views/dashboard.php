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
        <div style="text-align: right;padding: 15px;font-size: 20px;">
            <a href="<?php echo base_url('login/logout')?>">Logout</a>
        </div>
        <div id="login_container">
            <?php if($this->session->flashdata('Success')) { ?>
                <div class="align_div_success"><?php echo $this->session->flashdata('Success');?></div>
            <?php } ?>

            <?php if($this->session->flashdata('error')) { ?>
                <div class="align_div_error"><?php echo $this->session->flashdata('error');?></div>
            <?php } ?>
                
                
            <h1>Welcome <?php echo $name;?></h1>
            
            
            <div class="clear"></div>
        </div>
    </body>
</html>