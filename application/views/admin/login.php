<div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to MyHealth</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Please login with your Email and Password.
            </div>
            <?php echo validation_errors(); ?>
         <?php echo form_open('admin/login'); ?>
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Email" name="user_name">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary" value="Login" />
                    </p>
					<p class="center col-md-5">
                       <a  class="btn" data-toggle="modal" data-target="#myModal">Forgot Password</a>
                    </p>
                    
                     <?php echo $this->session->flashdata('msg'); ?>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row--> 
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reset your password</h4>
      </div>
      <div class="modal-body">         
          <form id="resetPassword" name="resetPassword" method="post" action="<?php echo base_url();?>admin/ForgotPassword" onsubmit ='return validate()'>
         <table class="table table-bordered table-hover table-striped">                                      
                    <tbody>
                    <tr>
                    <td>Enter Email: </td>
                    <td>
                <input type="email" name="email" id="email" style="width:250px" required>
                 </td>
                    <td><input type = "submit" value="submit" name="change" class="button"></td>
                    </tr>
                   
                    </tbody>               </table></form> 
                                     <div id="fade" class="black_overlay"></div>       
                      
        </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    
      </div>
    </div>
  </div>
</div>
