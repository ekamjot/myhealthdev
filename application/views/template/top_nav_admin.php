<div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
             <a class="navbar-brand" href="<?php base_url(); ?>admin"> <img height="50" width="80" alt="Myhealth Logo" src="<?php echo base_url();?>public/img/logo.png" class="hidden-xs"/>
             <!-- <span>SocialApp</span>  -->
</a>
            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> <?php echo $this->session->userdata('username'); ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>admin/profile">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url()."admin/logout"; ?>">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

        </div>
    </div>
    
