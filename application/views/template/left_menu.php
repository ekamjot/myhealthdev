<div class="ch-container">
    <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
						<?php
                        if($this->session->userdata('user_type')!='translator') {
                        ?>
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                        </li>
                        <?php
                        if($this->session->userdata('user_type')=='admin') {
                        ?>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Users</span></a>
                            <ul class="nav nav-pills nav-stacked">
								<?php 
								if($this->uri->segment(2)=='edit_user'){
									$type11g = $user['type'];
								}else{
									$type11g ='';
								}
								?>
                                <li class="<?php echo (($type11g =='medical')? 'active':''); ?>"><a href="<?php echo base_url();?>admin/user_list?type=medical" >All Medical Centers</a>
								</li>
								<li class="<?php echo (($type11g =='doctor')? 'active':''); ?>"><a href="<?php echo base_url();?>admin/user_list?type=doctor">All Doctors</a>
								</li>
								<li class="<?php echo (($type11g =='translator')? 'active':''); ?>"><a href="<?php echo base_url();?>admin/user_list?type=translator">All Translators</a>
								</li>
								<li><a href="<?php echo base_url();?>admin/add_user">Add Users</a>
								</li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a class="ajax-link" href="<?php echo base_url(); ?>admin/patient_list"><i class="glyphicon glyphicon-user"></i><span> Patients</span></a>
                        </li>	
			    <li><a class="ajax-link" href="<?php echo base_url(); ?>admin/appointments_list"><i class="glyphicon glyphicon-calendar"></i><span> Appointments</span></a>
                        </li>
                        <!--<li><a class="ajax-link" href="<?php echo base_url(); ?>admin/location_list"><i class="glyphicon glyphicon-home"></i><span> Locations</span></a>
                        </li>-->
                        <?php
                        if($this->session->userdata('user_type')=='admin') {
                        ?>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Packages</span></a>
                            <ul class="nav nav-pills nav-stacked">
								<li><a href="<?php echo base_url();?>admin/package_name">Package Name</a>
								</li>
                                <li><a href="<?php echo base_url();?>admin/services">Services</a>
								</li>
                                <li><a href="<?php echo base_url();?>admin/package_list">All Packages</a>
								</li>
								<li><a href="<?php echo base_url();?>admin/add_package">Add Package</a>
								</li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a class="ajax-link" href="<?php echo base_url(); ?>admin/check_dates?type=P"><i class="glyphicon glyphicon-calendar"></i><span> Dates Availabilty</span></a>
                        </li>
                        <?php
						if($this->session->userdata('user_type')=='admin') {
						?>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> E-information</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo base_url();?>admin/einfo_cat"> Filter Bars</a>
								</li>
								<li><a href="<?php echo base_url();?>admin/e_information_list"> Passages</a>
								</li>
                            </ul>
                        </li>
                        <?php  }/* else { ?>
                        <li><a class="ajax-link" href="<?php echo base_url(); ?>admin/e_information_list"><i class="glyphicon glyphicon-list-alt"></i><span> E-information</span></a>
                        </li>
                        <?php } */?>
                        <?php
						if($this->session->userdata('user_type')=='admin') {
						?>
						<li class="accordion home_optionss">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Home Page Options</span></a>
                            <ul class="nav nav-pills nav-stacked">
                               <li><a href="<?php echo base_url();?>admin/other_options#advertisement"><span> Advertisements</span></a>
                               </li>
							   <li><a href="<?php echo base_url();?>admin/other_options#einformation"><span> E-information Picture</span></a>
                               </li>
                               <li><a href="<?php echo base_url();?>admin/other_options#about_us"><span> About Us</span></a>
                               </li>
							   <li><a href="<?php echo base_url();?>admin/other_options#privacy_policy"><span> Privacy Policy</span></a>
                               </li>
                               <li><a href="<?php echo base_url();?>admin/other_options#contact_us"><span> Contact Us</span></a>
                               </li>
							   <li><a href="<?php echo base_url();?>admin/other_options#terms_use"><span> Terms Of Uses</span></a>
                               </li>
                            </ul>
                        </li>
                       
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Reports</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo base_url();?>admin/reports_info">Reports info</a>
								</li>
								<li><a href="<?php echo base_url();?>admin/report_cat">Manage Report Category</a>
								</li>
								 <li><a href="<?php echo base_url(); ?>admin/change_price">Change Price</a>
                        </li>
                            </ul>
                        </li>
                       
                        <?php } }else{ ?>
							<li><a href="<?php echo base_url();?>admin/reports_info"><i class="glyphicon glyphicon-file"></i><span>Reports info</span></a>
								</li>
						<?php	} ?>
                    </ul>
                   
                </div>
            </div>
        </div>
    
