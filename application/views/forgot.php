<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
<body>
    <div id="wrapper">
        <div style="width:84%; padding:8%; padding-top:0px; box-shadow:none; padding-bottom:5px;" id="form">
            <h1>Forgot Password</h1>
        
<!--        <h3>Forgot Password</h3>-->
        
      
        <form method="post" action="<?= site_url('login/forgot')?>" id="add">
            
                <?php                 
                if($this->session->flashdata('error')) { echo '<div class="align_div_error">'.$this->session->flashdata('error').'</div>'; }
                if(isset($message)) { echo '<div class="align_div_success">'.$message.'</div>'; }
                if(form_error('email')) { echo '<div class="align_div_error">'.form_error("email").'</div>'; }
                ?>
                
           
            <div class="form_row"> 
                <label for="textfield4">Email</label>
                <div class="text_holder">
                    <input type="text" name="email" id="email" class="text" required="required"/>
                </div>
            </div>

            <div class="form_row"> 
                <input type="submit" name="button" id="button" value="Send" class="btn btn-green"/>

            </div>
        </form>        
    </div>
</div>
</body>
