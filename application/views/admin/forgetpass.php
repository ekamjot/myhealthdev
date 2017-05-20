<?php $this->load->view('template/header'); ?>
<body>
    <!-- topbar starts -->
<div class="ch-container">
    <div class="row">
 <?php 
 $this->load->view('template/top_nav_re');  
 ?>  
<div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to MyHealth</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                <h5>Forget Password</h5>
            </div>
            <?php //echo validation_errors(); ?>
         <?php //echo form_open('admin/login'); ?>
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Email" name="user_name">
                    </div>
                    <div class="clearfix"></div><br>

                          <p class="center col-md-5">
                        <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary" value="Submit" />
                    </p>
					<p class="center col-md-5">
                        <a href="forget"> Forget Password</a>
                    </p>
                    
                     <?php echo $this->session->flashdata('msg'); ?>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->

 <?php $this->load->view('template/footer'); ?>  
 </div>
</body>
</html>